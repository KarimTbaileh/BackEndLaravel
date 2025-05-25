<?php

namespace Database\Factories;

use App\Models\Employeer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jobb>
 */
class JobbFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Requirements' => $this->faker->sentence(),
            'Location' => $this->faker->city(),
            'Job Type' => $this->faker->randomElement(['Full-Time', 'Part-Time', 'Freelance']),
            'Currency' => $this->faker->randomElement(['USD', 'EUR', 'ILS']),
            'Frequency' => $this->faker->randomElement(['Monthly', 'Hourly']),
            'Salary' => $this->faker->numberBetween(1000, 10000),
            'Type' => $this->faker->randomElement(['Remote', 'On-site']),
            'Title' => $this->faker->jobTitle(),
            'Description' => $this->faker->paragraph(),
            'Status' => $this->faker->randomElement(['Open', 'Closed']),
            'employeer_id' => Employeer::factory(),
        ];
    }
}
