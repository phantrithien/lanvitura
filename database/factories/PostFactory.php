<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    public function definition(): array
    {
        $title = $this->faker->sentence(6);
        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => $this->faker->paragraph(2),
            'body' => $this->faker->paragraph(20),
            'image_path' => 'https://placehold.co/600x400/E2E8F0/333333?text=Post+Image', // Placeholder image
        ];
    }
}