<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\ActivityType;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Activity>
 */
class ActivityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::all()->random()->id,
            'activity_type_id' => ActivityType::all()->random()->id,
            'activity_date' => date("Y-m-d H:i:s"),
            'name' => Str::random(10),
            'distance' => rand(1,30),
            'distance_unit' => "kilometers",
            'elapsed_time' => rand(100,500)
        ];
    }
}
