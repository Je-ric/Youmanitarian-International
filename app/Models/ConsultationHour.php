<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultationHour extends Model
{
    protected $fillable = [
        'user_id',
        'specialization',
        'day',
        'start_time',
        'end_time',
        'status',
    ];

    public function professional()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
