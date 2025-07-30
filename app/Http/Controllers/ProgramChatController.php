<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\ProgramChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramChatController extends Controller
{
    // programs_chats/index.blade.php (main)
    public function index()
    {
        $programs = $this->getUserPrograms();
        return view('programs_chats.index', compact('programs'));
    }

    // programs_chats/index.blade.php (main)
    public function show(Program $program)
    {
        if (!$this->canAccessProgram($program)) {
            return redirect()->route('program.chats.index')->with('error', 'You do not have access to this program chat.');
        }

        $programs = $this->getUserPrograms();
        $messages = $program->chats()->with(['sender:id,name,profile_pic'])->orderBy('created_at', 'asc')->paginate(20);

        // ProgramChat::withTrashed()->get();
        // ProgramChat::onlyTrashed()->get();

        return view('programs_chats.index', compact('programs', 'program', 'messages'));
    }

    // programs_chats/index.blade.php (main)
    public function store(Request $request, Program $program)
    {
        if (!$this->canAccessProgram($program)) {
            return response()->json(['success' => false, 'error' => 'You do not have access to this program chat.'], 403);
        }

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = $program->chats()->create([
            'sender_id' => Auth::id(),
            'message' => $request->message,
            'message_type' => 'regular',
            'sent_at' => now()
        ]);

        $message->load('sender:id,name,profile_pic');

        if ($request->ajax()) {
            $deleteUrl = route('program.chats.destroy', [$program, $message]);
            return response()->json(['success' => true, 'chat' => $message, 'delete_url' => $deleteUrl]);
        }
        return redirect()->route('program.chats.show', $program)->with('success', 'Message sent!');
    }

    // programs_chats/index.blade.php (main)
    public function destroy(Request $request, Program $program, ProgramChat $chat)

    {
        if ($chat->program_id !== $program->id) {
            return response()->json(['success' => false, 'error' => 'Message not found in this program.'], 404);
        }

        if ($chat->sender_id !== Auth::id()) {
            return response()->json(['success' => false, 'error' => 'You can only delete your own messages.'], 403);
        }

        $chat->delete();
        // message arent deleted from the db, they are soft deleted (check the model)
        // naka timestamp deleted_at, and naka hidden
        // soft delete means it can be restored
        // $chat->forceDelete(); // delete the message from the db

        return response()->json(['success' => true, 'chat_id' => $chat->id]);
    }



    // --- Helper methods ---
    private function getUserPrograms()
    {
        return Program::where(function($query) {
            $query->where('created_by', Auth::id())
                  ->orWhereHas('volunteers', function($q) {
                      $q->where('volunteers.user_id', Auth::id())
                        ->where('program_volunteers.status', 'approved');
                  });
        })->with(['volunteers', 'chats'])->get();
    }

    private function canAccessProgram(Program $program)
    {
        return $program->created_by === Auth::id() ||
               $program->volunteers()
                   ->where('volunteers.user_id', Auth::id())
                   ->where('program_volunteers.status', 'approved')
                   ->exists();
    }
}
