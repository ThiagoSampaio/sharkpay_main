<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Cart extends Model
{
    protected $table = "cart";

    protected $fillable = [
        'uniqueid',
        'title',
        'product',
        'quantity',
        'store',
        'cost',
        'total',
        'customer_email',
        'customer_name',
        'abandoned_at',
        'recovery_email_sent_at',
        'recovery_attempts',
        'recovered',
        'status'
    ];

    protected $casts = [
        'abandoned_at' => 'datetime',
        'recovery_email_sent_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'recovered' => 'boolean',
    ];

    /**
     * Scope para carrinhos abandonados
     */
    public function scopeAbandoned($query)
    {
        return $query->where('status', 'abandoned')
            ->whereNotNull('customer_email');
    }

    /**
     * Scope para carrinhos não recuperados
     */
    public function scopeNotRecovered($query)
    {
        return $query->where('recovered', false);
    }

    /**
     * Scope para carrinhos sem email de recuperação enviado
     */
    public function scopeNoRecoveryEmailSent($query)
    {
        return $query->whereNull('recovery_email_sent_at');
    }

    /**
     * Scope para carrinhos com tentativas de recuperação menores que X
     */
    public function scopeRecoveryAttemptsLessThan($query, $attempts)
    {
        return $query->where('recovery_attempts', '<', $attempts);
    }

    /**
     * Marcar carrinho como abandonado
     */
    public function markAsAbandoned()
    {
        $this->update([
            'status' => 'abandoned',
            'abandoned_at' => Carbon::now()
        ]);
    }

    /**
     * Marcar carrinho como recuperado
     */
    public function markAsRecovered()
    {
        $this->update([
            'status' => 'recovered',
            'recovered' => true
        ]);
    }

    /**
     * Incrementar tentativas de recuperação
     */
    public function incrementRecoveryAttempts()
    {
        $this->increment('recovery_attempts');
        $this->update(['recovery_email_sent_at' => Carbon::now()]);
    }

    /**
     * Verificar se o carrinho está abandonado há X horas
     */
    public function isAbandonedForHours($hours)
    {
        if (!$this->abandoned_at) {
            return false;
        }

        return $this->abandoned_at->diffInHours(Carbon::now()) >= $hours;
    }
}
