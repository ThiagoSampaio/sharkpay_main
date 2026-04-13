<?php

namespace App\Services;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Payout;
use App\Models\PaymentSplit;
use App\Models\Commission;
use App\Models\Refund;
use App\Models\CheckoutBuilder;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardService
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Dados principais do dashboard
     */
    public function getDashboardData(): array
    {
        return [
            'balance' => $this->getBalanceData(),
            'revenue' => $this->getRevenueData(),
            'transactions' => $this->getTransactionData(),
            'performance' => $this->getPerformanceData(),
            'recent_activity' => $this->getRecentActivity(),
            'alerts' => $this->getAlerts(),
            'quick_stats' => $this->getQuickStats()
        ];
    }

    /**
     * Dados de saldo em tempo real
     */
    public function getBalanceData(): array
    {
        $availableBalance = $this->calculateAvailableBalance();
        $pendingBalance = $this->calculatePendingBalance();
        $reservedBalance = $this->calculateReservedBalance();
        $totalBalance = $availableBalance + $pendingBalance;

        return [
            'available' => $availableBalance,
            'pending' => $pendingBalance,
            'reserved' => $reservedBalance,
            'total' => $totalBalance,
            'formatted' => [
                'available' => $this->formatCurrency($availableBalance),
                'pending' => $this->formatCurrency($pendingBalance),
                'reserved' => $this->formatCurrency($reservedBalance),
                'total' => $this->formatCurrency($totalBalance)
            ],
            'projection' => $this->getBalanceProjection()
        ];
    }

    /**
     * Dados de receita
     */
    public function getRevenueData(): array
    {
        $currentMonth = Carbon::now();
        $lastMonth = $currentMonth->copy()->subMonth();

        $thisMonth = $this->getMonthlyRevenue($currentMonth);
        $previousMonth = $this->getMonthlyRevenue($lastMonth);

        $growth = $previousMonth > 0 ? (($thisMonth - $previousMonth) / $previousMonth) * 100 : 0;

        return [
            'this_month' => $thisMonth,
            'last_month' => $previousMonth,
            'growth_percentage' => $growth,
            'growth_direction' => $growth >= 0 ? 'up' : 'down',
            'formatted' => [
                'this_month' => $this->formatCurrency($thisMonth),
                'last_month' => $this->formatCurrency($previousMonth),
                'growth' => number_format(abs($growth), 1) . '%'
            ],
            'daily_chart' => $this->getDailyRevenueChart(),
            'monthly_chart' => $this->getMonthlyRevenueChart()
        ];
    }

    /**
     * Dados de transações
     */
    public function getTransactionData(): array
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();

        return [
            'today_count' => $this->getTransactionCount($today, $today->copy()->endOfDay()),
            'today_amount' => $this->getTransactionAmount($today, $today->copy()->endOfDay()),
            'month_count' => $this->getTransactionCount($thisMonth, Carbon::now()),
            'month_amount' => $this->getTransactionAmount($thisMonth, Carbon::now()),
            'conversion_rate' => $this->getConversionRate(),
            'payment_methods' => $this->getPaymentMethodsBreakdown(),
            'hourly_chart' => $this->getHourlyTransactionChart(),
            'status_breakdown' => $this->getTransactionStatusBreakdown()
        ];
    }

    /**
     * Dados de performance
     */
    public function getPerformanceData(): array
    {
        return [
            'top_products' => $this->getTopProducts(),
            'top_payment_methods' => $this->getTopPaymentMethods(),
            'checkout_performance' => $this->getCheckoutPerformance(),
            'refund_rate' => $this->getRefundRate(),
            'average_order_value' => $this->getAverageOrderValue(),
            'customer_insights' => $this->getCustomerInsights()
        ];
    }

    /**
     * Atividade recente
     */
    public function getRecentActivity(int $limit = 10): array
    {
        $activities = collect();

        // Transações recentes
        $recentInvoices = Invoice::where('user_id', $this->user->id)
            ->whereIn('status', ['paid', 'processing'])
            ->orderBy('updated_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($invoice) {
                return [
                    'type' => 'transaction',
                    'icon' => 'credit-card',
                    'color' => 'success',
                    'title' => 'Nova transação',
                    'description' => $this->formatCurrency($invoice->amount) . ' - ' . $invoice->payment_method,
                    'time' => $invoice->updated_at,
                    'link' => route('invoice.show', $invoice->id)
                ];
            });

        // Saques recentes
        $recentPayouts = collect();

        if ($this->hasPayoutsTable()) {
            $recentPayouts = Payout::forUser($this->user->id)
                ->whereIn('status', ['completed', 'processing'])
                ->orderBy('updated_at', 'desc')
                ->limit($limit)
                ->get()
                ->map(function($payout) {
                    return [
                        'type' => 'payout',
                        'icon' => 'arrow-up',
                        'color' => 'info',
                        'title' => 'Saque processado',
                        'description' => $this->formatCurrency($payout->net_amount) . ' - ' . $payout->payout_method_display,
                        'time' => $payout->updated_at,
                        'link' => route('user.payouts.show', $payout->id)
                    ];
                });
        }

        // Reembolsos recentes
        $recentRefunds = Refund::forUser($this->user->id)
            ->whereIn('status', ['completed', 'approved'])
            ->orderBy('updated_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($refund) {
                return [
                    'type' => 'refund',
                    'icon' => 'arrow-left',
                    'color' => 'warning',
                    'title' => 'Reembolso ' . $refund->status_display,
                    'description' => $this->formatCurrency($refund->refund_amount) . ' - ' . $refund->refund_type_display,
                    'time' => $refund->updated_at,
                    'link' => route('user.refunds.show', $refund->id)
                ];
            });

        $activities = $activities->merge($recentInvoices)
                               ->merge($recentPayouts)
                               ->merge($recentRefunds)
                               ->sortByDesc('time')
                               ->take($limit)
                               ->values();

        return $activities->toArray();
    }

    /**
     * Alertas importantes
     */
    public function getAlerts(): array
    {
        $alerts = [];

        // Verificar saldo baixo
        $balance = $this->calculateAvailableBalance();
        if ($balance < 100) {
            $alerts[] = [
                'type' => 'warning',
                'title' => 'Saldo baixo',
                'message' => 'Seu saldo disponível é de apenas ' . $this->formatCurrency($balance),
                'action' => 'Ver transações',
                'link' => route('user.transactions')
            ];
        }

        // Verificar reembolsos pendentes
        $pendingRefunds = Refund::forUser($this->user->id)->pendingApproval()->count();
        if ($pendingRefunds > 0) {
            $alerts[] = [
                'type' => 'info',
                'title' => 'Reembolsos pendentes',
                'message' => "Você tem {$pendingRefunds} reembolso(s) aguardando aprovação",
                'action' => 'Ver reembolsos',
                'link' => route('user.refunds.index')
            ];
        }

        // Verificar saques agendados
        $scheduledPayouts = $this->hasPayoutsTable()
            ? Payout::forUser($this->user->id)->scheduled()->dueToday()->count()
            : 0;
        if ($scheduledPayouts > 0) {
            $alerts[] = [
                'type' => 'success',
                'title' => 'Saques agendados',
                'message' => "Você tem {$scheduledPayouts} saque(s) agendado(s) para hoje",
                'action' => 'Ver saques',
                'link' => route('user.payouts.index')
            ];
        }

        return $alerts;
    }

    /**
     * Estatísticas rápidas
     */
    public function getQuickStats(): array
    {
        $thisMonth = Carbon::now()->startOfMonth();

        return [
            'total_customers' => $this->getTotalCustomers(),
            'active_checkouts' => CheckoutBuilder::byUser($this->user->id)->active()->count(),
            'monthly_transactions' => $this->getTransactionCount($thisMonth, Carbon::now()),
            'success_rate' => $this->getSuccessRate(),
            'pending_commissions' => Commission::forUser($this->user->id)->pending()->sum('commission_amount'),
            'total_fees_paid' => $this->getTotalFeesPaid($thisMonth, Carbon::now())
        ];
    }

    // Métodos auxiliares privados

    private function calculateAvailableBalance(): float
    {
        // Somar transações concluídas menos taxas, comissões e saques
        $totalReceived = Invoice::where('user_id', $this->user->id)
            ->where('status', 'paid')
            ->sum('amount');

        $totalFees = $this->getTotalFeesPaid();
        $totalPayouts = $this->hasPayoutsTable()
            ? Payout::forUser($this->user->id)->completed()->sum('amount')
            : 0;
        $totalRefunds = Refund::forUser($this->user->id)->completed()->sum('refund_amount');

        return $totalReceived - $totalFees - $totalPayouts - $totalRefunds;
    }

    private function calculatePendingBalance(): float
    {
        return Invoice::where('user_id', $this->user->id)
            ->where('status', 'processing')
            ->sum('amount');
    }

    private function calculateReservedBalance(): float
    {
        if (!$this->hasPayoutsTable()) {
            return 0;
        }

        return Payout::forUser($this->user->id)
            ->whereIn('status', ['scheduled', 'processing'])
            ->sum('amount');
    }

    private function hasPayoutsTable(): bool
    {
        static $hasPayoutsTable;

        if ($hasPayoutsTable === null) {
            $hasPayoutsTable = Schema::hasTable('payouts');
        }

        return $hasPayoutsTable;
    }

    private function getBalanceProjection(): array
    {
        // Projeção simples baseada nos últimos 30 dias
        $last30Days = Carbon::now()->subDays(30);
        $avgDaily = Invoice::where('user_id', $this->user->id)
            ->where('status', 'paid')
            ->where('created_at', '>=', $last30Days)
            ->avg('amount') ?? 0;

        return [
            'next_7_days' => $avgDaily * 7,
            'next_30_days' => $avgDaily * 30,
            'formatted' => [
                'next_7_days' => $this->formatCurrency($avgDaily * 7),
                'next_30_days' => $this->formatCurrency($avgDaily * 30)
            ]
        ];
    }

    private function getMonthlyRevenue(Carbon $month): float
    {
        return Invoice::where('user_id', $this->user->id)
            ->where('status', 'paid')
            ->whereBetween('updated_at', [
                $month->startOfMonth(),
                $month->endOfMonth()
            ])
            ->sum('amount');
    }

    private function getDailyRevenueChart(): array
    {
        $last30Days = Carbon::now()->subDays(30);
        $data = [];

        for ($i = 29; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $revenue = Invoice::where('user_id', $this->user->id)
                ->where('status', 'paid')
                ->whereDate('updated_at', $date)
                ->sum('amount');

            $data[] = [
                'date' => $date->format('Y-m-d'),
                'revenue' => $revenue
            ];
        }

        return $data;
    }

    private function getMonthlyRevenueChart(): array
    {
        $data = [];

        for ($i = 11; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $revenue = $this->getMonthlyRevenue($month);

            $data[] = [
                'month' => $month->format('Y-m'),
                'revenue' => $revenue
            ];
        }

        return $data;
    }

    private function getTransactionCount(Carbon $start, Carbon $end): int
    {
        return Invoice::where('user_id', $this->user->id)
            ->whereBetween('created_at', [$start, $end])
            ->count();
    }

    private function getTransactionAmount(Carbon $start, Carbon $end): float
    {
        return Invoice::where('user_id', $this->user->id)
            ->where('status', 'paid')
            ->whereBetween('updated_at', [$start, $end])
            ->sum('amount');
    }

    private function getConversionRate(): float
    {
        $totalAttempts = Invoice::where('user_id', $this->user->id)->count();
        $successfulPayments = Invoice::where('user_id', $this->user->id)
            ->where('status', 'paid')
            ->count();

        return $totalAttempts > 0 ? ($successfulPayments / $totalAttempts) * 100 : 0;
    }

    private function getPaymentMethodsBreakdown(): array
    {
        return Invoice::where('user_id', $this->user->id)
            ->where('status', 'paid')
            ->select('payment_method', DB::raw('count(*) as count'), DB::raw('sum(amount) as total'))
            ->groupBy('payment_method')
            ->get()
            ->map(function($item) {
                return [
                    'method' => $item->payment_method ?? 'Não informado',
                    'count' => $item->count,
                    'total' => $item->total,
                    'formatted_total' => $this->formatCurrency($item->total)
                ];
            })
            ->toArray();
    }

    private function getTopProducts(int $limit = 5): array
    {
        // Implementar quando houver relação entre Invoice e Product
        return [];
    }

    private function getTopPaymentMethods(): array
    {
        return $this->getPaymentMethodsBreakdown();
    }

    private function getCheckoutPerformance(): array
    {
        $checkouts = CheckoutBuilder::byUser($this->user->id)->get();

        return $checkouts->map(function($checkout) {
            return [
                'id' => $checkout->id,
                'name' => $checkout->name,
                'conversion_rate' => $checkout->conversion_rate_formatted,
                'total_revenue' => $checkout->total_revenue,
                'total_orders' => $checkout->total_orders
            ];
        })->toArray();
    }

    private function getRefundRate(): float
    {
        $totalTransactions = Invoice::where('user_id', $this->user->id)
            ->where('status', 'paid')
            ->count();

        $totalRefunds = Refund::forUser($this->user->id)
            ->completed()
            ->count();

        return $totalTransactions > 0 ? ($totalRefunds / $totalTransactions) * 100 : 0;
    }

    private function getAverageOrderValue(): float
    {
        return Invoice::where('user_id', $this->user->id)
            ->where('status', 'paid')
            ->avg('amount') ?? 0;
    }

    private function getCustomerInsights(): array
    {
        // Implementar análise de clientes
        return [
            'total_customers' => $this->getTotalCustomers(),
            'returning_customers' => 0,
            'new_customers_this_month' => 0
        ];
    }

    private function getTotalCustomers(): int
    {
        return Invoice::where('user_id', $this->user->id)
            ->distinct('email')
            ->count('email');
    }

    private function getSuccessRate(): float
    {
        return $this->getConversionRate();
    }

    private function getTotalFeesPaid(Carbon $start = null, Carbon $end = null): float
    {
        $query = Invoice::where('user_id', $this->user->id)
            ->where('status', 'paid');

        if ($start && $end) {
            $query->whereBetween('updated_at', [$start, $end]);
        }

        // Calcular taxas baseado nas transações (implementar lógica específica)
        return $query->sum('amount') * 0.035; // Exemplo: 3.5% de taxa média
    }

    private function getHourlyTransactionChart(): array
    {
        $data = [];

        for ($hour = 0; $hour < 24; $hour++) {
            $count = Invoice::where('user_id', $this->user->id)
                ->whereRaw('HOUR(created_at) = ?', [$hour])
                ->count();

            $data[] = [
                'hour' => $hour,
                'count' => $count
            ];
        }

        return $data;
    }

    private function getTransactionStatusBreakdown(): array
    {
        return Invoice::where('user_id', $this->user->id)
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->get()
            ->map(function($item) {
                return [
                    'status' => $item->status,
                    'count' => $item->count
                ];
            })
            ->toArray();
    }

    private function formatCurrency(float $amount): string
    {
        return 'R$ ' . number_format($amount, 2, ',', '.');
    }
}