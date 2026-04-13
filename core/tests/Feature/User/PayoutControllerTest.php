<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use App\Models\Payout;
use App\Models\Invoice;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PayoutControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function user_can_view_payout_index()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'user')
            ->get(route('user.payouts.index'));

        $response->assertStatus(200);
        $response->assertViewIs('user.payouts.index');
    }

    /** @test */
    public function user_can_request_payout()
    {
        $user = User::factory()->create();

        // Create paid invoices to have balance
        Invoice::factory()->count(3)->create([
            'user_id' => $user->id,
            'status' => 'paid',
            'total_amount' => 100
        ]);

        $payoutData = [
            'amount' => 50,
            'payout_method' => 'pix',
            'scheduled_date' => now()->addDays(1)->format('Y-m-d'),
            'recipient_data' => [
                'pix_key' => '123.456.789-00',
                'pix_key_type' => 'cpf'
            ],
            'description' => 'Test payout'
        ];

        $response = $this->actingAs($user, 'user')
            ->post(route('user.payouts.store'), $payoutData);

        $response->assertRedirect();
        $this->assertDatabaseHas('payouts', [
            'user_id' => $user->id,
            'amount' => 50,
            'status' => 'scheduled'
        ]);
    }

    /** @test */
    public function user_cannot_request_payout_with_insufficient_balance()
    {
        $user = User::factory()->create();

        $payoutData = [
            'amount' => 1000, // More than available
            'payout_method' => 'pix',
            'scheduled_date' => now()->addDays(1)->format('Y-m-d'),
            'recipient_data' => [
                'pix_key' => '123.456.789-00',
                'pix_key_type' => 'cpf'
            ]
        ];

        $response = $this->actingAs($user, 'user')
            ->post(route('user.payouts.store'), $payoutData);

        $response->assertSessionHas('error');
    }

    /** @test */
    public function user_can_cancel_scheduled_payout()
    {
        $user = User::factory()->create();
        $payout = Payout::factory()->create([
            'user_id' => $user->id,
            'status' => 'scheduled'
        ]);

        $response = $this->actingAs($user, 'user')
            ->post(route('user.payouts.cancel', $payout->id));

        $response->assertRedirect();
        $this->assertDatabaseHas('payouts', [
            'id' => $payout->id,
            'status' => 'cancelled'
        ]);
    }

    /** @test */
    public function user_can_view_payout_details()
    {
        $user = User::factory()->create();
        $payout = Payout::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user, 'user')
            ->get(route('user.payouts.show', $payout->id));

        $response->assertStatus(200);
        $response->assertViewIs('user.payouts.show');
        $response->assertViewHas('payout', $payout);
    }

    /** @test */
    public function user_cannot_view_other_users_payout()
    {
        $user = User::factory()->create();
        $otherUser = User::factory()->create();
        $payout = Payout::factory()->create(['user_id' => $otherUser->id]);

        $response = $this->actingAs($user, 'user')
            ->get(route('user.payouts.show', $payout->id));

        $response->assertStatus(404);
    }

    /** @test */
    public function it_calculates_fee_via_api()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user, 'user')
            ->postJson(route('user.payouts.api.calculate-fee'), [
                'amount' => 100,
                'method' => 'pix'
            ]);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'gross_amount',
            'fee_amount',
            'net_amount',
            'formatted_fee',
            'formatted_net'
        ]);
    }
}
