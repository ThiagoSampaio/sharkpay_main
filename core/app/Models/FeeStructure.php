<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payment_method',
        'fee_type',
        'fee_value',
        'fixed_fee',
        'percentage_fee',
        'min_fee',
        'max_fee',
        'min_amount',
        'max_amount',
        'min_installments',
        'max_installments',
        'installment_fees',
        'conditions',
        'active',
        'is_active',
        'priority'
    ];

    protected $casts = [
        'fee_value' => 'decimal:4',
        'fixed_fee' => 'decimal:2',
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'conditions' => 'array',
        'active' => 'boolean'
    ];

    // Relacionamentos
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeForPaymentMethod($query, $method)
    {
        return $query->where('payment_method', $method);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeGlobal($query)
    {
        return $query->whereNull('user_id');
    }

    public function scopeForAmount($query, $amount)
    {
        return $query->where('min_amount', '<=', $amount)
                    ->where(function($q) use ($amount) {
                        $q->whereNull('max_amount')
                          ->orWhere('max_amount', '>=', $amount);
                    });
    }

    public function scopeForInstallments($query, $installments)
    {
        return $query->where('min_installments', '<=', $installments)
                    ->where(function($q) use ($installments) {
                        $q->whereNull('max_installments')
                          ->orWhere('max_installments', '>=', $installments);
                    });
    }

    public function scopeByPriority($query)
    {
        return $query->orderBy('priority', 'desc');
    }

    // Methods
    public function calculateFee($amount, $installments = 1)
    {
        if (!$this->appliesToAmount($amount) || !$this->appliesToInstallments($installments)) {
            return 0;
        }

        switch ($this->fee_type) {
            case 'fixed':
                return $this->fixed_fee;

            case 'percentage':
                return ($amount * $this->fee_value) / 100;

            case 'mixed':
                $percentageFee = ($amount * $this->fee_value) / 100;
                return $percentageFee + $this->fixed_fee;

            default:
                return 0;
        }
    }

    public function appliesToAmount($amount)
    {
        if ($amount < $this->min_amount) {
            return false;
        }

        if ($this->max_amount && $amount > $this->max_amount) {
            return false;
        }

        return true;
    }

    public function appliesToInstallments($installments)
    {
        if ($installments < $this->min_installments) {
            return false;
        }

        if ($this->max_installments && $installments > $this->max_installments) {
            return false;
        }

        return true;
    }

    public function appliesConditions($data = [])
    {
        if (!$this->conditions) {
            return true;
        }

        // Implementar lógica de condições personalizadas
        foreach ($this->conditions as $condition => $value) {
            switch ($condition) {
                case 'user_type':
                    if (!isset($data['user_type']) || $data['user_type'] !== $value) {
                        return false;
                    }
                    break;

                case 'product_category':
                    if (!isset($data['product_category']) || !in_array($data['product_category'], (array)$value)) {
                        return false;
                    }
                    break;

                case 'day_of_week':
                    $currentDay = date('N'); // 1 (Monday) to 7 (Sunday)
                    if (!in_array($currentDay, (array)$value)) {
                        return false;
                    }
                    break;

                case 'time_range':
                    $currentHour = (int)date('H');
                    if ($currentHour < $value['start'] || $currentHour > $value['end']) {
                        return false;
                    }
                    break;
            }
        }

        return true;
    }

    public function isGlobal()
    {
        return $this->user_id === null;
    }

    public function getDisplayName()
    {
        $name = ucfirst(str_replace('_', ' ', $this->payment_method));

        if ($this->fee_type === 'fixed') {
            return $name . ' - Taxa fixa: R$ ' . number_format($this->fixed_fee, 2, ',', '.');
        } elseif ($this->fee_type === 'percentage') {
            return $name . ' - Taxa: ' . number_format($this->fee_value, 2, ',', '.') . '%';
        } else {
            return $name . ' - Taxa mista: ' . number_format($this->fee_value, 2, ',', '.') . '% + R$ ' . number_format($this->fixed_fee, 2, ',', '.');
        }
    }

    // Static methods
    public static function findApplicableFee($paymentMethod, $amount, $installments = 1, $userId = null, $conditions = [])
    {
        $query = static::active()
            ->forPaymentMethod($paymentMethod)
            ->forAmount($amount)
            ->forInstallments($installments)
            ->byPriority();

        // Primeiro tenta encontrar uma taxa específica do usuário
        if ($userId) {
            $userFee = (clone $query)->forUser($userId)->first();
            if ($userFee && $userFee->appliesConditions($conditions)) {
                return $userFee;
            }
        }

        // Se não encontrou, busca uma taxa global
        $globalFee = (clone $query)->global()->first();
        if ($globalFee && $globalFee->appliesConditions($conditions)) {
            return $globalFee;
        }

        return null;
    }

    // Helper methods for views
    public function getIcon()
    {
        $icons = [
            'pix' => 'money-bill-wave',
            'credit_card' => 'credit-card',
            'debit_card' => 'credit-card',
            'boleto' => 'barcode',
            'bank_transfer' => 'university',
        ];

        return $icons[$this->payment_method] ?? 'dollar-sign';
    }
}