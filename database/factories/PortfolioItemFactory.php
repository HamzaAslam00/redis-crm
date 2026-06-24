<?php

namespace Database\Factories;

use App\Models\PortfolioItem;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<PortfolioItem>
 */
class PortfolioItemFactory extends Factory
{
    public function definition(): array
    {
        $title = fake()->words(4, true);

        return [
            'title' => ucwords($title),
            'slug' => Str::slug($title),
            'client_name' => fake()->company(),
            'category' => fake()->randomElement(['web', 'mobile', 'marketing', 'erp', 'ai', 'software']),
            'short_desc' => fake()->sentence(),
            'description' => '<p>'.implode('</p><p>', fake()->paragraphs(3)).'</p>',
            'tech_stack' => fake()->randomElements(['Laravel', 'Vue.js', 'Flutter', 'React', 'MySQL', 'Firebase', 'Python', 'Node.js'], 3),
            'featured_image' => null,
            'gallery_images' => null,
            'project_url' => null,
            'results' => null,
            'is_featured' => false,
            'status' => 'active',
            'display_order' => 0,
        ];
    }
}
