<?php

namespace Database\Factories;

use App\Models\Member;
use App\Models\User;
use App\Models\Volunteer;
use Illuminate\Database\Eloquent\Factories\Factory;

class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'volunteer_id' => Volunteer::factory(),
            'membership_type' => $this->faker->randomElement(['full_pledge', 'honorary']),
            'membership_status' => $this->faker->randomElement(['active', 'inactive']),
            'invitation_status' => $this->faker->randomElement(['pending', 'accepted', 'declined']),
            'invited_at' => $this->faker->optional()->dateTimeThisYear(),
            'invitation_expires_at' => $this->faker->optional()->dateTimeThisYear(),
            'start_date' => $this->faker->optional()->dateTimeThisYear(),
            'end_date' => $this->faker->optional()->dateTimeThisYear(),
            'board_invited' => $this->faker->boolean(20), // 20% chance true
        ];
    }
}