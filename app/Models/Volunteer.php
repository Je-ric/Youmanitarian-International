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
        return $this->belongsToMany(Program::class, 'program_volunteers')->withPivot('status') ->withTimestamps();
    }
    

}
