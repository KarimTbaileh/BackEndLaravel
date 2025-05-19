<?php

namespace Database\Factories;

use App\Models\Jobb;
use App\Models\JobSeeker;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Application>
 */
class ApplicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'Cv' => $this->faker->url(),
            'Applicant Name' => $this->faker->name(),
            'Cover Letter' => $this->faker->paragraph(),
            'Status' => $this->faker->randomElement(['Pending', 'Accepted', 'Rejected']),
            'position applied' => $this->faker->jobTitle(),
            'jobb_id' => Jobb::factory(),
            'job_seeker_id' => JobSeeker::factory(),
        ];
    }
}
