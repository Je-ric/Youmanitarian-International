<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProgramFeedback extends Model
{
    protected $fillable = [
        'program_id',
        'volunteer_id',
        'rating',
        'feedback',
        'submitted_at',
    ];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }
}
