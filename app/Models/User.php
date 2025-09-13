<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory, HasProfilePhoto, TwoFactorAuthenticatable;

    protected $fillable = [
        'name','email','password','google_id','profile_pic'
    ];

    protected $hidden = [
        'password','remember_token','two_factor_recovery_codes','two_factor_secret',
    ];

    protected $appends = ['profile_photo_url'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Roles / Permissions
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function assignedRoles()
    {
        return $this->hasMany(UserRole::class, 'assigned_by');
    }

    // Domain relations
    public function content()
    {
        return $this->hasMany(Content::class, 'created_by');
    }

    public function heartReacts()
    {
        return $this->hasMany(HeartReact::class);
    }

    public function contentRequests()
    {
        return $this->hasMany(ContentRequest::class, 'requested_by');
    }

    public function hasRole($roleName)
    {
        return $this->roles()->where('role_name', $roleName)->exists();
    }

    public function volunteer()
    {
        return $this->hasOne(Volunteer::class);
    }

    public function member()
    {
        return $this->hasOne(Member::class);
    }

    public function isVolunteer()
    {
        return $this->volunteer && $this->volunteer->application_status === 'approved';
    }

    public function isMember()
    {
        return $this->member && $this->member->membership_status === 'active';
    }

    // Consultation (current schema)
    public function consultationHours()
    {
        return $this->hasMany(ConsultationHour::class, 'user_id');
    }

    // Unified user-to-user threads (query builder shortcut)
    public function consultationThreads()
    {
        return ConsultationThread::where(function ($q) {
            $q->where('user_one_id', $this->id)
                ->orWhere('user_two_id', $this->id);
        });
    }
}
