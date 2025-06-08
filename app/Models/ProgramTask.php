<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramTask extends Model
{
    use HasFactory;

    protected $fillable = ['program_id', 'task_description', 'status'];

    public function program()
    {
        return $this->belongsTo(Program::class);
    }


    public function assignments()
    {
        // return $this->hasMany(TaskAssignment::class);
        return $this->hasMany(TaskAssignment::class, 'task_id');
    }
}
