<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    protected $table = 'campaigns';

    protected $fillable = [
        'user_id',
        'name',
        'type',
        'status',
        'settings',
        'started_at',
        'ended_at',
    ];

    protected $casts = [
        'settings' => 'array',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
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
     * Relacionamento com Links (para campanhas de afiliado)
     */
    public function affiliateLinks()
    {
        return $this->hasMany(AffiliateLink::class);
    }

    /**
     * Verifica se está ativa
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Verifica se é email campaign
     */
    public function isEmailCampaign()
    {
        return $this->type === 'email';
    }
}
