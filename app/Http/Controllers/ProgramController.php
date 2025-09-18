<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Program;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Notifications\ProgramUpdate;

class ProgramController extends Controller
{
    use AuthorizesRequests;

    /**
     * Display the programs list page with different views based on user role
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
        // Get the page number for the current tab
        $currentTab = $request->get('tab', 'all');
        $page       = $request->get('page', 1);
        $search     = $request->get('search');
        $sortBy     = $request->get('sort_by', 'date');
        $sortOrder  = $request->get('sort_order', 'desc');

        $allPrograms    = $this->getProgramsQuery($search, $sortBy, $sortOrder)->paginate(10, ['*'], 'page', $currentTab === 'all' ? $page : 1);
        $joinedPrograms = $this->getJoinedPrograms($user, $currentTab, $page, $search, $sortBy, $sortOrder);
        $myPrograms     = $this->getMyPrograms($user, $currentTab, $page, $search, $sortBy, $sortOrder);

        // Ensure pagination links keep the active tab in the query string
        $allPrograms->appends(['tab' => 'all', 'search' => $search, 'sort_by' => $sortBy, 'sort_order' => $sortOrder]);
        $joinedPrograms->appends(['tab' => 'joined', 'search' => $search, 'sort_by' => $sortBy, 'sort_order' => $sortOrder]);
        $myPrograms->appends(['tab' => 'my', 'search' => $search, 'sort_by' => $sortBy, 'sort_order' => $sortOrder]);

        return view('programs.index',
        compact('allPrograms',
                    'joinedPrograms',
                                'myPrograms',
                                'currentTab',
                                'search',
                                'sortBy',
                                'sortOrder'));
    }

    // programs/show.blade.php (main)
    public function showDetailsModal(Program $program)
    {
        return view('programs.show',
        compact('program'));
    }

    // programs/create.blade.php (main)
    public function gotoCreateProgram()
    {
        return view('programs.create');
    }

    // programs/create.blade.php (main)
    public function storeProgram(Request $request)
    {
        $data = $this->validateProgram($request);

        $program = Program::create(array_merge($data, [
            'created_by'       => Auth::id(),
            'volunteer_count'  => $data['volunteer_count'] ?? 0,
        ]));

        //! #region
        // Get all users with volunteer role
        // we need to check first kung may volunteer na
        // ang purpose is yung condition below, magproproceed lang yung notification sending if my volunteer
        // actually, useful lang talaga toh in early stage ng system
        //! #endregion
        $volunteers = User::whereHas('roles', function ($query) {
            $query->where('role_name', 'Volunteer');
        })->get();

        $this->notifyVolunteers($volunteers, new ProgramUpdate($program));

        // when creating a program, a group chat will instantly created
        // ito magsisilbing communication between pc and volunteers
        $program->chats()->create([
            'sender_id'    => Auth::id(),
            'message'      => "Welcome to the {$program->title} program chat!.",
            'message_type' => 'system',
            'is_pinned'    => true
        ]);

        return redirect()->route('programs.index')->with('toast', [
            'message' => 'Program created successfully.',
            'type'    => 'success'
        ]);
    }

    // programs_volunteers/partials/programDetails.blade.php (partial)
    public function updateProgram(Request $request, Program $program)
    {
        $data = $this->validateProgram($request);

        $program->update(array_merge($data, [
            // Only update volunteer_count if provided; otherwise keep current value
            'volunteer_count' => array_key_exists('volunteer_count', $data)
                ? ($data['volunteer_count'] ?? 0)
                : $program->volunteer_count,
        ]));

        //! #region
        // Notify all volunteers in this program about the update
        // check if may volunteer, para hindi na mag-occur nang error na wala namang sesendan
        // fetch all volunteer na nasa program
        // with('user') loads the User model for each volunteer, 1-1 relationship diba, para madisplay yung user data
        // NOTE: since kinuha kase natin is yung volunteer id or data hindi naman nag-ooccur don yung personal info gaya ng name and etc.
        // get() create collection ng user
        // pluck('user') ine-extract yung user data instead volunteer data, example user1 -> volunteer1
        // kase again, wala naman sa volunteer data yung personal info like name, email and etc.
        // filter() is to remove null user values from the collection, useful for notification sending
        // causes ng null values:
        // - may volunteer record pero walang user record (pwedeng dahil sa soft or hard user record delete)
        // example: volunteer1(user1) -> volunteer2(user2) -> volunteer3(null) -> volunteer4(user4)
        // output: user1, user2, user4
        //! #endregion
        $volunteers = $program->volunteers()->with('user')->get()->pluck('user')->filter();


        $this->notifyVolunteers($volunteers, ProgramUpdate::updatedProgram($program));

        if ($request->ajax()) {
            return response()->json([
                'success'    => true,
                'program_id' => $program->id
            ]);
        }

        return redirect()->route('programs.manage_volunteers', $program->id)->with('toast', [
            'message' => 'Program updated successfully.',
            'type'    => 'success'
        ]);
    }

    // programs/index.blade.php (main)
    public function destroy(Request $request, Program $program)
    {
        // $id = $program->id;
        $program->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success'    => true,
                'message'    => 'Program deleted successfully.',
                'program_id' => $program->id,
            ]);
        }

        return redirect()->route('programs.index')->with('toast', [
            'message' => 'Program deleted successfully.',
            'type'    => 'success'
        ]);
    }

    // ----------------------------
    //  Helper Methods
    // ----------------------------

    private function validateProgram(Request $request)
    {
        return $request->validate([
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'date'            => 'required|date',
            'start_time'      => 'required|date_format:H:i',
            'end_time'        => 'required|date_format:H:i|after:start_time',
            'location'        => 'nullable|string|max:255',
            'volunteer_count' => 'nullable|integer|min:0',
        ]);
    }

    private function notifyVolunteers($volunteers, $notification)
    {
        // 1. Only send notifications if there are volunteers in the system (New Program)
        // 2. Only send notifications if there are volunteers in the program (Update Program)
        // Send notification to all volunteers \Notifications\NewProgramAvailable.php
        if ($volunteers->isNotEmpty()) {
            Notification::send($volunteers, $notification);
        }
    }

    private function getProgramsQuery($search = null, $sortBy = 'date', $sortOrder = 'desc')
    {
        $query = Program::query();

        if ($search) {
            $query->where('title', 'like', "%{$search}%");
        }

        return $query->orderBy($sortBy, $sortOrder);
    }

    private function getJoinedPrograms($user, $currentTab, $page, $search = null, $sortBy = 'date', $sortOrder = 'desc')
    {
        // if user is a volunteer and has a volunteer record
        // get all programs na sinalihan ng volunteer
        if ($user->hasRole('Volunteer') && $user->volunteer) {
            $query = Program::whereHas('volunteers', function ($query) use ($user) {
                $query->where('volunteers.id', $user->volunteer->id) // volunteer id from the user
                    ->where('program_volunteers.status', 'approved');
            });

            if ($search) {
                $query->where('title', 'like', "%{$search}%");
            }

            return $query->orderBy($sortBy, $sortOrder)->paginate(10, ['*'], 'page', $currentTab === 'joined' ? $page : 1);
        }

        return Program::where('id', 0)->paginate(10, ['*'], 'page', $currentTab === 'joined' ? $page : 1);
    }

    private function getMyPrograms($user, $currentTab, $page, $search = null, $sortBy = 'date', $sortOrder = 'desc')
    {
        // since coordinator and admin lang yung may access sa create program
        // dinidisplay lang lahat ng programs na ginawa niya
        // pwede siguro lagyan ng auth check? pero nakatago naman sa blade yung myPrograms na tab kaya no need

        if ($user->hasRole('Program Coordinator') || $user->hasRole('Admin')) {
            $query = Program::where('created_by', $user->id);

            if ($search) {
                $query->where('title', 'like', "%{$search}%");
            }

            return $query->orderBy($sortBy, $sortOrder)->paginate(10, ['*'], 'page', $currentTab === 'my' ? $page : 1);
        }

        return Program::where('id', 0)->paginate(10, ['*'], 'page', $currentTab === 'my' ? $page : 1);
    }
}
