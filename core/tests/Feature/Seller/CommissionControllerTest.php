<?php

namespace Tests\Feature\Seller;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommissionControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $seller;
    protected $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->seller = User::factory()->create(['role' => 'seller']);
        $this->product = Product::factory()->create(['user_id' => $this->seller->id]);
    }

    /** @test */
    public function seller_can_view_commissions_page()
    {
        $response = $this->actingAs($this->seller)
            ->get(route('seller.commissions'));

        $response->assertStatus(200);
        $response->assertViewIs('seller.commissions.index');
    }

    /** @test */
    public function seller_can_view_commission_settings()
    {
        $response = $this->actingAs($this->seller)
            ->get(route('seller.commissions.settings'));

        $response->assertStatus(200);
        $response->assertViewIs('seller.commissions.settings');
    }

    /** @test */
    public function seller_can_update_product_commission()
    {
        $response = $this->actingAs($this->seller)
            ->post(route('seller.commissions.update', $this->product->id), [
                'commission_rate' => 15.00
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    /** @test */
    public function commission_rate_must_be_between_0_and_100()
    {
        $response = $this->actingAs($this->seller)
            ->post(route('seller.commissions.update', $this->product->id), [
                'commission_rate' => 150
            ]);

        $response->assertSessionHasErrors('commission_rate');
    }

    /** @test */
    public function seller_cannot_update_commission_of_other_sellers_products()
    {
        $otherSeller = User::factory()->create(['role' => 'seller']);
        $otherProduct = Product::factory()->create(['user_id' => $otherSeller->id]);

        $response = $this->actingAs($this->seller)
            ->post(route('seller.commissions.update', $otherProduct->id), [
                'commission_rate' => 15.00
            ]);

        $response->assertStatus(403);
    }
}
