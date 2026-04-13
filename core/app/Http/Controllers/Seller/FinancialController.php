<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\Commission;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Auth;

class FinancialController extends Controller
{
    public function balance()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        // Saldo disponível e pendente
        $availableBalance = $user->balance;
        $pendingBalance = $this->getPendingBalance($user->id);
        $processingBalance = $this->getProcessingBalance($user->id);

        // Histórico de transações
        $transactions = Transactions::where('receiver_id', $user->id)
            ->orWhere('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Estatísticas do mês
        $monthlyStats = $this->getMonthlyStats($user->id);

        // Gráfico de receita dos últimos 12 meses
        $revenueChart = $this->getRevenueChartData($user->id);

        return view('seller.financial.balance', compact(
            'availableBalance',
            'pendingBalance',
            'processingBalance',
            'transactions',
            'monthlyStats',
            'revenueChart',
            'lang'
        ));
    }

    public function withdrawals()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        // Saques anteriores
        $withdrawals = DB::table('w_history')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Saldo disponível para saque
        $availableBalance = $user->balance;

        // Métodos de saque configurados
        $withdrawMethods = $this->getWithdrawMethods($user->id);

        // Limites de saque
        $withdrawLimits = [
            'minimum' => 100.00,
            'maximum' => 10000.00,
            'daily_limit' => 5000.00,
            'monthly_limit' => 50000.00,
            'used_today' => $this->getUsedToday($user->id),
            'used_month' => $this->getUsedMonth($user->id)
        ];

        return view('seller.financial.withdrawals', compact(
            'withdrawals',
            'availableBalance',
            'withdrawMethods',
            'withdrawLimits',
            'lang'
        ));
    }

    public function requestWithdrawal(Request $request)
    {
        $user = Auth::guard('user')->user();

        $request->validate([
            'amount' => 'required|numeric|min:100|max:10000',
            'method' => 'required|in:pix,bank_transfer',
            'details' => 'required|array'
        ]);

        $amount = $request->amount;

        // Verificar saldo
        if ($amount > $user->balance) {
            return back()->with('error', 'Saldo insuficiente para realizar o saque.');
        }

        // Verificar limites
        if ($amount < 100) {
            return back()->with('error', 'O valor mínimo para saque é R$ 100,00.');
        }

        $usedToday = $this->getUsedToday($user->id);
        if (($usedToday + $amount) > 5000) {
            return back()->with('error', 'Limite diário de saque excedido.');
        }

        $usedMonth = $this->getUsedMonth($user->id);
        if (($usedMonth + $amount) > 50000) {
            return back()->with('error', 'Limite mensal de saque excedido.');
        }

        DB::beginTransaction();

        try {
            // Criar solicitação de saque
            $withdrawId = DB::table('w_history')->insertGetId([
                'user_id' => $user->id,
                'amount' => $amount,
                'method' => $request->method,
                'details' => json_encode($request->details),
                'reference' => $this->generateWithdrawReference(),
                'status' => 0, // Pendente
                'created_at' => now(),
                'updated_at' => now()
            ]);

            // Deduzir do saldo
            $user->balance -= $amount;
            $user->save();

            // Criar transação
            Transactions::create([
                'user_id' => $user->id,
                'receiver_id' => 0, // Sistema
                'amount' => $amount,
                'charge' => 0,
                'ref_id' => $this->generateTransactionRef(),
                'type' => 2, // Débito
                'status' => 0, // Pendente
                'gateway' => 'withdraw',
                'description' => 'Solicitação de saque #' . $withdrawId
            ]);

            DB::commit();

            return back()->with('success', 'Solicitação de saque realizada com sucesso! Processamento em até 2 dias úteis.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Erro ao processar solicitação de saque: ' . $e->getMessage());
        }
    }

    public function invoices()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        $invoices = DB::table('invoices')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('seller.financial.invoices', compact('invoices', 'lang'));
    }

    public function commissions()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        // Comissões como vendedor
        $sellerCommissions = Commission::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Comissões como afiliado
        $affiliateCommissions = Commission::where('affiliate_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Estatísticas de comissões
        $stats = [
            'total_seller' => Commission::where('user_id', $user->id)->sum('commission_amount'),
            'total_affiliate' => Commission::where('affiliate_id', $user->id)->sum('commission_amount'),
            'pending_seller' => Commission::where('user_id', $user->id)->where('status', 'pending')->sum('commission_amount'),
            'pending_affiliate' => Commission::where('affiliate_id', $user->id)->where('status', 'pending')->sum('commission_amount')
        ];

        return view('seller.financial.commissions', compact('sellerCommissions', 'affiliateCommissions', 'stats', 'lang'));
    }

    private function getPendingBalance($userId)
    {
        return Transactions::where('receiver_id', $userId)
            ->where('status', 0)
            ->sum('amount');
    }

    private function getProcessingBalance($userId)
    {
        return DB::table('w_history')
            ->where('user_id', $userId)
            ->where('status', 0)
            ->sum('amount');
    }

    private function getMonthlyStats($userId)
    {
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        return [
            'revenue' => Transactions::where('receiver_id', $userId)
                ->where('status', 1)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('amount'),
            'withdrawals' => DB::table('w_history')
                ->where('user_id', $userId)
                ->where('status', 1)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('amount'),
            'fees' => Transactions::where('receiver_id', $userId)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->sum('charge'),
            'transactions' => Transactions::where('receiver_id', $userId)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
                ->count()
        ];
    }

    private function getRevenueChartData($userId)
    {
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);

            $revenue = Transactions::where('receiver_id', $userId)
                ->where('status', 1)
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');

            $data['labels'][] = $month->format('M/Y');
            $data['revenue'][] = $revenue;
        }

        return $data;
    }

    private function getWithdrawMethods($userId)
    {
        $methods = [];

        // PIX
        $pixKey = DB::table('user_withdraw_methods')
            ->where('user_id', $userId)
            ->where('method', 'pix')
            ->first();

        if ($pixKey) {
            $methods[] = [
                'type' => 'pix',
                'name' => 'PIX',
                'details' => json_decode($pixKey->details, true),
                'icon' => 'fas fa-qrcode'
            ];
        }

        // Conta Bancária
        $bankAccount = DB::table('user_withdraw_methods')
            ->where('user_id', $userId)
            ->where('method', 'bank_transfer')
            ->first();

        if ($bankAccount) {
            $methods[] = [
                'type' => 'bank_transfer',
                'name' => 'Transferência Bancária',
                'details' => json_decode($bankAccount->details, true),
                'icon' => 'fas fa-university'
            ];
        }

        return $methods;
    }

    private function getUsedToday($userId)
    {
        return DB::table('w_history')
            ->where('user_id', $userId)
            ->whereDate('created_at', Carbon::today())
            ->sum('amount');
    }

    private function getUsedMonth($userId)
    {
        return DB::table('w_history')
            ->where('user_id', $userId)
            ->whereYear('created_at', Carbon::now()->year)
            ->whereMonth('created_at', Carbon::now()->month)
            ->sum('amount');
    }

    private function generateWithdrawReference()
    {
        do {
            $reference = 'WD' . Carbon::now()->format('YmdHis') . rand(1000, 9999);
        } while (DB::table('w_history')->where('reference', $reference)->exists());

        return $reference;
    }

    private function generateTransactionRef()
    {
        do {
            $reference = 'TRX' . Carbon::now()->format('YmdHis') . rand(1000, 9999);
        } while (Transactions::where('ref_id', $reference)->exists());

        return $reference;
    }
}