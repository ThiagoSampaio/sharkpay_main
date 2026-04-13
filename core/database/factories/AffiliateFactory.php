<?php

namespace Database\Factories;

use App\Models\Affiliate;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AffiliateFactory extends Factory
{
    protected $model = Affiliate::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'affiliate_code' => strtoupper($this->faker->unique()->lexify('AFF??????')),
            'status' => $this->faker->randomElement(['pending', 'approved', 'rejected', 'suspended']),
            'custom_commission_rate' => $this->faker->optional()->randomFloat(2, 5, 30),
            'payment_method' => $this->faker->randomElement(['bank_transfer', 'pix']),
            'payment_details' => json_encode([
                'bank' => $this->faker->company,
                'account' => $this->faker->bankAccountNumber,
            ]),
            'approved_at' => $this->faker->optional()->dateTimeBetween('-6 months', 'now'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function approved()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'approved',
                'approved_at' => now(),
            ];
        });
    }

    public function pending()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'pending',
                'approved_at' => null,
            ];
        });
    }
}
