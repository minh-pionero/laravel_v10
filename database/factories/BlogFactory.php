<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'category_id' => rand(1, 5),
            'title' => fake()->sentence(10),
            'thumbnail' => 'https://bold.vn/wp-content/uploads/2019/05/bold-academy-5.jpg',
            'short_description' => fake()->paragraph(),
        ];
    }
}
