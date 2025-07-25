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
        $status = $this->faker->randomElement(['active', 'inactive']);
        $invitationStatus = 'accepted';
        $startDate = null;

        if ($status === 'active') {
            $startDate = $this->faker->dateTimeThisYear();
            $invitationStatus = 'accepted';
        } else { // inactive
            $invitationStatus = $this->faker->randomElement(['pending', 'declined']);
        }

        return [
            'user_id' => User::factory(),
            'volunteer_id' => Volunteer::factory(),
            'membership_type' => $this->faker->randomElement(['full_pledge', 'honorary']),
            'membership_status' => $status,
            'invitation_status' => $invitationStatus,
            'invited_at' => $this->faker->dateTimeThisYear(),
            'start_date' => $startDate,
            'invited_by' => User::factory(),
        ];
    }
}
