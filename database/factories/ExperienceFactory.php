<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use App\Models\Category;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Experience>
 */
class ExperienceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            'description' => $this->faker->paragraph,
            'user_id' => Arr::random(range(1, 10)),
            'price' => $this->faker->randomFloat(2, 0, 100),
            'category_id' => Category::all()->random()->id,
            'duration' => $this->faker->randomNumber(3),
            'location' => Arr::random(array(
                'Porto','Lisboa','Paris','Barcelona','Madrid'
            )),
        ];
    }
}
