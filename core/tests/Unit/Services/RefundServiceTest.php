<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\RefundService;
use App\Models\Invoice;
use App\Models\User;
use App\Models\Refund;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RefundServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $refundService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->refundService = new RefundService();
    }

    /** @test */
    public function it_checks_refund_eligibility_for_paid_invoice()
    {
        $invoice = Invoice::factory()->create([
            'status' => 'paid',
            'total_amount' => 100
        ]);

        $eligible = $this->refundService->isEligibleForRefund($invoice->id);

        $this->assertTrue($eligible);
    }

    /** @test */
    public function it_rejects_refund_eligibility_for_unpaid_invoice()
    {
        $invoice = Invoice::factory()->create([
            'status' => 'pending',
            'total_amount' => 100
        ]);

        $eligible = $this->refundService->isEligibleForRefund($invoice->id);

        $this->assertFalse($eligible);
    }

    /** @test */
    public function it_calculates_refund_fee()
    {
        $amount = 100;
        $fee = $this->refundService->calculateRefundFee($amount);

        $this->assertIsNumeric($fee);
        $this->assertGreaterThanOrEqual(0, $fee);
    }

    /** @test */
    public function it_calculates_partial_refund_amount()
    {
        $invoice = Invoice::factory()->create([
            'total_amount' => 100
        ]);

        $refundAmount = $this->refundService->calculatePartialRefund($invoice->id, 50);

        $this->assertEquals(50, $refundAmount);
    }

    /** @test */
    public function it_processes_full_refund()
    {
        $user = User::factory()->create();
        $invoice = Invoice::factory()->create([
            'user_id' => $user->id,
            'status' => 'paid',
            'total_amount' => 100
        ]);

        $refund = Refund::factory()->create([
            'user_id' => $user->id,
            'invoice_id' => $invoice->id,
            'amount' => 100,
            'refund_type' => 'full',
            'status' => 'approved'
        ]);

        $result = $this->refundService->processRefund($refund->id);

        $this->assertTrue($result);
    }
}
