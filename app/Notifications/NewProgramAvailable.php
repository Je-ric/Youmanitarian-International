<?php

namespace App\Notifications;

use App\Models\Program;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

// class NewProgramAvailable extends Notification
class NewProgramAvailable extends Notification implements ShouldQueue
{
    use Queueable;

    protected $program;
    protected $mode; // 'new' or 'update'

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Program  $program
     * @param  string $mode  // 'new' or 'update'
     * @return void
     */
    public function __construct(Program $program, $mode = 'new')
    {
        $this->program = $program;
        $this->mode = $mode;
    }

    // Static helpers for clarity
    public static function newProgram(Program $program)
    {
        return new self($program, 'new');
    }
    public static function updatedProgram(Program $program)
    {
        return new self($program, 'update');
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
        if ($this->mode === 'update') {
            return [
                'title' => 'Program Updated!',
                'type' => 'program_update',
                'message' => "The program '{$this->program->title}' has been updated. Please check for changes.",
                'action_url' => route('programs.index', [], false) . '?modal=' . $this->program->id,
                'program_id' => $this->program->id,
                'mode' => 'update',
            ];
        } else {
            return [
                'title' => 'New Program Available!',
                'type' => 'program_update',
                'message' => "A new program, '{$this->program->title},' is now open for volunteers.",
                'action_url' => route('programs.index', [], false) . '?modal=' . $this->program->id,
                'program_id' => $this->program->id,
                'mode' => 'new',
            ];
        }
    }
} 