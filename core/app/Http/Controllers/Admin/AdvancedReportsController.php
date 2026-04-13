<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Auth;
use DB;

class AdvancedReportsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index(Request $request)
    {
        $lang = parent::getLanguageVars("admin_layout_pages");

        $period = $request->period ?? '30d';
        $dates = $this->getPeriodDates($period);

        // Métricas principais da plataforma
        $metrics = [
            'total_revenue' => DB::table('transactions')
                ->where('status', 1)
                ->whereBetween('created_at', [$dates['start'], $dates['end']])
                ->sum('amount'),
            'total_orders' => DB::table('orders')
                ->whereBetween('created_at', [$dates['start'], $dates['end']])
                ->count(),
            'total_customers' => DB::table('users')
                ->where('role', 'customer')
                ->whereBetween('created_at', [$dates['start'], $dates['end']])
                ->count(),
            'total_sellers' => DB::table('users')
                ->where('role', 'seller')
                ->whereBetween('created_at', [$dates['start'], $dates['end']])
                ->count(),
            'total_affiliates' => DB::table('affiliates')
                ->where('status', 'approved')
                ->whereBetween('created_at', [$dates['start'], $dates['end']])
                ->count(),
            'platform_fees' => DB::table('transactions')
                ->where('status', 1)
                ->whereBetween('created_at', [$dates['start'], $dates['end']])
                ->sum('platform_fee'),
            'avg_order_value' => 0,
            'conversion_rate' => 0
        ];

        if ($metrics['total_orders'] > 0) {
            $metrics['avg_order_value'] = round($metrics['total_revenue'] / $metrics['total_orders'], 2);
        }

        // Comparação com período anterior
        $previousPeriod = $this->getPreviousPeriodDates($period);
        $comparison = $this->getComparison($dates, $previousPeriod);

        return view('admin.reports.index', compact('metrics', 'comparison', 'period', 'lang'));
    }

    public function revenue(Request $request)
    {
        $lang = parent::getLanguageVars("admin_layout_pages");

        $period = $request->period ?? '30d';
        $dates = $this->getPeriodDates($period);

        // Receita por período
        $revenueChart = $this->getRevenueChart($dates, $period);

        // Receita por categoria
        $revenueByCategory = DB::table('transactions')
            ->join('orders', 'transactions.order_id', '=', 'orders.id')
            ->join('order_products', 'orders.id', '=', 'order_products.order_id')
            ->join('products', 'order_products.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('transactions.status', 1)
            ->whereBetween('transactions.created_at', [$dates['start'], $dates['end']])
            ->select(
                'categories.name',
                DB::raw('SUM(transactions.amount) as revenue'),
                DB::raw('COUNT(DISTINCT orders.id) as orders')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('revenue', 'desc')
            ->get();

        // Top sellers por receita
        $topSellers = DB::table('transactions')
            ->join('users', 'transactions.receiver_id', '=', 'users.id')
            ->where('transactions.status', 1)
            ->whereBetween('transactions.created_at', [$dates['start'], $dates['end']])
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('SUM(transactions.amount) as revenue'),
                DB::raw('COUNT(DISTINCT transactions.id) as sales')
            )
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('revenue', 'desc')
            ->limit(20)
            ->get();

        return view('admin.reports.revenue', compact('revenueChart', 'revenueByCategory', 'topSellers', 'period', 'lang'));
    }

    public function products()
    {
        $lang = parent::getLanguageVars("admin_layout_pages");

        // Top produtos por vendas
        $topProducts = DB::table('products')
            ->join('order_products', 'products.id', '=', 'order_products.product_id')
            ->join('orders', 'order_products.order_id', '=', 'orders.id')
            ->join('users', 'products.user_id', '=', 'users.id')
            ->where('orders.status', 1)
            ->select(
                'products.id',
                'products.name',
                'users.name as seller_name',
                DB::raw('COUNT(DISTINCT orders.id) as total_sales'),
                DB::raw('SUM(order_products.price) as revenue')
            )
            ->groupBy('products.id', 'products.name', 'users.name')
            ->orderBy('total_sales', 'desc')
            ->limit(50)
            ->get();

        return view('admin.reports.products', compact('topProducts', 'lang'));
    }

    public function affiliates()
    {
        $lang = parent::getLanguageVars("admin_layout_pages");

        // Performance de afiliados
        $affiliateStats = DB::table('commissions')
            ->join('users', 'commissions.affiliate_id', '=', 'users.id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COUNT(*) as total_sales'),
                DB::raw('SUM(commission_amount) as total_commission'),
                DB::raw('AVG(commission_amount) as avg_commission')
            )
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('total_commission', 'desc')
            ->limit(50)
            ->get();

        // Comissões pagas vs pendentes
        $commissionSummary = [
            'total_generated' => DB::table('commissions')->sum('commission_amount'),
            'pending' => DB::table('commissions')->where('status', 'pending')->sum('commission_amount'),
            'approved' => DB::table('commissions')->where('status', 'approved')->sum('commission_amount'),
            'paid' => DB::table('commissions')->where('status', 'paid')->sum('commission_amount')
        ];

        return view('admin.reports.affiliates', compact('affiliateStats', 'commissionSummary', 'lang'));
    }

    public function customers()
    {
        $lang = parent::getLanguageVars("admin_layout_pages");

        // Top clientes por gasto
        $topCustomers = DB::table('users')
            ->join('orders', 'users.id', '=', 'orders.user_id')
            ->where('orders.status', 1)
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COUNT(DISTINCT orders.id) as total_orders'),
                DB::raw('SUM(orders.amount) as total_spent'),
                DB::raw('AVG(orders.amount) as avg_order_value')
            )
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('total_spent', 'desc')
            ->limit(50)
            ->get();

        // Segmentação de clientes
        $segments = [
            'new' => DB::table('users')
                ->where('role', 'customer')
                ->where('created_at', '>=', Carbon::now()->subDays(30))
                ->count(),
            'active' => DB::table('users')
                ->where('role', 'customer')
                ->whereExists(function($query) {
                    $query->select(DB::raw(1))
                        ->from('orders')
                        ->whereRaw('orders.user_id = users.id')
                        ->where('orders.created_at', '>=', Carbon::now()->subDays(90));
                })
                ->count(),
            'inactive' => DB::table('users')
                ->where('role', 'customer')
                ->whereNotExists(function($query) {
                    $query->select(DB::raw(1))
                        ->from('orders')
                        ->whereRaw('orders.user_id = users.id')
                        ->where('orders.created_at', '>=', Carbon::now()->subDays(90));
                })
                ->count()
        ];

        return view('admin.reports.customers', compact('topCustomers', 'segments', 'lang'));
    }

    public function exports()
    {
        $lang = parent::getLanguageVars("admin_layout_pages");

        return view('admin.reports.exports', compact('lang'));
    }

    public function exportTransactions(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date'
        ]);

        $transactions = DB::table('transactions')
            ->join('users', 'transactions.receiver_id', '=', 'users.id')
            ->whereBetween('transactions.created_at', [$request->start_date, $request->end_date])
            ->select(
                'transactions.id',
                'transactions.transaction_id',
                'transactions.amount',
                'transactions.platform_fee',
                'transactions.status',
                'transactions.created_at',
                'users.name as seller_name',
                'users.email as seller_email'
            )
            ->get();

        $filename = 'transactions_' . date('Y-m-d') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Transaction ID', 'Amount', 'Platform Fee', 'Status', 'Date', 'Seller Name', 'Seller Email']);

        foreach ($transactions as $transaction) {
            fputcsv($output, (array) $transaction);
        }

        fclose($output);
        exit;
    }

    private function getPeriodDates($period)
    {
        switch($period) {
            case '7d':
                return ['start' => Carbon::now()->subDays(7), 'end' => Carbon::now()];
            case '30d':
                return ['start' => Carbon::now()->subDays(30), 'end' => Carbon::now()];
            case '90d':
                return ['start' => Carbon::now()->subDays(90), 'end' => Carbon::now()];
            case '1y':
                return ['start' => Carbon::now()->subYear(), 'end' => Carbon::now()];
            default:
                return ['start' => Carbon::now()->subDays(30), 'end' => Carbon::now()];
        }
    }

    private function getPreviousPeriodDates($period)
    {
        switch($period) {
            case '7d':
                return ['start' => Carbon::now()->subDays(14), 'end' => Carbon::now()->subDays(7)];
            case '30d':
                return ['start' => Carbon::now()->subDays(60), 'end' => Carbon::now()->subDays(30)];
            case '90d':
                return ['start' => Carbon::now()->subDays(180), 'end' => Carbon::now()->subDays(90)];
            case '1y':
                return ['start' => Carbon::now()->subYears(2), 'end' => Carbon::now()->subYear()];
            default:
                return ['start' => Carbon::now()->subDays(60), 'end' => Carbon::now()->subDays(30)];
        }
    }

    private function getRevenueChart($dates, $period)
    {
        // Implementar gráfico de receita baseado no período
        return ['labels' => [], 'data' => []];
    }

    private function getComparison($currentPeriod, $previousPeriod)
    {
        $currentRevenue = DB::table('transactions')
            ->where('status', 1)
            ->whereBetween('created_at', [$currentPeriod['start'], $currentPeriod['end']])
            ->sum('amount');

        $previousRevenue = DB::table('transactions')
            ->where('status', 1)
            ->whereBetween('created_at', [$previousPeriod['start'], $previousPeriod['end']])
            ->sum('amount');

        $revenueGrowth = 0;
        if ($previousRevenue > 0) {
            $revenueGrowth = round((($currentRevenue - $previousRevenue) / $previousRevenue) * 100, 2);
        }

        return [
            'revenue_growth' => $revenueGrowth,
            'current_revenue' => $currentRevenue,
            'previous_revenue' => $previousRevenue
        ];
    }
}
