<?php

namespace App\Http\Controllers;

use App\Models\ConsultationThread;
use App\Models\ConsultationChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationChatsController extends Controller
{
    // List only (no active thread)
    public function index()
    {
        $threads = $this->loadUserThreads(Auth::id());
        $thread = null;
        $messages = collect();

        return view('consultation.consultationChats', compact('threads', 'thread', 'messages'));
    }

    // Show a specific thread (sidebar + selected conversation)
    public function show(ConsultationThread $thread)
    {
        $this->authorizeThread($thread);

        $threads  = $this->loadUserThreads(Auth::id());
        $messages = $thread->chats()
            ->with('sender:id,name,profile_pic')
            ->orderBy('sent_at')
            ->get();

        return view('consultation.consultationChats', compact('threads', 'thread', 'messages'));
    }

    // Send message
    public function storeMessage(Request $request, ConsultationThread $thread)
    {
        $this->authorizeThread($thread);

        $data = $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        $chat = ConsultationChat::create([
            'thread_id' => $thread->id,
            'sender_id' => Auth::id(),
            'message'   => $data['message'],
            'sent_at'   => now(),
        ])->load('sender:id,name,profile_pic');

        // broadcast (exclude current sender on client via check)
        broadcast(new \App\Events\ConsultationNewMessage($chat))->toOthers();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'chat' => $chat,
            ]);
        }

        return redirect()->route('consultation-chats.thread.show', $thread);
    }

    // Start (or reuse) a thread between two users (role‑agnostic now)
    public function startWithUser(User $user)
    {
        $currentId = Auth::id();
        if ($currentId === $user->id) {
            return redirect()->route('consultation-chats.index')->with('info', 'Cannot start a chat with yourself.');
        }

        [$one, $two] = $currentId < $user->id
            ? [$currentId, $user->id]
            : [$user->id, $currentId];

        $thread = ConsultationThread::firstOrCreate(
            ['user_one_id' => $one, 'user_two_id' => $two],
            ['status' => 'active']
        );

        return redirect()->route('consultation-chats.thread.show', $thread);
    }

    /* ---------------- Helpers ---------------- */

    private function loadUserThreads(int $userId)
    {
        return ConsultationThread::forUser($userId)
            ->with([
                'userOne:id,name,profile_pic',
                'userTwo:id,name,profile_pic',
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
    }

    private function authorizeThread(ConsultationThread $thread): void
    {
        $uid = Auth::id();
        if ($thread->user_one_id !== $uid && $thread->user_two_id !== $uid) {
            abort(403);
        }
    }
}
