<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Day>
 */
class DayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $currentDate = now();
        $randomDays = $this->faker->numberBetween(1, 90); // Adjust the range as needed


        
        return [
        'experience_id' => Arr::random(range(1, 10)),
        'date' => $this->faker->dateTimeBetween($currentDate, $currentDate->addDays($randomDays))->format('Y-m-d'),
        'timeframe' => $this->faker->time,
        'max_people' => $this->faker->numberBetween(1, 50),
        'people_registered' => 0,
        ];
    }
}
