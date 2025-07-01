<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\VolunteerApplication;
use App\Models\Volunteer;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create 5 users
        $users = User::factory(20)->create();

        foreach ($users as $user) {
            // Create a volunteer for each user
            $volunteer = Volunteer::factory()->create([
                'user_id' => $user->id,
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