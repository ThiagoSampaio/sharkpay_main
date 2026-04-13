<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\Affiliate;
use App\Models\User;
use App\Models\Commission;
use App\Models\AffiliateLink;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AffiliateTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function affiliate_belongs_to_user()
    {
        $user = User::factory()->create();
        $affiliate = Affiliate::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $affiliate->user);
        $this->assertEquals($user->id, $affiliate->user->id);
    }

    /** @test */
    public function affiliate_has_many_links()
    {
        $affiliate = Affiliate::factory()->create();
        $link = AffiliateLink::factory()->create(['affiliate_id' => $affiliate->user_id]);

        $this->assertInstanceOf(AffiliateLink::class, $affiliate->links->first());
    }

    /** @test */
    public function affiliate_has_many_commissions()
    {
        $affiliate = Affiliate::factory()->create();
        $commission = Commission::factory()->create(['affiliate_id' => $affiliate->user_id]);

        $this->assertInstanceOf(Commission::class, $affiliate->commissions->first());
    }

    /** @test */
    public function is_approved_returns_true_for_approved_affiliate()
    {
        $affiliate = Affiliate::factory()->create(['status' => 'approved']);

        $this->assertTrue($affiliate->isApproved());
    }

    /** @test */
    public function is_approved_returns_false_for_pending_affiliate()
    {
        $affiliate = Affiliate::factory()->create(['status' => 'pending']);

        $this->assertFalse($affiliate->isApproved());
    }

    /** @test */
    public function is_pending_returns_true_for_pending_affiliate()
    {
        $affiliate = Affiliate::factory()->create(['status' => 'pending']);

        $this->assertTrue($affiliate->isPending());
    }

    /** @test */
    public function payment_details_are_cast_to_array()
    {
        $details = ['bank' => 'Bank of Brazil', 'account' => '12345'];
        $affiliate = Affiliate::factory()->create([
            'payment_details' => json_encode($details)
        ]);

        $this->assertIsArray($affiliate->payment_details);
        $this->assertEquals('Bank of Brazil', $affiliate->payment_details['bank']);
    }
}
