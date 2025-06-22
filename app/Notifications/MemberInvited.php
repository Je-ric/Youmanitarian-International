<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Member;

class MemberInvited extends Notification
{
    use Queueable;

    public $member;
    public $message;

    /**
     * Create a new notification instance.
     */
    public function __construct(Member $member, $message = null)
    {
        $this->member = $member;
        $this->message = $message ?? 'You have been invited to become a member of Youmanitarian-International.';
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'member_id' => $this->member->id,
            'message' => $this->message,
            'action_url' => route('member.invitation.show', ['member' => $this->member->id])
        ];
    }
}
