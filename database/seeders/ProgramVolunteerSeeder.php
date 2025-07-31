<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\Volunteer;
use App\Models\User;
use App\Models\ProgramVolunteer;
use Carbon\Carbon;

class ProgramVolunteerSeeder extends Seeder
{
    public function run(): void
    {
        // Get existing volunteers
        $volunteers = Volunteer::with('user')->get();

        if ($volunteers->isEmpty()) {
            $this->command->warn('No volunteers found. Please run UserSeeder first.');
            return;
        }

        // Get a program coordinator to create programs
        $programCoordinator = User::whereHas('roles', function($query) {
            $query->where('role_name', 'Program Coordinator');
        })->first();

        if (!$programCoordinator) {
            $programCoordinator = User::first(); // Fallback to first user
        }

        // Create programs with volunteers (no attendance records)
        $this->createProgramsWithVolunteers($volunteers, $programCoordinator);
    }

    private function createProgramsWithVolunteers($volunteers, $programCoordinator)
    {
        // Past programs
        $this->createPastPrograms($volunteers, $programCoordinator);

        // Current/Recent programs
        $this->createCurrentPrograms($volunteers, $programCoordinator);

        // Future programs
        $this->createFuturePrograms($volunteers, $programCoordinator);
    }

    private function createPastPrograms($volunteers, $programCoordinator)
    {
        // Past program 1: Community Service
        $program1 = Program::create([
            'title' => 'Community Service Day',
            'description' => 'A day dedicated to serving our local community through various activities.',
            'date' => Carbon::now()->subDays(30),
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'location' => 'Central Community Center',
            'created_by' => $programCoordinator->id,
            'progress' => 'done',
            'volunteer_count' => 12,
        ]);

        // Assign 12 volunteers to the program
        $selectedVolunteers = $volunteers->random(12);
        foreach ($selectedVolunteers as $volunteer) {
            ProgramVolunteer::create([
                'program_id' => $program1->id,
                'volunteer_id' => $volunteer->id,
                'status' => 'approved',
            ]);
        }

        // Past program 2: Educational Workshop
        $program2 = Program::create([
            'title' => 'Educational Workshop Series',
            'description' => 'Educational workshops focused on skill development and learning.',
            'date' => Carbon::now()->subDays(15),
            'start_time' => '14:00:00',
            'end_time' => '18:00:00',
            'location' => 'Public Library',
            'created_by' => $programCoordinator->id,
            'progress' => 'done',
            'volunteer_count' => 8,
        ]);

        // Assign 8 volunteers to the program
        $selectedVolunteers = $volunteers->random(8);
        foreach ($selectedVolunteers as $volunteer) {
            ProgramVolunteer::create([
                'program_id' => $program2->id,
                'volunteer_id' => $volunteer->id,
                'status' => 'approved',
            ]);
        }

        $this->command->info("Created 2 past programs with volunteers assigned.");
    }

    private function createCurrentPrograms($volunteers, $programCoordinator)
    {
        // Current program: Health Awareness
        $program3 = Program::create([
            'title' => 'Health Awareness Campaign',
            'description' => 'Promoting health awareness and wellness in the community.',
            'date' => Carbon::now()->subDays(2),
            'start_time' => '10:00:00',
            'end_time' => '16:00:00',
            'location' => 'City Hall Plaza',
            'created_by' => $programCoordinator->id,
            'progress' => 'done',
            'volunteer_count' => 15,
        ]);

        // Assign 15 volunteers to the program
        $selectedVolunteers = $volunteers->random(15);
        foreach ($selectedVolunteers as $volunteer) {
            ProgramVolunteer::create([
                'program_id' => $program3->id,
                'volunteer_id' => $volunteer->id,
                'status' => 'approved',
            ]);
        }

        // Recent program: Food Drive
        $program4 = Program::create([
            'title' => 'Food Drive Initiative',
            'description' => 'Collecting food items for families in need.',
            'date' => Carbon::now()->subDays(7),
            'start_time' => '11:00:00',
            'end_time' => '15:00:00',
            'location' => 'Community Center',
            'created_by' => $programCoordinator->id,
            'progress' => 'done',
            'volunteer_count' => 20,
        ]);

        // Assign 20 volunteers to the program
        $selectedVolunteers = $volunteers->random(20);
        foreach ($selectedVolunteers as $volunteer) {
            ProgramVolunteer::create([
                'program_id' => $program4->id,
                'volunteer_id' => $volunteer->id,
                'status' => 'approved',
            ]);
        }

        $this->command->info("Created 2 current/recent programs with volunteers assigned.");
    }

    private function createFuturePrograms($volunteers, $programCoordinator)
    {
        // Future program 1: Environmental Conservation
        $program5 = Program::create([
            'title' => 'Environmental Conservation Project',
            'description' => 'Environmental conservation and sustainability initiative.',
            'date' => Carbon::now()->addDays(14),
            'start_time' => '08:00:00',
            'end_time' => '12:00:00',
            'location' => 'Community Garden',
            'created_by' => $programCoordinator->id,
            'progress' => 'incoming',
            'volunteer_count' => 18,
        ]);

        // Assign 18 volunteers to the program
        $selectedVolunteers = $volunteers->random(18);
        foreach ($selectedVolunteers as $volunteer) {
            ProgramVolunteer::create([
                'program_id' => $program5->id,
                'volunteer_id' => $volunteer->id,
                'status' => 'approved',
            ]);
        }

        // Future program 2: Cultural Festival
        $program6 = Program::create([
            'title' => 'Cultural Festival Celebration',
            'description' => 'Cultural celebration and community building event.',
            'date' => Carbon::now()->addDays(30),
            'start_time' => '10:00:00',
            'end_time' => '20:00:00',
            'location' => 'Recreation Center',
            'created_by' => $programCoordinator->id,
            'progress' => 'incoming',
            'volunteer_count' => 25,
        ]);

        // Assign 25 volunteers to the program
        $selectedVolunteers = $volunteers->random(25);
        foreach ($selectedVolunteers as $volunteer) {
            ProgramVolunteer::create([
                'program_id' => $program6->id,
                'volunteer_id' => $volunteer->id,
                'status' => 'approved',
            ]);
        }

        // Future program 3: Youth Mentorship
        $program7 = Program::create([
            'title' => 'Youth Mentorship Program',
            'description' => 'Mentoring program for young people in the community.',
            'date' => Carbon::now()->addDays(21),
            'start_time' => '15:00:00',
            'end_time' => '18:00:00',
            'location' => 'Youth Center',
            'created_by' => $programCoordinator->id,
            'progress' => 'incoming',
            'volunteer_count' => 10,
        ]);

        // Assign 10 volunteers to the program
        $selectedVolunteers = $volunteers->random(10);
        foreach ($selectedVolunteers as $volunteer) {
            ProgramVolunteer::create([
                'program_id' => $program7->id,
                'volunteer_id' => $volunteer->id,
                'status' => 'approved',
            ]);
        }

        $this->command->info("Created 3 future programs with volunteers assigned.");
    }
}
