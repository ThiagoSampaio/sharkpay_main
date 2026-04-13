<?php

namespace Database\Factories;

use App\Models\Subscription;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionFactory extends Factory
{
    protected $model = Subscription::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'plan_name' => $this->faker->words(3, true),
            'amount' => $this->faker->randomFloat(2, 19.99, 299.99),
            'billing_cycle' => $this->faker->randomElement(['weekly', 'monthly', 'quarterly', 'yearly']),
            'status' => $this->faker->randomElement(['active', 'cancelled', 'expired']),
            'next_billing_date' => $this->faker->dateTimeBetween('now', '+1 year'),
            'cancelled_at' => null,
            'expires_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'active',
                'cancelled_at' => null,
                'expires_at' => null,
            ];
        });
    }

    public function cancelled()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'cancelled',
                'cancelled_at' => now(),
            ];
        });
    }
}
