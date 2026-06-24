<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<BlogPost>
 */
class BlogPostFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->sentence(6);

        return [
            'user_id' => User::factory(),
            'category_id' => BlogCategory::factory(),
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => fake()->paragraph(),
            'content' => '<p>'.implode('</p><p>', fake()->paragraphs(5)).'</p>',
            'featured_image' => null,
            'status' => fake()->randomElement(['draft', 'published']),
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
            'views_count' => fake()->numberBetween(0, 500),
            'meta_title' => Str::limit($title, 70),
            'meta_description' => fake()->sentence(20),
        ];
    }

    public function published(): static
    {
        return $this->state(['status' => 'published', 'published_at' => now()->subDays(fake()->numberBetween(1, 30))]);
    }

    public function draft(): static
    {
        return $this->state(['status' => 'draft', 'published_at' => null]);
    }
}
