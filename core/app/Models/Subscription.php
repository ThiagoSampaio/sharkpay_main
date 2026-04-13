<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    protected $table = 'subscriptions';

    protected $fillable = [
        'user_id',
        'product_id',
        'plan_name',
        'amount',
        'billing_cycle',
        'status',
        'next_billing_date',
        'cancelled_at',
        'expires_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'next_billing_date' => 'date',
        'cancelled_at' => 'datetime',
        'expires_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Relacionamento com User
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Verifica se está ativa
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Verifica se está cancelada
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    /**
     * Verifica se expirou
     */
    public function isExpired()
    {
        return $this->status === 'expired';
    }

    /**
     * Calcula próxima cobrança
     */
    public function calculateNextBilling()
    {
        if (!$this->next_billing_date) {
            return null;
        }

        switch ($this->billing_cycle) {
            case 'weekly':
                return $this->next_billing_date->addWeek();
            case 'monthly':
                return $this->next_billing_date->addMonth();
            case 'quarterly':
                return $this->next_billing_date->addMonths(3);
            case 'yearly':
                return $this->next_billing_date->addYear();
            default:
                return null;
        }
    }
}
