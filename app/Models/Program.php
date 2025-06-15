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
    
    /**
     * Get the program's progress status based on current time.
     * This is a dynamic calculation that doesn't rely on the database value.
     *
     * @return string
     */
    public function getProgressStatusAttribute()
    {
        $today = now();
        $programDate = $this->date->format('Y-m-d');
        $startDateTime = Carbon::parse("$programDate {$this->start_time}");
        $endDateTime = Carbon::parse("$programDate {$this->end_time}");

        if ($today->lt($startDateTime)) {
            return 'incoming';
        } elseif ($today->between($startDateTime, $endDateTime)) {
            return 'ongoing';
        } else {
            return 'done';
        }
    }

    /**
     * Get the program's progress status with styling classes.
     *
     * @return array
     */
    public function getProgressStatusWithStyleAttribute()
    {
        $status = $this->progress_status;
        
        $variant = [
            'success' => 'bg-green-100 text-green-500',
            'neutral' => 'bg-indigo-50 text-gray-500',
            'info'    => 'bg-blue-50 text-blue-500',
            'warning' => 'bg-yellow-50 text-yellow-500',
            'danger'  => 'bg-red-50 text-red-500',
        ];

        $statusMap = [
            'incoming' => ['label' => 'Incoming', 'style' => $variant['info']],
            'ongoing' => ['label' => 'Ongoing', 'style' => $variant['success']],
            'done' => ['label' => 'Done', 'style' => $variant['neutral']],
        ];

        return $statusMap[$status] ?? ['label' => 'Unknown', 'style' => 'bg-gray-300 text-black'];
    }

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
        return $this->belongsToMany(User::class, 'user_roles', 'role_id', 'user_id')
            ->whereHas('roles', function ($query) {
                $query->where('role_name', 'Program Coordinator');
            });
    }

    /**
     * Get the volunteers for the program.
     */
}
