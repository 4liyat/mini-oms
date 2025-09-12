<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $statuses = ['pending', 'in_progress', 'done', 'cancelled'];
        return [
            'customer_id' => Customer::factory(),
            'title' => $this->faker->sentence(),
            'status' => $this->faker->randomElement($statuses),
            'estimated_cost' => ($this->faker->boolean()) ? $this->faker->randomFloat(2, 50, 500) : null,
        ];
    }
}
