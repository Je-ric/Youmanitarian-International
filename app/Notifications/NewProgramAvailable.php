<?php

namespace App\Notifications;

use App\Models\Program;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewProgramAvailable extends Notification
{
    use Queueable;

    protected $program;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Program  $program
     * @return void
     */
    public function __construct(Program $program)
    {
        $this->program = $program;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database']; // We'll store it in the database for now
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'title' => 'New Program Available!',
            'message' => "A new program, '{$this->program->title},' is now open for volunteers.",
            'action_url' => route('programs.index'),
            'program_id' => $this->program->id,
        ];
    }
} 