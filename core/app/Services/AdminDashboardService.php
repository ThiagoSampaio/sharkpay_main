<?php

namespace App\Services;

use App\Models\User;
use App\Models\Invoice;
use App\Models\Payout;
use App\Models\Refund;
use App\Models\Commission;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AdminDashboardService
{
    /**
     * Obtém métricas principais do dashboard
     */
    public function getMainMetrics(): array
    {
        $today = Carbon::today();
        $thisMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();

        return [
            'revenue' => $this->getRevenueMetrics($thisMonth, $lastMonth),
            'users' => $this->getUserMetrics($thisMonth, $lastMonth),
            'transactions' => $this->getTransactionMetrics($today, $thisMonth),
            'performance' => $this->getPerformanceMetrics(),
            'financial' => $this->getFinancialMetrics()
        ];
    }

    /**
     * Métricas de receita
     */
    private function getRevenueMetrics(Carbon $thisMonth, Carbon $lastMonth): array
    {
        $currentRevenue = Invoice::where('status', 'paid')
            ->whereBetween('updated_at', [$thisMonth, Carbon::now()])
            ->sum('amount');

        $lastMonthRevenue = Invoice::where('status', 'paid')
            ->whereBetween('updated_at', [$lastMonth, $thisMonth])
            ->sum('amount');

        $growth = $lastMonthRevenue > 0 ?
            (($currentRevenue - $lastMonthRevenue) / $lastMonthRevenue) * 100 : 0;

        return [
            'current_month' => $currentRevenue,
            'last_month' => $lastMonthRevenue,
            'growth' => $growth,
            'daily_average' => $currentRevenue / Carbon::now()->day,
            'projection' => ($currentRevenue / Carbon::now()->day) * Carbon::now()->daysInMonth
        ];
    }

    /**
     * Métricas de usuários
     */
    private function getUserMetrics(Carbon $thisMonth, Carbon $lastMonth): array
    {
        return [
            'total' => User::count(),
            'active' => User::where('last_activity', '>=', Carbon::now()->subDays(30))->count(),
            'new_this_month' => User::whereBetween('created_at', [$thisMonth, Carbon::now()])->count(),
            'new_last_month' => User::whereBetween('created_at', [$lastMonth, $thisMonth])->count(),
            'pending_approval' => User::where('status', 'pending')->count(),
            'compliance_issues' => User::where('kyc_status', 'rejected')->count()
        ];
    }

    /**
     * Métricas de transações
     */
    private function getTransactionMetrics(Carbon $today, Carbon $thisMonth): array
    {
        return [
            'today_count' => Invoice::whereDate('created_at', $today)->count(),
            'today_volume' => Invoice::whereDate('created_at', $today)->sum('amount'),
            'month_count' => Invoice::whereBetween('created_at', [$thisMonth, Carbon::now()])->count(),
            'month_volume' => Invoice::whereBetween('created_at', [$thisMonth, Carbon::now()])->sum('amount'),
            'success_rate' => $this->calculateSuccessRate(),
            'average_ticket' => Invoice::where('status', 'paid')->avg('amount')
        ];
    }

    /**
     * Métricas de performance
     */
    private function getPerformanceMetrics(): array
    {
        return [
            'conversion_rate' => $this->calculateConversionRate(),
            'churn_rate' => $this->calculateChurnRate(),
            'refund_rate' => $this->calculateRefundRate(),
            'payment_methods' => $this->getPaymentMethodsDistribution(),
            'top_users' => $this->getTopUsers(),
            'risk_score' => $this->calculateRiskScore()
        ];
    }

    /**
     * Métricas financeiras
     */
    private function getFinancialMetrics(): array
    {
        return [
            'total_revenue' => Invoice::where('status', 'paid')->sum('amount'),
            'total_fees' => $this->calculateTotalFees(),
            'net_revenue' => $this->calculateNetRevenue(),
            'pending_payouts' => $this->hasPayoutsTable()
                ? Payout::whereIn('status', ['scheduled', 'processing'])->sum('net_amount')
                : 0,
            'pending_refunds' => Refund::whereIn('status', ['requested', 'approved'])->sum('refund_amount'),
            'available_balance' => $this->calculateAvailableBalance()
        ];
    }

    /**
     * Calcula taxa de sucesso
     */
    private function calculateSuccessRate(): float
    {
        $total = Invoice::count();
        $successful = Invoice::where('status', 'paid')->count();

        return $total > 0 ? ($successful / $total) * 100 : 0;
    }

    /**
     * Calcula taxa de conversão
     */
    private function calculateConversionRate(): float
    {
        // Implementar lógica específica de conversão
        return 65.5; // Exemplo
    }

    /**
     * Calcula taxa de churn
     */
    private function calculateChurnRate(): float
    {
        $totalUsers = User::count();
        $inactiveUsers = User::where('last_activity', '<', Carbon::now()->subDays(90))->count();

        return $totalUsers > 0 ? ($inactiveUsers / $totalUsers) * 100 : 0;
    }

    /**
     * Calcula taxa de reembolso
     */
    private function calculateRefundRate(): float
    {
        $totalPaid = Invoice::where('status', 'paid')->count();
        $totalRefunded = Refund::where('status', 'completed')->count();

        return $totalPaid > 0 ? ($totalRefunded / $totalPaid) * 100 : 0;
    }

    /**
     * Obtém distribuição de métodos de pagamento
     */
    private function getPaymentMethodsDistribution(): array
    {
        return Invoice::where('status', 'paid')
            ->select('payment_method', DB::raw('count(*) as count'), DB::raw('sum(amount) as total'))
            ->groupBy('payment_method')
            ->get()
            ->map(function($item) {
                return [
                    'method' => $item->payment_method ?? 'Não informado',
                    'count' => $item->count,
                    'total' => $item->total,
                    'percentage' => 0 // Calcular percentual
                ];
            })
            ->toArray();
    }

    /**
     * Obtém top usuários por volume
     */
    private function getTopUsers($limit = 10): array
    {
        return User::select('users.*', DB::raw('COALESCE(SUM(invoices.amount), 0) as total_revenue'))
            ->leftJoin('invoices', function($join) {
                $join->on('users.id', '=', 'invoices.user_id')
                     ->where('invoices.status', '=', 'paid');
            })
            ->groupBy('users.id')
            ->orderBy('total_revenue', 'desc')
            ->limit($limit)
            ->get()
            ->map(function($user) {
                return [
                    'id' => $user->id,
                    'name' => $user->business_name,
                    'email' => $user->email,
                    'total_revenue' => $user->total_revenue
                ];
            })
            ->toArray();
    }

    /**
     * Calcula score de risco
     */
    private function calculateRiskScore(): float
    {
        // Implementar análise de risco baseada em:
        // - Taxa de chargeback
        // - Transações suspeitas
        // - Compliance pendente
        // - Padrões anormais

        return 25.0; // Score baixo = menor risco
    }

    /**
     * Calcula total de taxas
     */
    private function calculateTotalFees(): float
    {
        // Implementar cálculo real de taxas
        $totalRevenue = Invoice::where('status', 'paid')->sum('amount');
        return $totalRevenue * 0.035; // 3.5% exemplo
    }

    /**
     * Calcula receita líquida
     */
    private function calculateNetRevenue(): float
    {
        $totalRevenue = Invoice::where('status', 'paid')->sum('amount');
        $totalFees = $this->calculateTotalFees();
        $totalRefunds = Refund::where('status', 'completed')->sum('refund_amount');

        return $totalRevenue - $totalFees - $totalRefunds;
    }

    /**
     * Calcula saldo disponível da plataforma
     */
    private function calculateAvailableBalance(): float
    {
        $totalReceived = Invoice::where('status', 'paid')->sum('amount');
        $totalRefunds = Refund::where('status', 'completed')->sum('refund_amount');
        $totalPayouts = $this->hasPayoutsTable() ? Payout::where('status', 'completed')->sum('amount') : 0;
        $pendingPayouts = $this->hasPayoutsTable() ? Payout::whereIn('status', ['scheduled', 'processing'])->sum('amount') : 0;

        return $totalReceived - $totalPayouts - $totalRefunds - $pendingPayouts;
    }

    private function hasPayoutsTable(): bool
    {
        static $hasPayoutsTable;

        if ($hasPayoutsTable === null) {
            $hasPayoutsTable = Schema::hasTable('payouts');
        }

        return $hasPayoutsTable;
    }
}