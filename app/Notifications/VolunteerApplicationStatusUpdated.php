<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VolunteerApplicationStatusUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $status;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($status)
    {
        $this->status = $status;
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
        $title = $this->status === 'approved' ? 'Application Approved!' : 'Application Status Update';
        $message = $this->status === 'approved' 
            ? 'Congratulations! Your volunteer application has been approved. You can now join programs.'
            : 'Your volunteer application has been denied. Please contact an administrator for more information.';
        
        return [
            'title' => $title,
            'type' => 'volunteer_joined',
            'message' => $message,
            'action_url' => $this->status === 'approved' ? route('programs.index') : route('dashboard'),
        ];
    }
} 