<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Member;
use App\Models\Volunteer;
use Illuminate\Database\Eloquent\Factories\Factory;

class VolunteerFactory extends Factory
{
    protected $model = Volunteer::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'total_hours' => $this->faker->numberBetween(0, 100),
            'application_status' => $this->faker->randomElement(['pending', 'approved', 'denied']),
        ];
    }
} 