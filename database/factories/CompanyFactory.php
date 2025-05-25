<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Company>
 */
class CompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->company,
            'logo' => $this->faker->imageUrl(100, 100, 'business', true, 'logo'),
            'type' => $this->faker->randomElement(['Private', 'Public', 'Government']),
            'size' => $this->faker->randomElement(['Small', 'Medium', 'Large']),
            'sector' => $this->faker->word,
            'address' => $this->faker->address,
            'city' => $this->faker->city,
            'country' => $this->faker->country,
        ];
    }
}
