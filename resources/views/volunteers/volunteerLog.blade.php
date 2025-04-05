{{-- @extends('layouts.sidebar')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-[#1a2235] mb-6">Volunteer Log for {{ $program->title }}</h1>

    <p class="text-gray-600"><strong>Start Date:</strong> {{ $program->start_date }}</p>
    <p class="text-gray-600"><strong>End Date:</strong> {{ $program->end_date ?? 'Ongoing' }}</p>
    <p class="text-gray-600"><strong>Created By:</strong> {{ $program->creator->name }}</p>

    <h2 class="text-2xl font-semibold text-[#1a2235] mt-6">Your Attendance</h2>
    
    @if(isset($logs) && $logs->isNotEmpty())
    <table class="w-full bg-white shadow-lg rounded-lg mt-4">
        <thead>
            <tr class="bg-gray-100">
                <th class="p-3 text-left">Clock In</th>
                <th class="p-3 text-left">Clock Out</th>
                <th class="p-3 text-left">Total Hours</th>
            </tr>
        </thead>
        <tbody>
            @foreach($logs as $log)
                <tr class="border-t">
                    <td class="p-3">{{ $log->clock_in }}</td>
                    <td class="p-3">{{ $log->clock_out ?? 'Still Clocked In' }}</td>
                    <td class="p-3">
                        @if($log->clock_out)
                            {{ round((strtotime($log->clock_out) - strtotime($log->clock_in)) / 3600, 2) }} hours
                        @else
                            In Progress...
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <p class="text-gray-600 mt-2">No clock-in records found for you.</p>
@endif


    <!-- Clock In / Clock Out Buttons -->
    @if(Auth::user()->hasRole('Volunteer'))
        <form action="{{ route('volunteers.clock_in', $program) }}" method="POST">
            @csrf
            <button type="submit" class="mt-4 px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">
                Clock In
            </button>
        </form>

        <form action="{{ route('volunteers.clock_out', $program) }}" method="POST">
            @csrf
            <button type="submit" class="mt-2 px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600">
                Clock Out
            </button>
        </form>
    @endif
</div>
@endsection --}}
