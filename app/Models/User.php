<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

/** @mixin \Illuminate\Notifications\Notifiable */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasFactory, HasProfilePhoto, TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'profile_pic'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the roles that belong to the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'user_roles', 'user_id', 'role_id');
    }

    public function assignedRoles()
    {
        return $this->hasMany(UserRole::class, 'assigned_by');
    }

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

    /**
     * Check if the user has a specific role.
     */
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

    // -------------------------------------------------------------------------

    public function consultationHours()
    {
        return $this->hasMany(\App\Models\ConsultationHour::class, 'user_id');
    }

    public function consultationThreadsAsVolunteer()
    {
        return $this->hasMany(\App\Models\ConsultationThread::class, 'volunteer_id');
    }

    public function consultationThreadsAsProfessional()
    {
        return $this->hasMany(\App\Models\ConsultationThread::class, 'professional_id');
    }

    public function consultationChats()
    {
        return $this->hasManyThrough(
            \App\Models\ConsultationChat::class,
            \App\Models\ConsultationThread::class,
            'volunteer_id',   // FK on threads table for first key
            'thread_id',      // FK on chats table
            'id',             // Local user id
            'id'              // Thread id
        );
    }


}
