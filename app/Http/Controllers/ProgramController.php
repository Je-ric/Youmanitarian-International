<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;


class ProgramController extends Controller {
    use AuthorizesRequests;
    
    public function index() {
        // $programs = Program::sortable()->orderBy('created_at', 'desc')->paginate(10);
        // $programs = Program::sortable(['title' => 'desc'])->paginate(10); 
        $programs = Program::sortable([
            'title' => 'asc',
            'start_date' => 'desc'
        ])->paginate(10);
                
        return view('programs.index', compact('programs'));
    }

    public function showDetailsModal(Program $program)
    {
        return view('programs.show', compact('program'));
    }



    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    

    public function create() {
        return view('programs.create');
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    

    public function edit(Program $program) {
        return view('programs.edit', compact('program'));
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
            'volunteer_count' => 'nullable|integer|min:0',
            
        ]);

        // $currentDateTime = now();
        // $startDateTime = $request->start_date . ' ' . $request->start_time;
        // $endDateTime = $request->end_date ? $request->end_date . ' ' . $request->end_time : null;

        // if (Carbon::parse($startDateTime)->isFuture()) {
        //     $progress = 'incoming'; 
        // } elseif ($currentDateTime->between(Carbon::parse($startDateTime), Carbon::parse($endDateTime))) {
        //     $progress = 'ongoing';
        // } else {
        //     $progress = 'done'; 
        // }

        // if ($totalHours === 0) {
        //     $volunteer->progress = 'not_started';
        // } elseif ($lastAttendance && is_null($lastAttendance->time_out)) {
        //     $volunteer->progress = 'in_progress';
        // } else {
        //     $volunteer->progress = 'completed';
        // }

    
        Program::create([
            'title' => $request->title,
            'description' => $request->description,
            'date' => $request->date,
            'start_time' => $request->start_time, 
            'end_time' => $request->end_time, 
            'location' => $request->location,
            'created_by' => Auth::id(),
            // 'progress' => $progress,
            'volunteer_count' => $request->volunteer_count ?? 0,
        ]);
    
        return redirect()->route('programs.index')->with('success', 'Program created successfully.');
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    
    public function update(Request $request, Program $program) {
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'nullable|string|max:255',
        ]);
    
        $program->update($request->all());
    
        return redirect()->route('programs.index')->with('success', 'Program updated successfully.');
    }


    // ═══════════════════════════════════════════════════════════════════════════════
    // 🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨🌟✨
    // ═══════════════════════════════════════════════════════════════════════════════

    

    public function destroy(Program $program) {
        $program->delete();
    
        return redirect()->route('programs.index')->with('success', 'Program deleted.');
    }
    
}
