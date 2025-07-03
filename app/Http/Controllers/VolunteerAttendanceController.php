<?php

namespace App\Http\Controllers;

use Carbon\Carbon; // It makes date/time work much easier and more readable
use App\Models\Program;
use App\Models\Volunteer;
use Illuminate\Http\Request;
use App\Models\VolunteerAttendance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\ProgramFeedback;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\ProgramTasksController;
use App\Notifications\AttendanceStatusUpdated;

class VolunteerAttendanceController extends Controller
{
    // programs/attendance.blade.php
    public function show(Program $program)
    {
        $user = Auth::user();
        $now = now()->setTimezone('Asia/Manila');

        // Check if the user has joined the program
        $isJoined = $program->volunteers()->where('user_id', $user->id)->exists();

        // Get the user's attendance record for this program
        $attendance = VolunteerAttendance::where('volunteer_id', $user->volunteer->id ?? null)
            ->where('program_id', $program->id)
            ->latest()
            ->first();


        $volunteerAttendance = VolunteerAttendance::where('program_id', $program->id)
            ->where('volunteer_id', $user->volunteer?->id)
            ->first();

        // If the attendance record exists and has a clock-in/clock-out time, convert it to a Carbon date in Manila timezone
        $clockInTime = $attendance?->clock_in ? Carbon::parse($attendance->clock_in)->setTimezone('Asia/Manila') : null;
        $clockOutTime = $attendance?->clock_out ? Carbon::parse($attendance->clock_out)->setTimezone('Asia/Manila') : null;

        $formattedWorkedTime = null;
        if ($clockInTime && $clockOutTime) { //If both times ay meron na, calculates the total difference (work hours)
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

        // canClockIn: ongoing, the user is joined, and hasn't clocked in yet
        // canClockOut: ongoing, the user is joined, has clocked in, but hasn't clocked out yet
        $canClockIn = $program->progress_status === 'ongoing' && $isJoined && !$attendance?->clock_in;
        $canClockOut = $program->progress_status === 'ongoing' && $isJoined && $attendance?->clock_in && !$attendance?->clock_out;

        // Get volunteers tasks 
        $volunteerTasks = $program->tasks()
            ->whereHas('assignments', function ($query) use ($user) {
                $query->where('volunteer_id', $user->volunteer->id ?? null);
            })
            ->with(['assignments' => function ($query) use ($user) {
                $query->where('volunteer_id', $user->volunteer->id ?? null);
            }])
            ->get();

        // creates an array with the task and the volunteers assignment for that task
        //  para mas madaling idisplay sa blade
        $taskData = $volunteerTasks->map(function ($task) {
            return [
                'task' => $task,
                'assignment' => $task->assignments->first()
            ];
        });

        $userFeedback = ProgramFeedback::where('program_id', $program->id)
            ->where('volunteer_id', $user->volunteer?->id)
            ->first();

        return view('programs.attendance', compact(
            'program',
            'attendance',
            'isJoined',
            'clockInTime',
            'clockOutTime',
            'formattedWorkedTime',
            'status',
            'canClockIn',
            'canClockOut',
            'volunteerTasks',
            'taskData',
            'volunteerAttendance',
            'userFeedback'
        ));
    }

    // programs/attendance.blade.php
    public function clockInOut(Program $program)
    {
        $user = Auth::user();

        // Check if the volunteer is already clocked in for this program (no clock out yet)
        $attendance = VolunteerAttendance::where('volunteer_id', $user->volunteer->id)
            ->where('program_id', $program->id)
            ->whereNull('clock_out')
            ->latest()
            ->first();

        if (!$attendance) {
            // Not clocked in yet: create a new attendance record and clock in
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
            // Already clocked in: set clock out time and calculate hours worked
            $clock_in = Carbon::parse($attendance->clock_in);
            $clock_out = Carbon::now();

            $attendance->clock_out = $clock_out;
            $attendance->hours_logged = round($clock_in->floatDiffInHours($clock_out), 2);
            $attendance->save();

            return redirect()->back()->with('toast', [
                'message' => 'Clocked out successfully.',
                'type' => 'success',
            ]);
        }
    }

    // programs/attendance.blade.php
    public function uploadProof(Request $request, $programId)
    {
        // Get the current volunteer's ID
        $volunteerId = Auth::user()?->volunteer?->id;

        if (!$volunteerId) {
            return back()->with(
                'toast',
                [
                    'message' => 'You must be logged in as a volunteer.',
                    'type' => 'error'
                ]
            );
        }

        // must be an image, max 10MB
        $validator = Validator::make($request->all(), [
            'proof_image' => 'required|image|max:10048',
        ]);

        // If validation fails, show an error toast
        if ($validator->fails()) {
            return redirect()->back()->with('toast', [
                'message' => $validator->errors()->first('proof_image'),
                'type' => 'error',
            ]);
        }

        // Find the volunteers attendance record for the program
        $attendance = VolunteerAttendance::where('program_id', $programId)
            ->where('volunteer_id', $volunteerId)
            ->firstOrFail();

        // Filename: ProgramName_VolunteerName_timestamp.extension
        $program = Program::findOrFail($programId);
        $volunteer = Volunteer::findOrFail($volunteerId);
        
        // remove any characters that are not letters, numbers, or dashes
        $volunteerName = preg_replace('/[^A-Za-z0-9\-]/', '', $volunteer->user->name);
        $programName = preg_replace('/[^A-Za-z0-9\-]/', '', $program->title);

        $file = $request->file('proof_image');
        $timestamp = time();
        $extension = $file->getClientOriginalExtension();
        $newFilename = "{$programName}_{$volunteerName}_{$timestamp}.{$extension}";
        $storagePath = $file->storeAs('uploads/attendance_proof', $newFilename, 'public');
        $attendance->proof_image = $storagePath;
        $attendance->save();

        return back()->with('toast', ['message' => 'Proof of attendance uploaded successfully!', 'type' => 'success']);
    }

    // volunteers.program-volunteers.blade.php
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

    // volunteers/program-volunteers.blade.php
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

        // Send notification sa volunteer kung approved or reject yung attendance \Notifications\AttendanceStatusUpdated.php
        $volunteerUser = $attendance->volunteer->user;
        $program = $attendance->program;
        $volunteerUser->notify(new AttendanceStatusUpdated($request->status, $program, $request->notes));

        return back()->with('toast', [
            'message' => 'Attendance ' . ucfirst($request->status) . ' successfully!',
            'type' => $request->status === 'approved' ? 'success' : 'error'
        ]);
    }

