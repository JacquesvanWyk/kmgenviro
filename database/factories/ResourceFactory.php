<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Resource;

class ResourceFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Resource::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'slug' => fake()->slug(),
            'description' => fake()->text(),
            'file' => fake()->word(),
            'file_type' => fake()->word(),
            'file_size' => fake()->numberBetween(-10000, 10000),
            'category' => fake()->word(),
            'download_count' => fake()->numberBetween(-10000, 10000),
            'requires_details' => fake()->boolean(),
            'is_active' => fake()->boolean(),
            'sort_order' => fake()->numberBetween(-10000, 10000),
        ];
    }
}
