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
                <p><span class="font-semibold">Participants:</span> {{ $program->volunteers->count() }} Volunteers</p>

                <div class="flex items-center gap-2">
                    <span class="font-semibold">Status:</span>
                    @php
                        $today = now();
                        if ($program->start_date > $today) {
                            echo '<span class="badge badge-info">Incoming</span>';
                        } elseif ($program->end_date && $program->end_date < $today) {
                            echo '<span class="badge badge-neutral">Done</span>';
                        } else {
                            echo '<span class="badge badge-success">Ongoing</span>';
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

                {{-- Attendance Buttons --}}
                @if($isAssigned)
                    @if($attendance && $attendance->clock_in && !$attendance->clock_out)
                        <p class="text-green-600">Clocked in at: <strong>{{ \Carbon\Carbon::parse($attendance->clock_in)->format('g:ia') }}</strong></p>

                        <form action="{{ route('programs.clock-out', $program) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-error w-full">Clock Out</button>
                        </form>

                    @elseif($attendance && $attendance->clock_out)
                        <div class="space-y-1">
                            <p class="text-green-600">Clocked in at: <strong>{{ \Carbon\Carbon::parse($attendance->clock_in)->format('g:ia') }}</strong></p>
                            <p class="text-red-600">Clocked out at: <strong>{{ \Carbon\Carbon::parse($attendance->clock_out)->format('g:ia') }}</strong></p>
                            <p class="text-blue-600">Total Time Worked: <strong>{{ $attendance->formatted_time }}</strong></p>
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
