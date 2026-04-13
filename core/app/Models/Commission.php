<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Commission extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'affiliate_id',
        'transaction_id',
        'commission_type',
        'transaction_amount',
        'commission_percentage',
        'commission_amount',
        'status',
        'due_date',
        'paid_at',
        'payout_method',
        'metadata'
    ];

    protected $casts = [
        'transaction_amount' => 'decimal:2',
        'commission_percentage' => 'decimal:2',
        'commission_amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_at' => 'datetime',
        'metadata' => 'array'
    ];

    // Relacionamentos
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function affiliate()
    {
        return $this->belongsTo(User::class, 'affiliate_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    public function scopeCancelled($query)
    {
        return $query->where('status', 'cancelled');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForAffiliate($query, $affiliateId)
    {
        return $query->where('affiliate_id', $affiliateId);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('commission_type', $type);
    }

    public function scopeDueToday($query)
    {
        return $query->where('due_date', '<=', Carbon::today());
    }

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', Carbon::today())
                    ->whereIn('status', ['pending', 'approved']);
    }

    public function scopeThisMonth($query)
    {
        return $query->whereBetween('created_at', [
            Carbon::now()->startOfMonth(),
            Carbon::now()->endOfMonth()
        ]);
    }

    public function scopeLastMonth($query)
    {
        return $query->whereBetween('created_at', [
            Carbon::now()->subMonth()->startOfMonth(),
            Carbon::now()->subMonth()->endOfMonth()
        ]);
    }

    // Accessors
    public function getCommissionPercentageFormattedAttribute()
    {
        return number_format($this->commission_percentage, 2, ',', '.') . '%';
    }

    public function getCommissionAmountFormattedAttribute()
    {
        return 'R$ ' . number_format($this->commission_amount, 2, ',', '.');
    }

    public function getTransactionAmountFormattedAttribute()
    {
        return 'R$ ' . number_format($this->transaction_amount, 2, ',', '.');
    }

    public function getStatusDisplayAttribute()
    {
        $statuses = [
            'pending' => 'Pendente',
            'approved' => 'Aprovada',
            'paid' => 'Paga',
            'cancelled' => 'Cancelada'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'pending' => 'warning',
            'approved' => 'info',
            'paid' => 'success',
            'cancelled' => 'danger'
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    public function getDaysUntilDueAttribute()
    {
        if (!$this->due_date) {
            return null;
        }

        return Carbon::today()->diffInDays($this->due_date, false);
    }

    public function getIsOverdueAttribute()
    {
        return $this->due_date && $this->due_date->isPast() && in_array($this->status, ['pending', 'approved']);
    }

    // Methods
    public function approve()
    {
        $this->update(['status' => 'approved']);
    }

    public function markAsPaid($payoutMethod = null)
    {
        $this->update([
            'status' => 'paid',
            'paid_at' => Carbon::now(),
            'payout_method' => $payoutMethod
        ]);
    }

    public function cancel($reason = null)
    {
        $metadata = $this->metadata ?? [];
        if ($reason) {
            $metadata['cancellation_reason'] = $reason;
        }

        $this->update([
            'status' => 'cancelled',
            'metadata' => $metadata
        ]);
    }

    public function canBeModified()
    {
        return in_array($this->status, ['pending']);
    }

    public function canBePaid()
    {
        return $this->status === 'approved';
    }

    public function getCommissionTypeDisplayName()
    {
        $types = [
            'product' => 'Comissão de Produto',
            'referral' => 'Comissão de Indicação',
            'tier1' => 'Comissão Nível 1',
            'tier2' => 'Comissão Nível 2',
            'tier3' => 'Comissão Nível 3',
            'override' => 'Comissão Override',
            'bonus' => 'Bônus',
            'penalty' => 'Desconto'
        ];

        return $types[$this->commission_type] ?? ucfirst($this->commission_type);
    }

    // Static methods
    public static function createFromTransaction($transactionData, $commissionRules)
    {
        $commissions = [];

        foreach ($commissionRules as $rule) {
            $commission = new static();
            $commission->user_id = $rule['user_id'];
            $commission->affiliate_id = $rule['affiliate_id'] ?? null;
            $commission->transaction_id = $transactionData['transaction_id'];
            $commission->commission_type = $rule['type'];
            $commission->transaction_amount = $transactionData['amount'];
            $commission->commission_percentage = $rule['percentage'];
            $commission->commission_amount = ($transactionData['amount'] * $rule['percentage']) / 100;
            $commission->status = 'pending';
            $commission->due_date = $rule['due_date'] ?? Carbon::now()->addDays(30);
            $commission->metadata = $rule['metadata'] ?? [];

            $commission->save();
            $commissions[] = $commission;
        }

        return $commissions;
    }

    public static function getTotalByUser($userId, $status = null)
    {
        $query = static::forUser($userId);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->sum('commission_amount');
    }

    public static function getMonthlyTotal($userId, Carbon $month = null)
    {
        $month = $month ?? Carbon::now();

        return static::forUser($userId)
            ->whereBetween('created_at', [
                $month->startOfMonth(),
                $month->endOfMonth()
            ])
            ->sum('commission_amount');
    }
}