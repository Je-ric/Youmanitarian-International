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
use Illuminate\Validation\ValidationException;

class VolunteerAttendanceController extends Controller
{
    // programs/attendance.blade.php
    public function show(Program $program)
    {
        $user = Auth::user();
        $now = now()->setTimezone('Asia/Manila');

        // validator kung yung user has joined the program
        $isJoined = $program->volunteers()->where('user_id', $user->id)->exists();

        // get the latest attendance record for clock in/out status
        $latestAttendance = VolunteerAttendance::where('volunteer_id', $user->volunteer->id ?? null)
            ->where('program_id', $program->id)
            ->latest()
            ->first();

        // get any attendance record for proof display
        $anyAttendance = VolunteerAttendance::where('program_id', $program->id)
            ->where('volunteer_id', $user->volunteer?->id)
            ->first();

        // If the attendance record exists and has a clock-in/clock-out time, convert it to a Carbon date in Manila timezone
        $clockInTime = $latestAttendance?->clock_in ? 
            Carbon::parse($latestAttendance->clock_in)->setTimezone('Asia/Manila') : null;
        $clockOutTime = $latestAttendance?->clock_out ? 
            Carbon::parse($latestAttendance->clock_out)->setTimezone('Asia/Manila') : null;

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
        $canClockIn = $program->progress_status === 'ongoing' && $isJoined && !$latestAttendance?->clock_in;
        $canClockOut = $program->progress_status === 'ongoing' && $isJoined && $latestAttendance?->clock_in && !$latestAttendance?->clock_out;

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
        // para mas madaling idisplay sa blade
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
            'latestAttendance',
            'isJoined',
            'clockInTime',
            'clockOutTime',
            'formattedWorkedTime',
            'status',
            'canClockIn',
            'canClockOut',
            'volunteerTasks',
            'taskData',
            'anyAttendance',
            'userFeedback'
        ));
    }

    // programs/attendance.blade.php
    public function clockInOut(Program $program)
    {
        $user = Auth::user();

        // hinahanap yung mga recent or latest attendance na may clock in pero walang clock out
        $attendance = VolunteerAttendance::where('volunteer_id', $user->volunteer->id)
            ->where('program_id', $program->id)
            ->whereNull('clock_out') // Only records without clock_out (still clocked in)
            ->latest() // Get the most recent record
            ->first();

        if (!$attendance) {
            // Not clocked in yet: create a new attendance record and clock in
            VolunteerAttendance::create([
                'volunteer_id' => $user->volunteer->id,
                'program_id' => $program->id,
                'clock_in' => now(), // start time
            ]);

            return redirect()->back()->with('toast', [
                'message' => 'Clocked in successfully.',
                'type' => 'success',
            ]);
        } else {
            // Already clocked in: set clock out time and calculate hours worked
            $clock_in = Carbon::parse($attendance->clock_in); // Convert to Carbon object
            $clock_out = Carbon::now(); // end time

            // Update the attendance record with clock out time
            // as we can see, naka set lang naman sa clock_out since yun lang ilalagay, similar sa hours_logged
            $attendance->clock_out = $clock_out;
            // Calculate (rounded to 2 decimal)
            $attendance->hours_logged = round($clock_in->floatDiffInHours($clock_out), 2);
            $attendance->save();

            // Update volunteer's total hours across all programs
            $volunteer = $attendance->volunteer;
            $volunteer->updateTotalHours(); // check model

            return redirect()->back()->with('toast', [
                'message' => 'Clocked out successfully.',
                'type' => 'success',
            ]);
        }
    }

    // programs/attendance.blade.php
    public function uploadProof(Request $request, $programId)
    {
        // get the current logged in volunteer id
        $volunteerId = Auth::user()?->volunteer?->id;

        if (!$volunteerId) {
            return back()->with(
                'toast',
                [
                    'message' => 'You must be logged in as a volunteer to upload proof.',
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
        // set an array to store yung attendance logs for each volunteer
        $logs = [];

        // loop through each volunteer in this program
        // Para makita yung attendance records at total hours ng bawat volunteer sa program na ito
        foreach ($program->volunteers as $volunteer) {
            // get all attendance records for this volunteer in this program
            $volunteerLogs = VolunteerAttendance::where('program_id', $program->id)
                ->where('volunteer_id', $volunteer->id)
                ->get();

            // calculate total hours worked by this volunteer
            $totalTime = 0;
            foreach ($volunteerLogs as $log) {
                $totalTime += $log->hours_logged; // Add each attendance record's hours
            }

            // store volunteer's logs and total time in the array
            // key is volunteer id, at yung value ay logs and total time
            $logs[$volunteer->id] = [
                'logs' => $volunteerLogs, // all attendance records
                'totalTime' => $totalTime . ' hours', // total hours as string (concat)
            ];
        }

        return view('volunteers.program-volunteers', 
        compact('program', 
        'logs'));
    }

    // volunteers/program-volunteers.blade.php
    public function updateAttendanceStatus(Request $request, $attendanceId)
    {
        $request->validate([
            'status' => 'required|in:approved,rejected',
            'notes' => 'nullable|string|max:1000'
        ]);

        $attendance = VolunteerAttendance::findOrFail($attendanceId);
        $program = $attendance->program;

        // Only the program coordinator can approve/reject
        if (Auth::id() !== $program->created_by) {
            abort(403, 'You are not authorized to approve/reject attendance for this program.');
        }

        $attendance->approval_status = $request->status;
        $attendance->approved_by = $program->created_by; // always set the coordinator
        $attendance->notes = $request->input('notes', $attendance->notes);
        $attendance->save();

        // Update volunteer's total hours when attendance status changes
        $volunteer = $attendance->volunteer;
        $volunteer->updateTotalHours();

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
        return view('programs-volunteers.modals.manualAttendanceModal', 
        compact('program', 
        'volunteers', 
        'selectedVolunteerId'));
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


        // ---------------------------------------------------------------
        // Get program start and end times
        $date = Carbon::parse($program->date)->format('Y-m-d');
        $programStart = Carbon::parse($date . ' ' . $program->start_time);
        $programEnd = Carbon::parse($date . ' ' . $program->end_time);
        // Parse
        $clockIn = $request->clock_in ? Carbon::parse($request->date . ' ' . $request->clock_in) : null;
        $clockOut = $request->clock_out ? Carbon::parse($request->date . ' ' . $request->clock_out) : null;

        // Validate clock_in is not before program start
        if ($clockIn && $clockIn->lt($programStart)) {
            throw ValidationException::withMessages([
                'clock_in' => 'Time in cannot be before the program start time (' . $programStart->format('H:i') . ').'
            ]);
        }

        // Validate clock_out is not before clock_in
        if ($clockIn && $clockOut && $clockOut->lt($clockIn)) {
            throw ValidationException::withMessages([
                'clock_out' => 'Time out cannot be before time in.'
            ]);
        }
        // ---------------------------------------------------------------

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

        // Update volunteer's total hours
        $volunteer = $attendance->volunteer;
        $volunteer->updateTotalHours();

        return redirect()->back()->with('toast', [
            'message' => 'Attendance record updated successfully!',
            'type' => 'success',
        ]);
    }
}
