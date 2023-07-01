<?php

namespace Database\Factories;

use App\Models\Travel;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Tour>
 */
class TourFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'travel_id' => Travel::factory()->create(),
            'name' => $this->faker->name(),
            'start_date' => $startDate = Carbon::now()->subDays(rand(1, 30)),
            'end_date' => Carbon::parse($startDate)->addDays(rand(1, 30)),
            'price' => $this->faker->randomFloat(2, 1, 100),
        ];
    }
}
