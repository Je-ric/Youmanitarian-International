<?php

namespace App\Http\Controllers;

use App\Events\NewChatMessage;
use App\Models\Program;
use App\Models\ProgramChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProgramChatController extends Controller
{
    /**
     * Display the list of all program chats.
     */
    public function index()
    {
        // Get programs where user is either a volunteer or coordinator
        $programs = Program::where(function($query) {
            $query->where('created_by', Auth::id())
                  ->orWhereHas('volunteers', function($q) {
                      $q->where('volunteers.user_id', Auth::id())
                        ->where('program_volunteers.status', 'approved');
                  });
        })->with(['volunteers', 'chats'])->get();

        return view('programs_chats.index', compact('programs'));
    }

    /**
     * Display the chat interface for a specific program.
     */
    public function show(Program $program)
    {
        // Check if user can access the program's chat
        if (!$this->canAccessProgramChat($program)) {
            return redirect()->route('program.chats.index')
                           ->with('toast', [
                               'type' => 'error',
                               'message' => 'You do not have access to this program chat.'
                           ]);
        }

        // Get all programs for the sidebar
        $programs = Program::where(function($query) {
            $query->where('created_by', Auth::id())
                  ->orWhereHas('volunteers', function($q) {
                      $q->where('volunteers.user_id', Auth::id())
                        ->where('program_volunteers.status', 'approved');
                  });
        })->with(['volunteers', 'chats'])->get();

        // Get messages for the selected program
        $messages = $program->chats()
            ->with(['sender:id,name,profile_pic'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('programs_chats.index', compact('programs', 'program', 'messages'));
    }

    /**
     * Store a new message
     */
    public function store(Request $request, Program $program)
    {
        if (!$this->canAccessProgramChat($program)) {
            return response()->json([
                'error' => 'You do not have access to this program chat.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Message is required and must be less than 1000 characters.'
            ], 422);
        }

        $chat = $program->chats()->create([
            'sender_id' => Auth::id(),
            'message' => $request->message
        ]);

        // Load the sender relationship for broadcasting
        $chat->load('sender:id,name,profile_pic');

        // Broadcast the new message
        broadcast(new NewChatMessage($chat))->toOthers();

        return response()->json([
            'message' => 'Message sent successfully.',
            'chat' => $chat
        ]);
    }

    /**
     * Update a message
     */
    public function update(Request $request, Program $program, ProgramChat $chat)
    {
        if ($chat->sender_id !== Auth::id()) {
            return response()->json([
                'error' => 'You can only edit your own messages.'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'message' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Message is required and must be less than 1000 characters.'
            ], 422);
        }

        $chat->update([
            'message' => $request->message,
            'is_edited' => true,
            'edited_at' => now()
        ]);

        // Load the sender relationship for broadcasting
        $chat->load('sender:id,name,profile_pic');

        // Broadcast the updated message
        broadcast(new NewChatMessage($chat))->toOthers();

        return response()->json([
            'message' => 'Message updated successfully.',
            'chat' => $chat
        ]);
    }

    /**
     * Delete a message
     */
    public function destroy(Program $program, ProgramChat $chat)
    {
        if ($chat->sender_id !== Auth::id()) {
            return response()->json([
                'error' => 'You can only delete your own messages.'
            ], 403);
        }

        // Store the chat ID before deletion for broadcasting
        $chatId = $chat->id;
        
        $chat->delete();

        // Broadcast the deleted message
        broadcast(new NewChatMessage((object)[
            'id' => $chatId,
            'is_deleted' => true,
            'program_id' => $program->id
        ]))->toOthers();

        return response()->json([
            'message' => 'Message deleted successfully.'
        ]);
    }

    /**
     * Check if user can access program chat
     */
    private function canAccessProgramChat(Program $program)
    {
        return $program->created_by === Auth::id() || 
               $program->volunteers()
                   ->where('volunteers.user_id', Auth::id())
                   ->where('program_volunteers.status', 'approved')
                   ->exists();
    }
} 