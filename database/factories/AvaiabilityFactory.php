<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Avaiability;
use App\Models\User;
use Carbon\Carbon;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Availability>
 */
class AvaiabilityFactory extends Factory
{
    protected $model = Avaiability::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = $this->faker->time('H:i', '09:00');
        $endTime = Carbon::createFromFormat('H:i', $startTime)->addHours(2)->format('H:i');
        return [
            'host_id' =>  User::where('role', 'host')->inRandomOrder()->first()?->id,
            'weekday' => $this->faker->randomElement(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']),
            'start_time' => $startTime,
            'end_time' => $endTime,
            'time_zone' => $this->faker->timezone,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
