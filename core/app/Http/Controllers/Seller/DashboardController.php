<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use App\Models\Transactions;
use App\Models\Commission;
use Carbon\Carbon;
use DB;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        // Métricas gerais
        $metrics = [
            'total_revenue' => $this->getTotalRevenue($user->id),
            'monthly_revenue' => $this->getMonthlyRevenue($user->id),
            'total_sales' => $this->getTotalSales($user->id),
            'monthly_sales' => $this->getMonthlySales($user->id),
            'total_products' => Product::where('user_id', $user->id)->count(),
            'active_products' => Product::where('user_id', $user->id)->where('status', 1)->count(),
            'total_customers' => $this->getTotalCustomers($user->id),
            'conversion_rate' => $this->getConversionRate($user->id),
            'average_ticket' => $this->getAverageTicket($user->id),
            'pending_withdrawals' => $this->getPendingWithdrawals($user->id),
        ];

        // Gráficos de vendas dos últimos 30 dias
        $salesChart = $this->getSalesChartData($user->id);

        // Top produtos
        $topProducts = $this->getTopProducts($user->id, 5);

        // Vendas recentes
        $recentSales = $this->getRecentSales($user->id, 10);

        // Resumo financeiro
        $financialSummary = [
            'available_balance' => $user->balance,
            'pending_balance' => $this->getPendingBalance($user->id),
            'total_withdrawn' => $this->getTotalWithdrawn($user->id),
            'next_payment_date' => $this->getNextPaymentDate()
        ];

        // Notificações importantes
        $notifications = $this->getImportantNotifications($user->id);

        return view('seller.dashboard', compact(
            'metrics',
            'salesChart',
            'topProducts',
            'recentSales',
            'financialSummary',
            'notifications',
            'lang'
        ));
    }

    private function getTotalRevenue($userId)
    {
        return Transactions::where('receiver_id', $userId)
            ->where('status', 1)
            ->sum('amount');
    }

    private function getMonthlyRevenue($userId)
    {
        return Transactions::where('receiver_id', $userId)
            ->where('status', 1)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('amount');
    }

    private function getTotalSales($userId)
    {
        return Order::whereHas('product', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })->count();
    }

    private function getMonthlySales($userId)
    {
        return Order::whereHas('product', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->whereMonth('created_at', Carbon::now()->month)
        ->whereYear('created_at', Carbon::now()->year)
        ->count();
    }

    private function getTotalCustomers($userId)
    {
        return Order::whereHas('product', function($q) use ($userId) {
            $q->where('user_id', $userId);
        })
        ->distinct('user_id')
        ->count('user_id');
    }

    private function getConversionRate($userId)
    {
        // Implementar lógica de taxa de conversão
        $visits = 1000; // Placeholder - implementar tracking de visitas
        $sales = $this->getTotalSales($userId);

        if ($visits > 0) {
            return round(($sales / $visits) * 100, 2);
        }

        return 0;
    }

    private function getAverageTicket($userId)
    {
        $totalRevenue = $this->getTotalRevenue($userId);
        $totalSales = $this->getTotalSales($userId);

        if ($totalSales > 0) {
            return round($totalRevenue / $totalSales, 2);
        }

        return 0;
    }

    private function getPendingWithdrawals($userId)
    {
        return DB::table('w_history')
            ->where('user_id', $userId)
            ->where('status', 0)
            ->sum('amount');
    }

    private function getPendingBalance($userId)
    {
        return Transactions::where('receiver_id', $userId)
            ->where('status', 0)
            ->sum('amount');
    }

    private function getTotalWithdrawn($userId)
    {
        return DB::table('w_history')
            ->where('user_id', $userId)
            ->where('status', 1)
            ->sum('amount');
    }

    private function getNextPaymentDate()
    {
        // Implementar lógica de próximo pagamento
        return Carbon::now()->addDays(7)->format('d/m/Y');
    }

    private function getSalesChartData($userId)
    {
        $days = 30;
        $data = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $sales = Order::whereHas('product', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->whereDate('created_at', $date)
            ->count();

            $revenue = Transactions::where('receiver_id', $userId)
                ->where('status', 1)
                ->whereDate('created_at', $date)
                ->sum('amount');

            $data['labels'][] = $date->format('d/m');
            $data['sales'][] = $sales;
            $data['revenue'][] = $revenue;
        }

        return $data;
    }

    private function getTopProducts($userId, $limit = 5)
    {
        return Product::where('user_id', $userId)
            ->withCount('orders')
            ->orderBy('orders_count', 'desc')
            ->limit($limit)
            ->get();
    }

    private function getRecentSales($userId, $limit = 10)
    {
        return Order::with(['user', 'product'])
            ->whereHas('product', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    private function getImportantNotifications($userId)
    {
        $notifications = [];

        // Verificar produtos sem estoque
        $outOfStock = Product::where('user_id', $userId)
            ->where('quantity', 0)
            ->where('quantity_status', 1)
            ->count();

        if ($outOfStock > 0) {
            $notifications[] = [
                'type' => 'warning',
                'message' => "Você tem {$outOfStock} produto(s) sem estoque"
            ];
        }

        // Verificar pagamentos pendentes
        $pendingPayments = Transactions::where('receiver_id', $userId)
            ->where('status', 0)
            ->count();

        if ($pendingPayments > 0) {
            $notifications[] = [
                'type' => 'info',
                'message' => "Você tem {$pendingPayments} pagamento(s) pendente(s)"
            ];
        }

        // Verificar se há saques disponíveis
        if ($this->getPendingBalance($userId) >= 100) {
            $notifications[] = [
                'type' => 'success',
                'message' => "Você tem saldo disponível para saque"
            ];
        }

        return $notifications;
    }
}