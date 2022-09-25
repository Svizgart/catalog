<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    private $longText = 100;
    private $minPrice = 100;
    private $maxPrice = 99999;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = fake()->name;

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'price' => fake()->numberBetween($this->minPrice, $this->maxPrice),
            'description' => fake()->text($this->longText),
        ];
    }
}
