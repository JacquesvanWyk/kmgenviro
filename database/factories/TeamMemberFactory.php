<?php

namespace Database\Factories;

use App\Models\TeamMember;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeamMemberFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TeamMember::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'slug' => fake()->slug(),
            'title' => fake()->sentence(4),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'bio' => fake()->text(),
            'qualifications' => fake()->text(),
            'registrations' => fake()->text(),
            'sort_order' => fake()->numberBetween(-10000, 10000),
            'is_active' => fake()->boolean(),
            'photo' => fake()->word(),
        ];
    }
}
