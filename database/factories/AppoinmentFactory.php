<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Appoinment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointment>
 */
class AppoinmentFactory extends Factory
{
    protected $model = Appoinment::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Y-m-d fromat date
            'date' => $this->faker->date('Y-m-d'),
            'notes' => $this->faker->sentence(),
            'avaiability_id' => \App\Models\Avaiability::inRandomOrder()->first()?->id,
            'guest_id' => \App\Models\User::where('role', 'guest')->inRandomOrder()->first()?->id,
            'status' => $this->faker->randomElement(['pending', 'confirmed', 'cancelled']),
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
