<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CheckoutBuilder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'description',
        'funnel_config',
        'upsell_products',
        'downsell_products',
        'abandoned_cart_config',
        'theme_config',
        'logo_url',
        'custom_css',
        'payment_methods',
        'installment_config',
        'status',
        'conversion_rate',
        'total_revenue',
        'total_orders'
    ];

    protected $casts = [
        'funnel_config' => 'array',
        'upsell_products' => 'array',
        'downsell_products' => 'array',
        'abandoned_cart_config' => 'array',
        'theme_config' => 'array',
        'payment_methods' => 'array',
        'installment_config' => 'array',
        'total_revenue' => 'decimal:2'
    ];

    // Relacionamentos
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'checkout_builder_id');
    }

    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value) . '-' . Str::random(6);
    }

    // Accessors
    public function getCheckoutUrlAttribute()
    {
        return url('/checkout-builder/' . $this->slug);
    }

    public function getConversionRateFormattedAttribute()
    {
        return number_format($this->conversion_rate / 100, 2) . '%';
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeByUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    // Methods
    public function activate()
    {
        $this->update(['status' => 'active']);
    }

    public function deactivate()
    {
        $this->update(['status' => 'inactive']);
    }

    public function archive()
    {
        $this->update(['status' => 'archived']);
    }

    public function updateMetrics($orderValue = 0)
    {
        $totalOrders = $this->orders()->count();
        $totalRevenue = $this->orders()->sum('amount');

        $this->update([
            'total_orders' => $totalOrders,
            'total_revenue' => $totalRevenue
        ]);
    }

    public function getUpsellProducts()
    {
        if (!$this->upsell_products) {
            return collect();
        }

        return Product::whereIn('id', $this->upsell_products)->get();
    }

    public function getDownsellProducts()
    {
        if (!$this->downsell_products) {
            return collect();
        }

        return Product::whereIn('id', $this->downsell_products)->get();
    }

    public function hasUpsells()
    {
        return !empty($this->upsell_products);
    }

    public function hasDownsells()
    {
        return !empty($this->downsell_products);
    }

    public function getDefaultThemeConfig()
    {
        return [
            'primary_color' => '#007bff',
            'secondary_color' => '#6c757d',
            'success_color' => '#28a745',
            'font_family' => 'Arial, sans-serif',
            'button_style' => 'rounded',
            'layout' => 'single-column',
            'show_security_badges' => true,
            'show_testimonials' => true,
            'enable_countdown' => false
        ];
    }

    public function getDefaultPaymentMethods()
    {
        return [
            'pix' => true,
            'credit_card' => true,
            'boleto' => true,
            'bank_transfer' => false
        ];
    }
}