<?php

namespace Tests\Feature\Seller;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class AnalyticsControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $seller;

    public function setUp(): void
    {
        parent::setUp();

        // Create a seller user
        $this->seller = User::factory()->create([
            'role' => 'seller',
            'email_verified_at' => now(),
        ]);
    }

    /** @test */
    public function seller_can_access_analytics_dashboard()
    {
        $response = $this->actingAs($this->seller)
            ->get(route('seller.analytics'));

        $response->assertStatus(200);
        $response->assertViewIs('seller.analytics.index');
        $response->assertViewHas('metrics');
    }

    /** @test */
    public function guest_cannot_access_analytics()
    {
        $response = $this->get(route('seller.analytics'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function seller_can_view_products_analytics()
    {
        $response = $this->actingAs($this->seller)
            ->get(route('seller.analytics.products'));

        $response->assertStatus(200);
        $response->assertViewIs('seller.analytics.products');
    }

    /** @test */
    public function seller_can_view_customers_analytics()
    {
        $response = $this->actingAs($this->seller)
            ->get(route('seller.analytics.customers'));

        $response->assertStatus(200);
        $response->assertViewIs('seller.analytics.customers');
    }

    /** @test */
    public function analytics_contains_required_metrics()
    {
        $response = $this->actingAs($this->seller)
            ->get(route('seller.analytics'));

        $response->assertViewHas('metrics', function ($metrics) {
            return isset($metrics['revenue']) &&
                   isset($metrics['orders']) &&
                   isset($metrics['conversion_rate']);
        });
    }
}
