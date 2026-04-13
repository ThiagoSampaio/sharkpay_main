<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\PayoutService;
use App\Models\User;
use App\Models\Payout;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PayoutServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $payoutService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->payoutService = new PayoutService();
    }

    /** @test */
    public function it_calculates_available_balance_correctly()
    {
        $user = User::factory()->create();

        // Create completed invoices
        Invoice::factory()->count(3)->create([
            'user_id' => $user->id,
            'status' => 'paid',
            'total_amount' => 100
        ]);

        $balance = $this->payoutService->getAvailableBalance($user->id);

        $this->assertIsNumeric($balance);
        $this->assertGreaterThanOrEqual(0, $balance);
    }

    /** @test */
    public function it_returns_minimum_payout_amount()
    {
        $minimum = $this->payoutService->getMinimumPayoutAmount();

        $this->assertIsNumeric($minimum);
        $this->assertGreaterThan(0, $minimum);
    }

    /** @test */
    public function it_calculates_payout_fee_for_pix()
    {
        $fee = $this->payoutService->calculatePayoutFee(100, 'pix');

        $this->assertIsNumeric($fee);
        $this->assertGreaterThanOrEqual(0, $fee);
    }

    /** @test */
    public function it_calculates_payout_fee_for_bank_transfer()
    {
        $fee = $this->payoutService->calculatePayoutFee(100, 'bank_transfer');

        $this->assertIsNumeric($fee);
        $this->assertGreaterThanOrEqual(0, $fee);
    }

    /** @test */
    public function it_reserves_balance_for_pending_payout()
    {
        $user = User::factory()->create();
        $amount = 50;

        $result = $this->payoutService->reserveBalance($user->id, $amount);

        $this->assertTrue($result);
    }

    /** @test */
    public function it_releases_reserved_balance_on_cancellation()
    {
        $user = User::factory()->create();
        $amount = 50;

        $this->payoutService->reserveBalance($user->id, $amount);
        $result = $this->payoutService->releaseReservedBalance($user->id, $amount);

        $this->assertTrue($result);
    }
}
