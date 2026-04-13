<?php

namespace App\Http\Controllers\Affiliate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Commission;
use App\Models\Product;
use Carbon\Carbon;
use DB;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Verificar se o usuário é afiliado aprovado
        $affiliateStatus = $this->checkAffiliateStatus($user->id);

        if ($affiliateStatus !== 'approved') {
            return view('affiliate.pending', compact('affiliateStatus'));
        }

        // Métricas principais
        $metrics = [
            'total_earnings' => $this->getTotalEarnings($user->id),
            'monthly_earnings' => $this->getMonthlyEarnings($user->id),
            'total_clicks' => $this->getTotalClicks($user->id),
            'total_conversions' => $this->getTotalConversions($user->id),
            'conversion_rate' => $this->getConversionRate($user->id),
            'pending_commissions' => $this->getPendingCommissions($user->id),
            'available_balance' => $this->getAvailableBalance($user->id),
            'active_campaigns' => $this->getActiveCampaigns($user->id)
        ];

        // Gráfico de ganhos dos últimos 30 dias
        $earningsChart = $this->getEarningsChartData($user->id);

        // Top produtos promovidos
        $topProducts = $this->getTopPromotedProducts($user->id, 5);

        // Comissões recentes
        $recentCommissions = $this->getRecentCommissions($user->id, 10);

        // Links mais clicados
        $topLinks = $this->getTopLinks($user->id, 5);

        // Notificações
        $notifications = $this->getAffiliateNotifications($user->id);

        return view('affiliate.dashboard', compact(
            'metrics',
            'earningsChart',
            'topProducts',
            'recentCommissions',
            'topLinks',
            'notifications'
        ));
    }

    private function checkAffiliateStatus($userId)
    {
        $affiliate = DB::table('affiliates')
            ->where('user_id', $userId)
            ->first();

        if (!$affiliate) {
            return 'not_registered';
        }

        return $affiliate->status; // approved, pending, rejected
    }

    private function getTotalEarnings($userId)
    {
        return Commission::where('affiliate_id', $userId)
            ->where('status', 'paid')
            ->sum('commission_amount');
    }

    private function getMonthlyEarnings($userId)
    {
        return Commission::where('affiliate_id', $userId)
            ->where('status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('commission_amount');
    }

    private function getTotalClicks($userId)
    {
        return DB::table('affiliate_clicks')
            ->where('affiliate_id', $userId)
            ->count();
    }

    private function getTotalConversions($userId)
    {
        return Commission::where('affiliate_id', $userId)
            ->count();
    }

    private function getConversionRate($userId)
    {
        $clicks = $this->getTotalClicks($userId);
        $conversions = $this->getTotalConversions($userId);

        if ($clicks > 0) {
            return round(($conversions / $clicks) * 100, 2);
        }

        return 0;
    }

    private function getPendingCommissions($userId)
    {
        return Commission::where('affiliate_id', $userId)
            ->whereIn('status', ['pending', 'approved'])
            ->sum('commission_amount');
    }

    private function getAvailableBalance($userId)
    {
        return Commission::where('affiliate_id', $userId)
            ->where('status', 'approved')
            ->sum('commission_amount');
    }

    private function getActiveCampaigns($userId)
    {
        return DB::table('affiliate_campaigns')
            ->where('affiliate_id', $userId)
            ->where('status', 'active')
            ->count();
    }

    private function getEarningsChartData($userId)
    {
        $days = 30;
        $data = [];

        for ($i = $days - 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);

            $earnings = Commission::where('affiliate_id', $userId)
                ->whereDate('created_at', $date)
                ->sum('commission_amount');

            $clicks = DB::table('affiliate_clicks')
                ->where('affiliate_id', $userId)
                ->whereDate('created_at', $date)
                ->count();

            $conversions = Commission::where('affiliate_id', $userId)
                ->whereDate('created_at', $date)
                ->count();

            $data['labels'][] = $date->format('d/m');
            $data['earnings'][] = $earnings;
            $data['clicks'][] = $clicks;
            $data['conversions'][] = $conversions;
        }

        return $data;
    }

    private function getTopPromotedProducts($userId, $limit = 5)
    {
        return DB::table('affiliate_products')
            ->join('products', 'affiliate_products.product_id', '=', 'products.id')
            ->where('affiliate_products.affiliate_id', $userId)
            ->select(
                'products.*',
                'affiliate_products.clicks',
                'affiliate_products.conversions',
                'affiliate_products.total_earnings'
            )
            ->orderBy('affiliate_products.total_earnings', 'desc')
            ->limit($limit)
            ->get();
    }

    private function getRecentCommissions($userId, $limit = 10)
    {
        return Commission::where('affiliate_id', $userId)
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    private function getTopLinks($userId, $limit = 5)
    {
        return DB::table('affiliate_links')
            ->where('affiliate_id', $userId)
            ->orderBy('clicks', 'desc')
            ->limit($limit)
            ->get();
    }

    private function getAffiliateNotifications($userId)
    {
        $notifications = [];

        // Verificar comissões pendentes
        $pendingCount = Commission::where('affiliate_id', $userId)
            ->where('status', 'pending')
            ->count();

        if ($pendingCount > 0) {
            $notifications[] = [
                'type' => 'info',
                'message' => "Você tem {$pendingCount} comissão(ões) pendente(s)"
            ];
        }

        // Verificar saldo disponível para saque
        $available = $this->getAvailableBalance($userId);
        if ($available >= 100) {
            $notifications[] = [
                'type' => 'success',
                'message' => "Você tem R$ " . number_format($available, 2, ',', '.') . " disponível para saque"
            ];
        }

        // Verificar produtos sem conversão
        $lowPerformance = DB::table('affiliate_products')
            ->where('affiliate_id', $userId)
            ->where('clicks', '>', 100)
            ->where('conversions', 0)
            ->count();

        if ($lowPerformance > 0) {
            $notifications[] = [
                'type' => 'warning',
                'message' => "Você tem {$lowPerformance} produto(s) com baixa performance"
            ];
        }

        return $notifications;
    }
}