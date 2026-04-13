<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class Payout extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'payout_id',
        'amount',
        'fee',
        'fee_amount',
        'net_amount',
        'payment_method',
        'payout_method',
        'recipient_data',
        'bank_account_id',
        'status',
        'scheduled_date',
        'processed_at',
        'external_id',
        'description',
        'failure_reason',
        'receipt_url',
        'metadata',
        'automatic'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'fee_amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'recipient_data' => 'array',
        'scheduled_date' => 'date',
        'processed_at' => 'datetime',
        'metadata' => 'array',
        'automatic' => 'boolean'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($payout) {
            if (!$payout->payout_id) {
                $payout->payout_id = 'PO-' . strtoupper(Str::random(8)) . '-' . time();
            }
        });
    }

    // Relacionamentos
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function paymentSplits()
    {
        return $this->hasMany(PaymentSplit::class, 'recipient_id', 'user_id')
                    ->where('status', 'completed');
    }

    // Scopes
    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByMethod($query, $method)
    {
        return $query->where('payout_method', $method);
    }

    public function scopeDueToday($query)
    {
        return $query->where('scheduled_date', '<=', Carbon::today());
    }

    public function scopeOverdue($query)
    {
        return $query->where('scheduled_date', '<', Carbon::today())
                    ->whereIn('status', ['scheduled']);
    }

    public function scopeAutomatic($query)
    {
        return $query->where('automatic', true);
    }

    public function scopeManual($query)
    {
        return $query->where('automatic', false);
    }

    // Accessors
    public function getAmountFormattedAttribute()
    {
        return 'R$ ' . number_format($this->amount, 2, ',', '.');
    }

    public function getNetAmountFormattedAttribute()
    {
        return 'R$ ' . number_format($this->net_amount, 2, ',', '.');
    }

    public function getFeeAmountFormattedAttribute()
    {
        return 'R$ ' . number_format($this->fee_amount, 2, ',', '.');
    }

    public function getStatusDisplayAttribute()
    {
        $statuses = [
            'scheduled' => 'Agendado',
            'processing' => 'Processando',
            'completed' => 'Concluído',
            'failed' => 'Falhou',
            'cancelled' => 'Cancelado'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'scheduled' => 'warning',
            'processing' => 'info',
            'completed' => 'success',
            'failed' => 'danger',
            'cancelled' => 'secondary'
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    public function getPayoutMethodDisplayAttribute()
    {
        $methods = [
            'pix' => 'PIX',
            'bank_transfer' => 'Transferência Bancária',
            'wallet' => 'Carteira Digital'
        ];

        return $methods[$this->payout_method] ?? $this->payout_method;
    }

    public function getDaysUntilScheduledAttribute()
    {
        return Carbon::today()->diffInDays($this->scheduled_date, false);
    }

    public function getIsOverdueAttribute()
    {
        return $this->scheduled_date->isPast() && $this->status === 'scheduled';
    }

    // Methods
    public function markAsProcessing()
    {
        $this->update(['status' => 'processing']);
    }

    public function markAsCompleted($externalId = null)
    {
        $this->update([
            'status' => 'completed',
            'processed_at' => Carbon::now(),
            'external_id' => $externalId
        ]);
    }

    public function markAsFailed($reason = null)
    {
        $this->update([
            'status' => 'failed',
            'failure_reason' => $reason
        ]);
    }

    public function cancel()
    {
        if ($this->canBeCancelled()) {
            $this->update(['status' => 'cancelled']);
        }
    }

    public function retry()
    {
        if ($this->status === 'failed') {
            $this->update([
                'status' => 'scheduled',
                'failure_reason' => null,
                'scheduled_date' => Carbon::now()->addDay()
            ]);
        }
    }

    public function canBeProcessed()
    {
        return $this->status === 'scheduled' && $this->scheduled_date->isPast();
    }

    public function canBeRetried()
    {
        return $this->status === 'failed';
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['scheduled', 'failed']);
    }

    public function getRecipientDisplayName()
    {
        $data = $this->recipient_data;

        switch ($this->payout_method) {
            case 'pix':
                return $data['pix_key'] ?? 'N/A';

            case 'bank_transfer':
                $bank = $data['bank_name'] ?? '';
                $account = $data['account_number'] ?? '';
                return $bank . ' - Conta: ' . substr($account, -4);

            case 'wallet':
                return $data['wallet_id'] ?? 'Carteira Digital';

            default:
                return 'N/A';
        }
    }

    // Static methods
    public static function createFromSplits(Collection $paymentSplits, array $payoutConfig = [])
    {
        $groupedSplits = $paymentSplits->groupBy('recipient_id');
        $payouts = [];

        foreach ($groupedSplits as $recipientId => $splits) {
            $totalAmount = $splits->sum('net_amount');
            $user = User::find($recipientId);

            if (!$user || $totalAmount <= 0) {
                continue;
            }

            $feeAmount = $payoutConfig['fee_amount'] ?? 0;
            $netAmount = $totalAmount - $feeAmount;

            $payout = new static();
            $payout->user_id = $recipientId;
            $payout->amount = $totalAmount;
            $payout->fee_amount = $feeAmount;
            $payout->net_amount = $netAmount;
            $payout->payout_method = $payoutConfig['method'] ?? 'pix';
            $payout->recipient_data = $payoutConfig['recipient_data'] ?? [];
            $payout->status = 'scheduled';
            $payout->scheduled_date = $payoutConfig['scheduled_date'] ?? Carbon::now()->addDays(1);
            $payout->description = $payoutConfig['description'] ?? 'Repasse automático';
            $payout->automatic = $payoutConfig['automatic'] ?? true;
            $payout->metadata = [
                'split_ids' => $splits->pluck('id')->toArray(),
                'split_count' => $splits->count()
            ];

            $payout->save();
            $payouts[] = $payout;
        }

        return $payouts;
    }

    public static function getTotalByUser($userId, $status = null)
    {
        $query = static::forUser($userId);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->sum('net_amount');
    }

    public static function getPendingTotalByUser($userId)
    {
        return static::forUser($userId)
                    ->whereIn('status', ['scheduled', 'processing'])
                    ->sum('net_amount');
    }

    public static function getMonthlyTotal($userId, Carbon $month = null)
    {
        $month = $month ?? Carbon::now();

        return static::forUser($userId)
                    ->whereBetween('processed_at', [
                        $month->startOfMonth(),
                        $month->endOfMonth()
                    ])
                    ->completed()
                    ->sum('net_amount');
    }

    // Helper methods for views
    public function getPaymentMethodLabel()
    {
        $methods = [
            'pix' => 'PIX',
            'ted' => 'TED',
            'doc' => 'DOC',
            'bank_transfer' => 'Transferência Bancária',
        ];

        return $methods[$this->payment_method ?? $this->payout_method] ?? 'N/A';
    }

    public function getStatusColor()
    {
        $colors = [
            'pending' => 'warning',
            'processing' => 'info',
            'completed' => 'success',
            'failed' => 'danger',
            'cancelled' => 'secondary',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    public function getStatusLabel()
    {
        $labels = [
            'pending' => 'Pendente',
            'processing' => 'Processando',
            'completed' => 'Concluído',
            'failed' => 'Falhou',
            'cancelled' => 'Cancelado',
        ];

        return $labels[$this->status] ?? $this->status;
    }
}