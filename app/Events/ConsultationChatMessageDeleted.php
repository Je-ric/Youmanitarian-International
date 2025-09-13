<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class ConsultationChatMessageDeleted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $messageId;
    public int $threadId;

    public function __construct(int $messageId, int $threadId)
    {
        $this->messageId = $messageId;
        $this->threadId  = $threadId;
    }

    public function broadcastOn(): Channel
    {
        return new Channel('consultation.thread.' . $this->threadId);
    }

    public function broadcastWith(): array
    {
        return [
            'messageId' => $this->messageId,
            'threadId'  => $this->threadId,
        ];
    }
}
