<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramVolunteer extends Model
{
    protected $table = 'program_volunteers';
    use HasFactory;

    protected $fillable = ['program_id', 'volunteer_id', 'status'];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }
}
