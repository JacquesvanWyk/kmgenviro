<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\TrainingBooking;
use App\Models\TrainingCourse;
use App\Models\TrainingSchedule;

class TrainingBookingFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TrainingBooking::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'training_course_id' => TrainingCourse::factory(),
            'training_schedule_id' => TrainingSchedule::factory(),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'company' => fake()->company(),
            'number_of_delegates' => fake()->numberBetween(-10000, 10000),
            'delegate_names' => fake()->text(),
            'special_requirements' => fake()->text(),
            'preferred_date' => fake()->date(),
            'status' => fake()->word(),
            'notes' => fake()->text(),
        ];
    }
}
