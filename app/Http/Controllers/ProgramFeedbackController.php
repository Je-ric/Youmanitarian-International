<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\ProgramFeedback;
use Illuminate\Support\Facades\Auth;

class ProgramFeedbackController extends Controller
{

    // attendance.blade.php (main)
    // feedbackModal.blade.php (partial)
    public function submitFeedback(Request $request, Program $program)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
        ]);

        $volunteer = Auth::user()->volunteer;

        if (!$volunteer) {
            return redirect()->back()->with('toast', [
                'message' => 'Only volunteers can submit feedback.',
                'type' => 'error',
            ]);
        }

        // Check if already submitted
        $existing = ProgramFeedback::where('program_id', $program->id)
            ->where('volunteer_id', $volunteer->id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('toast', [
                'message' => 'You have already submitted feedback for this program.',
                'type' => 'info',
            ]);
        }

        ProgramFeedback::create([
            'program_id' => $program->id,
            'volunteer_id' => $volunteer->id,
            'rating' => $request->rating,
            'feedback' => $request->feedback,
            'submitted_at' => now(),
        ]);

        return redirect()->back()->with('toast', [
            'message' => 'Thank you for your feedback!',
            'type' => 'success',
        ]);
    }


    // view_feedbacks.blade.php (main)
    // feedbackItem.blade.php (partial)

    // public function viewAll(Program $program)
    // {
    //     $feedbacks = ProgramFeedback::with('volunteer.user')
    //         ->where('program_id', $program->id)
    //         ->latest('submitted_at')
    //         ->get();

    //     $totalFeedbacks = $feedbacks->count();
    //     $averageRating = $totalFeedbacks > 0 ? round($feedbacks->avg('rating'), 1) : 0;

    //     $ratingCounts = [];
    //     for ($i = 1; $i <= 5; $i++) {
    //         $ratingCounts[$i] = $feedbacks->where('rating', $i)->count();
    //     }

    //     return view('programs.view_feedbacks', [
    //         'program' => $program,
    //         'feedbacks' => $feedbacks,
    //         'totalFeedbacks' => $totalFeedbacks,
    //         'averageRating' => $averageRating,
    //         'ratingCounts' => $ratingCounts,
    //     ]);
    // }
    // Route::get('/programs/{program}/viewAll_feedbacks', [ProgramFeedbackController::class, 'viewAll'])->name('programs.feedback.view'); // kung separate page, magagamit

    // {{-- <x-button href="{{ route('programs.feedback.view', $program->id) }}" variant="secondary" class="mb-6">
    //             View Feedbacks
    //         </x-button> --}}
    //  {{-- <div class="text-end mb-4">

public function submitGuestFeedback(Request $request, Program $program)
{
    $request->validate([
        'guest_name' => 'required|string|max:255',
        'guest_email' => 'nullable|email|max:255',
        'rating' => 'required|integer|min:1|max:5',
        'feedback' => 'nullable|string|max:1000',
    ]);

    // Optionally, prevent duplicate feedback by email/program
    $existing = ProgramFeedback::where('program_id', $program->id)
        ->where('guest_email', $request->guest_email) //pwede din name?
        ->first();

    if ($existing) {
        return redirect()->back()->with('toast', [
            'message' => 'You have already submitted feedback for this program.',
            'type' => 'info',
        ]);
    }

    ProgramFeedback::create([
        'program_id' => $program->id,
        'guest_name' => $request->guest_name,
        'guest_email' => $request->guest_email,
        'user_type' => 'guest',
        'rating' => $request->rating,
        'feedback' => $request->feedback,
        'submitted_at' => now(),
    ]);

    return redirect()->back()->with('toast', [
        'message' => 'Thank you for your feedback!',
        'type' => 'success',
    ]);
}


}
