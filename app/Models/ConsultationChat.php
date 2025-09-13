<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationChat extends Model
{
    protected $fillable = [
        'thread_id','sender_id','message','sent_at'
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
