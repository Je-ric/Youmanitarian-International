<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'volunteer_id',
        'membership_type',
        'start_date',
        'end_date',
        'membership_status',
        'board_invited',
        'became_member_at'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'became_member_at' => 'datetime',
        'board_invited' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }

    public function membershipPayments()
    {
        return $this->hasMany(MembershipPayment::class);
    }
}
