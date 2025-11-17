<?php

namespace Database\Factories;

use App\Models\Project;
use App\Models\Sector;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'sector_id' => Sector::factory(),
            'title' => fake()->sentence(4),
            'slug' => fake()->slug(),
            'client_name' => fake()->word(),
            'location' => fake()->word(),
            'province' => fake()->word(),
            'short_description' => fake()->text(),
            'full_description' => fake()->text(),
            'services_provided' => fake()->text(),
            'outcomes' => fake()->text(),
            'featured_image' => fake()->word(),
            'gallery_images' => fake()->text(),
            'completion_date' => fake()->date(),
            'is_featured' => fake()->boolean(),
            'is_active' => fake()->boolean(),
            'sort_order' => fake()->numberBetween(-10000, 10000),
            'meta_title' => fake()->word(),
            'meta_description' => fake()->text(),
        ];
    }
}
