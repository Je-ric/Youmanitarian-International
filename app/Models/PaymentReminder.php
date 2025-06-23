<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentReminder extends Model
{
    protected $table = 'membership_payments_reminders';

    protected $fillable = [
        'membership_payment_id',
        'sent_by_user_id',
        'status',
        'content'
    ];

    protected $casts = [
        'scheduled_for' => 'datetime',
        'sent_at' => 'datetime'
    ];

    /**
     * Get the membership payment that this reminder belongs to
     */
    public function membershipPayment(): BelongsTo
    {
        return $this->belongsTo(MembershipPayment::class);
    }

    /**
     * Get the user who sent the reminder
     */
    public function sentByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'sent_by_user_id');
    }

    /**
     * Check if the reminder has been sent
     */
    public function isSent(): bool
    {
        return $this->status === 'sent';
    }

    /**
     * Check if the reminder is scheduled
     */
    public function isScheduled(): bool
    {
        return $this->status === 'scheduled';
    }

    /**
     * Check if the reminder failed
     */
    public function hasFailed(): bool
    {
        return $this->status === 'failed';
    }
} 