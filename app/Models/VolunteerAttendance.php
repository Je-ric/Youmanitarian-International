<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class VolunteerAttendance extends Model
{
    use HasFactory;

    protected $table = 'volunteer_attendance';
    protected $fillable = [
        'volunteer_id',
        'program_id',
        'clock_in',
        'clock_out',
        'hours_logged',
        'approval_status',
        'approved_by',
        'notes',
        'proof_image',
    ];

    protected $casts = [
        'clock_in' => 'datetime',
        'clock_out' => 'datetime',
        'hours_logged' => 'float',
    ];

    protected static function booted()
    {
        // Before saving, compute hours_logged if both times exist
        static::saving(function (VolunteerAttendance $attendance) {
            if ($attendance->clock_in && $attendance->clock_out) {
                try {
                    $start = $attendance->clock_in instanceof Carbon
                        ? $attendance->clock_in
                        : Carbon::parse($attendance->clock_in);
                    $end = $attendance->clock_out instanceof Carbon
                        ? $attendance->clock_out
                        : Carbon::parse($attendance->clock_out);

                    if ($end->greaterThan($start)) {
                        $attendance->hours_logged = round($start->floatDiffInHours($end), 2);
                    }
                } catch (\Throwable $e) {
                    // ignore parse errors; controller validation should guard this
                }
            }
        });

        // After save/delete, refresh the volunteer's aggregated total_hours
        $recomputeVolunteerHours = function (VolunteerAttendance $attendance) {
            if ($attendance->relationLoaded('volunteer')) {
                $attendance->volunteer?->updateTotalHours();
            } else {
                $attendance->volunteer()->first()?->updateTotalHours();
            }
        };

        static::saved($recomputeVolunteerHours);
        static::deleted($recomputeVolunteerHours);
    }

    public function volunteer()
    {
        return $this->belongsTo(Volunteer::class, 'volunteer_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
