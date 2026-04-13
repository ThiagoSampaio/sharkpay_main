<?php

namespace Tests\Feature\Affiliate;

use Tests\TestCase;
use App\Models\User;
use App\Models\Product;
use App\Models\Affiliate;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MarketplaceControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $affiliate;
    protected $affiliateRecord;
    protected $product;

    public function setUp(): void
    {
        parent::setUp();

        $this->affiliate = User::factory()->create(['role' => 'user']);
        $this->affiliateRecord = Affiliate::factory()->create([
            'user_id' => $this->affiliate->id,
            'status' => 'approved'
        ]);
        $this->product = Product::factory()->create(['status' => 1]);
    }

    /** @test */
    public function approved_affiliate_can_view_marketplace()
    {
        $response = $this->actingAs($this->affiliate)
            ->get(route('affiliate.marketplace'));

        $response->assertStatus(200);
        $response->assertViewIs('affiliate.marketplace.index');
    }

    /** @test */
    public function affiliate_can_view_product_details()
    {
        $response = $this->actingAs($this->affiliate)
            ->get(route('affiliate.marketplace.show', $this->product->id));

        $response->assertStatus(200);
        $response->assertViewIs('affiliate.marketplace.show');
    }

    /** @test */
    public function affiliate_can_promote_product()
    {
        $response = $this->actingAs($this->affiliate)
            ->post(route('affiliate.promote', $this->product->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('affiliate_links', [
            'affiliate_id' => $this->affiliate->id,
            'product_id' => $this->product->id
        ]);
    }

    /** @test */
    public function affiliate_can_stop_promoting_product()
    {
        // First promote the product
        $this->actingAs($this->affiliate)
            ->post(route('affiliate.promote', $this->product->id));

        // Then stop promoting
        $response = $this->actingAs($this->affiliate)
            ->delete(route('affiliate.stop-promoting', $this->product->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    /** @test */
    public function pending_affiliate_cannot_promote_products()
    {
        $pendingAffiliate = User::factory()->create();
        Affiliate::factory()->create([
            'user_id' => $pendingAffiliate->id,
            'status' => 'pending'
        ]);

        $response = $this->actingAs($pendingAffiliate)
            ->post(route('affiliate.promote', $this->product->id));

        $response->assertStatus(403);
    }
}
