<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Auth;
use DB;
use Carbon\Carbon;

class SubscriptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function index()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();

        // Assinaturas ativas
        $activeSubscriptions = DB::table('subscriptions')
            ->join('products', 'subscriptions.product_id', '=', 'products.id')
            ->where('subscriptions.user_id', $user->id)
            ->where('subscriptions.status', 'active')
            ->select(
                'subscriptions.*',
                'products.name as product_name',
                'products.thumbnail'
            )
            ->get();

        // Assinaturas canceladas/expiradas
        $inactiveSubscriptions = DB::table('subscriptions')
            ->join('products', 'subscriptions.product_id', '=', 'products.id')
            ->where('subscriptions.user_id', $user->id)
            ->whereIn('subscriptions.status', ['cancelled', 'expired', 'suspended'])
            ->select(
                'subscriptions.*',
                'products.name as product_name',
                'products.thumbnail'
            )
            ->orderBy('subscriptions.updated_at', 'desc')
            ->limit(10)
            ->get();

        // Estatísticas
        $stats = [
            'active_subscriptions' => $activeSubscriptions->count(),
            'monthly_cost' => $activeSubscriptions->where('billing_cycle', 'monthly')->sum('amount'),
            'total_subscriptions' => DB::table('subscriptions')
                ->where('user_id', $user->id)
                ->count(),
            'next_billing' => DB::table('subscriptions')
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->orderBy('next_billing_date')
                ->value('next_billing_date')
        ];

        return view('customer.subscriptions.index', compact('activeSubscriptions', 'inactiveSubscriptions', 'stats', 'lang'));
    }

    public function show($id)
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();

        $subscription = DB::table('subscriptions')
            ->join('products', 'subscriptions.product_id', '=', 'products.id')
            ->where('subscriptions.user_id', $user->id)
            ->where('subscriptions.id', $id)
            ->select(
                'subscriptions.*',
                'products.name as product_name',
                'products.description as product_description',
                'products.thumbnail'
            )
            ->firstOrFail();

        // Histórico de pagamentos da assinatura
        $paymentHistory = DB::table('invoices')
            ->where('user_id', $user->id)
            ->where('subscription_id', $id)
            ->orderBy('created_at', 'desc')
            ->limit(12)
            ->get();

        // Próximas cobranças
        $upcomingCharges = $this->calculateUpcomingCharges($subscription);

        return view('customer.subscriptions.show', compact('subscription', 'paymentHistory', 'upcomingCharges', 'lang'));
    }

    public function cancel($id)
    {
        $user = Auth::user();

        $subscription = DB::table('subscriptions')
            ->where('user_id', $user->id)
            ->where('id', $id)
            ->where('status', 'active')
            ->first();

        if (!$subscription) {
            return back()->with('error', 'Assinatura não encontrada ou já cancelada.');
        }

        // Cancelar assinatura (mantém acesso até o fim do período pago)
        DB::table('subscriptions')
            ->where('id', $id)
            ->update([
                'status' => 'cancelled',
                'cancelled_at' => now(),
                'auto_renew' => false,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Assinatura cancelada com sucesso. Você terá acesso até ' . Carbon::parse($subscription->next_billing_date)->format('d/m/Y'));
    }

    public function reactivate($id)
    {
        $user = Auth::user();

        $subscription = DB::table('subscriptions')
            ->where('user_id', $user->id)
            ->where('id', $id)
            ->where('status', 'cancelled')
            ->first();

        if (!$subscription) {
            return back()->with('error', 'Assinatura não encontrada ou não pode ser reativada.');
        }

        // Verificar se ainda está no período pago
        if (Carbon::parse($subscription->next_billing_date)->isPast()) {
            return back()->with('error', 'Assinatura expirada. Faça uma nova assinatura.');
        }

        // Reativar assinatura
        DB::table('subscriptions')
            ->where('id', $id)
            ->update([
                'status' => 'active',
                'cancelled_at' => null,
                'auto_renew' => true,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Assinatura reativada com sucesso!');
    }

    public function changePlan(Request $request, $id)
    {
        $user = Auth::user();

        $subscription = DB::table('subscriptions')
            ->where('user_id', $user->id)
            ->where('id', $id)
            ->where('status', 'active')
            ->first();

        if (!$subscription) {
            return back()->with('error', 'Assinatura não encontrada.');
        }

        $request->validate([
            'billing_cycle' => 'required|in:monthly,quarterly,semi-annual,annual'
        ]);

        // Calcular novo valor baseado no ciclo
        $newAmount = $this->calculateAmountForCycle($subscription->product_id, $request->billing_cycle);

        // Atualizar plano
        DB::table('subscriptions')
            ->where('id', $id)
            ->update([
                'billing_cycle' => $request->billing_cycle,
                'amount' => $newAmount,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Plano alterado com sucesso! A alteração será efetiva na próxima cobrança.');
    }

    public function updatePaymentMethod(Request $request, $id)
    {
        $user = Auth::user();

        $request->validate([
            'payment_method' => 'required|in:credit_card,pix,boleto'
        ]);

        DB::table('subscriptions')
            ->where('user_id', $user->id)
            ->where('id', $id)
            ->update([
                'payment_method' => $request->payment_method,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Método de pagamento atualizado com sucesso!');
    }

    private function calculateUpcomingCharges($subscription)
    {
        $charges = [];
        $nextDate = Carbon::parse($subscription->next_billing_date);

        for ($i = 0; $i < 6; $i++) {
            $charges[] = [
                'date' => $nextDate->format('d/m/Y'),
                'amount' => $subscription->amount,
                'status' => $i == 0 ? 'pending' : 'scheduled'
            ];

            // Calcular próxima data baseado no ciclo
            switch ($subscription->billing_cycle) {
                case 'monthly':
                    $nextDate->addMonth();
                    break;
                case 'quarterly':
                    $nextDate->addMonths(3);
                    break;
                case 'semi-annual':
                    $nextDate->addMonths(6);
                    break;
                case 'annual':
                    $nextDate->addYear();
                    break;
            }
        }

        return $charges;
    }

    private function calculateAmountForCycle($productId, $cycle)
    {
        $product = Product::find($productId);
        $baseAmount = $product->amount;

        // Aplicar desconto baseado no ciclo
        switch ($cycle) {
            case 'monthly':
                return $baseAmount;
            case 'quarterly':
                return $baseAmount * 3 * 0.95; // 5% desconto
            case 'semi-annual':
                return $baseAmount * 6 * 0.90; // 10% desconto
            case 'annual':
                return $baseAmount * 12 * 0.85; // 15% desconto
            default:
                return $baseAmount;
        }
    }
}
