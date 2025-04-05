<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class VolunteerApplication extends Model
{
    use HasFactory;
    protected $table = 'volunteer_application';
    protected $fillable = [
        'volunteer_id',
        'form_data',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'form_data' => 'array',
    ];

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class);
    }
}
