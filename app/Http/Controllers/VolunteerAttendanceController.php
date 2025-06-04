<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Program;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use App\Models\VolunteerAttendance;
use Illuminate\Support\Facades\Auth;

class VolunteerAttendanceController extends Controller
{
    public function show(Program $program)
    {
        $user = Auth::user();

        $isAssigned = $program->volunteers()->where('user_id', $user->id)->exists();

        $attendance = VolunteerAttendance::where('volunteer_id', $user->volunteer->id ?? null)
            ->where('program_id', $program->id)
            ->latest()
            ->first();

        if ($attendance && $attendance->clock_in && $attendance->clock_out) {
            $clock_in = Carbon::parse($attendance->clock_in);
            $clock_out = Carbon::parse($attendance->clock_out);

            $diffInSeconds = $clock_in->diffInSeconds($clock_out);

            $hours = floor($diffInSeconds / 3600);
            $minutes = floor(($diffInSeconds % 3600) / 60);
            $seconds = $diffInSeconds % 60;

            $formattedTime = sprintf('%02d:%02d:%02d', $hours, $minutes, $seconds);

            $attendance->formatted_time = $formattedTime; // Save formatted time
        }

        return view('programs.view-program', compact('program', 'attendance', 'isAssigned'));
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
            return redirect()->back()->with('error', 'You are already clocked in.');
        }

        VolunteerAttendance::create([
            'volunteer_id' => $user->volunteer->id,
            'program_id' => $program->id,
            'clock_in' => now(),
        ]);

        return redirect()->back()->with('success', 'Clocked in successfully.');
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════



    public function clockOut(Program $program)
    {
        $user = Auth::user();

        $attendance = VolunteerAttendance::where('volunteer_id', $user->volunteer->id)
            ->where('program_id', $program->id)
            ->whereNull('clock_out')
            ->latest()
            ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'You need to clock in first.');
        }

        // Set the clock-out time and calculate total time using Carbon
        $clock_in = Carbon::parse($attendance->clock_in);
        $clock_out = Carbon::now();

        $total_seconds = $clock_in->diffInSeconds($clock_out);

        // Calculate 
        $hours = floor($total_seconds / 3600);
        $minutes = floor(($total_seconds % 3600) / 60);
        $seconds = $total_seconds % 60;

        // Store 
        $attendance->update([
            'clock_out' => $clock_out,
            'hours_logged' => $total_seconds / 3600, // decimal
            'formatted_time' => sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds),
        ]);

        return redirect()->back()->with('success', 'Clocked out successfully.');
    }

    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    //Volunteer uploads proof of attendance
    public function uploadProof(Request $request, $programId)
    {
        $user = Auth::user();
        $volunteer = $user->volunteer;

        $request->validate([
            'proof_image' => 'required|image|max:10240', // max 10mb
        ]);

        // Find attendance record for volunteer & program
        $attendance = VolunteerAttendance::where('volunteer_id', $volunteer->id)
            ->where('program_id', $programId)
            ->first();

        if (!$attendance) {
            return redirect()->back()->with('error', 'Attendance record not found.');
        }

        $path = $request->file('proof_image')->store('uploads/attendance_proof', 'public');

        $attendance->proof_image = $path;
        $attendance->approval_status = 'pending';
        $attendance->save();

        return redirect()->back()->with('success', 'Proof of attendance uploaded successfully.');
    }

  public function programVolunteers(Program $program)
    {
        // Get volunteers with attendance logs grouped by volunteer
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
        $attendance->approved_by = auth()->id();
        $attendance->notes = $request->input('notes', $attendance->notes);
        $attendance->save();

        return back()->with('toast', ['message' => 'Attendance approved!', 'type' => 'success']);
    }

    // Reject attendance
    public function rejectAttendance(Request $request, $attendanceId)
    {
        $attendance = VolunteerAttendance::findOrFail($attendanceId);
        $attendance->approval_status = 'rejected';
        $attendance->approved_by = auth()->id();
        $attendance->notes = $request->input('notes', $attendance->notes);
        $attendance->save();

        return back()->with('toast', ['message' => 'Attendance rejected!', 'type' => 'error']);
    }
}
