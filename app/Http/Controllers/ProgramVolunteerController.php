<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use App\Models\ProgramFeedback;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ProgramVolunteerController extends Controller
{

    public function manageVolunteers(Program $program)
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

        return view('volunteers.program-volunteers', compact(
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

    // public function manageVolunteers(Program $program)
    // {
    //     $approvedVolunteers = $program->volunteers()->where('program_volunteers.status', 'approved')->get();
    //     $pendingVolunteers = $program->volunteers()->where('program_volunteers.status', 'pending')->get();

    //     $approvedCount = $approvedVolunteers->count();
    //     $isFull = $approvedCount >= $program->volunteer_count;

    //     $logs = [];
    //     foreach ($approvedVolunteers as $volunteer) {
    //         $volunteerLogs = $program->volunteerAttendances()
    //             ->where('volunteer_id', $volunteer->id)
    //             ->orderBy('clock_in', 'desc')
    //             ->get();

    //         $totalTime = 0;
    //         foreach ($volunteerLogs as $log) {
    //             if ($log->clock_out) {
    //                 $diff = \Carbon\Carbon::parse($log->clock_in)->diff(\Carbon\Carbon::parse($log->clock_out));
    //                 $totalTime += $diff->h * 3600 + $diff->i * 60 + $diff->s;
    //             }
    //         }
    //         $totalTimeInHours = gmdate("H:i:s", $totalTime);

    //         $logs[$volunteer->id] = [
    //             'logs' => $volunteerLogs,
    //             'totalTime' => $totalTimeInHours
    //         ];
    //     }

    //     return view('volunteers.program-volunteers', compact('program', 'approvedVolunteers', 'pendingVolunteers', 'approvedCount', 'isFull', 'logs'));
    // }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════


    // index.blade.php (main)
    // view-modal.blade.php (component)
    public function join(Program $program)
    {
        $user = Auth::user();
        $volunteer = $user->volunteer;

        if (!$volunteer) {
            return redirect()->back()->with('error', 'Only volunteers can join programs.');
        }

        // Avoid duplicate entry
        if (!$program->volunteers->contains($volunteer->id)) {
            $program->volunteers()->attach($volunteer->id, ['status' => 'approved']);
        } //pero di na kailangan cause sa pag-join ng volunteer, automatic na siya magjo-join sa program

        return redirect()->back()->with('success', 'You have successfully joined the program.');
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

}
