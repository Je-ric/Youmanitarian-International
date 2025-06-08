<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\ProgramTask;
use Illuminate\Http\Request;
use App\Models\TaskAssignment;
use Illuminate\Support\Facades\Auth;

class ProgramTasksController extends Controller
{
    // Store a new task under the program
    public function store(Request $request, Program $program)
    {
        $request->validate([
            'task_description' => 'required|string|max:1000',
        ]);

        $program->tasks()->create([
            'task_description' => $request->task_description,
            'status' => 'pending', // default status
        ]);

        return redirect()->back()->with('success', 'Task added successfully.');
    }

    // Delete a task from the program
    public function destroy(Program $program, ProgramTask $task)
    {
        if ($task->program_id !== $program->id) {
            abort(403);
        }

        $task->delete();

        return redirect()->back()->with('success', 'Task deleted successfully.');
    }

    // Update a task's description or status
    public function update(Request $request, Program $program, ProgramTask $task)
    {
        if ($task->program_id !== $program->id) {
            abort(403);
        }

        $request->validate([
            'task_description' => 'sometimes|string|max:1000',
            'status' => 'sometimes|in:pending,in_progress,completed',
        ]);

        $task->update($request->only('task_description', 'status'));

        return redirect()->back()->with('success', 'Task updated successfully.');
    }

    // Assign a volunteer to a task
    public function assignVolunteer(Request $request, Program $program, ProgramTask $task)
    {
        if ($task->program_id !== $program->id) {
            abort(403);
        }

        $request->validate([
            'volunteer_id' => 'required|exists:volunteers,id',
        ]);

        // Prevent duplicate assignment
        $existing = TaskAssignment::where('task_id', $task->id)
            ->where('volunteer_id', $request->volunteer_id)
            ->first();

        if ($existing) {
            return redirect()->back()->with('success', 'Volunteer already assigned to this task.');
        }

        TaskAssignment::create([
            'task_id' => $task->id,
            'volunteer_id' => $request->volunteer_id,
            'assigned_by' => optional(Auth::user())->id,
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success', 'Volunteer assigned to task.');
    }
}
