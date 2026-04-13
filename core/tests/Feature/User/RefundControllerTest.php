<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use App\Models\Refund;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RefundControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_refunds_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'user')
            ->get(route('user.refunds.index'));

        $response->assertStatus(200);
        $response->assertViewIs('user.refunds.index');
    }

    /** @test */
    public function user_can_request_refund_for_paid_invoice()
    {
        $user = User::factory()->create();
        $invoice = Invoice::factory()->create([
            'user_id' => $user->id,
            'status' => 'paid',
            'total_amount' => 100
        ]);

        $refundData = [
            'invoice_id' => $invoice->id,
            'amount' => 100,
            'refund_type' => 'full',
            'reason' => 'Customer request',
            'description' => 'Full refund requested'
        ];

        $response = $this->actingAs($user, 'user')
            ->post(route('user.refunds.store'), $refundData);

        $response->assertRedirect();
        $this->assertDatabaseHas('refunds', [
            'user_id' => $user->id,
            'invoice_id' => $invoice->id,
            'status' => 'requested'
        ]);
    }

    /** @test */
    public function user_can_request_partial_refund()
    {
        $user = User::factory()->create();
        $invoice = Invoice::factory()->create([
            'user_id' => $user->id,
            'status' => 'paid',
            'total_amount' => 100
        ]);

        $refundData = [
            'invoice_id' => $invoice->id,
            'amount' => 50,
            'refund_type' => 'partial',
            'reason' => 'Partial return',
            'description' => 'Returning one item'
        ];

        $response = $this->actingAs($user, 'user')
            ->post(route('user.refunds.store'), $refundData);

        $response->assertRedirect();
        $this->assertDatabaseHas('refunds', [
            'user_id' => $user->id,
            'amount' => 50,
            'refund_type' => 'partial'
        ]);
    }

    /** @test */
    public function user_cannot_refund_unpaid_invoice()
    {
        $user = User::factory()->create();
        $invoice = Invoice::factory()->create([
            'user_id' => $user->id,
            'status' => 'pending',
            'total_amount' => 100
        ]);

        $refundData = [
            'invoice_id' => $invoice->id,
            'amount' => 100,
            'refund_type' => 'full',
            'reason' => 'Test'
        ];

        $response = $this->actingAs($user, 'user')
            ->post(route('user.refunds.store'), $refundData);

        $response->assertSessionHas('error');
    }

    /** @test */
    public function user_can_view_refund_details()
    {
        $user = User::factory()->create();
        $refund = Refund::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'user')
            ->get(route('user.refunds.show', $refund->id));

        $response->assertStatus(200);
        $response->assertViewIs('user.refunds.show');
        $response->assertViewHas('refund', $refund);
    }

    /** @test */
    public function user_can_cancel_pending_refund_request()
    {
        $user = User::factory()->create();
        $refund = Refund::factory()->create([
            'user_id' => $user->id,
            'status' => 'requested'
        ]);

        $response = $this->actingAs($user, 'user')
            ->post(route('user.refunds.cancel', $refund->id));

        $response->assertRedirect();
        $this->assertDatabaseHas('refunds', [
            'id' => $refund->id,
            'status' => 'cancelled'
        ]);
    }

    /** @test */
    public function it_checks_refund_eligibility_via_api()
    {
        $user = User::factory()->create();
        $invoice = Invoice::factory()->create([
            'user_id' => $user->id,
            'status' => 'paid'
        ]);

        $response = $this->actingAs($user, 'user')
            ->getJson(route('user.refunds.api.eligibility', ['invoice_id' => $invoice->id]));

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'eligible',
            'reason'
        ]);
    }
}
