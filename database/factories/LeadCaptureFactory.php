<?php

namespace Database\Factories;

use App\Models\LeadCapture;
use App\Models\Resource;
use Illuminate\Database\Eloquent\Factories\Factory;

class LeadCaptureFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = LeadCapture::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'company' => fake()->company(),
            'province' => fake()->word(),
            'source' => fake()->word(),
            'resource_id' => Resource::factory(),
        ];
    }
}
