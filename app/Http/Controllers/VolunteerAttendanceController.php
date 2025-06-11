<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Program;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use App\Models\VolunteerAttendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class VolunteerAttendanceController extends Controller
{
    // attendance.blade.php
    // public function show(Program $program)
    // {
    //     $user = Auth::user();

    //     $isAssigned = $program->volunteers()->where('user_id', $user->id)->exists();

    //     $attendance = VolunteerAttendance::where('volunteer_id', $user->volunteer->id ?? null)
    //         ->where('program_id', $program->id)
    //         ->latest()
    //         ->first();

    //     if ($attendance && $attendance->clock_in && $attendance->clock_out) {
    //         $clock_in = Carbon::parse($attendance->clock_in);
    //         $clock_out = Carbon::parse($attendance->clock_out);

    //         $diffInSeconds = $clock_in->diffInSeconds($clock_out);

    //         $hours = floor($diffInSeconds / 3600);
    //         $minutes = floor(($diffInSeconds % 3600) / 60);
    //         $seconds = $diffInSeconds % 60;

    //         $formattedTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

    //         $attendance->formatted_time = $formattedTime;
    //     }

    //     return view('programs.attendance', compact('program', 'attendance', 'isAssigned'));
    // }
    public function show(Program $program)
    {
        $user = Auth::user();
        $now = now()->setTimezone('Asia/Manila');

        $isAssigned = $program->volunteers()->where('user_id', $user->id)->exists();

        $attendance = VolunteerAttendance::where('volunteer_id', $user->volunteer->id ?? null)
            ->where('program_id', $program->id)
            ->latest()
            ->first();

        $clockInTime = $attendance?->clock_in ? Carbon::parse($attendance->clock_in)->setTimezone('Asia/Manila') : null;
        $clockOutTime = $attendance?->clock_out ? Carbon::parse($attendance->clock_out)->setTimezone('Asia/Manila') : null;

        $formattedWorkedTime = null;
        if ($clockInTime && $clockOutTime) {
            $diffInSeconds = $clockInTime->diffInSeconds($clockOutTime);
            $hours = floor($diffInSeconds / 3600);
            $minutes = floor(($diffInSeconds % 3600) / 60);
            $seconds = $diffInSeconds % 60;
            $formattedWorkedTime = sprintf('%02d hr %02d min %02d sec', $hours, $minutes, $seconds);
        }

        $status = match (true) {
            $program->date > $now => 'upcoming',
            $program->date < $now && $program->end_time < $now => 'done',
            default => 'ongoing'
        };

        $canClockIn = $status === 'ongoing' && $isAssigned && !$attendance?->clock_in;
        $canClockOut = $status === 'ongoing' && $isAssigned && $attendance?->clock_in && !$attendance?->clock_out;
        
        return view('programs.attendance', compact(
            'program',
            'attendance',
            'isAssigned',
            'clockInTime',
            'clockOutTime',
            'formattedWorkedTime',
            'status',
            'canClockIn',
            'canClockOut'
        ));
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════



    public function clockIn(Program $program)
    {
        $user = Auth::user();

        $existingClockIn = VolunteerAttendance::where('volunteer_id', $user->volunteer->id)
            ->where('program_id', $program->id)
            ->whereNull('clock_out')
            ->exists();

        if ($existingClockIn) {
            return redirect()->back()->with('toast', [
                'message' => 'You are already clocked in.',
                'type' => 'error',
            ]);
        }

        VolunteerAttendance::create([
            'volunteer_id' => $user->volunteer->id,
            'program_id' => $program->id,
            'clock_in' => now(),
        ]);

        return redirect()->back()->with('toast', [
            'message' => 'Clocked in successfully.',
            'type' => 'success',
        ]);
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════


    // attendance.blade.php 
    public function clockOut(Program $program)
    {
        $user = Auth::user();

        $attendance = VolunteerAttendance::where('volunteer_id', $user->volunteer->id)
            ->where('program_id', $program->id)
            ->whereNull('clock_out')
            ->latest()
            ->first();

        if (!$attendance) {
            return redirect()->back()->with('toast', [
                'message' => 'You need to clock in first.',
                'type' => 'error',
            ]);
        }

        $clock_in = Carbon::parse($attendance->clock_in);
        $clock_out = Carbon::now();

        $total_seconds = $clock_in->diffInSeconds($clock_out);

        $hours = floor($total_seconds / 3600);
        $minutes = floor(($total_seconds % 3600) / 60);
        $seconds = $total_seconds % 60;

        $attendance->update([
            'clock_out' => $clock_out,
            'hours_logged' => $total_seconds / 3600,
            'formatted_time' => sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds),
        ]);

        return redirect()->back()->with('toast', [
            'message' => 'Clocked out successfully.',
            'type' => 'success',
        ]);
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════


    // attendance.blade.php 
    public function uploadProof(Request $request, $programId)
    {
        $volunteerId = auth()->user()?->volunteer?->id;

        if (!$volunteerId) {
            return back()->with('toast', ['message' => 'You must be logged in as a volunteer.', 'type' => 'error']);
        }

        // $request->validate([
        //     'proof_image' => 'required|image|max:10048', // 10mb max
        // ]);

        $validator = Validator::make($request->all(), [
            'proof_image' => 'required|image|max:10048', // max 10MB
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with('toast', [
                'message' => $validator->errors()->first('proof_image'),
                'type' => 'error',
            ]);
        }

        $attendance = VolunteerAttendance::where('program_id', $programId)
            ->where('volunteer_id', $volunteerId)
            ->firstOrFail();

        // Filename: ProgramName-VolunteerName.extension
        $program = Program::findOrFail($programId);
        $volunteer = Volunteer::findOrFail($volunteerId);
        $volunteerName = preg_replace('/[^A-Za-z0-9\-]/', '', $volunteer->user->name);
        $programName = preg_replace('/[^A-Za-z0-9\-]/', '', $program->title);
        // If $programName or $volunteerName contains special characters or spaces, it can cause issues. Kaya sinanitize para maging alphanumeric. 
        
        $file = $request->file('proof_image');
        $filename = $programName . '_' . $volunteerName . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('uploads/attendance_proof', $filename, 'public');

        $attendance->proof_image = $path;
        $attendance->save();

        return back()->with('toast', ['message' => 'Proof of attendance uploaded successfully!', 'type' => 'success']);
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════


    public function programVolunteers(Program $program)
    {
        $logs = [];

        foreach ($program->volunteers as $volunteer) {
            $volunteerLogs = VolunteerAttendance::where('program_id', $program->id)
                ->where('volunteer_id', $volunteer->id)
                ->get();

            $totalTime = 0;
            foreach ($volunteerLogs as $log) {
                $totalTime += $log->hours_logged;
            }

            $logs[$volunteer->id] = [
                'logs' => $volunteerLogs,
                'totalTime' => $totalTime . ' hours',
            ];
        }

        return view('volunteers.program-volunteers', compact('program', 'logs'));
    }

    // Approve attendance
    public function approveAttendance(Request $request, $attendanceId)
    {
        $attendance = VolunteerAttendance::findOrFail($attendanceId);
        $attendance->approval_status = 'approved';
        // $attendance->approved_by = auth()->id();
        $user = Auth::user();
        $attendance->approved_by = $user->volunteer ? $user->volunteer->id : null;
        $attendance->notes = $request->input('notes', $attendance->notes);
        $attendance->save();

        return back()->with('toast', ['message' => 'Attendance approved!', 'type' => 'success']);
    }

    // Reject attendance
    public function rejectAttendance(Request $request, $attendanceId)
    {
        $attendance = VolunteerAttendance::findOrFail($attendanceId);
        $attendance->approval_status = 'rejected';
        // $attendance->approved_by = auth()->id();
        $user = Auth::user();
        $attendance->approved_by = $user->volunteer ? $user->volunteer->id : null;
        $attendance->notes = $request->input('notes', $attendance->notes);
        $attendance->save();

        return back()->with('toast', ['message' => 'Attendance rejected!', 'type' => 'error']);
    }
}
