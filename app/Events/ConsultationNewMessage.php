<?php

namespace App\Events;

use App\Models\ConsultationChat;
use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ConsultationNewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ConsultationChat $chat;

    public function __construct(ConsultationChat $chat)
    {
        $this->chat = $chat;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('consultation.thread.' . $this->chat->thread_id);
    }

    public function broadcastWith(): array
    {
        return [
            'chat' => $this->chat->load('sender:id,name,profile_pic'),
        ];
    }
}
