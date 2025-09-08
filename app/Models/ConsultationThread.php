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
        return $this->belongsTo(User::class, 'volunteer_id');
    }

    public function professional()
    {
        return $this->belongsTo(User::class, 'professional_id');
    }

    public function chats()
    {
        return $this->hasMany(ConsultationChat::class, 'thread_id');
    }
}

