<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\VolunteerApplication;
use App\Models\Volunteer;
use App\Models\Member;
use App\Models\Role;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Get Volunteer role
        $volunteerRole = Role::where('role_name', 'Volunteer')->first();

        if (!$volunteerRole) {
            throw new \Exception('Volunteer role not found. Please run RoleSeeder first.');
        }

        $namedUsersData = [
            ['name' => 'Larababes', 'email' => 'larababes@test.com', 'password' => 'larababes'],
            ['name' => 'Hiro Hamada', 'email' => 'hirohamada@test.com', 'password' => 'hirohamada'],
            ['name' => 'Administrator', 'email' => 'administrator@test.com', 'password' => 'Administrator'],
            ['name' => 'Content Manager', 'email' => 'content_manager@test.com', 'password' => 'content_manager'],
            ['name' => 'Program Coordinator', 'email' => 'program_coordinator@test.com', 'password' => 'program_coordinator'],
            ['name' => 'Financial Coordinator', 'email' => 'financial_coordinator@test.com', 'password' => 'financial_coordinator'],
        ];

        foreach ($namedUsersData as $userData) {
            $user = User::create([
                'name' => $userData['name'],
                'email' => $userData['email'],
                'password' => Hash::make($userData['password']),
            ]);

            // Assign role
            $user->roles()->attach($volunteerRole->id, [
                'assigned_by' => null,
                'assigned_at' => now(),
            ]);

            // Create related models
            $volunteer = Volunteer::factory()->create(['user_id' => $user->id]);

            Member::factory()->create([
                'user_id' => $user->id,
                'volunteer_id' => $volunteer->id,
            ]);

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

        // Create 20 random users
        $randomUsers = User::factory(20)->create();

        foreach ($randomUsers as $user) {
            $user->roles()->attach($volunteerRole->id, [
                'assigned_by' => null,
                'assigned_at' => now(),
            ]);

            $volunteer = Volunteer::factory()->create(['user_id' => $user->id]);

            Member::factory()->create([
                'user_id' => $user->id,
                'volunteer_id' => $volunteer->id,
            ]);

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
