<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\User;
use App\Notifications\ProgramUpdate;
use Illuminate\Support\Facades\Notification;

class ProgramController extends Controller
{
    use AuthorizesRequests;

    public function gotoProgramsList(Request $request)
    {
        // /** @var \App\Models\User $user */
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }
        $tab = $request->get('tab', 'all');

        $allPrograms = Program::orderBy('date', 'desc')->paginate(10);

        // Initialize other program collections with empty paginated collections
        $joinedPrograms = Program::where('id', 0)->paginate(10);
        $myPrograms = Program::where('id', 0)->paginate(10);

        // joined programs for volunteers
        if ($user->hasRole('Volunteer') && $user->volunteer) {
            $joinedPrograms = Program::whereHas('volunteers', function ($query) use ($user) {
                $query->where('volunteers.id', $user->volunteer->id)
                    ->where('program_volunteers.status', 'approved');
            })->orderBy('date', 'desc')->paginate(10);
        }

        // programs created by coordinators
        if ($user->hasRole('Program Coordinator') || $user->hasRole('Admin')) {
            $myPrograms = Program::where('created_by', $user->id)
                ->orderBy('date', 'desc')
                ->paginate(10);
        }

        return view('programs.index',
            compact('allPrograms',
            'joinedPrograms',
                        'myPrograms')
                    );

        // compact() takes variable names as strings

        // return view('programs.index', [
        //     'allPrograms' => $allPrograms,
        //     'joinedPrograms' => $joinedPrograms,
        //     'myPrograms' => $myPrograms
        // ]);
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

        // Get all users with volunteer role
        $volunteers = User::whereHas('roles', function ($query) {
            $query->where('role_name', 'Volunteer');
        })->get();


        // Only send notifications if there are volunteers in the system
        // Send notification to all volunteers \Notifications\NewProgramAvailable.php
        if ($volunteers->isNotEmpty()) {
            Notification::send($volunteers, new ProgramUpdate($program));
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
            // 'title' => $request->input('title'),
            // 'description' => $request->input('description'),
            // 'date' => $request->input('date'),
            // 'start_time' => $request->input('start_time'),
            // 'end_time' => $request->input('end_time'),
            // 'location' => $request->input('location'),
            // 'volunteer_count' => $request->input('volunteer_count', 0),
        ]);

        // Notify all volunteers in this program about the update
        // check if may volunteer, para hindi na mag-occur nang error na wala namang sesendan
        $volunteers = $program->volunteers()->with('user')->get()->pluck('user')->filter();
        if ($volunteers->isNotEmpty()) {
            Notification::send($volunteers, ProgramUpdate::updatedProgram($program));
        }

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
