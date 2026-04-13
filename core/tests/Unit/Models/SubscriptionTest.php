<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SubscriptionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function subscription_belongs_to_user()
    {
        $user = User::factory()->create();
        $subscription = Subscription::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $subscription->user);
        $this->assertEquals($user->id, $subscription->user->id);
    }

    /** @test */
    public function subscription_belongs_to_product()
    {
        $product = Product::factory()->create();
        $subscription = Subscription::factory()->create(['product_id' => $product->id]);

        $this->assertInstanceOf(Product::class, $subscription->product);
        $this->assertEquals($product->id, $subscription->product->id);
    }

    /** @test */
    public function is_active_returns_true_for_active_subscription()
    {
        $subscription = Subscription::factory()->create(['status' => 'active']);

        $this->assertTrue($subscription->isActive());
    }

    /** @test */
    public function is_cancelled_returns_true_for_cancelled_subscription()
    {
        $subscription = Subscription::factory()->create(['status' => 'cancelled']);

        $this->assertTrue($subscription->isCancelled());
    }

    /** @test */
    public function is_expired_returns_true_for_expired_subscription()
    {
        $subscription = Subscription::factory()->create(['status' => 'expired']);

        $this->assertTrue($subscription->isExpired());
    }

    /** @test */
    public function calculate_next_billing_for_weekly_cycle()
    {
        $subscription = Subscription::factory()->create([
            'billing_cycle' => 'weekly',
            'next_billing_date' => Carbon::parse('2025-10-01')
        ]);

        $nextBilling = $subscription->calculateNextBilling();

        $this->assertEquals('2025-10-08', $nextBilling->format('Y-m-d'));
    }

    /** @test */
    public function calculate_next_billing_for_monthly_cycle()
    {
        $subscription = Subscription::factory()->create([
            'billing_cycle' => 'monthly',
            'next_billing_date' => Carbon::parse('2025-10-01')
        ]);

        $nextBilling = $subscription->calculateNextBilling();

        $this->assertEquals('2025-11-01', $nextBilling->format('Y-m-d'));
    }

    /** @test */
    public function calculate_next_billing_for_yearly_cycle()
    {
        $subscription = Subscription::factory()->create([
            'billing_cycle' => 'yearly',
            'next_billing_date' => Carbon::parse('2025-10-01')
        ]);

        $nextBilling = $subscription->calculateNextBilling();

        $this->assertEquals('2026-10-01', $nextBilling->format('Y-m-d'));
    }

    /** @test */
    public function amount_is_cast_to_decimal()
    {
        $subscription = Subscription::factory()->create(['amount' => 99.99]);

        $this->assertIsString($subscription->amount);
        $this->assertEquals('99.99', $subscription->amount);
    }
}
