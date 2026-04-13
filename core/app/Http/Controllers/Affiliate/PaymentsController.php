<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class PaymentsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function index()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();
        $affiliate = DB::table('affiliates')->where('user_id', $user->id)->first();

        // Comissões
        $commissions = DB::table('commissions')
            ->where('affiliate_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Resumo financeiro
        $summary = [
            'total_earned' => DB::table('commissions')
                ->where('affiliate_id', $user->id)
                ->sum('commission_amount'),
            'pending' => DB::table('commissions')
                ->where('affiliate_id', $user->id)
                ->where('status', 'pending')
                ->sum('commission_amount'),
            'approved' => DB::table('commissions')
                ->where('affiliate_id', $user->id)
                ->where('status', 'approved')
                ->sum('commission_amount'),
            'paid' => DB::table('commissions')
                ->where('affiliate_id', $user->id)
                ->where('status', 'paid')
                ->sum('commission_amount')
        ];

        return view('affiliate.payments.index', compact('commissions', 'summary', 'lang'));
    }

    public function withdraw()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();
        $affiliate = DB::table('affiliates')->where('user_id', $user->id)->first();

        $availableBalance = DB::table('commissions')
            ->where('affiliate_id', $user->id)
            ->where('status', 'approved')
            ->sum('commission_amount');

        return view('affiliate.payments.withdraw', compact('availableBalance', 'affiliate', 'lang'));
    }

    public function requestWithdraw(Request $request)
    {
        $user = Auth::user();
        $affiliate = DB::table('affiliates')->where('user_id', $user->id)->first();

        $request->validate([
            'amount' => 'required|numeric|min:100'
        ]);

        $availableBalance = DB::table('commissions')
            ->where('affiliate_id', $user->id)
            ->where('status', 'approved')
            ->sum('commission_amount');

        if ($request->amount > $availableBalance) {
            return back()->with('error', 'Saldo insuficiente.');
        }

        // Criar solicitação de saque
        DB::table('affiliate_withdrawals')->insert([
            'affiliate_id' => $affiliate->id,
            'amount' => $request->amount,
            'payment_method' => $affiliate->payment_method,
            'payment_details' => $affiliate->payment_details,
            'status' => 'pending',
            'created_at' => now()
        ]);

        return back()->with('success', 'Solicitação de saque enviada com sucesso!');
    }
}
