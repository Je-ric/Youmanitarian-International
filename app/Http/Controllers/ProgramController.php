<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;
use App\Notifications\NewProgramAvailable;
use Illuminate\Support\Facades\Notification;

class ProgramController extends Controller
{
    use AuthorizesRequests;

    public function gotoProgramsList(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $tab = $request->get('tab', 'all');

        // Base query for all programs
        $allPrograms = Program::orderBy('date', 'desc')->paginate(10);

        // Initialize other program collections with empty paginated collections
        $joinedPrograms = Program::where('id', 0)->paginate(10); // Empty paginated collection
        $myPrograms = Program::where('id', 0)->paginate(10); // Empty paginated collection

        // Get joined programs for volunteers
        if ($user->hasRole('Volunteer') && $user->volunteer) {
            $joinedPrograms = Program::whereHas('volunteers', function ($query) use ($user) {
                $query->where('volunteers.id', $user->volunteer->id)
                    ->where('program_volunteers.status', 'approved');
            })->orderBy('date', 'desc')->paginate(10);
        }

        // Get programs created by coordinators
        if ($user->hasRole('Program Coordinator') || $user->hasRole('Admin')) {
            $myPrograms = Program::where('created_by', $user->id)
                ->orderBy('date', 'desc')
                ->paginate(10);
        }

        return view('programs.index', compact('allPrograms', 'joinedPrograms', 'myPrograms'));
    }

    public function showDetailsModal(Program $program)
    {
        return view('programs.show', compact('program'));
    }

    public function gotoCreateProgram()
    {
        return view('programs.create');
    }

    public function storeProgram(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'volunteer_count' => 'nullable|integer|min:0',
        ]);

        $program = Program::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'created_by' => Auth::id(),
            'volunteer_count' => $request->volunteer_count ?? 0,
        ]);

        // Notify all volunteers about the new program
        $volunteers = User::whereHas('roles', function ($query) {
            $query->where('role_name', 'Volunteer');
        })->get();

        if ($volunteers->isNotEmpty()) {
            Notification::send($volunteers, new NewProgramAvailable($program));
        }

        // Create a welcome message in the program chat
        $program->chats()->create([
            'sender_id' => Auth::id(),
            'message' => "Welcome to the {$program->title} program chat!.",
            'message_type' => 'system',
            'is_pinned' => true
        ]);

        return redirect()->route('programs.index')->with('toast', [
            'message' => 'Program created successfully.',
            'type' => 'success'
        ]);
    }

    public function updateProgram(Request $request, Program $program)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'volunteer_count' => 'nullable|integer|min:0',
        ]);

        $program->update([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'location' => $request->location,
            'volunteer_count' => $request->volunteer_count ?? 0,
        ]);

        return redirect()
            ->route('programs.manage_volunteers', $program->id)
            ->with('toast', [
                'message' => 'Program updated successfully.',
                'type' => 'success'
            ]);
    }

    public function deleteProgram(Program $program)
    {
        $program->delete();

        return redirect()->route('programs.index')->with('toast', [
            'message' => 'Program deleted successfully.',
            'type' => 'success'
        ]);
    }
}
