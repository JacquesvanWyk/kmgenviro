<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\TrainingCourse;
use App\Models\TrainingSchedule;

class TrainingScheduleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TrainingSchedule::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'training_course_id' => TrainingCourse::factory(),
            'start_date' => fake()->dateTime(),
            'end_date' => fake()->dateTime(),
            'location' => fake()->word(),
            'is_online' => fake()->boolean(),
            'available_seats' => fake()->numberBetween(-10000, 10000),
            'price_override' => fake()->randomFloat(2, 0, 99999999.99),
            'notes' => fake()->text(),
            'is_active' => fake()->boolean(),
        ];
    }
}
