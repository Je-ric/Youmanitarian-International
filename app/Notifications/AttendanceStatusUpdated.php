<?php

namespace App\Notifications;

use App\Models\Program;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AttendanceStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $status;
    protected $program;
    protected $notes;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($status, Program $program, $notes = null)
    {
        $this->status = $status;
        $this->program = $program;
        $this->notes = $notes;
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
        $statusText = ucfirst($this->status);
        $title = "Your Attendance has been {$statusText}!";
        $message = "Your attendance for the program '{$this->program->title}' has been {$this->status}.";
        
        if ($this->notes) {
            $message .= " Reviewer's notes: \"{$this->notes}\"";
        }
        
        return [
            'title' => $title,
            'message' => $message,
            'action_url' => route('programs.view', $this->program->id),
        ];
    }
} 