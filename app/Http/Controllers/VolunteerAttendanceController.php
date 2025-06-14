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
use App\Http\Controllers\ProgramTasksController;

class VolunteerAttendanceController extends Controller
{
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

        // Get volunteer's tasks directly
        $volunteerTasks = $program->tasks()
            ->whereHas('assignments', function($query) use ($user) {
                $query->where('volunteer_id', $user->volunteer->id ?? null);
            })
            ->with(['assignments' => function($query) use ($user) {
                $query->where('volunteer_id', $user->volunteer->id ?? null);
            }])
            ->get();

        // Prepare task data for view
        $taskData = $volunteerTasks->map(function($task) {
            return [
                'task' => $task,
                'assignment' => $task->assignments->first()
            ];
        });

        return view('programs.attendance', compact(
            'program',
            'attendance',
            'isAssigned',
            'clockInTime',
            'clockOutTime',
            'formattedWorkedTime',
            'status',
            'canClockIn',
            'canClockOut',
            'volunteerTasks',
            'taskData'
        ));
    }

    public function clockInOut(Program $program)
    {
        $user = Auth::user();

        // Check for existing active attendance
        $attendance = VolunteerAttendance::where('volunteer_id', $user->volunteer->id)
            ->where('program_id', $program->id)
            ->whereNull('clock_out')
            ->latest()
            ->first();

        if (!$attendance) {
            // No active attendance - perform clock in
            VolunteerAttendance::create([
                'volunteer_id' => $user->volunteer->id,
                'program_id' => $program->id,
                'clock_in' => now(),
            ]);

            return redirect()->back()->with('toast', [
                'message' => 'Clocked in successfully.',
                'type' => 'success',
            ]);
        } else {
            // Active attendance exists - perform clock out
            $clock_in = \Carbon\Carbon::parse($attendance->clock_in);
            $clock_out = \Carbon\Carbon::now();

            // Calculate hours_logged as decimal hours
            $attendance->clock_out = $clock_out;
            $attendance->hours_logged = round($clock_in->floatDiffInHours($clock_out), 2);
            $attendance->save();

            return redirect()->back()->with('toast', [
                'message' => 'Clocked out successfully.',
                'type' => 'success',
            ]);
        }
    }

    public function uploadProof(Request $request, $programId)
    {
        $volunteerId = Auth::user()?->volunteer?->id;

        if (!$volunteerId) {
            return back()->with('toast', ['message' => 'You must be logged in as a volunteer.', 'type' => 'error']);
        }

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

        $file = $request->file('proof_image');
        $filename = $programName . '_' . $volunteerName . '_' . time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('uploads/attendance_proof', $filename, 'public');

        $attendance->proof_image = $path;
        $attendance->save();

        return back()->with('toast', ['message' => 'Proof of attendance uploaded successfully!', 'type' => 'success']);
    }

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

    public function updateAttendanceStatus(Request $request, $attendanceId)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'notes' => 'nullable|string|max:1000'
        ]);

        $attendance = VolunteerAttendance::findOrFail($attendanceId);
        $attendance->approval_status = $request->status;
        $attendance->approved_by = Auth::user()->volunteer?->id;
        $attendance->notes = $request->input('notes', $attendance->notes);
        $attendance->save();

        return back()->with('toast', [
            'message' => 'Attendance ' . ucfirst($request->status) . ' successfully!',
            'type' => $request->status === 'approved' ? 'success' : 'error'
        ]);
    }

    public function showManualEntryForm(Request $request, Program $program)
    {
        $volunteers = $program->volunteers()->with('user')->get();
        $selectedVolunteerId = $request->query('volunteer_id');
        return view('programs-volunteers.modals.manualAttendanceModal', compact('program', 'volunteers', 'selectedVolunteerId'));
    }

    public function manualEntry(Request $request, Program $program)
    {
        $request->validate([
            'volunteer_id' => 'required|exists:volunteers,id',
            'date' => 'required|date',
            'clock_in' => 'required',
            'clock_out' => 'nullable',
            'notes' => 'required|string|max:1000',
        ]);

        $clockIn = $request->date . ' ' . $request->clock_in;
        $clockOut = $request->clock_out ? $request->date . ' ' . $request->clock_out : null;

        $attendance = \App\Models\VolunteerAttendance::firstOrNew([
            'program_id' => $program->id,
            'volunteer_id' => $request->volunteer_id,
        ]);

        $attendance->clock_in = $clockIn;
        $attendance->clock_out = $clockOut;
        $attendance->notes = $request->notes;

        // Calculate hours_logged
        if ($attendance->clock_in && $attendance->clock_out) {
            $in = \Carbon\Carbon::parse($attendance->clock_in);
            $out = \Carbon\Carbon::parse($attendance->clock_out);
            $attendance->hours_logged = round($in->floatDiffInHours($out), 2);
        } else {
            $attendance->hours_logged = 0;
        }

        $attendance->save();

        return redirect()->back()->with('toast', [
            'message' => 'Attendance record updated successfully!',
            'type' => 'success',
        ]);
    }
}
