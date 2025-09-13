<?php

namespace App\Http\Controllers;

use App\Models\ConsultationThread;
use App\Models\ConsultationChat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationChatsController extends Controller
{
    // Display all threads, optionally with a selected thread
    public function index(ConsultationThread $thread = null)
    {
        $userId = Auth::id();

        $threads = ConsultationThread::forUser($userId)
            ->with([
                'volunteer:id,name,profile_pic',
                'professional:id,name,profile_pic',
                'latestChat.sender:id,name',
            ])
            ->withCount('chats')
            ->orderByDesc(
                ConsultationChat::select('sent_at')
                    ->whereColumn('consultation_chats.thread_id', 'consultation_threads.id')
                    ->latest()
                    ->limit(1)
            )
            ->get();

        $messages = $thread
            ? $thread->chats()->with('sender:id,name,profile_pic')->orderBy('sent_at')->get()
            : collect();

        return view('consultation.consultationChats', compact('threads', 'thread', 'messages'));
    }

    // Store new chat message
    public function storeMessage(Request $request, ConsultationThread $thread)
    {
        $userId = Auth::id();

        if ($thread->volunteer_id !== $userId && $thread->professional_id !== $userId) {
            return response()->json(['success' => false], 403);
        }

        $data = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $chat = ConsultationChat::create([
            'thread_id' => $thread->id,
            'sender_id' => $userId,
            'message'   => $data['message'],
            'sent_at'   => now(),
        ])->load('sender:id,name,profile_pic');

        if ($request->ajax()) {
            return response()->json(['success' => true, 'chat' => $chat]);
        }

        return redirect()->route('consultation-chats.index', $thread);
    }

    // Optionally, you can add a method to start a new thread with a specific user
    public function startWithUser($otherUserId)
    {
        $userId = Auth::id();

        if ($otherUserId == $userId) {
            return redirect()->back()->with('info', 'You cannot start a chat with yourself.');
        }

        $thread = ConsultationThread::firstOrCreate(
            [
                'volunteer_id'    => min($userId, $otherUserId),
                'professional_id' => max($userId, $otherUserId),
            ],
            ['status' => 'active']
        );

        return redirect()->route('consultation-chats.index', $thread);
    }
}
