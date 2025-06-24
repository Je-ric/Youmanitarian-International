<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VolunteerAttendance extends Model
{
    use HasFactory;

    protected $table = 'volunteer_attendance';
    protected $fillable = [
        'volunteer_id', 
        'program_id', 
        'clock_in', 
        'clock_out', 
        'hours_logged',
        'approval_status',
        'approved_by',
        'notes',
        'proof_image',
    ];

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class, 'volunteer_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
