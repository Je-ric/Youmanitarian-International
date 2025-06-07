<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\ProgramTask;
use Illuminate\Http\Request;

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
}