    // programs-volunteers/modals/manualAttendanceModal.blade.php
    public function showManualEntryForm(Request $request, Program $program)
    {
        $volunteers = $program->volunteers()->with('user')->get();
        $selectedVolunteerId = $request->query('volunteer_id');
        return view('programs-volunteers.modals.manualAttendanceModal', compact('program', 'volunteers', 'selectedVolunteerId'));
    }

    // programs-volunteers/modals/manualAttendanceModal.blade.php
    public function manualEntry(Request $request, Program $program)
    {
        // Find an existing attendance record or create a new one
        $attendance = VolunteerAttendance::firstOrNew([
            'program_id' => $program->id,
            'volunteer_id' => $request->volunteer_id,
        ]);

        // Define base validation rules.
        $rules = [
            'volunteer_id' => 'required|exists:volunteers,id',
            'date' => 'required|date',
            'notes' => 'required|string|max:1000',
        ];

        // Make clock_in required only for new attendance records.
        if (!$attendance->clock_in) {
            $rules['clock_in'] = 'required';
        }
        $rules['clock_out'] = 'nullable'; // Clock_out is always optional.        
        $request->validate($rules);

        // Update clock_in only if meron na, to avoid overwriting existing data.
        if ($request->has('clock_in')) {
            $attendance->clock_in = $request->date . ' ' . $request->clock_in;
        }
        // Update clock_out only if a clock_out was provided.
        if ($request->filled('clock_out')) {
            $attendance->clock_out = $request->date . ' ' . $request->clock_out;
        }
        
        $attendance->notes = $request->notes;

        // Calculate total hours worked if both clock_in and clock_out are set.
        if ($attendance->clock_in && $attendance->clock_out) {
            $in = Carbon::parse($attendance->clock_in);
            $out = Carbon::parse($attendance->clock_out);
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
