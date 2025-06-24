<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Volunteer;
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
        $isFull = $approvedCount >= $program->volunteer_count;

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
            'ratingCounts'
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

        // Avoid duplicate entry
        if (!$program->volunteers->contains($volunteer->id)) {
            $program->volunteers()->attach($volunteer->id, ['status' => 'approved']);

            // Notify coordinator na may nagjoin sa program niya \Notifications\VolunteerJoinedProgram.php
            $programCoordinator = $program->creator;
            if ($programCoordinator) {
                $programCoordinator->notify(new VolunteerJoinedProgram($program, $user));
            }

            // Create a welcome message in the program chat
            $program->chats()->create([
                'sender_id' => Auth::id(),
                'message' => "Welcome {$user->name} to the {$program->title} program! We're excited to have you join us.",
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

        // Detach volunteer from program
        $program->volunteers()->detach($volunteer->id);

        return back()->with('toast', [
            'message' => 'You have left the program.',
            'type' => 'success'
        ]);
    }
}
