<?php

namespace App\Http\Controllers;

use App\Models\ProgramRequest;
use Illuminate\Http\Request;

class ProgramRequestsController extends Controller
{
    public function index()
    {
        $requests = ProgramRequest::latest()->paginate(perPage: 12);
        return view('program_requests.index', compact('requests'));
    }

    public function create()
    {
        return view('program_requests.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'target_audience' => 'required|string|max:255',
            'location'        => 'required|string|max:255',
            'proposed_date'   => 'nullable|date',
        ]);

        ProgramRequest::create($validated);

        return redirect()
            ->route('website.programs')   // changed from website.program
            ->with('toast', [
                'message' => 'Program request submitted.',
                'type'    => 'success'
            ]);
    }

    // public function show(ProgramRequest $programRequest)
    // {
    //     return view('program_requests.show', compact('programRequest'));
    // }

    // public function edit(ProgramRequest $programRequest)
    // {
    //     return view('program_requests.edit', compact('programRequest'));
    // }

    // public function update(Request $request, ProgramRequest $programRequest)
    // {
    //     $validated = $request->validate([
    //         'name'            => 'required|string|max:255',
    //         'title'           => 'required|string|max:255',
    //         'description'     => 'required|string',
    //         'target_audience' => 'required|string|max:255',
    //         'location'        => 'required|string|max:255',
    //         'proposed_date'   => 'nullable|date',
    //     ]);

    //     $programRequest->update($validated);

    //     return redirect()->route('program_requests.index')->with('success', 'Program request updated.');
    // }

    public function destroy(ProgramRequest $programRequest)
    {
        $programRequest->delete();

        return redirect()
            ->route('program_requests.index')
            ->with('toast', [
                'message' => 'Program request deleted.',
                'type'    => 'success'
            ]);
    }
}
