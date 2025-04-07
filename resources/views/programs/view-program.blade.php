@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-4xl font-bold text-[#1a2235] mb-8">{{ $program->title }}</h1>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        {{-- Program Details Card --}}
        <div class="card bg-base-100 shadow-lg">
            <div class="card-body space-y-3">
                <h2 class="card-title text-xl">Program Details</h2>

                <p><span class="font-semibold">Description:</span> {{ $program->description }}</p>
                <p><span class="font-semibold">Organizer:</span> {{ $program->creator->name }}</p>

                <p>
                    <span class="font-semibold">Date:</span>
                    {{ \Carbon\Carbon::parse($program->start_date)->format('F j, Y') }}
                    @if($program->end_date)
                        - {{ \Carbon\Carbon::parse($program->end_date)->format('F j, Y') }}
                    @endif
                </p>

                <p>
                    <span class="font-semibold">Time:</span>
                    @php
                        $startTime = \Carbon\Carbon::parse($program->start_time)->format('g:ia');
                        $endTime = $program->end_time ? \Carbon\Carbon::parse($program->end_time)->format('g:ia') : null;
                    @endphp
                    {{ $endTime ? "$startTime - $endTime" : $startTime }}
                </p>

                <p><span class="font-semibold">Location:</span> {{ $program->location ?? 'N/A' }}</p>
                <p><span class="font-semibold">Volunteers:</span> {{ $program->volunteers->count() }}</p>

                <div class="flex items-center gap-2">
                    <span class="font-semibold">Status:</span>
                    @php
                        $today = now();
                        if ($program->start_date > $today) {
                            echo '<span class="text-blue-500">Incoming</span>';
                        } elseif ($program->end_date && $program->end_date < $today) {
                            echo '<span class="text-gray-500">Done</span>';
                        } else {
                            echo '<span class="text-green-500">Ongoing</span>';
                        }
                    @endphp
                </div>
            </div>
        </div>

        {{-- Clock In/Out Card --}}
        <div class="card bg-base-100 shadow-lg">
            <div class="card-body space-y-4">
                <h2 class="card-title text-xl">Attendance</h2>

                {{-- Flash Messages --}}
                @if(session('success'))
                    <div class="alert alert-success shadow-lg">
                        <span>{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-error shadow-lg">
                        <span>{{ session('error') }}</span>
                    </div>
                @endif

                @php
                    $today = now()->setTimezone('Asia/Manila');
                    $isUpcoming = $program->start_date > $today;
                @endphp
            
                {{-- Attendance Buttons --}}
                @if($isUpcoming)
                    <div class="alert alert-warning">
                        <span>This program hasn’t started yet. Clock-in will be available on <strong>{{ \Carbon\Carbon::parse($program->start_date)->format('F j, Y') }}</strong> at <strong>{{ \Carbon\Carbon::parse($program->start_time)->format('g:ia') }}</strong>. We’re excited to see you there!</span>
                    </div>
                @elseif($isAssigned)
                    @if($attendance && $attendance->clock_in && !$attendance->clock_out)
                        <p class="text-green-600">Clocked in at: <strong>{{ \Carbon\Carbon::parse($attendance->clock_in)->setTimezone('Asia/Manila')->format('g:ia') }}</strong></p>
                
                        <form action="{{ route('programs.clock-out', $program) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-error w-full">Clock Out</button>
                        </form>
                
                    @elseif($attendance && $attendance->clock_out)
                        @php
                            $clockInTime = \Carbon\Carbon::parse($attendance->clock_in)->setTimezone('Asia/Manila');
                            $clockOutTime = \Carbon\Carbon::parse($attendance->clock_out)->setTimezone('Asia/Manila');
                            $duration = $clockInTime->diff($clockOutTime);
                            $formatted = sprintf('%02d hr %02d min %02d sec', $duration->h, $duration->i, $duration->s);
                        @endphp
                        
                        <div class="space-y-1">
                            <p class="text-green-600">Clocked in at: <strong>{{ $clockInTime->format('g:ia') }}</strong></p>
                            <p class="text-red-600">Clocked out at: <strong>{{ $clockOutTime->format('g:ia') }}</strong></p>
                            <p class="text-blue-600">Total Time Worked: <strong>{{ $formatted }}</strong></p>
                        </div>
                    @else
                        <form action="{{ route('programs.clock-in', $program) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-primary w-full">Clock In</button>
                        </form>
                    @endif
                @else
                    <div class="alert alert-info">
                        <span>You are not assigned to this program.</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
