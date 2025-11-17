<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Equipment;
use App\Models\EquipmentCategory;

class EquipmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Equipment::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'equipment_category_id' => EquipmentCategory::factory(),
            'name' => fake()->name(),
            'slug' => fake()->slug(),
            'description' => fake()->text(),
            'specifications' => fake()->text(),
            'typical_uses' => fake()->text(),
            'photo' => fake()->word(),
            'gallery_images' => fake()->text(),
            'daily_rate' => fake()->randomFloat(2, 0, 99999999.99),
            'weekly_rate' => fake()->randomFloat(2, 0, 99999999.99),
            'monthly_rate' => fake()->randomFloat(2, 0, 99999999.99),
            'is_available' => fake()->boolean(),
            'is_featured' => fake()->boolean(),
            'sort_order' => fake()->numberBetween(-10000, 10000),
        ];
    }
}
