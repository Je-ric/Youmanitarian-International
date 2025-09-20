<?php

namespace App\Http\Controllers;

use App\Models\ConsultationHour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultationHourController extends Controller
{
    // for all auth
    public function browse(Request $request)
    {
        // harmonize with <x-search-form>: accept either 'q' or 'search'
        $q = trim((string) ($request->get('search', $request->get('q', ''))));

        $hours = ConsultationHour::with(['professional:id,name,profile_pic'])
            ->where('status', 'active')
            ->when($q !== '', function ($query) use ($q) {
                $query->where('specialization', 'like', "%{$q}%");
            })
            ->orderByRaw("FIELD(day, 'Monday','Tuesday','Wednesday','Thursday','Friday','Saturday','Sunday')")
            ->orderBy('start_time')
            ->paginate(12)
            ->appends(['search' => $q]);

        return view('consultation.browseHours', compact('hours', 'q'));
    }
    public function index(Request $request)
    {
        $consultationHours = ConsultationHour::where('user_id', Auth::id())->get();
        $editingHour = null;

        if ($request->has('edit')) {
            $editingHour = ConsultationHour::findOrFail($request->input('edit'));
        }

        return view(
            'consultation.consultationHours',
            compact('consultationHours', 'editingHour')
        );
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
