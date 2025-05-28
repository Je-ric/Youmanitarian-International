<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class VolunteerApplication extends Model
{
     use HasFactory;

    protected $fillable = [
        'volunteer_id',
        'why_volunteer',
        'interested_programs',
        'skills_experience',
        'availability',
        'commitment_hours',
        'physical_limitations',
        'emergency_contact',
        'contact_consent',
        'volunteered_before',
        'outdoor_ok',
        'short_bio',
        'is_active',
        'submitted_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'submitted_at' => 'datetime',
    ];

    // Relationship: an application belongs to one volunteer
    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }

    
}
