<?php

namespace App\Notifications;

use App\Models\PaymentReminder as PaymentReminderModel;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentReminder extends Notification
{
    use Queueable;

    public $reminder;

    /**
     * Create a new notification instance.
     *
     * @param \App\Models\PaymentReminder $reminder
     * @return void
     */
    public function __construct(PaymentReminderModel $reminder)
    {
        $this->reminder = $reminder;
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
        $payment = $this->reminder->membershipPayment;
        $period = $payment->payment_period . ' ' . $payment->payment_year;
        
        return [
            'title' => 'Payment Reminder',
            'reminder_id' => $this->reminder->id,
            'type' => 'payment_reminder',
            'membership_payment_id' => $this->reminder->membership_payment_id,
            'message' => "You have a payment reminder for your membership fee for {$period}.",
            'content' => $this->reminder->content,
            'action_url' => route('finance.membership.payments'),
        ];
    }
}
