<?php

namespace App\Http\Controllers;

// use Mail;
use Illuminate\Http\Request;
use App\Models\ProgramRequest;
use App\Mail\ProgramRequestApproved;
use App\Mail\ProgramRequestReceived;
use Illuminate\Support\Facades\Mail;

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
            'email'          => 'nullable|email|max:255',
            'contact_number' => 'nullable|string|max:255',
            'description'     => 'required|string',
            'target_audience' => 'required|string|max:255',
            'location'        => 'required|string|max:255',
            'proposed_date'   => 'nullable|date',
            // 'status'          => 'required|in:pending,approved,rejected',
        ]);

        $programRequest = ProgramRequest::create($validated);

        // Send thank you email if email is provided
        if ($programRequest->email) {
            Mail::to($programRequest->email)->send(
                new ProgramRequestReceived($programRequest)
            );
        }

        return redirect()
            ->route('website.programs')   // changed from website.program
            ->with('toast', [
                'message' => 'Program request submitted. Thank you for your submission!',
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

    public function update(Request $request, ProgramRequest $programRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $oldStatus = $programRequest->status;

        $programRequest->update($validated);

        // If status changed to approved and email exists, send email
        if ($validated['status'] === 'approved' && $oldStatus !== 'approved' && $programRequest->email) {
            Mail::to($programRequest->email)->send(
                new ProgramRequestApproved($programRequest)
            );
        }

        return redirect()->route('program_requests.index')
                        ->with('toast', [
                            'message' => 'Program request updated successfully.',
                            'type' => 'success'
                        ]);
    }

}
