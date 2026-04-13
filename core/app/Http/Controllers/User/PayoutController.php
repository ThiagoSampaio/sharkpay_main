<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payout;
use App\Services\PayoutService;
use Illuminate\Http\Request;
use Auth;

class PayoutController extends Controller
{
    protected $payoutService;

    public function __construct(PayoutService $payoutService)
    {
        $this->payoutService = $payoutService;
    }

    public function index()
    {
        $user = Auth::user();

        // Get balance information
        $availableBalance = $this->payoutService->getAvailableBalance($user->id);
        $pendingAmount = $this->payoutService->getPendingAmount($user);
        $processingAmount = $this->payoutService->getProcessingAmount($user);
        $totalPaidOut = $this->payoutService->getTotalPaidOut($user);

        // Get payouts
        $payouts = Payout::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // Get bank accounts (empty for now)
        $bankAccounts = collect([]);

        // Get fees configuration
        $fees = $this->payoutService->getPayoutFees();
        $minimumPayout = $this->payoutService->getMinimumPayout();

        $data = [
            'title' => 'Saques e Transferências',
            'availableBalance' => $availableBalance,
            'pendingAmount' => $pendingAmount,
            'processingAmount' => $processingAmount,
            'totalPaidOut' => $totalPaidOut,
            'payouts' => $payouts,
            'bankAccounts' => $bankAccounts,
            'fees' => $fees,
            'minimumPayout' => $minimumPayout,
        ];

        return view('user.payouts.index', $data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:' . $this->payoutService->getMinimumPayout(),
            'payment_method' => 'required|in:pix,ted,doc',
        ]);

        $user = Auth::user();
        $availableBalance = $this->payoutService->getAvailableBalance($user->id);

        if ($request->amount > $availableBalance) {
            return back()->with('error', 'Saldo insuficiente para realizar o saque.');
        }

        $fees = $this->payoutService->getPayoutFees();
        $fee = $fees[$request->payment_method] ?? 0;

        $payout = Payout::create([
            'user_id' => $user->id,
            'amount' => $request->amount,
            'fee' => $fee,
            'net_amount' => $request->amount - $fee,
            'payment_method' => $request->payment_method,
            'bank_account_id' => $request->bank_account_id,
            'status' => 'pending',
            'metadata' => [],
        ]);

        return redirect()->route('user.payouts.index')
            ->with('success', 'Solicitação de saque criada com sucesso!');
    }

    public function show($id)
    {
        $user = Auth::user();
        $payout = Payout::where('user_id', $user->id)
            ->where('id', $id)
            ->firstOrFail();

        $data = [
            'title' => 'Detalhes do Saque',
            'payout' => $payout,
        ];

        return view('user.payouts.show', $data);
    }

    public function cancel($id)
    {
        $user = Auth::user();
        $payout = Payout::where('user_id', $user->id)
            ->where('id', $id)
            ->where('status', 'pending')
            ->firstOrFail();

        $payout->update(['status' => 'cancelled']);

        return redirect()->route('user.payouts.index')
            ->with('success', 'Saque cancelado com sucesso!');
    }
}