<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAssignment extends Model
{
    use HasFactory;

    protected $fillable = ['task_id', 'volunteer_id', 'assigned_by', 'status'];

    public function task()
    {
        return $this->belongsTo(ProgramTask::class, 'task_id');
    }

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }


public function assignedByUser()
{
    return $this->belongsTo(User::class, 'assigned_by');
}

}
