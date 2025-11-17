<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\BlogPost;

class BlogPostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlogPost::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'slug' => fake()->slug(),
            'excerpt' => fake()->text(),
            'content' => fake()->paragraphs(3, true),
            'featured_image' => fake()->word(),
            'author' => fake()->word(),
            'published_at' => fake()->dateTime(),
            'is_published' => fake()->boolean(),
            'is_featured' => fake()->boolean(),
            'meta_title' => fake()->word(),
            'meta_description' => fake()->text(),
        ];
    }
}
