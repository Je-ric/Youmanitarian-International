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

        /**
     * Display the programs list page with different views based on user role
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    // programs/index.blade.php (main)
    public function gotoProgramsList(Request $request)
    {
        // Get authenticated user
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Get the current tab from the request
        $currentTab = $request->get('tab', 'all');

        // Get the page number for the current tab
        $page = $request->get('page', 1);

        $allPrograms = Program::orderBy('date', 'desc')->paginate(10, ['*'], 'page', $currentTab === 'all' ? $page : 1);

        // create empty collections para sa joined at created programs
        // purpose nito ay ipakita ang empty state kung wala naman talagang laman
        $joinedPrograms = Program::where('id', 0)->paginate(10, ['*'], 'page', $currentTab === 'joined' ? $page : 1);
        $myPrograms = Program::where('id', 0)->paginate(10, ['*'], 'page', $currentTab === 'my' ? $page : 1);

        // if user is a volunteer and has a volunteer record
        // get all programs na sinalihan ng volunteer
        if ($user->hasRole('Volunteer') && $user->volunteer) {
            // ito na yung variable na pinrepare
            $joinedPrograms = Program::whereHas('volunteers', function ($query) use ($user) {
                $query->where('volunteers.id', $user->volunteer->id)  // volunteer id from the user
                    ->where('program_volunteers.status', 'approved');
            })->orderBy('date', 'desc')->paginate(10, ['*'], 'page', $currentTab === 'joined' ? $page : 1);
        }

        // since coordinator and admin lang yung may access sa create program
        // dinidisplay lang lahat ng programs na ginawa niya
        // pwede siguro lagyan ng auth check? pero nakatago naman sa blade yung myPrograms na tab kaya no need
        if ($user->hasRole('Program Coordinator') || $user->hasRole('Admin')) {
            $myPrograms = Program::where('created_by', $user->id)
                ->orderBy('date', 'desc')
                ->paginate(10, ['*'], 'page', $currentTab === 'my' ? $page : 1);
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

    // programs/show.blade.php (main)
    public function showDetailsModal(Program $program)
    {
        return view('programs.show', compact('program'));
    }

    // programs/create.blade.php (main)
    public function gotoCreateProgram()
    {
        return view('programs.create');
    }

    // programs/create.blade.php (main)
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
        // we need to check first kung may volunteer na
        // ang purpose is yung condition below, magproproceed lang yung notification sending if my volunteer
        // actually, useful lang talaga toh in early stage ng system
        $volunteers = User::whereHas('roles', function ($query) {
            $query->where('role_name', 'Volunteer');
        })->get();

        // Only send notifications if there are volunteers in the system
        // Send notification to all volunteers \Notifications\NewProgramAvailable.php
        if ($volunteers->isNotEmpty()) {
            Notification::send($volunteers, new ProgramUpdate($program));
        }

        // when creating a program, a group chat will instantly created
        // ito magsisilbing communication between pc and volunteers
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

    // programs_volunteers/partials/programDetails.blade.php (partial)
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
        // fetch all volunteer na nasa program
        // with('user') loads the User model for each volunteer, 1-1 relationship diba, para madisplay yung user data
        // since kinuha kase natin is yung volunteer id or data hindi naman nag-ooccur don yung personal info gaya ng name and etc.
        // get() create collection ng user
        // pluck('user') ine-extract yung user data instead volunteer data, example user1 -> volunteer1
        // kase again, wala naman sa volunteer data yung personal info like name, email and etc.
        // filter() is to remove null user values from the collection, useful for notification sending
            // causes ng null values:
            // - may volunteer record pero walang user record (pwedeng dahil sa soft or hard user record delete)
            // example: volunteer1(user1) -> volunteer2(user2) -> volunteer3(null) -> volunteer4(user4)
            // output: user1, user2, user4
        $volunteers = $program->volunteers()
                    ->with('user')
                    ->get()
                    ->pluck('user')
                    ->filter();

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

    // programs/index.blade.php (main)
    public function deleteProgram(Program $program)
    {
        $program->delete();

        return redirect()->route('programs.index')->with('toast', [
            'message' => 'Program deleted successfully.',
            'type' => 'success'
        ]);
    }
}
