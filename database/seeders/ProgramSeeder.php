<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Program;
use App\Models\Volunteer;
use App\Models\User;
use App\Models\VolunteerAttendance;
use App\Models\ProgramVolunteer;
use Carbon\Carbon;

class ProgramSeeder extends Seeder
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

        // Create programs with different scenarios
        $this->createProgramsWithVariedScenarios($volunteers, $programCoordinator);
    }

    private function createProgramsWithVariedScenarios($volunteers, $programCoordinator)
    {
        // Scenario 1: Past program with complete attendance for most volunteers
        $this->createPastProgramWithCompleteAttendance($volunteers, $programCoordinator);

        // Scenario 2: Past program with mixed attendance (some complete, some partial, some no-show)
        $this->createPastProgramWithMixedAttendance($volunteers, $programCoordinator);

        // Scenario 3: Past program where some volunteers joined but didn't attend
        $this->createPastProgramWithNoShows($volunteers, $programCoordinator);

        // Scenario 4: Recent program with pending attendance approvals
        $this->createRecentProgramWithPendingAttendance($volunteers, $programCoordinator);

        // Scenario 5: Future program with volunteers signed up
        $this->createFutureProgramWithVolunteers($volunteers, $programCoordinator);

        // Scenario 6: Large program with many volunteers and varied attendance
        $this->createLargeProgramWithVariedAttendance($volunteers, $programCoordinator);
    }

    private function createPastProgramWithCompleteAttendance($volunteers, $programCoordinator)
    {
        $program = Program::create([
            'title' => 'Community Cleanup Day',
            'description' => 'Join us for a day of community service and environmental stewardship.',
            'date' => Carbon::now()->subDays(30),
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'location' => 'Central Park',
            'created_by' => $programCoordinator->id,
            'progress' => 'done',
            'volunteer_count' => 15,
        ]);

        // Add 15 volunteers to the program
        $selectedVolunteers = $volunteers->random(15);

        foreach ($selectedVolunteers as $volunteer) {
            // Add volunteer to program
            ProgramVolunteer::create([
                'program_id' => $program->id,
                'volunteer_id' => $volunteer->id,
                'status' => 'approved',
            ]);

            // Create complete attendance record
            VolunteerAttendance::create([
                'volunteer_id' => $volunteer->id,
                'program_id' => $program->id,
                'clock_in' => Carbon::parse($program->date)->setTimeFromTimeString('09:00:00'),
                'clock_out' => Carbon::parse($program->date)->setTimeFromTimeString('17:00:00'),
                'hours_logged' => 8.0,
                'approval_status' => 'approved',
                'approved_by' => $programCoordinator->id,
                'notes' => 'Complete attendance - full day participation',
            ]);
        }

        $this->command->info("Created 'Community Cleanup Day' with 15 volunteers and complete attendance.");
    }

    private function createPastProgramWithMixedAttendance($volunteers, $programCoordinator)
    {
        $program = Program::create([
            'title' => 'Food Drive Campaign',
            'description' => 'Help us collect food items for families in need.',
            'date' => Carbon::now()->subDays(15),
            'start_time' => '10:00:00',
            'end_time' => '16:00:00',
            'location' => 'Community Center',
            'created_by' => $programCoordinator->id,
            'progress' => 'done',
            'volunteer_count' => 20,
        ]);

        // Add 20 volunteers to the program
        $selectedVolunteers = $volunteers->random(20);

        foreach ($selectedVolunteers as $index => $volunteer) {
            // Add volunteer to program
            ProgramVolunteer::create([
                'program_id' => $program->id,
                'volunteer_id' => $volunteer->id,
                'status' => 'approved',
            ]);

            // Create varied attendance scenarios
            if ($index < 10) {
                // Complete attendance (50%)
                VolunteerAttendance::create([
                    'volunteer_id' => $volunteer->id,
                    'program_id' => $program->id,
                    'clock_in' => Carbon::parse($program->date)->setTimeFromTimeString('10:00:00'),
                    'clock_out' => Carbon::parse($program->date)->setTimeFromTimeString('16:00:00'),
                    'hours_logged' => 6.0,
                    'approval_status' => 'approved',
                    'approved_by' => $programCoordinator->id,
                ]);
            } elseif ($index < 15) {
                // Partial attendance (25%)
                VolunteerAttendance::create([
                    'volunteer_id' => $volunteer->id,
                    'program_id' => $program->id,
                    'clock_in' => Carbon::parse($program->date)->setTimeFromTimeString('10:00:00'),
                    'clock_out' => null,
                    'hours_logged' => 0,
                    'approval_status' => 'pending',
                    'notes' => 'Volunteer forgot to clock out',
                ]);
            } else {
                // No attendance (25%)
                VolunteerAttendance::create([
                    'volunteer_id' => $volunteer->id,
                    'program_id' => $program->id,
                    'clock_in' => null,
                    'clock_out' => null,
                    'hours_logged' => 0,
                    'approval_status' => 'pending',
                    'notes' => 'Volunteer did not attend the program',
                ]);
            }
        }

        $this->command->info("Created 'Food Drive Campaign' with mixed attendance scenarios.");
    }

    private function createPastProgramWithNoShows($volunteers, $programCoordinator)
    {
        $program = Program::create([
            'title' => 'Educational Workshop',
            'description' => 'Educational program focused on skill development and learning.',
            'date' => Carbon::now()->subDays(7),
            'start_time' => '14:00:00',
            'end_time' => '18:00:00',
            'location' => 'Library',
            'created_by' => $programCoordinator->id,
            'progress' => 'done',
            'volunteer_count' => 12,
        ]);

        // Add 12 volunteers to the program
        $selectedVolunteers = $volunteers->random(12);

        foreach ($selectedVolunteers as $index => $volunteer) {
            // Add volunteer to program
            ProgramVolunteer::create([
                'program_id' => $program->id,
                'volunteer_id' => $volunteer->id,
                'status' => 'approved',
            ]);

            // Most volunteers didn't show up
            if ($index < 3) {
                // Only 3 volunteers actually attended
                VolunteerAttendance::create([
                    'volunteer_id' => $volunteer->id,
                    'program_id' => $program->id,
                    'clock_in' => Carbon::parse($program->date)->setTimeFromTimeString('14:00:00'),
                    'clock_out' => Carbon::parse($program->date)->setTimeFromTimeString('18:00:00'),
                    'hours_logged' => 4.0,
                    'approval_status' => 'approved',
                    'approved_by' => $programCoordinator->id,
                ]);
            } else {
                // 9 volunteers didn't attend
                VolunteerAttendance::create([
                    'volunteer_id' => $volunteer->id,
                    'program_id' => $program->id,
                    'clock_in' => null,
                    'clock_out' => null,
                    'hours_logged' => 0,
                    'approval_status' => 'pending',
                    'notes' => 'Volunteer did not attend the program',
                ]);
            }
        }

        $this->command->info("Created 'Educational Workshop' with mostly no-shows.");
    }

    private function createRecentProgramWithPendingAttendance($volunteers, $programCoordinator)
    {
        $program = Program::create([
            'title' => 'Health Awareness Campaign',
            'description' => 'Health awareness and wellness promotion event.',
            'date' => Carbon::now()->subDays(2),
            'start_time' => '11:00:00',
            'end_time' => '15:00:00',
            'location' => 'City Hall',
            'created_by' => $programCoordinator->id,
            'progress' => 'done',
            'volunteer_count' => 18,
        ]);

        // Add 18 volunteers to the program
        $selectedVolunteers = $volunteers->random(18);

        foreach ($selectedVolunteers as $index => $volunteer) {
            // Add volunteer to program
            ProgramVolunteer::create([
                'program_id' => $program->id,
                'volunteer_id' => $volunteer->id,
                'status' => 'approved',
            ]);

            // Create attendance records with pending approvals
            if ($index < 12) {
                // Most volunteers attended but approval is pending
                VolunteerAttendance::create([
                    'volunteer_id' => $volunteer->id,
                    'program_id' => $program->id,
                    'clock_in' => Carbon::parse($program->date)->setTimeFromTimeString('11:00:00'),
                    'clock_out' => Carbon::parse($program->date)->setTimeFromTimeString('15:00:00'),
                    'hours_logged' => 4.0,
                    'approval_status' => 'pending',
                    'notes' => 'Attendance pending approval',
                ]);
            } else {
                // Some volunteers with late arrival
                $lateArrival = Carbon::parse($program->date)->setTimeFromTimeString('11:00:00')->addMinutes(30);
                VolunteerAttendance::create([
                    'volunteer_id' => $volunteer->id,
                    'program_id' => $program->id,
                    'clock_in' => $lateArrival,
                    'clock_out' => Carbon::parse($program->date)->setTimeFromTimeString('15:00:00'),
                    'hours_logged' => 3.5,
                    'approval_status' => 'pending',
                    'notes' => 'Volunteer arrived 30 minutes late',
                ]);
            }
        }

        $this->command->info("Created 'Health Awareness Campaign' with pending attendance approvals.");
    }

    private function createFutureProgramWithVolunteers($volunteers, $programCoordinator)
    {
        $program = Program::create([
            'title' => 'Environmental Conservation',
            'description' => 'Environmental conservation and sustainability initiative.',
            'date' => Carbon::now()->addDays(14),
            'start_time' => '08:00:00',
            'end_time' => '12:00:00',
            'location' => 'Community Garden',
            'created_by' => $programCoordinator->id,
            'progress' => 'incoming',
            'volunteer_count' => 25,
        ]);

        // Add 25 volunteers to the program (no attendance records yet)
        $selectedVolunteers = $volunteers->random(25);

        foreach ($selectedVolunteers as $volunteer) {
            // Add volunteer to program
            ProgramVolunteer::create([
                'program_id' => $program->id,
                'volunteer_id' => $volunteer->id,
                'status' => 'approved',
            ]);
        }

        $this->command->info("Created 'Environmental Conservation' future program with 25 volunteers signed up.");
    }

    private function createLargeProgramWithVariedAttendance($volunteers, $programCoordinator)
    {
        $program = Program::create([
            'title' => 'Cultural Festival',
            'description' => 'Cultural celebration and community building.',
            'date' => Carbon::now()->subDays(45),
            'start_time' => '10:00:00',
            'end_time' => '20:00:00',
            'location' => 'Recreation Center',
            'created_by' => $programCoordinator->id,
            'progress' => 'done',
            'volunteer_count' => 35,
        ]);

        // Add 35 volunteers to the program
        $selectedVolunteers = $volunteers->random(35);

        foreach ($selectedVolunteers as $index => $volunteer) {
            // Add volunteer to program
            ProgramVolunteer::create([
                'program_id' => $program->id,
                'volunteer_id' => $volunteer->id,
                'status' => 'approved',
            ]);

            // Create varied attendance scenarios
            if ($index < 20) {
                // Complete attendance (57%)
                VolunteerAttendance::create([
                    'volunteer_id' => $volunteer->id,
                    'program_id' => $program->id,
                    'clock_in' => Carbon::parse($program->date)->setTimeFromTimeString('10:00:00'),
                    'clock_out' => Carbon::parse($program->date)->setTimeFromTimeString('20:00:00'),
                    'hours_logged' => 10.0,
                    'approval_status' => 'approved',
                    'approved_by' => $programCoordinator->id,
                ]);
            } elseif ($index < 25) {
                // Late arrival (14%)
                $lateArrival = Carbon::parse($program->date)->setTimeFromTimeString('10:00:00')->addHours(1);
                VolunteerAttendance::create([
                    'volunteer_id' => $volunteer->id,
                    'program_id' => $program->id,
                    'clock_in' => $lateArrival,
                    'clock_out' => Carbon::parse($program->date)->setTimeFromTimeString('20:00:00'),
                    'hours_logged' => 9.0,
                    'approval_status' => 'approved',
                    'approved_by' => $programCoordinator->id,
                    'notes' => 'Volunteer arrived 1 hour late',
                ]);
            } elseif ($index < 30) {
                // Early departure (14%)
                $earlyDeparture = Carbon::parse($program->date)->setTimeFromTimeString('20:00:00')->subHours(2);
                VolunteerAttendance::create([
                    'volunteer_id' => $volunteer->id,
                    'program_id' => $program->id,
                    'clock_in' => Carbon::parse($program->date)->setTimeFromTimeString('10:00:00'),
                    'clock_out' => $earlyDeparture,
                    'hours_logged' => 8.0,
                    'approval_status' => 'approved',
                    'approved_by' => $programCoordinator->id,
                    'notes' => 'Volunteer left 2 hours early',
                ]);
            } else {
                // No attendance (14%)
                VolunteerAttendance::create([
                    'volunteer_id' => $volunteer->id,
                    'program_id' => $program->id,
                    'clock_in' => null,
                    'clock_out' => null,
                    'hours_logged' => 0,
                    'approval_status' => 'pending',
                    'notes' => 'Volunteer did not attend the program',
                ]);
            }
        }

        $this->command->info("Created 'Cultural Festival' with varied attendance scenarios.");
    }
}
