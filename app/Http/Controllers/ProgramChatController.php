<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\ProgramChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProgramChatController extends Controller
{
    public function index()
    {
        $programs = $this->getUserPrograms();
        return view('programs_chats.index', compact('programs'));
    }

    public function show(Program $program)
    {
        if (!$this->canAccessProgram($program)) {
            return redirect()->route('program.chats.index')->with('error', 'You do not have access to this program chat.');
        }

        $programs = $this->getUserPrograms();
        $messages = $program->chats()->with(['sender:id,name,profile_pic'])->orderBy('created_at', 'asc')->paginate(20);

        return view('programs_chats.index', compact('programs', 'program', 'messages'));
    }

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
            return response()->json(['success' => true, 'chat' => $message]);
        }
        return redirect()->route('program.chats.show', $program)->with('success', 'Message sent!');
    }

    public function update(Request $request, Program $program, ProgramChat $message)
    {
        if ($message->program_id !== $program->id) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Message not found in this program.'], 404);
            }
            return redirect()->route('program.chats.show', $program)->with('error', 'Message not found in this program.');
        }
        if ($message->sender_id !== Auth::id()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'You can only edit your own messages.'], 403);
            }
            return redirect()->route('program.chats.show', $program)->with('error', 'You can only edit your own messages.');
        }

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message->update([
            'message' => $request->message,
            'is_edited' => true,
            'edited_at' => now()
        ]);

        $message->load('sender:id,name,profile_pic');

        if ($request->ajax()) {
            return response()->json(['success' => true, 'chat' => $message]);
        }
        return redirect()->route('program.chats.show', $program)->with('success', 'Message updated!');
    }

    public function destroy(Request $request, Program $program, ProgramChat $message)
    {
        if ($message->program_id !== $program->id) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'Message not found in this program.'], 404);
            }
            return redirect()->route('program.chats.show', $program)->with('error', 'Message not found in this program.');
        }
        if ($message->sender_id !== Auth::id()) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'error' => 'You can only delete your own messages.'], 403);
            }
            return redirect()->route('program.chats.show', $program)->with('error', 'You can only delete your own messages.');
        }

        $message->delete();

        if ($request->ajax()) {
            return response()->json(['success' => true, 'chat_id' => $message->id]);
        }
        return redirect()->route('program.chats.show', $program)->with('success', 'Message deleted!');
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