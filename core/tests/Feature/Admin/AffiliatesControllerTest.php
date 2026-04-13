<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use App\Models\User;
use App\Models\Affiliate;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AffiliatesControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $affiliate;

    public function setUp(): void
    {
        parent::setUp();

        $this->admin = User::factory()->create([
            'role' => 'admin',
            'is_admin' => true
        ]);

        $user = User::factory()->create();
        $this->affiliate = Affiliate::factory()->create([
            'user_id' => $user->id,
            'status' => 'pending'
        ]);
    }

    /** @test */
    public function admin_can_view_affiliates_list()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.affiliates'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.affiliates.index');
    }

    /** @test */
    public function admin_can_view_affiliate_details()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->get(route('admin.affiliates.show', $this->affiliate->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.affiliates.show');
    }

    /** @test */
    public function admin_can_approve_affiliate()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('admin.affiliates.approve', $this->affiliate->id));

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('affiliates', [
            'id' => $this->affiliate->id,
            'status' => 'approved'
        ]);
    }

    /** @test */
    public function admin_can_reject_affiliate()
    {
        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('admin.affiliates.reject', $this->affiliate->id), [
                'rejection_reason' => 'Does not meet requirements'
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('affiliates', [
            'id' => $this->affiliate->id,
            'status' => 'rejected'
        ]);
    }

    /** @test */
    public function admin_can_update_commission_rate()
    {
        $this->affiliate->update(['status' => 'approved']);

        $response = $this->actingAs($this->admin, 'admin')
            ->post(route('admin.affiliates.commission-rate', $this->affiliate->id), [
                'custom_commission_rate' => 20.00
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('affiliates', [
            'id' => $this->affiliate->id,
            'custom_commission_rate' => 20.00
        ]);
    }

    /** @test */
    public function non_admin_cannot_access_affiliates_management()
    {
        $user = User::factory()->create(['role' => 'user']);

        $response = $this->actingAs($user)
            ->get(route('admin.affiliates'));

        $response->assertStatus(403);
    }
}
