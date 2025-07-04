<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Volunteer;
use App\Models\Member;

class VolunteerToMemberSeeder extends Seeder
{
    public function run(): void
    {
        $volunteers = Volunteer::all();

        foreach ($volunteers as $volunteer) {
            // Only create a member if one doesn't already exist for this volunteer
            if (!Member::where('volunteer_id', $volunteer->id)->exists()) {
                Member::create([
                    'user_id' => $volunteer->user_id, 
                    'volunteer_id' => $volunteer->id,
                    'membership_type' => 'full_pledge',
                    'membership_status' => 'active',
                    'invitation_status' => 'accepted',
                    'invited_at' => now(),
                    'invitation_expires_at' => now()->addDays(7),
                    'start_date' => now(),
                    'end_date' => null,
                    'board_invited' => false,
                ]);
            }
        }
    }
}
