<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PaymentSplit extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'recipient_id',
        'recipient_type',
        'original_amount',
        'split_percentage',
        'split_amount',
        'fee_amount',
        'net_amount',
        'status',
        'split_rule_id',
        'split_config',
        'scheduled_at',
        'processed_at',
        'external_id',
        'failure_reason'
    ];

    protected $casts = [
        'original_amount' => 'decimal:2',
        'split_percentage' => 'decimal:2',
        'split_amount' => 'decimal:2',
        'fee_amount' => 'decimal:2',
        'net_amount' => 'decimal:2',
        'split_config' => 'array',
        'scheduled_at' => 'datetime',
        'processed_at' => 'datetime'
    ];

    // Relacionamentos
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_id');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
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

    public function scopeForRecipient($query, $recipientId)
    {
        return $query->where('recipient_id', $recipientId);
    }

    public function scopeForTransaction($query, $transactionId)
    {
        return $query->where('transaction_id', $transactionId);
    }

    public function scopeReadyToProcess($query)
    {
        return $query->where('status', 'pending')
                    ->where(function($q) {
                        $q->whereNull('scheduled_at')
                          ->orWhere('scheduled_at', '<=', Carbon::now());
                    });
    }

    // Accessors
    public function getSplitAmountFormattedAttribute()
    {
        return 'R$ ' . number_format($this->split_amount, 2, ',', '.');
    }

    public function getNetAmountFormattedAttribute()
    {
        return 'R$ ' . number_format($this->net_amount, 2, ',', '.');
    }

    public function getFeeAmountFormattedAttribute()
    {
        return 'R$ ' . number_format($this->fee_amount, 2, ',', '.');
    }

    public function getSplitPercentageFormattedAttribute()
    {
        return number_format($this->split_percentage, 2, ',', '.') . '%';
    }

    public function getStatusDisplayAttribute()
    {
        $statuses = [
            'pending' => 'Pendente',
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
            'pending' => 'warning',
            'processing' => 'info',
            'completed' => 'success',
            'failed' => 'danger',
            'cancelled' => 'secondary'
        ];

        return $colors[$this->status] ?? 'secondary';
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
        $this->update(['status' => 'cancelled']);
    }

    public function retry()
    {
        if ($this->status === 'failed') {
            $this->update([
                'status' => 'pending',
                'failure_reason' => null,
                'scheduled_at' => Carbon::now()
            ]);
        }
    }

    public function canBeProcessed()
    {
        return $this->status === 'pending' &&
               ($this->scheduled_at === null || $this->scheduled_at->isPast());
    }

    public function canBeRetried()
    {
        return $this->status === 'failed';
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'failed']);
    }

    // Static methods
    public static function createFromTransactionSplit($transactionId, array $splitData)
    {
        $splits = [];

        foreach ($splitData as $split) {
            $paymentSplit = new static();
            $paymentSplit->transaction_id = $transactionId;
            $paymentSplit->recipient_id = $split['recipient_id'];
            $paymentSplit->recipient_type = $split['recipient_type'] ?? 'user';
            $paymentSplit->original_amount = $split['original_amount'];
            $paymentSplit->split_percentage = $split['percentage'];
            $paymentSplit->split_amount = $split['split_amount'];
            $paymentSplit->fee_amount = $split['fee_amount'] ?? 0;
            $paymentSplit->net_amount = $split['net_amount'];
            $paymentSplit->status = 'pending';
            $paymentSplit->split_config = $split['rule'] ?? [];
            $paymentSplit->scheduled_at = $split['scheduled_at'] ?? null;

            $paymentSplit->save();
            $splits[] = $paymentSplit;
        }

        return $splits;
    }

    public static function getTotalByRecipient($recipientId, $status = null)
    {
        $query = static::forRecipient($recipientId);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->sum('net_amount');
    }

    public static function getPendingTotalByRecipient($recipientId)
    {
        return static::forRecipient($recipientId)
                    ->pending()
                    ->sum('net_amount');
    }

    public static function getProcessingTotalByRecipient($recipientId)
    {
        return static::forRecipient($recipientId)
                    ->processing()
                    ->sum('net_amount');
    }
}