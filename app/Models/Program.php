<?php

namespace App\Models;

use Carbon\Carbon;
use Kyslik\ColumnSortable\Sortable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Program extends Model
{
    use HasFactory;
    use Sortable;

    protected $fillable = [
        'title',
        'description',
        'date',
        'start_time',
        'end_time',
        'location',
        'created_by',
        'progress',
        'volunteer_count'
    ];

    public $sortable = [
        'title',
        'date',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'date' => 'datetime'
    ];
    
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function volunteers()
    {
        // return $this->belongsToMany(Volunteer::class, 'program_volunteers')->withTimestamps();

        // return $this->belongsToMany(Volunteer::class, 'program_volunteers')
        //     ->withPivot('status', 'created_at', 'updated_at');
        
        return $this->belongsToMany(Volunteer::class, 'program_volunteers', 'program_id', 'volunteer_id')
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

    /**
     * Get the chats for the program.
     */
    public function chats()
    {
        return $this->hasMany(ProgramChat::class);
    }

    public function feedback()
    {
        return $this->hasMany(ProgramFeedback::class);
    }

    /**
     * Get the roles associated with the program.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id')
            ->where('role_name', 'Program Coordinator');
    }

    /**
     * Get the user roles associated with the program.
     */
    public function userRoles()
    {
        return $this->hasMany(UserRole::class, 'user_id', 'id');
    }

    /**
     * Get the program coordinators.
     */
    public function programCoordinators()
    {
        return $this->belongsToMany(User::class, 'user_roles', 'user_id', 'role_id')
            ->whereHas('roles', function ($query) {
                $query->where('role_name', 'Program Coordinator');
            });
    }

    /**
     * Get the volunteers for the program.
     */
}
