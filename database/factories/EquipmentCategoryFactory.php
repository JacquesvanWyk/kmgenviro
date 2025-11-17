<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\EquipmentCategory;

class EquipmentCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EquipmentCategory::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'slug' => fake()->slug(),
            'description' => fake()->text(),
            'icon' => fake()->word(),
            'sort_order' => fake()->numberBetween(-10000, 10000),
            'is_active' => fake()->boolean(),
        ];
    }
}
