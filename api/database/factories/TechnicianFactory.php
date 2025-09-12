<?php

namespace Database\Factories;

use App\Models\Technician;
use Illuminate\Database\Eloquent\Factories\Factory;

class TechnicianFactory extends Factory
{
    protected $model = Technician::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'skills' => json_encode($this->faker->randomElements(['Plumbing', 'Electrical', 'HVAC', 'Painting'], $this->faker->numberBetween(1, 3))),
        ];
    }
}
