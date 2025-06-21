<?php

namespace App\Notifications;

use App\Models\Program;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VolunteerJoinedProgram extends Notification implements ShouldQueue
{
    use Queueable;

    protected $program;
    protected $volunteerUser;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Program $program, User $volunteerUser)
    {
        $this->program = $program;
        $this->volunteerUser = $volunteerUser;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
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
            'title' => 'A Volunteer Joined Your Program!',
            'message' => "{$this->volunteerUser->name} has joined your program: {$this->program->title}.",
            'action_url' => route('programs.manage_volunteers', $this->program->id),
            'program_id' => $this->program->id,
        ];
    }
} 