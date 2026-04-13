<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateWithdrawal extends Model
{
    protected $table = 'affiliate_withdrawals';

    protected $fillable = [
        'affiliate_id',
        'amount',
        'payment_method',
        'payment_details',
        'status',
        'rejection_reason',
        'processed_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_details' => 'array',
        'processed_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public $timestamps = false;

    /**
     * Relacionamento com Affiliate
     */
    public function affiliate()
    {
        return $this->belongsTo(Affiliate::class);
    }

    /**
     * Verifica se está pendente
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }

    /**
     * Verifica se foi aprovado
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Verifica se foi rejeitado
     */
    public function isRejected()
    {
        return $this->status === 'rejected';
    }
}
