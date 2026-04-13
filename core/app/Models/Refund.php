<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;

class Refund extends Model
{
    use HasFactory;

    protected $fillable = [
        'refund_id',
        'transaction_id',
        'original_transaction_id',
        'user_id',
        'requested_by',
        'original_amount',
        'refund_amount',
        'fee_amount',
        'refund_type',
        'reason',
        'reason_details',
        'status',
        'requested_at',
        'approved_at',
        'processed_at',
        'approved_by',
        'external_id',
        'rejected_reason',
        'rejection_reason',
        'failure_reason',
        'gateway_refund_id',
        'metadata'
    ];

    protected $casts = [
        'original_amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'fee_amount' => 'decimal:2',
        'requested_at' => 'datetime',
        'approved_at' => 'datetime',
        'processed_at' => 'datetime',
        'metadata' => 'array'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($refund) {
            if (!$refund->refund_id) {
                $refund->refund_id = 'REF-' . strtoupper(Str::random(8)) . '-' . time();
            }
            if (!$refund->requested_at) {
                $refund->requested_at = Carbon::now();
            }
        });
    }

    // Relacionamentos
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function requestedBy()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scopes
    public function scopeRequested($query)
    {
        return $query->where('status', 'requested');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeProcessing($query)
    {
        return $query->where('status', 'processing');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeForTransaction($query, $transactionId)
    {
        return $query->where('original_transaction_id', $transactionId);
    }

    public function scopePendingApproval($query)
    {
        return $query->where('status', 'requested');
    }

    public function scopeReadyToProcess($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeFullRefunds($query)
    {
        return $query->where('refund_type', 'full');
    }

    public function scopePartialRefunds($query)
    {
        return $query->where('refund_type', 'partial');
    }

    // Accessors
    public function getOriginalAmountFormattedAttribute()
    {
        return 'R$ ' . number_format($this->original_amount, 2, ',', '.');
    }

    public function getRefundAmountFormattedAttribute()
    {
        return 'R$ ' . number_format($this->refund_amount, 2, ',', '.');
    }

    public function getFeeAmountFormattedAttribute()
    {
        return 'R$ ' . number_format($this->fee_amount, 2, ',', '.');
    }

    public function getStatusDisplayAttribute()
    {
        $statuses = [
            'requested' => 'Solicitado',
            'approved' => 'Aprovado',
            'processing' => 'Processando',
            'completed' => 'Concluído',
            'rejected' => 'Rejeitado',
            'failed' => 'Falhou'
        ];

        return $statuses[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'requested' => 'warning',
            'approved' => 'info',
            'processing' => 'primary',
            'completed' => 'success',
            'rejected' => 'danger',
            'failed' => 'danger'
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    public function getRefundTypeDisplayAttribute()
    {
        return $this->refund_type === 'full' ? 'Reembolso Total' : 'Reembolso Parcial';
    }

    public function getRefundPercentageAttribute()
    {
        if ($this->original_amount <= 0) {
            return 0;
        }

        return ($this->refund_amount / $this->original_amount) * 100;
    }

    public function getRefundPercentageFormattedAttribute()
    {
        return number_format($this->refund_percentage, 1, ',', '.') . '%';
    }

    public function getDaysProcessingAttribute()
    {
        if (!$this->requested_at) {
            return 0;
        }

        $endDate = $this->processed_at ?? Carbon::now();
        return $this->requested_at->diffInDays($endDate);
    }

    // Methods
    public function approve($approvedBy = null)
    {
        if ($this->status !== 'requested') {
            return false;
        }

        $this->update([
            'status' => 'approved',
            'approved_at' => Carbon::now(),
            'approved_by' => $approvedBy
        ]);

        return true;
    }

    public function reject($reason = null, $rejectedBy = null)
    {
        if ($this->status !== 'requested') {
            return false;
        }

        $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'approved_by' => $rejectedBy
        ]);

        return true;
    }

    public function markAsProcessing()
    {
        if ($this->status !== 'approved') {
            return false;
        }

        $this->update(['status' => 'processing']);
        return true;
    }

    public function markAsCompleted($externalId = null)
    {
        if ($this->status !== 'processing') {
            return false;
        }

        $this->update([
            'status' => 'completed',
            'processed_at' => Carbon::now(),
            'external_id' => $externalId
        ]);

        return true;
    }

    public function markAsFailed($reason = null)
    {
        $this->update([
            'status' => 'failed',
            'failure_reason' => $reason
        ]);

        return true;
    }

    public function canBeApproved()
    {
        return $this->status === 'requested';
    }

    public function canBeRejected()
    {
        return $this->status === 'requested';
    }

    public function canBeProcessed()
    {
        return $this->status === 'approved';
    }

    public function canBeRetried()
    {
        return $this->status === 'failed';
    }

    public function retry()
    {
        if ($this->status === 'failed') {
            $this->update([
                'status' => 'approved',
                'failure_reason' => null
            ]);
        }
    }

    public function getNetRefundAmount()
    {
        return $this->refund_amount - $this->fee_amount;
    }

    public function addMetadata($key, $value)
    {
        $metadata = $this->metadata ?? [];
        $metadata[$key] = $value;
        $this->update(['metadata' => $metadata]);
    }

    // Static methods
    public static function createFullRefund($transactionId, $originalAmount, $reason, $requestedBy = null)
    {
        return static::create([
            'original_transaction_id' => $transactionId,
            'user_id' => $requestedBy,
            'requested_by' => $requestedBy,
            'original_amount' => $originalAmount,
            'refund_amount' => $originalAmount,
            'refund_type' => 'full',
            'reason' => $reason,
            'status' => 'requested'
        ]);
    }

    public static function createPartialRefund($transactionId, $originalAmount, $refundAmount, $reason, $requestedBy = null)
    {
        return static::create([
            'original_transaction_id' => $transactionId,
            'user_id' => $requestedBy,
            'requested_by' => $requestedBy,
            'original_amount' => $originalAmount,
            'refund_amount' => $refundAmount,
            'refund_type' => 'partial',
            'reason' => $reason,
            'status' => 'requested'
        ]);
    }

    public static function getTotalByUser($userId, $status = null)
    {
        $query = static::forUser($userId);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->sum('refund_amount');
    }

    public static function getTransactionRefunds($transactionId)
    {
        return static::forTransaction($transactionId)
                    ->orderBy('created_at', 'desc')
                    ->get();
    }

    public static function getTotalRefundedForTransaction($transactionId)
    {
        return static::forTransaction($transactionId)
                    ->whereIn('status', ['completed'])
                    ->sum('refund_amount');
    }

    public static function getMonthlyStats(Carbon $month = null)
    {
        $month = $month ?? Carbon::now();

        return [
            'total_requested' => static::whereBetween('requested_at', [
                $month->startOfMonth(),
                $month->endOfMonth()
            ])->sum('refund_amount'),

            'total_completed' => static::whereBetween('processed_at', [
                $month->startOfMonth(),
                $month->endOfMonth()
            ])->completed()->sum('refund_amount'),

            'count_requested' => static::whereBetween('requested_at', [
                $month->startOfMonth(),
                $month->endOfMonth()
            ])->count(),

            'count_completed' => static::whereBetween('processed_at', [
                $month->startOfMonth(),
                $month->endOfMonth()
            ])->completed()->count(),

            'average_processing_time' => static::whereBetween('processed_at', [
                $month->startOfMonth(),
                $month->endOfMonth()
            ])->completed()->avg('days_processing')
        ];
    }

    // Helper methods for views
    public function isPartial()
    {
        return $this->refund_type === 'partial' || $this->refund_amount < $this->original_amount;
    }

    public function getStatusColor()
    {
        $colors = [
            'pending' => 'warning',
            'analyzing' => 'info',
            'approved' => 'primary',
            'processing' => 'info',
            'completed' => 'success',
            'rejected' => 'danger',
            'cancelled' => 'secondary',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    public function getStatusLabel()
    {
        $labels = [
            'pending' => 'Pendente',
            'analyzing' => 'Em Análise',
            'approved' => 'Aprovado',
            'processing' => 'Processando',
            'completed' => 'Concluído',
            'rejected' => 'Rejeitado',
            'cancelled' => 'Cancelado',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    public function canBeCancelled()
    {
        return in_array($this->status, ['pending', 'analyzing']);
    }

    public function hasDocuments()
    {
        // Check if metadata has documents or implement document relationship
        return isset($this->metadata['documents']) && count($this->metadata['documents']) > 0;
    }
}