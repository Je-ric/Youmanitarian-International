<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Volunteer;
use App\Models\ProgramChat;
use Illuminate\Http\Request;
use App\Models\ProgramFeedback;
use App\Notifications\VolunteerJoinedProgram;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProgramVolunteerController extends Controller
{

    // program-volunteers.blade.php (main)
    // viewFeedback.blade.php (partial)
    //      feedbackItem.blade.php (partial)
    // _form.blade.php (partial)
    public function gotoManageVolunteers(Program $program)
    {
        $approvedVolunteers = $program->volunteers()->where('program_volunteers.status', 'approved')->get();
        $pendingVolunteers = $program->volunteers()->where('program_volunteers.status', 'pending')->get();
        $approvedCount = $approvedVolunteers->count();
        $isFull = $approvedCount >= $program->volunteer_count; // check kung full

        $totalVolunteers = $approvedVolunteers->count();
        $totalAttendanceRecords = 0;
        $approvedAttendanceCount = 0;
        $pendingAttendanceCount = 0;
        $rejectedAttendanceCount = 0;
        $noRecordsCount = 0;

        foreach ($approvedVolunteers as $volunteer) { // for each approved volunteer
            $attendanceRecords = $volunteer->attendanceLogs()
                ->where('program_id', $program->id)
                ->get(); // get all attendance records for this program
            if ($attendanceRecords->isEmpty()) {
                $noRecordsCount++;
            } else {
                $totalAttendanceRecords += $attendanceRecords->count();
                foreach ($attendanceRecords as $record) {
                    switch ($record->approval_status) {
                        case 'approved':
                            $approvedAttendanceCount++;
                            break;
                        case 'pending':
                            $pendingAttendanceCount++;
                            break;
                        case 'rejected':
                            $rejectedAttendanceCount++;
                            break;
                    }
                }
            }
        }

        $attendanceOverview = [
            'totalVolunteers' => $totalVolunteers,
            'totalAttendanceRecords' => $totalAttendanceRecords,
            'approvedCount' => $approvedAttendanceCount,
            'pendingCount' => $pendingAttendanceCount,
            'rejectedCount' => $rejectedAttendanceCount,
            'noRecordsCount' => $noRecordsCount,
        ];

        $recentActivities = $program->volunteers()
            ->where('program_volunteers.status', 'approved')
            ->orderBy('program_volunteers.created_at', 'desc')
            ->get()
            ->map(function ($volunteer) {
                return [
                    'user' => $volunteer->user,
                    'date' => $volunteer->pivot->created_at,
                    'message' => 'joined the program'
                ];
            });

        $logs = [];
        foreach ($approvedVolunteers as $volunteer) {
            $volunteerLogs = $program->volunteerAttendances()
                ->where('volunteer_id', $volunteer->id)
                ->orderBy('clock_in', 'desc')
                ->get();

            $totalTime = 0;
            foreach ($volunteerLogs as $log) {
                if ($log->clock_out) {
                    $diff = \Carbon\Carbon::parse($log->clock_in)->diff(\Carbon\Carbon::parse($log->clock_out));
                    $totalTime += $diff->h * 3600 + $diff->i * 60 + $diff->s;
                }
            }
            $totalTimeInHours = gmdate("H:i:s", $totalTime);

            $logs[$volunteer->id] = [
                'logs' => $volunteerLogs,
                'totalTime' => $totalTimeInHours
            ];
        }

        $tasks = $program->tasks()->orderBy('created_at', 'desc')->get();

        $feedbacks = ProgramFeedback::with('volunteer.user')
            ->where('program_id', $program->id)
            ->latest('submitted_at')
            ->get();

        $totalFeedbacks = $feedbacks->count();
        $averageRating = $totalFeedbacks > 0 ? round($feedbacks->avg('rating'), 1) : 0;

        $ratingCounts = [];
        for ($i = 1; $i <= 5; $i++) {
            $ratingCounts[$i] = $feedbacks->where('rating', $i)->count();
        }

        $totalVolunteersCount = $program->volunteers->count();
        $activeTasksCount = $tasks->where('status', 'active')->count();
        $completedTasksCount = $tasks->where('status', 'completed')->count();

        return view('programs_volunteers.program-volunteers', compact(
            'program',
            'approvedVolunteers',
            'pendingVolunteers',
            'approvedCount',
            'isFull',
            'logs',
            'tasks',
            'feedbacks',
            'totalFeedbacks',
            'averageRating',
            'ratingCounts',
            'attendanceOverview',
            'recentActivities',
            'totalVolunteersCount',
            'activeTasksCount',
            'completedTasksCount'
        ));
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════


    // index.blade.php (main)
    // view-modal.blade.php (component)
    public function joinProgram(Program $program)
    {
        $user = Auth::user();
        $volunteer = $user->volunteer;

        if (!$volunteer) {
            return redirect()->back()->with('toast', [
                'message' => 'Only volunteers can join programs.',
                'type' => 'error'
            ]);
        }

        if ($volunteer->application_status !== 'approved') { // check kung approved volunteer
            return redirect()->back()->with('toast', [
                'message' => 'Your volunteer application must be approved before joining a program.',
                'type' => 'error'
            ]);
        }

        // If program is full (theres cases na baka mabypass yung condition sa blade, sana hindi pa den)
        // Parang double layer of protection
        $approvedCount = $program->volunteers()->where('program_volunteers.status', 'approved')->count();
        if ($approvedCount >= $program->volunteer_count) {
            return redirect()->back()->with('toast', [
                'message' => 'This program is full.',
                'type' => 'error'
            ]);
        }

        // Same dito, meron naman sa blade (naha-hide naman buttons)
        if ($program->progress_status === 'done') {
            return redirect()->back()->with('toast', [
                'message' => 'This program is already completed.',
                'type' => 'error'
            ]);
        }

        // Avoid duplicate entry
        if (!$program->volunteers->contains($volunteer->id)) {
            $program->volunteers()->attach($volunteer->id, ['status' => 'approved']);

            // Notify coordinator na may nagjoin sa program niya \Notifications\VolunteerJoinedProgram.php
            $programCoordinator = $program->creator;
            if ($programCoordinator) {
                $programCoordinator->notify(new VolunteerJoinedProgram($program, $user));
            }

            // message when joining
            $program->chats()->create([
                'sender_id' => Auth::id(),
                'message' => "Welcome {$user->name} to the {$program->title} program!",
                'message_type' => 'system'
            ]);
        }

        return redirect()->back()->with('toast', [
            'message' => 'You have successfully joined the program.',
            'type' => 'success'
        ]);
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    public function leaveProgram(Request $request, Program $program, Volunteer $volunteer)
    {
        // Makes sure the volunteer has any task assignments for this program
        $hasTasks = $volunteer->taskAssignments()
            ->whereHas('task', function ($query) use ($program) {
                $query->where('program_id', $program->id);
            })->exists();

        if ($program->progress !== 'incoming' || $hasTasks) {
            $message = $hasTasks
                ? 'You cannot leave this program because you have assigned tasks.'
                : 'You cannot leave this program because it is no longer in incoming status.';

            return back()->with('error', $message);
        }

        // Remove volunteers messages from program chat (pero pwede sigurong hindi?) UNDECIDED!!!
        // $program->chats()
        //     ->where('sender_id', $volunteer->user_id)
        //     ->delete();

        // message na nagleave
        $program->chats()->create([
            'sender_id' => Auth::id(),
            'message' => "{$volunteer->user->name} has left the {$program->title} program.",
            'message_type' => 'system'
        ]);

        // Detach volunteer from program
        $program->volunteers()->detach($volunteer->id);

        return back()->with('toast', [
            'message' => 'You have left the program.',
            'type' => 'success'
        ]);
    }
}
