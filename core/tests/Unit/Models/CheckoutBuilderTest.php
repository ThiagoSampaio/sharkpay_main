<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\CheckoutBuilder;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CheckoutBuilderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function checkout_builder_belongs_to_user()
    {
        $user = User::factory()->create();
        $checkout = CheckoutBuilder::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $checkout->user);
        $this->assertEquals($user->id, $checkout->user->id);
    }

    /** @test */
    public function it_casts_config_to_array()
    {
        $config = [
            'upsell_enabled' => true,
            'downsell_enabled' => false,
            'theme' => 'modern'
        ];

        $checkout = CheckoutBuilder::factory()->create([
            'config' => json_encode($config)
        ]);

        $this->assertIsArray($checkout->config);
        $this->assertTrue($checkout->config['upsell_enabled']);
    }

    /** @test */
    public function it_casts_theme_settings_to_array()
    {
        $themeSettings = [
            'primary_color' => '#3490dc',
            'font_family' => 'Inter',
            'button_style' => 'rounded'
        ];

        $checkout = CheckoutBuilder::factory()->create([
            'theme_settings' => json_encode($themeSettings)
        ]);

        $this->assertIsArray($checkout->theme_settings);
        $this->assertEquals('#3490dc', $checkout->theme_settings['primary_color']);
    }

    /** @test */
    public function it_checks_if_checkout_is_active()
    {
        $activeCheckout = CheckoutBuilder::factory()->create(['status' => 'active']);
        $inactiveCheckout = CheckoutBuilder::factory()->create(['status' => 'inactive']);

        $this->assertTrue($activeCheckout->isActive());
        $this->assertFalse($inactiveCheckout->isActive());
    }

    /** @test */
    public function it_generates_unique_slug()
    {
        $checkout1 = CheckoutBuilder::factory()->create(['name' => 'My Checkout']);
        $checkout2 = CheckoutBuilder::factory()->create(['name' => 'My Checkout']);

        $this->assertNotEquals($checkout1->slug, $checkout2->slug);
    }

    /** @test */
    public function it_tracks_conversion_metrics()
    {
        $checkout = CheckoutBuilder::factory()->create([
            'total_visits' => 100,
            'total_conversions' => 25,
            'total_revenue' => 5000
        ]);

        $this->assertEquals(25, $checkout->conversion_rate);
        $this->assertEquals(50, $checkout->average_order_value);
    }
}
