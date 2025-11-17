<?php

namespace Database\Factories;

use App\Models\Equipment;
use App\Models\EquipmentRentalQuote;
use Illuminate\Database\Eloquent\Factories\Factory;

class EquipmentRentalQuoteFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EquipmentRentalQuote::class;

    /**
     * Define the model's default state.
     */
    public function definition(): array
    {
        return [
            'equipment_id' => Equipment::factory(),
            'name' => fake()->name(),
            'company' => fake()->company(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'equipment_requested' => fake()->text(),
            'rental_duration' => fake()->word(),
            'start_date' => fake()->date(),
            'location' => fake()->word(),
            'delivery_required' => fake()->boolean(),
            'message' => fake()->text(),
            'status' => fake()->word(),
            'notes' => fake()->text(),
        ];
    }
}
