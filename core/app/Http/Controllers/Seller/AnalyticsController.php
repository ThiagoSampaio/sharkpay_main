<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\Transactions;
use Carbon\Carbon;
use DB;
use Auth;

class AnalyticsController extends Controller
{
    public function index(Request $request)
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();
        $period = $request->period ?? '30d';

        $dates = $this->getPeriodDates($period);

        // Métricas principais
        $metrics = [
            'revenue' => $this->getRevenue($user->id, $dates),
            'orders' => $this->getOrders($user->id, $dates),
            'customers' => $this->getCustomers($user->id, $dates),
            'conversion_rate' => $this->getConversionRate($user->id, $dates),
            'avg_order_value' => $this->getAvgOrderValue($user->id, $dates),
            'refund_rate' => $this->getRefundRate($user->id, $dates)
        ];

        // Gráficos
        $charts = [
            'revenue_chart' => $this->getRevenueChart($user->id, $period),
            'orders_chart' => $this->getOrdersChart($user->id, $period),
            'traffic_sources' => $this->getTrafficSources($user->id, $dates),
            'top_products' => $this->getTopProducts($user->id, $dates, 10)
        ];

        // Comparação com período anterior
        $comparison = $this->getComparison($user->id, $period);

        return view('seller.analytics.index', compact('metrics', 'charts', 'comparison', 'period', 'lang'));
    }

    public function products()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        $productAnalytics = Product::where('user_id', $user->id)
            ->withCount(['orders' => function($q) {
                $q->where('status', 1);
            }])
            ->get()
            ->map(function($product) {
                $revenue = Order::whereHas('product', function($q) use ($product) {
                    $q->where('product_id', $product->id);
                })->where('status', 1)->sum('amount');

                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'total_orders' => $product->orders_count,
                    'revenue' => $revenue,
                    'views' => rand(100, 5000), // Implementar tracking real
                    'conversion_rate' => $product->orders_count > 0 ? rand(1, 15) : 0,
                    'avg_rating' => rand(30, 50) / 10
                ];
            })->sortByDesc('revenue');

        return view('seller.analytics.products', compact('productAnalytics', 'lang'));
    }

    public function customers()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        // Análise de clientes
        $customerAnalytics = [
            'total_customers' => $this->getTotalCustomers($user->id),
            'new_customers_month' => $this->getNewCustomers($user->id, 30),
            'returning_rate' => $this->getReturningRate($user->id),
            'avg_lifetime_value' => $this->getAvgLifetimeValue($user->id),
            'customer_segments' => $this->getCustomerSegments($user->id)
        ];

        // Top clientes
        $topCustomers = DB::table('orders')
            ->join('users', 'orders.user_id', '=', 'users.id')
            ->join('order_products', 'orders.id', '=', 'order_products.order_id')
            ->join('products', 'order_products.product_id', '=', 'products.id')
            ->where('products.user_id', $user->id)
            ->where('orders.status', 1)
            ->select(
                'users.id',
                'users.name',
                'users.email',
                DB::raw('COUNT(DISTINCT orders.id) as total_orders'),
                DB::raw('SUM(orders.amount) as total_spent')
            )
            ->groupBy('users.id', 'users.name', 'users.email')
            ->orderBy('total_spent', 'desc')
            ->limit(20)
            ->get();

        return view('seller.analytics.customers', compact('customerAnalytics', 'topCustomers', 'lang'));
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

    private function getRevenue($userId, $dates)
    {
        return Transactions::where('receiver_id', $userId)
            ->where('status', 1)
            ->whereBetween('created_at', [$dates['start'], $dates['end']])
            ->sum('amount');
    }

    private function getOrders($userId, $dates)
    {
        return Order::whereHas('product', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->whereBetween('created_at', [$dates['start'], $dates['end']])
        ->count();
    }

    private function getCustomers($userId, $dates)
    {
        return Order::whereHas('product', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->whereBetween('created_at', [$dates['start'], $dates['end']])
        ->distinct('user_id')
        ->count('user_id');
    }

    private function getConversionRate($userId, $dates)
    {
        $views = 10000; // Implementar tracking
        $orders = $this->getOrders($userId, $dates);
        return $views > 0 ? round(($orders / $views) * 100, 2) : 0;
    }

    private function getAvgOrderValue($userId, $dates)
    {
        $revenue = $this->getRevenue($userId, $dates);
        $orders = $this->getOrders($userId, $dates);
        return $orders > 0 ? round($revenue / $orders, 2) : 0;
    }

    private function getRefundRate($userId, $dates)
    {
        $total = $this->getOrders($userId, $dates);
        $refunds = 0; // Implementar
        return $total > 0 ? round(($refunds / $total) * 100, 2) : 0;
    }

    private function getRevenueChart($userId, $period)
    {
        $dates = $this->getPeriodDates($period);
        $points = $this->buildPeriodPoints($dates['start']->copy(), $dates['end']->copy(), $period);

        return [
            'labels' => $points['labels'],
            'data' => $points['points']->map(function ($point) use ($userId) {
                return (float) Transactions::where('receiver_id', $userId)
                    ->where('status', 1)
                    ->whereBetween('created_at', [$point['start'], $point['end']])
                    ->sum('amount');
            })->all(),
        ];
    }

    private function getOrdersChart($userId, $period)
    {
        $dates = $this->getPeriodDates($period);
        $points = $this->buildPeriodPoints($dates['start']->copy(), $dates['end']->copy(), $period);

        return [
            'labels' => $points['labels'],
            'data' => $points['points']->map(function ($point) use ($userId) {
                return Order::whereHas('product', function($q) use ($userId) {
                        $q->where('user_id', $userId);
                    })
                    ->whereBetween('created_at', [$point['start'], $point['end']])
                    ->count();
            })->all(),
        ];
    }

    private function getTrafficSources($userId, $dates)
    {
        // Implementar análise de fontes de tráfego
        return [
            'direct' => 40,
            'organic' => 30,
            'social' => 20,
            'referral' => 10
        ];
    }

    private function getTopProducts($userId, $dates, $limit)
    {
        return Product::where('user_id', $userId)
            ->withCount(['orders' => function($q) use ($dates) {
                $q->whereBetween('created_at', [$dates['start'], $dates['end']]);
            }])
            ->orderBy('orders_count', 'desc')
            ->limit($limit)
            ->get()
            ->map(function ($product) use ($dates) {
                $product->analytics_revenue = (float) Order::where('product_id', $product->id)
                    ->whereBetween('created_at', [$dates['start'], $dates['end']])
                    ->sum('total');

                return $product;
            });
    }

    private function getComparison($userId, $period)
    {
        $current = $this->getPeriodDates($period);
        $diffInDays = $current['start']->diffInDays($current['end']);
        $previousEnd = $current['start']->copy()->subDay();
        $previousStart = $previousEnd->copy()->subDays(max($diffInDays, 1));

        $currentDates = ['start' => $current['start']->copy(), 'end' => $current['end']->copy()];
        $previousDates = ['start' => $previousStart, 'end' => $previousEnd];

        $currentRevenue = $this->getRevenue($userId, $currentDates);
        $previousRevenue = $this->getRevenue($userId, $previousDates);
        $currentOrders = $this->getOrders($userId, $currentDates);
        $previousOrders = $this->getOrders($userId, $previousDates);
        $currentCustomers = $this->getCustomers($userId, $currentDates);
        $previousCustomers = $this->getCustomers($userId, $previousDates);

        return [
            'revenue_growth' => $this->calculateGrowth($currentRevenue, $previousRevenue),
            'orders_growth' => $this->calculateGrowth($currentOrders, $previousOrders),
            'customers_growth' => $this->calculateGrowth($currentCustomers, $previousCustomers)
        ];
    }

    private function buildPeriodPoints(Carbon $start, Carbon $end, string $period): array
    {
        $points = collect();
        $labels = [];

        if ($period === '1y') {
            $cursor = $start->copy()->startOfMonth();
            while ($cursor <= $end) {
                $pointStart = $cursor->copy()->startOfMonth();
                $pointEnd = $cursor->copy()->endOfMonth();
                $points->push(['start' => $pointStart, 'end' => $pointEnd]);
                $labels[] = $cursor->translatedFormat('M/y');
                $cursor->addMonth();
            }
        } else {
            $cursor = $start->copy()->startOfDay();
            while ($cursor <= $end) {
                $pointStart = $cursor->copy()->startOfDay();
                $pointEnd = $cursor->copy()->endOfDay();
                $points->push(['start' => $pointStart, 'end' => $pointEnd]);
                $labels[] = $cursor->format('d/m');
                $cursor->addDay();
            }
        }

        return ['labels' => $labels, 'points' => $points];
    }

    private function calculateGrowth($currentValue, $previousValue): float
    {
        if ((float) $previousValue === 0.0) {
            return (float) $currentValue > 0 ? 100.0 : 0.0;
        }

        return round((($currentValue - $previousValue) / $previousValue) * 100, 1);
    }

    private function getTotalCustomers($userId)
    {
        return Order::whereHas('product', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->distinct('user_id')->count('user_id');
    }

    private function getNewCustomers($userId, $days)
    {
        return Order::whereHas('product', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->where('created_at', '>=', Carbon::now()->subDays($days))
        ->distinct('user_id')
        ->count('user_id');
    }

    private function getReturningRate($userId)
    {
        // Implementar taxa de retorno
        return 35.5;
    }

    private function getAvgLifetimeValue($userId)
    {
        // Implementar LTV médio
        return 250.00;
    }

    private function getCustomerSegments($userId)
    {
        return [
            'new' => 40,
            'active' => 35,
            'at_risk' => 15,
            'churned' => 10
        ];
    }
}
