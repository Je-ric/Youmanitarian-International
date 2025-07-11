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
    public function submitVolunteerFeedback(Request $request, Program $program)
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
            'user_type' => 'volunteer',
        ]);

        return redirect()->back()->with('toast', [
            'message' => 'Thank you for your feedback!',
            'type' => 'success',
        ]);
    }

    // website/programs.blade.php
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
            ->where('guest_email', $request->guest_email) 
            // pwede din siguro name kaso baka may magkapangalan
            // or make the email input required para maiwasan ang multiple feedbacks
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

