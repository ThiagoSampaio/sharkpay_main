<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use DB;

class AffiliatesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $lang = parent::getLanguageVars("admin_layout_pages");

        $status = $request->status ?? 'all';

        $query = DB::table('affiliates')
            ->join('users', 'affiliates.user_id', '=', 'users.id')
            ->select(
                'affiliates.*',
                'users.name',
                'users.email',
                'users.phone'
            );

        if ($status !== 'all') {
            $query->where('affiliates.status', $status);
        }

        $affiliates = $query->orderBy('affiliates.created_at', 'desc')->paginate(20);

        // Estatísticas
        $stats = [
            'total' => DB::table('affiliates')->count(),
            'pending' => DB::table('affiliates')->where('status', 'pending')->count(),
            'approved' => DB::table('affiliates')->where('status', 'approved')->count(),
            'rejected' => DB::table('affiliates')->where('status', 'rejected')->count(),
            'total_commissions' => DB::table('commissions')->sum('commission_amount'),
            'paid_commissions' => DB::table('commissions')->where('status', 'paid')->sum('commission_amount')
        ];

        return view('admin.affiliates.index', compact('affiliates', 'stats', 'status', 'lang'));
    }

    public function show($id)
    {
        $lang = parent::getLanguageVars("admin_layout_pages");

        $affiliate = DB::table('affiliates')
            ->join('users', 'affiliates.user_id', '=', 'users.id')
            ->where('affiliates.id', $id)
            ->select('affiliates.*', 'users.name', 'users.email', 'users.phone')
            ->first();

        if (!$affiliate) {
            return redirect()->route('admin.affiliates.index')->with('error', 'Afiliado não encontrado.');
        }

        // Comissões do afiliado
        $commissions = DB::table('commissions')
            ->where('affiliate_id', $affiliate->user_id)
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        // Performance
        $performance = [
            'total_clicks' => DB::table('affiliate_clicks')
                ->join('affiliate_links', 'affiliate_clicks.link_id', '=', 'affiliate_links.id')
                ->where('affiliate_links.affiliate_id', $affiliate->user_id)
                ->count(),
            'total_conversions' => DB::table('commissions')
                ->where('affiliate_id', $affiliate->user_id)
                ->count(),
            'total_earned' => DB::table('commissions')
                ->where('affiliate_id', $affiliate->user_id)
                ->sum('commission_amount'),
            'conversion_rate' => 0
        ];

        if ($performance['total_clicks'] > 0) {
            $performance['conversion_rate'] = round(($performance['total_conversions'] / $performance['total_clicks']) * 100, 2);
        }

        return view('admin.affiliates.show', compact('affiliate', 'commissions', 'performance', 'lang'));
    }

    public function approve($id)
    {
        DB::table('affiliates')
            ->where('id', $id)
            ->update([
                'status' => 'approved',
                'approved_at' => now()
            ]);

        return back()->with('success', 'Afiliado aprovado com sucesso!');
    }

    public function reject($id, Request $request)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        DB::table('affiliates')
            ->where('id', $id)
            ->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Afiliado rejeitado.');
    }

    public function suspend($id)
    {
        DB::table('affiliates')
            ->where('id', $id)
            ->update([
                'status' => 'suspended',
                'updated_at' => now()
            ]);

        return back()->with('success', 'Afiliado suspenso.');
    }

    public function reactivate($id)
    {
        DB::table('affiliates')
            ->where('id', $id)
            ->update([
                'status' => 'approved',
                'updated_at' => now()
            ]);

        return back()->with('success', 'Afiliado reativado.');
    }

    public function updateCommissionRate(Request $request, $id)
    {
        $request->validate([
            'custom_commission_rate' => 'required|numeric|min:0|max:100'
        ]);

        DB::table('affiliates')
            ->where('id', $id)
            ->update([
                'custom_commission_rate' => $request->custom_commission_rate,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Taxa de comissão atualizada!');
    }

    public function performance()
    {
        $lang = parent::getLanguageVars("admin_layout_pages");

        // Top afiliados por vendas
        $topAffiliates = DB::table('commissions')
            ->join('users', 'commissions.affiliate_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COUNT(*) as total_sales'),
                DB::raw('SUM(commission_amount) as total_commission')
            )
            ->where('commissions.status', '!=', 'cancelled')
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('total_commission', 'desc')
            ->limit(20)
            ->get();

        return view('admin.affiliates.performance', compact('topAffiliates', 'lang'));
    }
}
