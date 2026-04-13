<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountCode extends Model
{
    protected $table = 'discount_codes';

    protected $fillable = [
        'user_id',
        'code',
        'type',
        'value',
        'max_uses',
        'current_uses',
        'expires_at',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'max_uses' => 'integer',
        'current_uses' => 'integer',
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
     * Verifica se ainda é válido
     */
    public function isValid()
    {
        // Verifica expiração
        if ($this->expires_at && $this->expires_at->isPast()) {
            return false;
        }

        // Verifica limite de usos
        if ($this->max_uses && $this->current_uses >= $this->max_uses) {
            return false;
        }

        return true;
    }

    /**
     * Incrementa uso
     */
    public function incrementUse()
    {
        $this->increment('current_uses');
    }

    /**
     * Calcula desconto
     */
    public function calculateDiscount($amount)
    {
        if ($this->type === 'percentage') {
            return $amount * ($this->value / 100);
        } else {
            return min($this->value, $amount);
        }
    }
}
