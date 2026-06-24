<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<BlogCategory>
 */
class BlogCategoryFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->unique()->randomElement([
            'Web Development', 'Mobile Apps', 'AI & Automation', 'Digital Marketing',
            'Case Studies', 'Industry News', 'Tutorials', 'Company Updates',
        ]);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'color' => fake()->randomElement(['#FF6400', '#EC4899', '#6366F1', '#10B981', '#0EA5E9', '#F59E0B']),
            'description' => fake()->sentence(),
        ];
    }
}
