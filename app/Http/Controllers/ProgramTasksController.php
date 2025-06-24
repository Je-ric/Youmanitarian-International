<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\ProgramTask;
use Illuminate\Http\Request;
use App\Models\TaskAssignment;
use App\Models\Volunteer;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TaskAssigned;

class ProgramTasksController extends Controller
{
    public function storeTask(Request $request, Program $program)
    {
        $request->validate([
            'task_description' => 'required|string|max:1000',
        ]);

        $program->tasks()->create([
            'task_description' => $request->task_description,
            'status' => 'pending', // default status
        ]);

        return redirect()->back()->with('toast', [
            'message' => 'Task added successfully.',
            'type' => 'success'
        ]);
    }

    public function deleteTask(Program $program, ProgramTask $task)
    {
        // Makes sure the task belongs to the correct program
        if ($task->program_id !== $program->id) {
            abort(403);
        }

        $task->delete();

        return redirect()->back()->with('toast', [
            'message' => 'Task deleted successfully.',
            'type' => 'success'
        ]);
    }

    public function updateTask(Request $request, Program $program, ProgramTask $task)
    {
        // Makes sure the task belongs to the correct program
        if ($task->program_id !== $program->id) {
            abort(403);
        }

        $request->validate([
            'task_description' => 'sometimes|string|max:1000',
            'status' => 'sometimes|in:pending,in_progress,completed',
        ]);

        // If status is being updated, update both task and assignments
        if ($request->has('status')) {
            $task->update(['status' => $request->status]);
            
            // Update all task_assignments
            $task->assignments()->update(['status' => $request->status]);
        } else {
            $task->update($request->only('task_description'));
        }

        return redirect()->back()->with('toast', [
            'message' => 'Task updated successfully.',
            'type' => 'success'
        ]);
    }

    // Update individual assignment status
    public function updateAssignmentStatus(Request $request, Program $program, ProgramTask $task, TaskAssignment $assignment)
    {
        // Makes sure the assignment belongs to the correct task and program
        if ($task->program_id !== $program->id || $assignment->task_id !== $task->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        // update based sa selection ni volunteer and ni coordinator
        // Volunteer: Pending, In Progress
        // Coordinator: Pending, In Progress but Siya lang ang pwedeng mag set na complete
        $assignment->update(['status' => $request->status]);

        // Update main task status based on assignment statuses
        $this->updateMainTaskStatus($task);

        return redirect()->back()->with('toast', [
            'message' => 'Assignment status updated successfully.',
            'type' => 'success'
        ]);
    }

    // Helper method to remove and update main task status based on assignment statuses
    private function updateMainTaskStatus(ProgramTask $task)
    {
        // Gets all volunteer assignments for specific task
        // fn($assignment)
        $assignments = $task->assignments;
        
        if ($assignments->isEmpty()) {
            return;
        }
        
        // If EVERYONE is done -> Task is completed
        if ($assignments->every(fn($assignment) => $assignment->status === 'completed')) {
            $task->update(['status' => 'completed']);
        }
        // If ANYONE is working (in_progress) -> Task is in progress
        elseif ($assignments->contains(fn($assignment) => $assignment->status === 'in_progress')) {
            $task->update(['status' => 'in_progress']);
        }
        // If NO ONE is working -> Task is pending
        else {
            $task->update(['status' => 'pending']);
        }
    }

    public function assignVolunteerToTask(Request $request, Program $program, ProgramTask $task)
    {
        // Makes sure the task belongs to the correct program
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
            return redirect()->back()->with('toast', [
                'message' => 'Volunteer already assigned to this task.',
                'type' => 'info'
            ]);
        }

        TaskAssignment::create([
            'task_id' => $task->id,
            'volunteer_id' => $request->volunteer_id,
            'assigned_by' => optional(Auth::user())->id,
            'status' => 'pending',
        ]);

        // Send notification sa volunteer na nilagyan ng task \Notifications\TaskAssigned.php
        $volunteer = Volunteer::find($request->volunteer_id);
        if ($volunteer && $volunteer->user) {
            $volunteer->user->notify(new TaskAssigned($task, $program));
        }

        return redirect()->back()->with('toast', [
            'message' => 'Volunteer assigned to task.',
            'type' => 'success'
        ]);
    }

    // Remove a volunteer from a task
    public function removeVolunteerFromTask(Program $program, ProgramTask $task, TaskAssignment $assignment)
    {
        // Makes sure the assignment belongs to the correct task and program
        if ($task->program_id !== $program->id || $assignment->task_id !== $task->id) {
            abort(403);
        }

        $assignment->delete();

        // Update main task status after removing assignment
        $this->updateMainTaskStatus($task);

        return redirect()->back()->with('toast', [
            'message' => 'Volunteer removed from task successfully.',
            'type' => 'success'
        ]);
    }
}
