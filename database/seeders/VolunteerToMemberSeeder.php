<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Volunteer;
use App\Models\Member;
use App\Models\Role;

class VolunteerToMemberSeeder extends Seeder
{
    public function run(): void
    {
        $volunteers = Volunteer::all();
        $memberRole = Role::where('role_name', 'Member')->first();

        foreach ($volunteers as $volunteer) {
            // Only create a member if one doesn't already exist for this volunteer
            if (!Member::where('volunteer_id', $volunteer->id)->exists()) {
                $member = Member::create([
                    'user_id' => $volunteer->user_id, 
                    'volunteer_id' => $volunteer->id,
                    'membership_type' => ['full_pledge', 'honorary'][array_rand(['full_pledge', 'honorary'])],
                    'membership_status' => 'active',
                    'invitation_status' => ['pending', 'accepted'][array_rand(['pending', 'accepted'])],
                    'invited_at' => now(),
                    'start_date' => now(),
                    'invited_by' => null,
                ]);

                // Assign Member role if the role exists and user doesn't have it
                if ($memberRole && !$volunteer->user->hasRole('Member')) {
                    $volunteer->user->roles()->attach($memberRole->id, [
                        'assigned_by' => null,
                        'assigned_at' => now()
                    ]);
                }
            }
        }
    }
}
