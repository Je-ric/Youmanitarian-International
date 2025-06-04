<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Program;
use App\Models\ProgramFeedback;
use Illuminate\Support\Facades\Auth;

class ProgramFeedbackController extends Controller
{
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

        // Store feedback
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

    public function viewAll(Program $program)
    {
        $feedbacks = ProgramFeedback::with('volunteer.user')
            ->where('program_id', $program->id)
            ->latest('submitted_at')
            ->get();

        return view('programs.view_feedbacks', [
            'program' => $program,
            'feedbacks' => $feedbacks
        ]);
    }
}
