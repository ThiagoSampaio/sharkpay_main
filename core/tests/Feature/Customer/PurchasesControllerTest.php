<?php

namespace Tests\Feature\Customer;

use Tests\TestCase;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PurchasesControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $customer;
    protected $order;

    public function setUp(): void
    {
        parent::setUp();

        $this->customer = User::factory()->create(['role' => 'customer']);
        $product = Product::factory()->create();

        $this->order = Order::factory()->create([
            'user_id' => $this->customer->id,
            'status' => 1
        ]);
    }

    /** @test */
    public function customer_can_view_purchases()
    {
        $response = $this->actingAs($this->customer)
            ->get(route('customer.purchases'));

        $response->assertStatus(200);
        $response->assertViewIs('customer.purchases.index');
    }

    /** @test */
    public function customer_can_view_purchase_details()
    {
        $response = $this->actingAs($this->customer)
            ->get(route('customer.purchases.show', $this->order->id));

        $response->assertStatus(200);
        $response->assertViewIs('customer.purchases.show');
    }

    /** @test */
    public function customer_can_download_invoice()
    {
        $response = $this->actingAs($this->customer)
            ->get(route('customer.purchases.invoice', $this->order->id));

        $response->assertStatus(200);
    }

    /** @test */
    public function customer_can_request_refund_within_7_days()
    {
        $recentOrder = Order::factory()->create([
            'user_id' => $this->customer->id,
            'created_at' => now()->subDays(5)
        ]);

        $response = $this->actingAs($this->customer)
            ->post(route('customer.purchases.refund', $recentOrder->id), [
                'reason' => 'Not satisfied with the product'
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');
    }

    /** @test */
    public function customer_cannot_request_refund_after_7_days()
    {
        $oldOrder = Order::factory()->create([
            'user_id' => $this->customer->id,
            'created_at' => now()->subDays(10)
        ]);

        $response = $this->actingAs($this->customer)
            ->post(route('customer.purchases.refund', $oldOrder->id), [
                'reason' => 'Not satisfied'
            ]);

        $response->assertStatus(403);
    }

    /** @test */
    public function customer_cannot_view_other_customers_purchases()
    {
        $otherCustomer = User::factory()->create(['role' => 'customer']);
        $otherOrder = Order::factory()->create(['user_id' => $otherCustomer->id]);

        $response = $this->actingAs($this->customer)
            ->get(route('customer.purchases.show', $otherOrder->id));

        $response->assertStatus(403);
    }
}
