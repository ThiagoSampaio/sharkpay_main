<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Webhook extends Model
{
    protected $table = 'webhooks';

    protected $fillable = [
        'name',
        'url',
        'events',
        'secret',
        'active',
    ];

    protected $casts = [
        'events' => 'array',
        'active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relacionamento com Logs
     */
    public function logs()
    {
        return $this->hasMany(WebhookLog::class);
    }

    /**
     * Verifica se está ativo
     */
    public function isActive()
    {
        return $this->active === true;
    }

    /**
     * Verifica se escuta evento específico
     */
    public function listensTo($event)
    {
        return in_array($event, $this->events);
    }

    /**
     * Gera assinatura HMAC
     */
    public function generateSignature($payload)
    {
        return hash_hmac('sha256', $payload, $this->secret);
    }
}
