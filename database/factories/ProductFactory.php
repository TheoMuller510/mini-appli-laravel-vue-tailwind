<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name('Appartement'),
            'description' => $this->faker->paragraph($nbSentences = 2, $variableNbSentences = true),
            'category' => $this->faker->text(),
            'image' => $this->faker->imageUrl(),
        ];
    }
}
