<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AffiliateLink extends Model
{
    protected $table = 'affiliate_links';

    protected $fillable = [
        'affiliate_id',
        'product_id',
        'campaign_id',
        'link_code',
        'full_url',
    ];

    protected $casts = [
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
     * Relacionamento com Product
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Relacionamento com Campaign
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Relacionamento com Clicks
     */
    public function clicks()
    {
        return $this->hasMany(AffiliateClick::class, 'link_id');
    }

    /**
     * Gera URL completa
     */
    public function generateUrl($baseUrl)
    {
        return $baseUrl . '?ref=' . $this->link_code;
    }
}
