<?php

namespace App\Http\Controllers;

use App\Models\ConsultationThread;
use App\Models\ConsultationChat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ConsultationChatsController extends Controller
{
    public function index()
    {
        $userId   = Auth::id();
        $threads  = $this->prepareThreads($userId);
        $thread   = null;
        $messages = collect();
        $other    = null;

        return view('consultation.consultationChats', compact('threads','thread','messages','other'));
    }

    public function show(ConsultationThread $thread)
    {
        $this->authorizeThread($thread);

        $userId  = Auth::id();
        $threads = $this->prepareThreads($userId, $thread->id);
        $other   = $thread->user_one_id === $userId ? $thread->userTwo : $thread->userOne;

        $rawMessages = $thread->chats()
            ->with('sender:id,name,profile_pic')
            ->orderBy('sent_at')
            ->get();

        $messages = $rawMessages->map(function($m) use ($userId, $thread) {
            $sentAt = Carbon::parse($m->sent_at);
            return [
                'id'          => $m->id,
                'thread_id'   => $thread->id,
                'sender_id'   => $m->sender_id,
                'sender_name' => $m->sender->name,
                'message'     => $m->message,
                'is_mine'     => $m->sender_id === $userId,
                'time_label'  => $this->formatMessageTime($sentAt),
                'sent_iso'    => $sentAt->toIso8601String(),
                'delete_url'  => route('consultation-chats.thread.message.destroy', [$thread, $m]),
            ];
        });

        return view('consultation.consultationChats', compact('threads','thread','messages','other'));
    }

    // Start (or reuse) a thread between two users (role‑agnostic now)
    public function startWithUser(User $user)
    {
        $currentId = Auth::id();
        if ($currentId === $user->id) {
            return redirect()
                ->route('consultation-chats.index')
                ->with('toast', ['message' => 'Cannot chat with yourself.', 'type' => 'info']);
        }

        $thread = ConsultationThread::betweenUsers($currentId, $user->id)->first();

        if (!$thread) {
            [$one,$two] = $currentId < $user->id ? [$currentId,$user->id] : [$user->id,$currentId];
            $thread = ConsultationThread::create([
                'user_one_id' => $one,
                'user_two_id' => $two,
                'status'      => 'active'
            ]);
            $toast = ['message' => 'Conversation started.', 'type' => 'success'];
        } else {
            $toast = ['message' => 'Conversation opened.', 'type' => 'success'];
        }

        return redirect()
            ->route('consultation-chats.thread.show', $thread)
            ->with('toast', $toast);
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

    private function prepareThreads(int $userId, ?int $activeId = null)
    {
        return ConsultationThread::forUser($userId)
            ->with(['userOne:id,name,profile_pic','userTwo:id,name,profile_pic','latestChat.sender:id,name'])
            ->withCount('chats')
            ->orderByDesc(
                ConsultationChat::select('sent_at')
                    ->whereColumn('consultation_chats.thread_id', 'consultation_threads.id')
                    ->latest()
                    ->limit(1)
            )
            ->get()
            ->map(function($t) use ($userId, $activeId) {
                $other    = $t->user_one_id === $userId ? $t->userTwo : $t->userOne;
                $last     = $t->latestChat;
                $lastTime = $last ? Carbon::parse($last->sent_at) : null;
                $timeLabel = '';
                if ($lastTime) {
                    if ($lastTime->isToday())       $timeLabel = $lastTime->format('g:i A');
                    elseif ($lastTime->isYesterday()) $timeLabel = 'Yesterday';
                    else                               $timeLabel = $lastTime->format('M j');
                }
                $preview = $last?->message
                    ? Str::limit($last->message, 40)
                    : 'No messages yet.';
                return [
                    'id'         => $t->id,
                    'other'      => $other,
                    'preview'    => $preview,
                    'time_label' => $timeLabel,
                    'is_active'  => $activeId === $t->id,
                ];
            });
    }

    private function formatMessageTime(Carbon $dt): string
    {
        if ($dt->isToday()) return $dt->format('g:i A');
        if ($dt->isYesterday()) return 'Yesterday '.$dt->format('g:i A');
        return $dt->format('M j, Y g:i A');
    }

    private function authorizeThread(ConsultationThread $thread): void
    {
        $uid = Auth::id();
        if ($thread->user_one_id !== $uid && $thread->user_two_id !== $uid) {
            abort(403);
        }
    }
}
