<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Travel>
 */
class TravelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "id" => $this->faker->uuid(),
            "is_public" => $this->faker->boolean(),
            "slug" => $this->faker->slug,
            "name" => $this->faker->name,
            "description" => $this->faker->text(50),
            "num_of_days" => rand(1,10),
        ];
    }
}
