<?php

namespace Database\Factories;

use App\Models\SupportTicket;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupportTicketFactory extends Factory
{
    protected $model = SupportTicket::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'product_id' => Product::factory(),
            'subject' => $this->faker->sentence,
            'priority' => $this->faker->randomElement(['low', 'medium', 'high', 'urgent']),
            'status' => $this->faker->randomElement(['open', 'in_progress', 'closed']),
            'closed_at' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function open()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'open',
                'closed_at' => null,
            ];
        });
    }

    public function closed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'closed',
                'closed_at' => now(),
            ];
        });
    }
}
