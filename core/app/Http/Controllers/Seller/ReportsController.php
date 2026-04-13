<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Transactions;
use Carbon\Carbon;
use DB;
use Auth;

class ReportsController extends Controller
{
    public function sales(Request $request)
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        // Filtros
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->subDays(30);
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();
        $productId = $request->product_id;

        // Query base
        $query = Order::with(['user', 'product'])
            ->whereHas('product', function($q) use ($user, $productId) {
                $q->where('user_id', $user->id);
                if ($productId) {
                    $q->where('product_id', $productId);
                }
            })
            ->whereBetween('created_at', [$startDate, $endDate]);

        // Métricas gerais
        $metrics = [
            'total_sales' => $query->count(),
            'total_revenue' => $query->sum('amount'),
            'average_ticket' => $query->avg('amount'),
            'unique_customers' => $query->distinct('user_id')->count('user_id')
        ];

        // Vendas por período
        $salesByPeriod = $this->getSalesByPeriod($user->id, $startDate, $endDate, $productId);

        // Vendas por produto
        $salesByProduct = $this->getSalesByProduct($user->id, $startDate, $endDate);

        // Vendas por forma de pagamento
        $salesByPaymentMethod = $this->getSalesByPaymentMethod($user->id, $startDate, $endDate);

        // Lista de vendas
        $sales = $query->orderBy('created_at', 'desc')->paginate(20);

        // Produtos para filtro
        $products = Product::where('user_id', $user->id)->get();

