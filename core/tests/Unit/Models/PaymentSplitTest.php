<?php

namespace Tests\Unit\Models;

use Tests\TestCase;
use App\Models\PaymentSplit;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaymentSplitTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function payment_split_belongs_to_invoice()
    {
        $invoice = Invoice::factory()->create();
        $split = PaymentSplit::factory()->create(['invoice_id' => $invoice->id]);

        $this->assertInstanceOf(Invoice::class, $split->invoice);
        $this->assertEquals($invoice->id, $split->invoice->id);
    }

    /** @test */
    public function payment_split_belongs_to_recipient()
    {
        $user = User::factory()->create();
        $split = PaymentSplit::factory()->create([
            'recipient_id' => $user->id,
            'recipient_type' => 'user'
        ]);

        $this->assertInstanceOf(User::class, $split->recipient);
        $this->assertEquals($user->id, $split->recipient->id);
    }

    /** @test */
    public function it_casts_recipient_data_to_array()
    {
        $data = [
            'pix_key' => '123.456.789-00',
            'bank_account' => '12345-6'
        ];

        $split = PaymentSplit::factory()->create([
            'recipient_data' => json_encode($data)
        ]);

        $this->assertIsArray($split->recipient_data);
        $this->assertEquals('123.456.789-00', $split->recipient_data['pix_key']);
    }

    /** @test */
    public function it_checks_if_split_is_pending()
    {
        $pendingSplit = PaymentSplit::factory()->create(['status' => 'pending']);
        $completedSplit = PaymentSplit::factory()->create(['status' => 'completed']);

        $this->assertTrue($pendingSplit->isPending());
        $this->assertFalse($completedSplit->isPending());
    }

    /** @test */
    public function it_checks_if_split_is_completed()
    {
        $completedSplit = PaymentSplit::factory()->create(['status' => 'completed']);
        $pendingSplit = PaymentSplit::factory()->create(['status' => 'pending']);

        $this->assertTrue($completedSplit->isCompleted());
        $this->assertFalse($pendingSplit->isCompleted());
    }

    /** @test */
    public function it_calculates_net_amount_after_fees()
    {
        $split = PaymentSplit::factory()->create([
            'amount' => 100,
            'fee_amount' => 5
        ]);

        $this->assertEquals(95, $split->net_amount);
    }

    /** @test */
    public function it_filters_splits_by_status()
    {
        PaymentSplit::factory()->create(['status' => 'pending']);
        PaymentSplit::factory()->create(['status' => 'completed']);
        PaymentSplit::factory()->create(['status' => 'pending']);

        $pendingSplits = PaymentSplit::where('status', 'pending')->get();

        $this->assertCount(2, $pendingSplits);
    }
}
