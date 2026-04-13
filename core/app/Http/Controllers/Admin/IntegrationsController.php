<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use DB;

class IntegrationsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function index()
    {
        $lang = parent::getLanguageVars("admin_layout_pages");

        // Webhooks configurados
        $webhooks = DB::table('webhooks')
            ->orderBy('created_at', 'desc')
            ->get();

        // Logs recentes de webhooks
        $recentLogs = DB::table('webhook_logs')
            ->orderBy('created_at', 'desc')
            ->limit(50)
            ->get();

        // Estatísticas
        $stats = [
            'total_webhooks' => DB::table('webhooks')->count(),
            'active_webhooks' => DB::table('webhooks')->where('active', true)->count(),
            'total_deliveries' => DB::table('webhook_logs')->count(),
            'failed_deliveries' => DB::table('webhook_logs')->where('status', 'failed')->count(),
            'success_rate' => 0
        ];

        if ($stats['total_deliveries'] > 0) {
            $successCount = DB::table('webhook_logs')->where('status', 'success')->count();
            $stats['success_rate'] = round(($successCount / $stats['total_deliveries']) * 100, 2);
        }

        return view('admin.integrations.index', compact('webhooks', 'recentLogs', 'stats', 'lang'));
    }

    public function createWebhook(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'url' => 'required|url',
            'events' => 'required|array',
            'events.*' => 'required|in:order.created,order.completed,order.refunded,payment.received,subscription.created,subscription.cancelled,payout.completed'
        ]);

        $secret = bin2hex(random_bytes(32));

        DB::table('webhooks')->insert([
            'name' => $request->name,
            'url' => $request->url,
            'events' => json_encode($request->events),
            'secret' => $secret,
            'active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'Webhook criado com sucesso!')->with('webhook_secret', $secret);
    }

    public function updateWebhook(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'url' => 'required|url',
            'events' => 'required|array'
        ]);

        DB::table('webhooks')
            ->where('id', $id)
            ->update([
                'name' => $request->name,
                'url' => $request->url,
                'events' => json_encode($request->events),
                'updated_at' => now()
            ]);

        return back()->with('success', 'Webhook atualizado!');
    }

    public function toggleWebhook($id)
    {
        $webhook = DB::table('webhooks')->where('id', $id)->first();

        DB::table('webhooks')
            ->where('id', $id)
            ->update([
                'active' => !$webhook->active,
                'updated_at' => now()
            ]);

        return back()->with('success', 'Status do webhook atualizado!');
    }

    public function deleteWebhook($id)
    {
        DB::table('webhooks')->where('id', $id)->delete();

        return back()->with('success', 'Webhook removido.');
    }

    public function testWebhook($id)
    {
        $webhook = DB::table('webhooks')->where('id', $id)->first();

        if (!$webhook) {
            return back()->with('error', 'Webhook não encontrado.');
        }

        $testPayload = [
            'event' => 'test.ping',
            'timestamp' => now()->toIso8601String(),
            'data' => [
                'message' => 'Test webhook delivery'
            ]
        ];

        try {
            $ch = curl_init($webhook->url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($testPayload));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json',
                'X-Webhook-Signature: ' . hash_hmac('sha256', json_encode($testPayload), $webhook->secret)
            ]);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);

            $response = curl_exec($ch);
            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpCode >= 200 && $httpCode < 300) {
                return back()->with('success', 'Webhook testado com sucesso! Status: ' . $httpCode);
            } else {
                return back()->with('error', 'Webhook retornou erro. Status: ' . $httpCode);
            }
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao testar webhook: ' . $e->getMessage());
        }
    }

    public function webhookLogs($id)
    {
        $lang = parent::getLanguageVars("admin_layout_pages");

        $webhook = DB::table('webhooks')->where('id', $id)->first();

        if (!$webhook) {
            return redirect()->route('admin.integrations.index')->with('error', 'Webhook não encontrado.');
        }

        $logs = DB::table('webhook_logs')
            ->where('webhook_id', $id)
            ->orderBy('created_at', 'desc')
            ->paginate(50);

        return view('admin.integrations.webhook-logs', compact('webhook', 'logs', 'lang'));
    }

    public function n8n()
    {
        $lang = parent::getLanguageVars("admin_layout_pages");

        // Configurações do N8n
        $settings = [
            'n8n_enabled' => $this->getSetting('n8n_enabled', false),
            'n8n_webhook_url' => $this->getSetting('n8n_webhook_url', ''),
            'n8n_api_key' => $this->getSetting('n8n_api_key', ''),
            'n8n_auto_sync' => $this->getSetting('n8n_auto_sync', false)
        ];

        return view('admin.integrations.n8n', compact('settings', 'lang'));
    }

    public function updateN8n(Request $request)
    {
        $request->validate([
            'n8n_webhook_url' => 'nullable|url',
            'n8n_api_key' => 'nullable|string|max:255'
        ]);

        $this->setSetting('n8n_enabled', $request->has('n8n_enabled'));
        $this->setSetting('n8n_webhook_url', $request->n8n_webhook_url);
        $this->setSetting('n8n_api_key', $request->n8n_api_key);
        $this->setSetting('n8n_auto_sync', $request->has('n8n_auto_sync'));

        return back()->with('success', 'Configurações do N8n atualizadas!');
    }

    public function apiKeys()
    {
        $lang = parent::getLanguageVars("admin_layout_pages");

        $apiKeys = DB::table('api_keys')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.integrations.api-keys', compact('apiKeys', 'lang'));
    }

    public function createApiKey(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'permissions' => 'required|array'
        ]);

        $key = 'sk_' . bin2hex(random_bytes(32));

        DB::table('api_keys')->insert([
            'name' => $request->name,
            'key' => hash('sha256', $key),
            'permissions' => json_encode($request->permissions),
            'active' => true,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return back()->with('success', 'API Key criada com sucesso!')->with('api_key', $key);
    }

    public function revokeApiKey($id)
    {
        DB::table('api_keys')->where('id', $id)->delete();

        return back()->with('success', 'API Key revogada.');
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
