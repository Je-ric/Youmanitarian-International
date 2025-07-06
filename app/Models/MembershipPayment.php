<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MembershipPayment extends Model
{
    protected $fillable = [
        'member_id',
        'amount',
        'payment_date',
        'payment_status',
        'payment_method',
        'receipt_url',
        'payment_period',
        'payment_year',
        'notes',
        'recorded_by',
    ];

    protected $casts = [
        'payment_date' => 'datetime',
        'amount' => 'decimal:2',
        'payment_year' => 'integer',
        'recorded_by' => 'integer',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    /**
     * Get the reminders for this payment
     */
    public function reminders(): HasMany
    {
        return $this->hasMany(PaymentReminder::class, 'membership_payment_id');
    }

    public function recorder()
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function isPaid(): bool
    {
        return $this->payment_status === 'paid';
    }

    public function isOverdue(): bool
    {
        return $this->payment_status === 'overdue';
    }

    public function isPending(): bool
    {
        return $this->payment_status === 'pending';
    }
}
