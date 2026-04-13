<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Invoice;
use App\Models\Product;
use Auth;
use DB;

class PurchasesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function index(Request $request)
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();

        // Filtros
        $status = $request->status;
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Query de pedidos
        $query = Order::where('user_id', $user->id)
            ->with(['products', 'invoice']);

        if ($status) {
            $query->where('status', $status);
        }

        if ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        }

        if ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        $purchases = $query->orderBy('created_at', 'desc')->paginate(20);

        // Estatísticas
        $stats = [
            'total_purchases' => Order::where('user_id', $user->id)->count(),
            'total_spent' => Order::where('user_id', $user->id)->where('status', 1)->sum('amount'),
            'pending_orders' => Order::where('user_id', $user->id)->where('status', 0)->count(),
            'completed_orders' => Order::where('user_id', $user->id)->where('status', 1)->count()
        ];

        return view('customer.purchases.index', compact('purchases', 'stats', 'lang'));
    }

    public function show($id)
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();

        $purchase = Order::where('user_id', $user->id)
            ->where('id', $id)
            ->with(['products', 'invoice', 'user'])
            ->firstOrFail();

        // Detalhes de pagamento
        $payment = Invoice::where('order_id', $id)->first();

        // Produtos do pedido
        $orderProducts = DB::table('order_products')
            ->join('products', 'order_products.product_id', '=', 'products.id')
            ->where('order_products.order_id', $id)
            ->select('products.*', 'order_products.quantity', 'order_products.price', 'order_products.total')
            ->get();

        return view('customer.purchases.show', compact('purchase', 'payment', 'orderProducts', 'lang'));
    }

    public function invoice($id)
    {
        $user = Auth::user();

        $purchase = Order::where('user_id', $user->id)
            ->where('id', $id)
            ->with(['products', 'invoice'])
            ->firstOrFail();

        $invoice = Invoice::where('order_id', $id)->firstOrFail();

        return view('customer.purchases.invoice', compact('purchase', 'invoice'));
    }

    public function requestRefund(Request $request, $id)
    {
        $user = Auth::user();

        $purchase = Order::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        // Verificar se já existe solicitação de reembolso
        $existingRefund = DB::table('refunds')
            ->where('original_transaction_id', $purchase->transaction_id)
            ->where('status', '!=', 'rejected')
            ->first();

        if ($existingRefund) {
            return back()->with('error', 'Já existe uma solicitação de reembolso para este pedido.');
        }

        // Verificar prazo de reembolso (7 dias)
        $daysSincePurchase = now()->diffInDays($purchase->created_at);
        if ($daysSincePurchase > 7) {
            return back()->with('error', 'O prazo para solicitar reembolso expirou (7 dias).');
        }

        $request->validate([
            'reason' => 'required|string|min:10|max:500'
        ]);

        // Criar solicitação de reembolso
        $refundId = 'REF' . now()->format('YmdHis') . rand(1000, 9999);

        DB::table('refunds')->insert([
            'refund_id' => $refundId,
            'original_transaction_id' => $purchase->transaction_id,
            'user_id' => $purchase->seller_id ?? 1,
            'requested_by' => $user->id,
            'original_amount' => $purchase->amount,
            'refund_amount' => $purchase->amount,
            'refund_type' => 'full',
            'reason' => $request->reason,
            'status' => 'requested',
            'requested_at' => now(),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Solicitação de reembolso enviada com sucesso! Você receberá uma resposta em até 48 horas.');
    }
}
