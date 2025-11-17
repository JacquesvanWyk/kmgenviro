<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Service;
use App\Models\ServiceCategory;

class ServiceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Service::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'service_category_id' => ServiceCategory::factory(),
            'name' => fake()->name(),
            'slug' => fake()->slug(),
            'short_description' => fake()->text(),
            'full_description' => fake()->text(),
            'icon' => fake()->word(),
            'sort_order' => fake()->numberBetween(-10000, 10000),
            'is_active' => fake()->boolean(),
            'is_featured' => fake()->boolean(),
            'meta_title' => fake()->word(),
            'meta_description' => fake()->text(),
        ];
    }
}
