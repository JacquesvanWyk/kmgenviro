<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\TrainingCourse;

class TrainingCourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TrainingCourse::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'slug' => fake()->slug(),
            'short_description' => fake()->text(),
            'full_description' => fake()->text(),
            'duration' => fake()->word(),
            'accreditation' => fake()->word(),
            'price' => fake()->randomFloat(2, 0, 99999999.99),
            'max_delegates' => fake()->numberBetween(-10000, 10000),
            'is_active' => fake()->boolean(),
            'is_featured' => fake()->boolean(),
            'course_outline' => fake()->text(),
            'target_audience' => fake()->text(),
            'prerequisites' => fake()->text(),
            'thumbnail' => fake()->word(),
            'sort_order' => fake()->numberBetween(-10000, 10000),
            'meta_title' => fake()->word(),
            'meta_description' => fake()->text(),
        ];
    }
}
