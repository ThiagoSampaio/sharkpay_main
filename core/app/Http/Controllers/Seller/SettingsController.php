<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class SettingsController extends Controller
{
    public function index()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        return view('seller.settings.index', compact('lang'));
    }

    public function profile()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        return view('seller.settings.profile', compact('lang'));
    }

    public function notifications()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        $settings = [
            'email_new_order' => $user->getSetting('email_new_order', true),
            'email_new_customer' => $user->getSetting('email_new_customer', true),
            'email_refund_request' => $user->getSetting('email_refund_request', true),
            'email_weekly_report' => $user->getSetting('email_weekly_report', false),
            'sms_notifications' => $user->getSetting('sms_notifications', false)
        ];

        return view('seller.settings.notifications', compact('settings', 'lang'));
    }

    public function updateNotifications(Request $request)
    {
        $user = Auth::guard('user')->user();

        $settings = [
            'email_new_order' => $request->has('email_new_order'),
            'email_new_customer' => $request->has('email_new_customer'),
            'email_refund_request' => $request->has('email_refund_request'),
            'email_weekly_report' => $request->has('email_weekly_report'),
            'sms_notifications' => $request->has('sms_notifications')
        ];

        foreach ($settings as $key => $value) {
            $user->setSetting($key, $value);
        }

        return back()->with('success', 'Configurações de notificação atualizadas!');
    }

    public function paymentMethods()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        $methods = DB::table('user_withdraw_methods')
            ->where('user_id', $user->id)
            ->get();

        return view('seller.settings.payment-methods', compact('methods', 'lang'));
    }

    public function addPaymentMethod(Request $request)
    {
        $user = Auth::guard('user')->user();

        $request->validate([
            'method' => 'required|in:pix,bank_transfer',
            'details' => 'required|array'
        ]);

        DB::table('user_withdraw_methods')->insert([
            'user_id' => $user->id,
            'method' => $request->method,
            'details' => json_encode($request->details),
            'is_default' => $request->has('is_default'),
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Método de pagamento adicionado!');
    }

    public function tax()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        $taxSettings = [
            'cpf_cnpj' => $user->cpf_cnpj ?? '',
            'company_name' => $user->company_name ?? '',
            'tax_regime' => $user->getSetting('tax_regime', 'simples'),
            'issue_nf' => $user->getSetting('issue_nf', false),
            'municipal_registration' => $user->getSetting('municipal_registration', ''),
            'state_registration' => $user->getSetting('state_registration', ''),
        ];

        return view('seller.settings.tax', compact('taxSettings', 'lang'));
    }

    public function updateTax(Request $request)
    {
        $user = Auth::guard('user')->user();

        $request->validate([
            'cpf_cnpj' => 'required|string|max:18',
            'tax_regime' => 'required|in:simples,lucro_presumido,lucro_real,mei',
        ]);

        // Update user tax information
        $user->update([
            'cpf_cnpj' => $request->cpf_cnpj,
            'company_name' => $request->company_name,
        ]);

        // Save settings
        $user->setSetting('tax_regime', $request->tax_regime);
        $user->setSetting('issue_nf', $request->has('issue_nf'));
        $user->setSetting('municipal_registration', $request->municipal_registration);
        $user->setSetting('state_registration', $request->state_registration);

        return back()->with('success', 'Configurações fiscais atualizadas!');
    }

    public function api()
    {
        $lang = parent::getLanguageVars("user_layout_pages");

        $user = Auth::guard('user')->user();

        // Get user API keys
        $apiKeys = DB::table('api_keys')
            ->where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('seller.settings.api', compact('apiKeys', 'lang'));
    }

    public function generateApiKey(Request $request)
    {
        $user = Auth::guard('user')->user();

        $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'nullable|array'
        ]);

        // Generate random API key
        $apiKey = 'sk_' . bin2hex(random_bytes(32));

        DB::table('api_keys')->insert([
            'user_id' => $user->id,
            'name' => $request->name,
            'key' => hash('sha256', $apiKey),
            'permissions' => json_encode($request->permissions ?? []),
            'active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with([
            'success' => 'API Key criada com sucesso!',
            'api_key' => $apiKey // Show only once
        ]);
    }

    public function revokeApiKey($id)
    {
        $user = Auth::guard('user')->user();

        DB::table('api_keys')
            ->where('id', $id)
            ->where('user_id', $user->id)
            ->update(['active' => false, 'updated_at' => now()]);

        return back()->with('success', 'API Key revogada!');
    }
}