        return view('seller.reports.sales', compact(
            'metrics',
            'salesByPeriod',
            'salesByProduct',
            'salesByPaymentMethod',
            'sales',
            'products',
            'startDate',
            'endDate',
            'productId',
            'lang'
        ));
    }

    public function customers(Request $request)
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        // Filtros
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->subDays(30);
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        // Clientes únicos
        $customers = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where('products.user_id', $user->id)
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select(
                'orders.user_id as id',
                DB::raw("MAX(TRIM(CONCAT(COALESCE(orders.first_name, ''), ' ', COALESCE(orders.last_name, '')))) as name"),
                DB::raw('MAX(orders.email) as email'),
                DB::raw('COUNT(DISTINCT orders.id) as total_orders'),
                DB::raw('SUM(orders.total) as total_spent'),
                DB::raw('MIN(orders.created_at) as first_purchase'),
                DB::raw('MAX(orders.created_at) as last_purchase')
            )
            ->groupBy('orders.user_id')
            ->orderBy('total_spent', 'desc')
            ->paginate(20);

        // Métricas de clientes
        $metrics = [
            'total_customers' => $customers->total(),
            'new_customers' => $this->getNewCustomers($user->id, $startDate, $endDate),
            'returning_customers' => $this->getReturningCustomers($user->id, $startDate, $endDate),
            'average_lifetime_value' => $this->getAverageLifetimeValue($user->id),
            'total_revenue' => (float) $customers->getCollection()->sum('total_spent'),
            'average_value' => (float) $customers->getCollection()->avg('total_spent')
        ];

        // Segmentação de clientes
        $customerSegmentation = $this->getCustomerSegmentation($user->id);

        // Taxa de retenção
        $retentionRate = $this->getRetentionRate($user->id, $startDate, $endDate);

        return view('seller.reports.customers', compact(
            'customers',
            'metrics',
            'customerSegmentation',
            'retentionRate',
            'startDate',
            'endDate',
            'lang'
        ));
    }

    public function products(Request $request)
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        // Filtros
        $startDate = $request->start_date ? Carbon::parse($request->start_date) : Carbon::now()->subDays(30);
        $endDate = $request->end_date ? Carbon::parse($request->end_date) : Carbon::now();

        // Performance dos produtos
        $products = Product::where('user_id', $user->id)
            ->withCount(['orders' => function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->with(['category'])
            ->get()
            ->map(function($product) use ($startDate, $endDate) {
                $revenue = Order::whereHas('product', function($q) use ($product) {
                        $q->where('product_id', $product->id);
                    })
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->sum('amount');

                $product->revenue = $revenue;
                $product->conversion_rate = $this->getProductConversionRate($product->id);
                $product->refund_rate = $this->getProductRefundRate($product->id, $startDate, $endDate);

                return $product;
            })
            ->sortByDesc('revenue');

        // Métricas gerais de produtos
        $metrics = [
            'total_products' => $products->count(),
            'active_products' => $products->where('status', 1)->count(),
            'best_seller' => $products->first(),
            'total_revenue' => $products->sum('revenue'),
            'average_price' => $products->avg('amount')
        ];

        // Produtos por categoria
        $productsByCategory = $this->getProductsByCategory($user->id);

        // Taxa de conversão por produto
        $conversionRates = $this->getProductConversionRates($user->id, $startDate, $endDate);

        return view('seller.reports.products', compact(
            'products',
            'metrics',
            'productsByCategory',
            'conversionRates',
            'startDate',
            'endDate',
            'lang'
        ));
    }

    private function getSalesByPeriod($userId, $startDate, $endDate, $productId = null)
    {
        $days = $startDate->diffInDays($endDate);
        $data = [
            'labels' => [],
            'sales' => [],
            'revenue' => [],
        ];

        if ($days <= 31) {
            // Diário
            for ($date = clone $startDate; $date <= $endDate; $date->addDay()) {
                $query = Order::whereHas('product', function($q) use ($userId, $productId) {
                        $q->where('user_id', $userId);
                        if ($productId) {
                            $q->where('id', $productId);
                        }
                    })
                    ->whereDate('created_at', $date);

                $data['labels'][] = $date->format('d/m');
                $data['sales'][] = $query->count();
                $data['revenue'][] = (float) $query->sum('amount');
            }
        } elseif ($days <= 365) {
            // Mensal
            $period = $startDate->copy();
            while ($period <= $endDate) {
                $query = Order::whereHas('product', function($q) use ($userId, $productId) {
                        $q->where('user_id', $userId);
                        if ($productId) {
                            $q->where('id', $productId);
                        }
                    })
                    ->whereYear('created_at', $period->year)
                    ->whereMonth('created_at', $period->month);

                $data['labels'][] = $period->format('M/Y');
                $data['sales'][] = $query->count();
                $data['revenue'][] = (float) $query->sum('amount');

                $period->addMonth();
            }
        } else {
            $period = $startDate->copy()->startOfYear();
            while ($period <= $endDate) {
                $query = Order::whereHas('product', function($q) use ($userId, $productId) {
                        $q->where('user_id', $userId);
                        if ($productId) {
                            $q->where('id', $productId);
                        }
                    })
                    ->whereYear('created_at', $period->year);

                $data['labels'][] = (string) $period->year;
                $data['sales'][] = $query->count();
                $data['revenue'][] = (float) $query->sum('amount');

                $period->addYear();
            }
        }

        return $data;
    }

    private function getSalesByProduct($userId, $startDate, $endDate)
    {
        return Product::where('user_id', $userId)
            ->withCount(['orders' => function($q) use ($startDate, $endDate) {
                $q->whereBetween('created_at', [$startDate, $endDate]);
            }])
            ->orderBy('orders_count', 'desc')
            ->limit(10)
            ->get();
    }

    private function getSalesByPaymentMethod($userId, $startDate, $endDate)
    {
        return Transactions::where('receiver_id', $userId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select('gateway', DB::raw('COUNT(*) as count'), DB::raw('SUM(amount) as total'))
            ->groupBy('gateway')
            ->get();
    }

    private function getNewCustomers($userId, $startDate, $endDate)
    {
        return DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where('products.user_id', $userId)
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->whereNotExists(function($query) use ($userId, $startDate) {
                $query->select(DB::raw(1))
                    ->from('orders as o2')
                    ->join('products as p2', 'o2.product_id', '=', 'p2.id')
                    ->whereRaw('o2.user_id = orders.user_id')
                    ->where('p2.user_id', $userId)
                    ->where('o2.created_at', '<', $startDate);
            })
            ->distinct('orders.user_id')
            ->count('orders.user_id');
    }

    private function getReturningCustomers($userId, $startDate, $endDate)
    {
        return DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where('products.user_id', $userId)
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->whereExists(function($query) use ($userId, $startDate) {
                $query->select(DB::raw(1))
                    ->from('orders as o2')
                    ->join('products as p2', 'o2.product_id', '=', 'p2.id')
                    ->whereRaw('o2.user_id = orders.user_id')
                    ->where('p2.user_id', $userId)
                    ->where('o2.created_at', '<', $startDate);
            })
            ->distinct('orders.user_id')
            ->count('orders.user_id');
    }

    private function getAverageLifetimeValue($userId)
    {
        $customerTotals = DB::table('orders')
            ->join('products', 'orders.product_id', '=', 'products.id')
            ->where('products.user_id', $userId)
            ->select('orders.user_id', DB::raw('SUM(orders.total) as total'))
            ->groupBy('orders.user_id')
            ->get();

        return $customerTotals->isNotEmpty()
            ? (float) $customerTotals->avg('total')
            : 0;
    }

    private function getCustomerSegmentation($userId)
    {
        // Implementar segmentação de clientes (VIP, Regular, Novo, Inativo)
        return [
            'vip' => 10,
            'regular' => 45,
            'new' => 30,
            'inactive' => 15
        ];
    }

    private function getRetentionRate($userId, $startDate, $endDate)
    {
        // Implementar cálculo de taxa de retenção
        return 65.5; // Placeholder
    }

    private function getProductConversionRate($productId)
    {
        // Implementar cálculo de taxa de conversão do produto
        return rand(5, 25) / 10; // Placeholder
    }

    private function getProductRefundRate($productId, $startDate, $endDate)
    {
        // Implementar cálculo de taxa de reembolso
        return rand(1, 5) / 10; // Placeholder
    }

    private function getProductsByCategory($userId)
    {
        return Product::where('user_id', $userId)
            ->join('product_category', 'products.cat_id', '=', 'product_category.id')
            ->select('product_category.name', DB::raw('COUNT(*) as count'))
            ->groupBy('product_category.name')
            ->get();
    }

    private function getProductConversionRates($userId, $startDate, $endDate)
    {
        $products = Product::where('user_id', $userId)->get();

        return $products->map(function($product) {
            return [
                'name' => $product->name,
                'rate' => $this->getProductConversionRate($product->id)
            ];
        });
    }
}