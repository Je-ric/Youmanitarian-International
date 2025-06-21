<?php

namespace App\Notifications;

use App\Models\Program;
use App\Models\ProgramTask;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskAssigned extends Notification implements ShouldQueue
{
    use Queueable;

    protected $task;
    protected $program;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(ProgramTask $task, Program $program)
    {
        $this->task = $task;
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
            'title' => 'You Have a New Task!',
            'type' => 'task_assigned',
            'message' => "You have been assigned a new task: '{$this->task->task_description}' in the program '{$this->program->title}'.",
            'action_url' => route('programs.view', $this->program->id),
        ];
    }
} 