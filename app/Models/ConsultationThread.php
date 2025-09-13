<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationThread extends Model
{
    protected $fillable = [
        'volunteer_id',
        'professional_id',
        'status',
    ];

    // Relationships
    public function volunteer()
    {
        return $this->belongsTo(\App\Models\User::class, 'volunteer_id');
    }

    public function professional()
    {
        return $this->belongsTo(\App\Models\User::class, 'professional_id');
    }

    public function chats()
    {
        return $this->hasMany(\App\Models\ConsultationChat::class, 'thread_id');
    }

    public function latestChat()
    {
        return $this->hasOne(\App\Models\ConsultationChat::class, 'thread_id')->latestOfMany('sent_at');
    }

    // Scopes
    public function scopeBetween($query, $volunteerId, $professionalId)
    {
        return $query->where('volunteer_id', $volunteerId)
                     ->where('professional_id', $professionalId);
    }

    // Optional scope for user membership
    public function scopeForUser($q, $userId)
    {
        $q->where(function($qq) use ($userId) {
            $qq->where('volunteer_id', $userId)
               ->orWhere('professional_id', $userId);
        });
    }
}

