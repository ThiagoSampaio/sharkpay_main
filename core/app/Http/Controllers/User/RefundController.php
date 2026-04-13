<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use App\Models\Invoice;
use App\Services\RefundService;
use Illuminate\Http\Request;
use Auth;

class RefundController extends Controller
{
    protected $refundService;

    public function __construct()
    {
        // Service será criado depois se necessário
    }

    public function index()
    {
        $user = Auth::user();

        // Get refunds
        $refunds = Refund::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get statistics
        $stats = [
            'pending' => Refund::where('user_id', $user->id)->where('status', 'pending')->count(),
            'analyzing' => Refund::where('user_id', $user->id)->where('status', 'analyzing')->count(),
            'approved' => Refund::where('user_id', $user->id)->where('status', 'approved')->count(),
            'total_refunded' => Refund::where('user_id', $user->id)->where('status', 'completed')->sum('refund_amount'),
            'approval_rate' => 0,
            'avg_response_time' => '2',
            'avg_refund_amount' => Refund::where('user_id', $user->id)->where('status', 'completed')->avg('refund_amount') ?? 0,
        ];

        // Calculate approval rate
        $totalProcessed = Refund::where('user_id', $user->id)
            ->whereIn('status', ['completed', 'rejected'])
            ->count();

        if ($totalProcessed > 0) {
            $approved = Refund::where('user_id', $user->id)->where('status', 'completed')->count();
            $stats['approval_rate'] = round(($approved / $totalProcessed) * 100, 1);
        }

        // Get eligible transactions for refund
        $eligibleTransactions = Invoice::where('user_id', $user->id)
            ->where('status', 'paid')
            ->where('created_at', '>=', now()->subDays(7))
            ->get();

        // Common refund reasons
        $commonReasons = [
            ['reason' => 'Produto não recebido', 'count' => 5],
            ['reason' => 'Produto com defeito', 'count' => 3],
            ['reason' => 'Cobrança duplicada', 'count' => 2],
        ];

        $data = [
            'title' => 'Reembolsos',
            'refunds' => $refunds,
            'stats' => $stats,
            'eligibleTransactions' => $eligibleTransactions,
            'commonReasons' => $commonReasons,
        ];

        return view('user.refunds.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaction_id' => 'required|exists:invoices,id',
            'refund_type' => 'required|in:full,partial',
            'partial_amount' => 'required_if:refund_type,partial|numeric|min:0.01',
            'reason_type' => 'required',
            'reason_description' => 'required|string|max:500',
        ]);

        $user = Auth::user();

        // Get the transaction
        $transaction = Invoice::where('user_id', $user->id)
            ->where('id', $request->transaction_id)
            ->where('status', 'paid')
            ->firstOrFail();

        $refundAmount = $request->refund_type === 'full'
            ? $transaction->amount
            : $request->partial_amount;

        // Create refund request
        $refund = Refund::create([
            'transaction_id' => $transaction->id,
            'user_id' => $user->id,
            'original_amount' => $transaction->amount,
            'refund_amount' => $refundAmount,
            'fee_amount' => 0,
            'reason' => $request->reason_type,
            'reason_details' => $request->reason_description,
            'status' => 'pending',
            'metadata' => [],
        ]);

        return redirect()->route('user.refunds.index')
            ->with('success', 'Solicitação de reembolso enviada com sucesso!');
    }

    public function show($id)
    {
        $user = Auth::user();
        $refund = Refund::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        $data = [
            'title' => 'Detalhes do Reembolso',
            'refund' => $refund,
        ];

        return view('user.refunds.show', $data);
    }

    public function cancel($id)
    {
        $user = Auth::user();
        $refund = Refund::where('user_id', $user->id)
            ->where('id', $id)
            ->whereIn('status', ['pending', 'analyzing'])
            ->firstOrFail();

        $refund->update(['status' => 'cancelled']);

        return redirect()->route('user.refunds.index')
            ->with('success', 'Solicitação de reembolso cancelada com sucesso!');
    }

    public function documents($id)
    {
        $user = Auth::user();
        $refund = Refund::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        // Return documents view or download
        return response()->json(['message' => 'Documents feature to be implemented']);
    }
}