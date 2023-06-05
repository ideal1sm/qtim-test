<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->words(5, true);

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'preview_image' => fake()->imageUrl(),
            'detail_image' => fake()->imageUrl(),
            'description' => fake()->text(100)
        ];
    }
}
