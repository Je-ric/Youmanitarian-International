<?php

namespace App\Http\Controllers;

use App\Models\ConsultationHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationHourController extends Controller
{
    public function index(Request $request)
    {
        $consultationHours = ConsultationHour::where('user_id', Auth::id())->get();
        $editingHour = null;

        if ($request->has('edit')) {
            $editingHour = ConsultationHour::findOrFail($request->input('edit'));
        }

        return view('consultation.consultationHours',
            compact('consultationHours', 'editingHour'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['user_id'] = Auth::id() ?? $request->input('user_id');

        ConsultationHour::create($data);

        return redirect()
            ->route('consultation-hours.index')
            ->with('toast', [
                'message' => 'Consultation hour created.',
                'type' => 'success'
            ]);
    }

    public function update(Request $request, ConsultationHour $consultationHour)
    {
        if ($request->user() && $consultationHour->user_id !== $request->user()->id) {
            abort(403);
        }

        $data = $this->validateData($request, updating: true);
        unset($data['user_id']);

        $consultationHour->update($data);

        return redirect()
            ->route('consultation-hours.index')
            ->with('toast', [
                'message' => 'Consultation hour updated.',
                'type' => 'success'
            ]);
    }

    public function destroy(Request $request, ConsultationHour $consultationHour)
    {
        if ($request->user() && $consultationHour->user_id !== $request->user()->id) {
            abort(403);
        }

        $consultationHour->delete();

        return redirect()
            ->route('consultation-hours.index')
            ->with('toast', [
                'message' => 'Consultation hour deleted.',
                'type' => 'success'
            ]);
    }

    private function validateData(Request $request, bool $updating = false): array
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

        return $request->validate([
            'specialization' => ['required', 'string', 'max:255'],
            'day'            => ['required', 'in:' . implode(',', $days)],
            'start_time'     => ['required', 'date_format:H:i'],
            'end_time'       => ['required', 'date_format:H:i', 'after:start_time'],
            'status'         => ['required', 'in:active,inactive'],
            'user_id'        => $updating ? ['sometimes'] : ['sometimes', 'exists:users,id'],
        ]);
    }
}
