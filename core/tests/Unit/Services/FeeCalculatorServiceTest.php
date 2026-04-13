<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\FeeCalculatorService;
use App\Models\FeeStructure;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class FeeCalculatorServiceTest extends TestCase
{
    use RefreshDatabase;

    protected $feeCalculator;

    protected function setUp(): void
    {
        parent::setUp();
        $this->feeCalculator = new FeeCalculatorService();
    }

    /** @test */
    public function it_calculates_percentage_fee()
    {
        $user = User::factory()->create();

        FeeStructure::factory()->create([
            'user_id' => $user->id,
            'fee_type' => 'percentage',
            'fee_value' => 5.0, // 5%
            'payment_method' => 'credit_card'
        ]);

        $fee = $this->feeCalculator->calculate(100, 'credit_card', $user->id);

        $this->assertEquals(5.0, $fee);
    }

    /** @test */
    public function it_calculates_fixed_fee()
    {
        $user = User::factory()->create();

        FeeStructure::factory()->create([
            'user_id' => $user->id,
            'fee_type' => 'fixed',
            'fee_value' => 2.50,
            'payment_method' => 'pix'
        ]);

        $fee = $this->feeCalculator->calculate(100, 'pix', $user->id);

        $this->assertEquals(2.50, $fee);
    }

    /** @test */
    public function it_calculates_mixed_fee()
    {
        $user = User::factory()->create();

        FeeStructure::factory()->create([
            'user_id' => $user->id,
            'fee_type' => 'mixed',
            'percentage_fee' => 3.0,
            'fixed_fee' => 1.00,
            'payment_method' => 'boleto'
        ]);

        $fee = $this->feeCalculator->calculate(100, 'boleto', $user->id);

        // 3% of 100 = 3.00 + 1.00 fixed = 4.00
        $this->assertEquals(4.00, $fee);
    }

    /** @test */
    public function it_applies_tiered_fees_based_on_amount()
    {
        $user = User::factory()->create();

        // Low amount tier
        FeeStructure::factory()->create([
            'user_id' => $user->id,
            'fee_type' => 'percentage',
            'fee_value' => 5.0,
            'min_amount' => 0,
            'max_amount' => 100,
            'payment_method' => 'credit_card'
        ]);

        // High amount tier
        FeeStructure::factory()->create([
            'user_id' => $user->id,
            'fee_type' => 'percentage',
            'fee_value' => 3.0,
            'min_amount' => 100.01,
            'max_amount' => 1000,
            'payment_method' => 'credit_card'
        ]);

        $lowFee = $this->feeCalculator->calculate(50, 'credit_card', $user->id);
        $highFee = $this->feeCalculator->calculate(500, 'credit_card', $user->id);

        $this->assertEquals(2.50, $lowFee); // 5% of 50
        $this->assertEquals(15.00, $highFee); // 3% of 500
    }

    /** @test */
    public function it_uses_global_fee_when_user_fee_not_found()
    {
        $user = User::factory()->create();

        FeeStructure::factory()->create([
            'user_id' => null, // Global fee
            'fee_type' => 'percentage',
            'fee_value' => 4.0,
            'payment_method' => 'pix'
        ]);

        $fee = $this->feeCalculator->calculate(100, 'pix', $user->id);

        $this->assertEquals(4.0, $fee);
    }

    /** @test */
    public function it_prioritizes_user_fee_over_global_fee()
    {
        $user = User::factory()->create();

        // Global fee
        FeeStructure::factory()->create([
            'user_id' => null,
            'fee_type' => 'percentage',
            'fee_value' => 5.0,
            'payment_method' => 'credit_card'
        ]);

        // User-specific fee
        FeeStructure::factory()->create([
            'user_id' => $user->id,
            'fee_type' => 'percentage',
            'fee_value' => 3.0,
            'payment_method' => 'credit_card'
        ]);

        $fee = $this->feeCalculator->calculate(100, 'credit_card', $user->id);

        $this->assertEquals(3.0, $fee); // Should use user-specific 3%, not global 5%
    }
}
