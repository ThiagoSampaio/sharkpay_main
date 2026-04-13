<?php

namespace App\Http\Controllers\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\Webhook;
use App\Models\WebhookLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SubscriptionWebhookController extends Controller
{
    /**
     * Eventos disponíveis de webhook de assinaturas
     */
    const EVENTS = [
        'subscription.created' => 'Nova assinatura criada',
        'subscription.updated' => 'Assinatura atualizada',
        'subscription.cancelled' => 'Assinatura cancelada',
        'subscription.renewed' => 'Assinatura renovada',
        'subscription.expired' => 'Assinatura expirada',
        'subscription.payment_failed' => 'Falha no pagamento da assinatura',
        'subscription.plan_changed' => 'Plano da assinatura alterado',
    ];

    /**
     * Disparar webhook de assinatura
     */
    public static function trigger($event, Subscription $subscription)
    {
        // Buscar webhooks ativos para este evento
        $webhooks = Webhook::where('active', true)
            ->where('events', 'LIKE', "%{$event}%")
            ->get();

        foreach ($webhooks as $webhook) {
            self::sendWebhook($webhook, $event, $subscription);
        }
    }

    /**
     * Enviar webhook
     */
    protected static function sendWebhook(Webhook $webhook, $event, Subscription $subscription)
    {
        $payload = self::buildPayload($event, $subscription);

        $signature = self::generateSignature($payload, $webhook->secret);

        try {
            $response = Http::timeout(30)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                    'X-Webhook-Signature' => $signature,
                    'X-Webhook-Event' => $event,
                    'X-Webhook-ID' => $webhook->id,
                ])
                ->post($webhook->url, $payload);

            // Log do webhook
            WebhookLog::create([
                'webhook_id' => $webhook->id,
                'event' => $event,
                'payload' => json_encode($payload),
                'response_code' => $response->status(),
                'response_body' => $response->body(),
                'status' => $response->successful() ? 'success' : 'failed',
            ]);

            Log::info("Subscription webhook sent successfully", [
                'event' => $event,
                'webhook_id' => $webhook->id,
                'subscription_id' => $subscription->id,
                'status' => $response->status()
            ]);

        } catch (\Exception $e) {
            // Log de erro
            WebhookLog::create([
                'webhook_id' => $webhook->id,
                'event' => $event,
                'payload' => json_encode($payload),
                'response_code' => 0,
                'response_body' => $e->getMessage(),
                'status' => 'error',
            ]);

            Log::error("Subscription webhook failed", [
                'event' => $event,
                'webhook_id' => $webhook->id,
                'subscription_id' => $subscription->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Construir payload do webhook
     */
    protected static function buildPayload($event, Subscription $subscription)
    {
        return [
            'event' => $event,
            'timestamp' => now()->toIso8601String(),
            'data' => [
                'subscription_id' => $subscription->id,
                'user_id' => $subscription->user_id,
                'product_id' => $subscription->product_id,
                'plan_name' => $subscription->plan_name,
                'amount' => $subscription->amount,
                'billing_cycle' => $subscription->billing_cycle,
                'status' => $subscription->status,
                'next_billing_date' => $subscription->next_billing_date ? $subscription->next_billing_date->toDateString() : null,
                'cancelled_at' => $subscription->cancelled_at ? $subscription->cancelled_at->toIso8601String() : null,
                'expires_at' => $subscription->expires_at ? $subscription->expires_at->toIso8601String() : null,
                'created_at' => $subscription->created_at->toIso8601String(),
                'updated_at' => $subscription->updated_at->toIso8601String(),
            ],
            'user' => [
                'id' => $subscription->user->id,
                'name' => $subscription->user->name,
                'email' => $subscription->user->email,
            ],
        ];
    }

    /**
     * Gerar assinatura HMAC do webhook
     */
    protected static function generateSignature($payload, $secret)
    {
        return hash_hmac('sha256', json_encode($payload), $secret);
    }

    /**
     * Listar eventos disponíveis (para configuração)
     */
    public function listEvents()
    {
        return response()->json([
            'events' => self::EVENTS
        ]);
    }
}
