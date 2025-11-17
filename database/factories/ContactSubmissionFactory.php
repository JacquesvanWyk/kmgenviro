<?php

namespace Database\Factories;

use App\Models\ContactSubmission;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactSubmissionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ContactSubmission::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'type' => fake()->word(),
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'company' => fake()->company(),
            'subject' => fake()->word(),
            'message' => fake()->text(),
            'service_type' => fake()->word(),
            'project_name' => fake()->word(),
            'location' => fake()->word(),
            'sector' => fake()->word(),
            'timeline' => fake()->word(),
            'attachments' => fake()->text(),
            'status' => fake()->word(),
            'notes' => fake()->text(),
            'ip_address' => fake()->word(),
            'user_agent' => fake()->text(),
        ];
    }
}
