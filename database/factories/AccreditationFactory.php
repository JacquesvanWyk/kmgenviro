<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Accreditation;

class AccreditationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Accreditation::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'acronym' => fake()->word(),
            'logo' => fake()->word(),
            'description' => fake()->text(),
            'certificate_number' => fake()->word(),
            'valid_until' => fake()->date(),
            'sort_order' => fake()->numberBetween(-10000, 10000),
            'is_active' => fake()->boolean(),
        ];
    }
}
