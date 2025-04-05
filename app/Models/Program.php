<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 
                            'start_date', 'end_date', 
                            'start_time', 'end_time',
                            'location', 'created_by',
                            'progress', 'volunteer_count'];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function volunteers()
    {
        // return $this->belongsToMany(Volunteer::class, 'program_volunteers')->withTimestamps();

        return $this->belongsToMany(Volunteer::class, 'program_volunteers')
            ->withPivot('status', 'created_at', 'updated_at');
    }

    public function tasks()
    {
        return $this->hasMany(ProgramTask::class);
    }
    public function volunteerAttendances()
{
    return $this->hasMany(VolunteerAttendance::class);
}



    
}
