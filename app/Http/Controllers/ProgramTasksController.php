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
        // check if the task belongs to the correct program
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
        // check if the task belongs to the correct program
        if ($task->program_id !== $program->id) {
            abort(403);
        }

        $request->validate([
            'task_description' => 'sometimes|string|max:1000',
            'status' => 'sometimes|in:pending,in_progress,completed',
        ]);

        // For reference:
        // program_tasks table (nandito yung program id, task id, description and status)
        // tasks_assignments table (nandito yung task id, volunteer id and status)

        // if program_tasks status is being updated, update BOTH task and assignments
        if ($request->has('status')) {
            $task->update(['status' => $request->status]);
            
            // update all task_assignments 
            $task->assignments()->update(['status' => $request->status]);
        } else {
            // if not, update only the task description
            $task->update($request->only('task_description'));
        }

        // Example: task1 = jeric (pending), jozen (in_progress), melgie (pending)
        // if task1 ay tapos na, kapag pinalitan yung program tasks (tasks1) status to completed,
        // then all task_assignments (volunteer task status) will be updated to completed
        // Output: tasks1 = jeric (completed), jozen (completed), melgie (completed)

        return redirect()->back()->with('toast', [
            'message' => 'Task updated successfully.',
            'type' => 'success'
        ]);
    }

    // Update individual assignment status
    public function updateAssignmentStatus(Request $request, Program $program, ProgramTask $task, TaskAssignment $assignment)
    {
        // check if the assignment belongs to the correct task and program
        if ($task->program_id !== $program->id || $assignment->task_id !== $task->id) {
            abort(403);
        }

        $request->validate([
            'status' => 'required|in:pending,in_progress,completed',
        ]);

        // Volunteer: Pending, In Progress (bawal complete)
        // Coordinator: Pending, In Progress and siya lang ang pwedeng mag set na complete
    
        // this is individual tasks_assignment status, not the program_tasks status
        // kaya kung sino lang nagpalit or pinalitan yung assignment status, yung specific volunteer lang na yon affected

        $assignment->update(['status' => $request->status]); 

        // update main task status based on assignment statuses
        // sa function ko nalang i-explain, basta checker
        $this->updateMainTaskStatus($task); 
        
        // Example: task1 = jeric (pending), jozen (in_progress), melgie (in_progress)
        // if si melgie ay tapos na, at pinalitan yung status to completed, siya lang mababago ang status, hindi yung iba
        // Output: tasks1 = jeric (pending), jozen (in_progress), melgie (completed)

        return redirect()->back()->with('toast', [
            'message' => 'Assignment status updated successfully.',
            'type' => 'success'
        ]);
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

        // check if the volunteer is already assigned to the task (using tasks id and volunteer id)
        $existing = TaskAssignment::where('task_id', $task->id)
            ->where('volunteer_id', $request->volunteer_id)
            ->first();
        
        // get(): SELECT * FROM task_assignments WHERE... and returns ALL matching records
        // first(): SELECT * FROM task_assignments WHERE... LIMIT 1 and returns only ONE record

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

        // find() returns a single Volunteer model or null if not found
        // it searches pk (id)
        $volunteer = Volunteer::find($request->volunteer_id);

        // Send notification sa volunteer na nilagyan ng task \Notifications\TaskAssigned.php
        // check if volunteer record exists and has user record
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
        // check if the assignment belongs to the correct task and program
        if ($task->program_id !== $program->id || $assignment->task_id !== $task->id) {
            abort(403);
        }

        $assignment->delete();

        // update main task status after removing assignment
        $this->updateMainTaskStatus($task);

        return redirect()->back()->with('toast', [
            'message' => 'Volunteer removed from task successfully.',
            'type' => 'success'
        ]);
    }

    // Helper method to remove and update main task status based on assignment statuses
    private function updateMainTaskStatus(ProgramTask $task)
    {
        // gets all volunteer assignments for specific task
        // fn($assignment) is a callback function that will be called for each assignment
        $assignments = $task->assignments;
        
        // if no assignments, return
        if ($assignments->isEmpty()) {
            return;
        }
        
        // Remember, sa first line, were fetching all volunteer assignments for specific task
        // Also remember na may dalawa tayong table, program_tasks and tasks_assignments
        // program_tasks is the main task, and tasks_assignments is the volunteer task
        // chinecheck dito yung assignment status, bago ma-update yung program_tasks status
        // MAGULO? HINDI MALINAW? EXAMPLE? Exampleeee.

        // Example:
        // Task: "Batukan si ______" → status: "in_progress" 
        // - Jeric: pending
        // - Jozen: in_progress
        // - Melgie: completed

        // Task: "Batukan si ______" → status: "pending" 
        // - Jeric: pending
        // - Jozen: pending
        // - Melgie: pending

        // Task: "Batukan si ______" → status: "completed" 
        // - Jeric: completed
        // - Jozen: completed
        // - Melgie: completed

        // If EVERYONE (ALL) is done -> Task is completed
        if ($assignments->every(fn($assignment) => $assignment->status === 'completed')) {
            $task->update(['status' => 'completed']);
        }
        // If ANYONE (>0) is working (in_progress) -> Task is in progress
        elseif ($assignments->contains(fn($assignment) => $assignment->status === 'in_progress')) {
            $task->update(['status' => 'in_progress']);
        }
        // If NO ONE is working (0) -> Task is pending
        else {
            $task->update(['status' => 'pending']);
        }
    }
}
