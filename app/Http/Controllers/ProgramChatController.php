<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\ProgramChat;
use App\Models\Role;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProgramChatController extends Controller
{
    /**
     * Get all messages for a program
     */
    public function index(Request $request, Program $program)
    {
        // Check if user is authorized to view program chats
        if (!$this->canAccessProgramChat($program)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $messages = $program->chats()
            ->with(['sender:id,name,profile_pic', 'readBy:id'])
            ->whereNull('parent_id') // Get only parent messages
            ->with(['replies' => function ($query) {
                $query->with(['sender:id,name,profile_pic', 'readBy:id']);
            }])
            ->orderBy('is_pinned', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return response()->json($messages);
    }

    /**
     * Store a new message
     */
    public function store(Request $request, Program $program)
    {
        // Check if user is authorized to send messages
        if (!$this->canAccessProgramChat($program)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000',
            'message_type' => 'required|in:regular,announcement,system',
            'parent_id' => 'nullable|exists:program_chats,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $chat = $program->chats()->create([
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'message_type' => $request->message_type,
            'parent_id' => $request->parent_id
        ]);

        // Mark the message as read by the sender
        $chat->readBy()->attach(Auth::id());

        return response()->json([
            'message' => 'Message sent successfully',
            'chat' => $chat->load(['sender:id,name,profile_pic', 'readBy:id'])
        ], 201);
    }

    /**
     * Update a message
     */
    public function update(Request $request, Program $program, ProgramChat $chat)
    {
        // Check if user is the message sender
        if ($chat->sender_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $chat->update([
            'message' => $request->message,
            'is_edited' => true,
            'edited_at' => now()
        ]);

        return response()->json([
            'message' => 'Message updated successfully',
            'chat' => $chat->load(['sender:id,name,profile_pic', 'readBy:id'])
        ]);
    }

    /**
     * Delete a message (soft delete)
     */
    public function destroy(Program $program, ProgramChat $chat)
    {
        // Check if user is the message sender or a program coordinator
        if ($chat->sender_id !== Auth::id() && !$this->isProgramCoordinator($program)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $chat->delete();

        return response()->json(['message' => 'Message deleted successfully']);
    }

    /**
     * Mark messages as read
     */
    public function markAsRead(Request $request, Program $program)
    {
        if (!$this->canAccessProgramChat($program)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'message_ids' => 'required|array',
            'message_ids.*' => 'exists:program_chats,id'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $program->chats()
            ->whereIn('id', $request->message_ids)
            ->get()
            ->each(function ($chat) {
                $chat->readBy()->syncWithoutDetaching([Auth::id() => ['read_at' => now()]]);
            });

        return response()->json(['message' => 'Messages marked as read']);
    }

    /**
     * Pin/Unpin a message
     */
    public function togglePin(Program $program, ProgramChat $chat)
    {
        // Only program coordinators can pin messages
        if (!$this->isProgramCoordinator($program)) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $chat->update(['is_pinned' => !$chat->is_pinned]);

        return response()->json([
            'message' => $chat->is_pinned ? 'Message pinned' : 'Message unpinned',
            'chat' => $chat->load(['sender:id,name,profile_pic', 'readBy:id'])
        ]);
    }

    /**
     * Check if user can access program chat
     */
    private function canAccessProgramChat(Program $program)
    {
        // Check if user is the program creator
        if ($program->created_by === Auth::id()) {
            return true;
        }

        // Check if user is a program coordinator
        if ($this->isProgramCoordinator($program)) {
            return true;
        }

        // Check if user is an approved volunteer for this program
        return $program->volunteers()
            ->where('user_id', Auth::id())
            ->where('status', 'approved')
            ->exists();
    }

    /**
     * Check if user is a program coordinator
     */
    private function isProgramCoordinator(Program $program)
    {
        $user = Auth::user();
        if (!$user) return false;
        
        $coordinatorRole = Role::where('role_name', 'Program Coordinator')->first();
        if (!$coordinatorRole) return false;
        
        return UserRole::where('user_id', $user->id)
            ->where('role_id', $coordinatorRole->id)
            ->exists();
    }

    /**
     * Display the chat interface.
     */
    public function show(?Program $program = null)
    {
        // Get all programs where the user is a volunteer
        $volunteerPrograms = Program::whereHas('volunteers', function ($query) {
            $query->where('user_id', Auth::id())
                  ->where('status', 'approved');
        })->with(['volunteers', 'chats'])->get();

        // Get all programs where the user is a coordinator
        $coordinatorPrograms = Program::where('created_by', Auth::id())
            ->with(['volunteers', 'chats'])
            ->get();

        // Merge and deduplicate programs
        $programs = $volunteerPrograms->merge($coordinatorPrograms)->unique('id');

        // If no specific program is selected, just show the list
        if (!$program) {
            return view('programs_chats.index', [
                'programs' => $programs,
                'volunteerPrograms' => $volunteerPrograms,
                'coordinatorPrograms' => $coordinatorPrograms
            ]);
        }

        // Check if user can access the selected program's chat
        if (!$this->canAccessProgramChat($program)) {
            abort(403, 'You do not have access to this program chat.');
        }

        return view('programs_chats.index', [
            'program' => $program,
            'programs' => $programs,
            'volunteerPrograms' => $volunteerPrograms,
            'coordinatorPrograms' => $coordinatorPrograms
        ]);
    }
} 