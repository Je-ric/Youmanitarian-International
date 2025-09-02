<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = [
        'member_id',
        'name',
        'position',
        'photo_url',
        'bio',
        'facebook_url',
        'instagram_url',
        'linkedin_url',
        'twitter_url',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
