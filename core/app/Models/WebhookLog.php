<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebhookLog extends Model
{
    protected $table = 'webhook_logs';

    protected $fillable = [
        'webhook_id',
        'event',
        'payload',
        'response_code',
        'response_body',
        'status',
        'attempt',
    ];

    protected $casts = [
        'payload' => 'array',
        'response_code' => 'integer',
        'attempt' => 'integer',
        'created_at' => 'datetime',
    ];

    public $timestamps = false;

    /**
     * Relacionamento com Webhook
     */
    public function webhook()
    {
        return $this->belongsTo(Webhook::class);
    }

    /**
     * Verifica se foi sucesso
     */
    public function isSuccess()
    {
        return $this->status === 'success';
    }

    /**
     * Verifica se falhou
     */
    public function isFailed()
    {
        return $this->status === 'failed';
    }
}
