<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'total_hours', 'status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function programs()
    {
        // return $this->hasMany(ProgramVolunteer::class);
        // return $this->belongsToMany(Program::class, 'program_volunteers')->withPivot('status')->withTimestamps();

        // return $this->belongsToMany(Program::class, 'program_volunteers', 'volunteer_id', 'program_id')
        // ->withPivot('status')->withTimestamps(); 
        return $this->belongsToMany(Program::class, 'program_volunteers', 'volunteer_id', 'program_id')
        ->withPivot('status')->withTimestamps(); 
    }

    public function application()
    {
        return $this->hasOne(VolunteerApplication::class, 'volunteer_id');
    }

    public function attendanceLogs()
    {
        return $this->hasMany(VolunteerAttendance::class, 'volunteer_id');
    }

    public function attendances()
    {
        return $this->hasMany(\App\Models\VolunteerAttendance::class);
    }

    public function taskAssignments()
    {
        return $this->hasMany(TaskAssignment::class);
    }
    
    public function feedbacks()
    {
        return $this->hasMany(ProgramFeedback::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
