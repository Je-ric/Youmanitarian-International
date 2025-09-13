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

    // Start (or reuse) a thread between two users (role‑agnostic now)
    public function startWithUser(User $user)
    {
        $currentId = Auth::id();

        if ($currentId === $user->id) {
            return redirect()
                ->route('consultation-chats.index')
                ->with('toast', [
                    'message' => 'Cannot start a chat with yourself.',
                    'type' => 'info'
                ]);
        }

        [$one, $two] = $currentId < $user->id
            ? [$currentId, $user->id]
            : [$user->id, $currentId];

        // Extra guard lang, baka mabutasan
        if ($one === $two) {
            return redirect()
                ->route('consultation-chats.index')
                ->with('toast', [
                    'message' => 'Invalid thread participants.',
                    'type' => 'error'
                ]);
        }

        $thread = ConsultationThread::firstOrCreate(
            ['user_one_id' => $one, 'user_two_id' => $two],
            ['status' => 'active']
        );

        $msg = $thread->wasRecentlyCreated
            ? 'New conversation started.'
            : 'Conversation loaded.';

        return redirect()
            ->route('consultation-chats.thread.show', $thread)
            ->with('toast', [
                'message' => $msg,
                'type' => 'success'
            ]);
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
                'toast' => [
                    'message' => 'Message sent.',
                    'type' => 'success'
                ]
            ]);
        }

        return redirect()
            ->route('consultation-chats.thread.show', $thread)
            ->with('toast', [
                'message' => 'Message sent.',
                'type' => 'success'
            ]);
    }

    // Delete message
    public function destroyMessage(Request $request, ConsultationThread $thread, ConsultationChat $chat)
    {
        $this->authorizeThread($thread);

        if ($chat->thread_id !== $thread->id) {
            return response()->json([
                'success' => false,
                'error'   => 'Message not in this thread.'
            ], 404);
        }

        if ($chat->sender_id !== Auth::id()) {
            return response()->json([
                'success' => false,
                'error'   => 'You can only delete your own messages.'
            ], 403);
        }

        $chat->delete(); // soft or hard depending on model

        broadcast(new \App\Events\ConsultationChatMessageDeleted($chat->id, $thread->id))->toOthers();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'chat_id' => $chat->id
            ]);
        }

        return back()->with('toast', [
            'message' => 'Message deleted.',
            'type'    => 'success'
        ]);
    }

    // Helper

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
