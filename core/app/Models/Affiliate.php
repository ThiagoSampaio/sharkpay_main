<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Affiliate extends Model
{
    protected $table = 'affiliates';

    protected $fillable = [
        'user_id',
        'affiliate_code',
        'status',
        'custom_commission_rate',
        'payment_method',
        'payment_details',
        'rejection_reason',
        'approved_at',
    ];

    protected $casts = [
        'payment_details' => 'array',
        'approved_at' => 'datetime',
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
     * Relacionamento com Links
     */
    public function links()
    {
        return $this->hasMany(AffiliateLink::class);
    }

    /**
     * Relacionamento com Comissões
     */
    public function commissions()
    {
        return $this->hasMany(Commission::class);
    }

    /**
     * Relacionamento com Saques
     */
    public function withdrawals()
    {
        return $this->hasMany(AffiliateWithdrawal::class);
    }

    /**
     * Verifica se está aprovado
     */
    public function isApproved()
    {
        return $this->status === 'approved';
    }

    /**
     * Verifica se está pendente
     */
    public function isPending()
    {
        return $this->status === 'pending';
    }
}
