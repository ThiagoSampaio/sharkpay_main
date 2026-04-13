<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;
use Carbon\Carbon;

class TrackingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:user');
    }

    public function index(Request $request)
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();
        $affiliate = DB::table('affiliates')->where('user_id', $user->id)->first();

        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->subDays(30);
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        // Conversões no período
        $conversions = DB::table('commissions')
            ->join('products', 'commissions.transaction_id', '=', 'products.ref_id')
            ->where('commissions.affiliate_id', $affiliate->user_id)
            ->whereBetween('commissions.created_at', [$startDate, $endDate])
            ->select(
                'commissions.*',
                'products.name as product_name'
            )
            ->orderBy('commissions.created_at', 'desc')
            ->paginate(20);

        // Métricas do período
        $metrics = [
            'total_clicks' => DB::table('affiliate_clicks')
                ->where('affiliate_id', $affiliate->id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count(),
            'total_conversions' => $conversions->total(),
            'total_revenue' => DB::table('commissions')
                ->where('affiliate_id', $affiliate->user_id)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->sum('commission_amount'),
            'conversion_rate' => 0 // Calcular
        ];

        return view('affiliate.tracking.index', compact('conversions', 'metrics', 'startDate', 'endDate', 'lang'));
    }

    public function realtime()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::user();
        $affiliate = DB::table('affiliates')->where('user_id', $user->id)->first();

        // Últimas 24 horas
        $recentActivity = DB::table('affiliate_clicks')
            ->where('affiliate_id', $affiliate->id)
            ->where('created_at', '>=', Carbon::now()->subDay())
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        return view('affiliate.tracking.realtime', compact('recentActivity', 'lang'));
    }
}
