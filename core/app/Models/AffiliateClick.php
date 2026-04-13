<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateClick extends Model
{
    protected $table = 'affiliate_clicks';

    protected $fillable = [
        'link_id',
        'ip_address',
        'user_agent',
        'referrer',
        'converted',
        'converted_at',
    ];

    protected $casts = [
        'converted' => 'boolean',
        'converted_at' => 'datetime',
        'created_at' => 'datetime',
    ];

    public $timestamps = false;

    /**
     * Relacionamento com Link
     */
    public function link()
    {
        return $this->belongsTo(AffiliateLink::class, 'link_id');
    }
}
