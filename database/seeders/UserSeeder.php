<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\VolunteerApplication;
use App\Models\Volunteer;
use App\Models\Member;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Get or create the Volunteer role
        $volunteerRole = Role::where('role_name', 'Volunteer')->first();
        
        if (!$volunteerRole) {
            throw new \Exception('Volunteer role not found. Please run RoleSeeder first.');
        }

        // Create 20 users
        $users = User::factory(20)->create();

        foreach ($users as $user) {
            // Assign Volunteer role to each user
            $user->roles()->attach($volunteerRole->id, [
                'assigned_by' => null,
                'assigned_at' => now()
            ]);

            // Create a volunteer for each user
            $volunteer = Volunteer::factory()->create([
                'user_id' => $user->id,
            ]);

            // Create a member for each volunteer
            $member = Member::factory()->create([
                'user_id' => $user->id,
                'volunteer_id' => $volunteer->id,
            ]);

            // Create a volunteer application for each volunteer
            VolunteerApplication::factory()->create([
                'volunteer_id' => $volunteer->id,
                'why_volunteer' => 'I want to help the community.',
                'interested_programs' => 'Education, Health',
                'skills_experience' => 'Teaching, First Aid',
                'availability' => 'Weekends',
                'commitment_hours' => '5',
                'physical_limitations' => null,
                'emergency_contact' => 'John Doe, 123456789',
                'contact_consent' => 'yes',
                'volunteered_before' => 'no',
                'outdoor_ok' => 'yes',
                'short_bio' => 'Passionate about volunteering.',
                'is_active' => true,
                'submitted_at' => now(),
            ]);
        }
    }
} 