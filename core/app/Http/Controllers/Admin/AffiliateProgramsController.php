<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class AffiliateProgramsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $lang = parent::getLanguageVars("admin_layout_pages");

        // Configurações globais do programa de afiliados
        $settings = [
            'program_enabled' => $this->getSetting('affiliate_program_enabled', true),
            'auto_approve' => $this->getSetting('affiliate_auto_approve', false),
            'default_commission_rate' => $this->getSetting('affiliate_default_commission_rate', 10),
            'minimum_payout' => $this->getSetting('affiliate_minimum_payout', 100),
            'cookie_duration' => $this->getSetting('affiliate_cookie_duration', 30),
            'payment_frequency' => $this->getSetting('affiliate_payment_frequency', 'monthly'),
            'require_approval' => $this->getSetting('affiliate_require_approval', true),
            'terms_url' => $this->getSetting('affiliate_terms_url', ''),
            'welcome_email_enabled' => $this->getSetting('affiliate_welcome_email', true)
        ];

        // Estatísticas do programa
        $stats = [
            'total_affiliates' => DB::table('affiliates')->where('status', 'approved')->count(),
            'pending_applications' => DB::table('affiliates')->where('status', 'pending')->count(),
            'total_clicks' => DB::table('affiliate_clicks')->count(),
            'total_conversions' => DB::table('commissions')->count(),
            'total_commission_paid' => DB::table('commissions')->where('status', 'paid')->sum('commission_amount'),
            'pending_payouts' => DB::table('commissions')->where('status', 'approved')->sum('commission_amount')
        ];

        return view('admin.affiliate-programs.index', compact('settings', 'stats', 'lang'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'program_enabled' => 'boolean',
            'auto_approve' => 'boolean',
            'default_commission_rate' => 'required|numeric|min:0|max:100',
            'minimum_payout' => 'required|numeric|min:0',
            'cookie_duration' => 'required|integer|min:1|max:365',
            'payment_frequency' => 'required|in:weekly,biweekly,monthly',
            'require_approval' => 'boolean',
            'terms_url' => 'nullable|url',
            'welcome_email_enabled' => 'boolean'
        ]);

        $this->setSetting('affiliate_program_enabled', $request->has('program_enabled'));
        $this->setSetting('affiliate_auto_approve', $request->has('auto_approve'));
        $this->setSetting('affiliate_default_commission_rate', $request->default_commission_rate);
        $this->setSetting('affiliate_minimum_payout', $request->minimum_payout);
        $this->setSetting('affiliate_cookie_duration', $request->cookie_duration);
        $this->setSetting('affiliate_payment_frequency', $request->payment_frequency);
        $this->setSetting('affiliate_require_approval', $request->has('require_approval'));
        $this->setSetting('affiliate_terms_url', $request->terms_url);
        $this->setSetting('affiliate_welcome_email', $request->has('welcome_email_enabled'));

        return back()->with('success', 'Configurações do programa de afiliados atualizadas!');
    }

    public function tiers()
    {
        $lang = parent::getLanguageVars("admin_layout_pages");

        $tiers = DB::table('affiliate_tiers')
            ->orderBy('min_sales', 'asc')
            ->get();

        return view('admin.affiliate-programs.tiers', compact('tiers', 'lang'));
    }

    public function createTier(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'min_sales' => 'required|integer|min:0',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'benefits' => 'nullable|string'
        ]);

        DB::table('affiliate_tiers')->insert([
            'name' => $request->name,
            'min_sales' => $request->min_sales,
            'commission_rate' => $request->commission_rate,
            'benefits' => $request->benefits,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Tier criado com sucesso!');
    }

    public function updateTier(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'min_sales' => 'required|integer|min:0',
            'commission_rate' => 'required|numeric|min:0|max:100',
            'benefits' => 'nullable|string'
        ]);

        DB::table('affiliate_tiers')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'min_sales' => $request->min_sales,
                'commission_rate' => $request->commission_rate,
                'benefits' => $request->benefits,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Tier atualizado!');
    }

    public function deleteTier($id)
    {
        DB::table('affiliate_tiers')->where('id', $id)->delete();

        return back()->with('success', 'Tier removido.');
    }

    public function payouts()
    {
        $lang = parent::getLanguageVars("admin_layout_pages");

        $pendingPayouts = DB::table('affiliate_withdrawals')
            ->join('affiliates', 'affiliate_withdrawals.affiliate_id', '=', 'affiliates.id')
            ->join('users', 'affiliates.user_id', '=', 'users.id')
            ->where('affiliate_withdrawals.status', 'pending')
            ->select(
                'affiliate_withdrawals.*',
                'users.name',
                'users.email'
            )
            ->orderBy('affiliate_withdrawals.created_at', 'asc')
            ->paginate(20);

        return view('admin.affiliate-programs.payouts', compact('pendingPayouts', 'lang'));
    }

    public function approvePayout($id)
    {
        DB::table('affiliate_withdrawals')
            ->where('id', $id)
            ->update([
                'status' => 'approved',
                'approved_at' => now()
            ]);

        return back()->with('success', 'Pagamento aprovado!');
    }

    public function rejectPayout($id, Request $request)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:500'
        ]);

        DB::table('affiliate_withdrawals')
            ->where('id', $id)
            ->update([
                'status' => 'rejected',
                'rejection_reason' => $request->rejection_reason,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Pagamento rejeitado.');
    }

    private function getSetting($key, $default = null)
    {
        $setting = DB::table('system_settings')->where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    private function setSetting($key, $value)
    {
        DB::table('system_settings')->updateOrInsert(
            ['key' => $key],
            ['value' => $value, 'updated_at' => now()]
        );
    }
}
