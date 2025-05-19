<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employeer>
 */
class EmployeerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'language' => $this->faker->randomElement(['English', 'Arabic', 'French']),
            'job_title' => $this->faker->jobTitle,
        ];
    }
}
