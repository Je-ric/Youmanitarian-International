<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'volunteer_id',
        'membership_type',
        'membership_status',
        'invitation_status',
        'invited_at',
        // 'invitation_expires_at',
        'start_date',
        // 'end_date',
        // 'board_invited',
        'profile_photo_url',
        'invited_by',
    ];

    protected $casts = [
        'invited_at' => 'datetime',
        // 'invitation_expires_at' => 'datetime',
        'start_date' => 'datetime',
        // 'end_date' => 'datetime',
        // 'board_invited' => 'boolean',
        'profile_photo_url' => 'string',
        'invited_by' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
        // return $this->hasOne(Volunteer::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(MembershipPayment::class);
    }

    public function isActive(): bool
    {
        return $this->membership_status === 'active';
    }

    public function isInvitationPending(): bool
    {
        return $this->invitation_status === 'pending';
    }

    // public function isInvitationExpired(): bool
    // {
    //     return $this->invitation_expires_at && $this->invitation_expires_at->isPast();
    // }

    public function getCurrentQuarter(): string
    {
        $month = now()->month;
        if ($month <= 3) return 'Q1';
        if ($month <= 6) return 'Q2';
        if ($month <= 9) return 'Q3';
        return 'Q4';
    }

    public function inviter()
    {
        return $this->belongsTo(User::class, 'invited_by');
    }
}
