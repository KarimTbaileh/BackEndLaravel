<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    public function definition(): array
    {
        return [
            'skill' => $this->faker->jobTitle(),
            'cv' => $this->faker->url(),
            'summary' => $this->faker->paragraph(),
            'email' => $this->faker->unique()->safeEmail(),
            'experience' => $this->faker->sentence(),
            'education' => $this->faker->word(),
            'country' => $this->faker->country(),
            'city' => $this->faker->city(),
            'phone_number' => $this->faker->phoneNumber(),
            'first_name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'is_active' => $this->faker->boolean(), // make sure this field exists in your migration
        ];
    }
}
