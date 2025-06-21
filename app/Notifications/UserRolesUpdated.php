<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserRolesUpdated extends Notification implements ShouldQueue
{
    use Queueable;

    protected $addedRoles;
    protected $removedRoles;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($addedRoles, $removedRoles)
    {
        $this->addedRoles = $addedRoles;
        $this->removedRoles = $removedRoles;
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
        $message = 'Your roles have been updated.';
        if (!empty($this->addedRoles)) {
            $message .= ' You have been given the role(s): ' . implode(', ', $this->addedRoles) . '.';
        }
        if (!empty($this->removedRoles)) {
            $message .= ' Your role(s) have been removed: ' . implode(', ', $this->removedRoles) . '.';
        }

        $remainingRoles = $notifiable->roles->pluck('role_name')->toArray();

        if (!empty($remainingRoles)) {
            $message .= ' Your current roles are now: ' . implode(', ', $remainingRoles) . '.';
        } else {
            $message .= ' You currently have no roles assigned.';
        }

        return [
            'title' => 'Your Roles Have Been Updated',
            'type' => 'role_update',
            'message' => $message,
            'action_url' => route('dashboard'),
        ];
    }
} 