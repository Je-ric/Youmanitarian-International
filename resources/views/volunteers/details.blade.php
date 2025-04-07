@extends('layouts.sidebar')

@section('content')
    <div class="container mx-auto p-6">
        {{-- Volunteer Details --}}
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h1 class="text-3xl font-bold text-[#1a2235] mb-6">Volunteer Details: {{ $volunteer->user->name }}</h1>

            <div class="mb-4">
                <p><strong>Name:</strong> {{ $volunteer->user->name }}</p>
                <p><strong>Email:</strong> {{ $volunteer->user->email }}</p>
            </div>
        </div>

        {{-- Programs --}}
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h3 class="text-xl font-semibold mb-4">Programs:</h3>

            @if ($volunteer->programs->isEmpty())
                <p class="text-gray-500">No programs assigned yet.</p>
            @else
                <ul class="list-disc pl-5">
                    @foreach ($volunteer->programs as $program)
                        <li class="mb-2">
                            <strong>{{ $program->title }}</strong>
                            <p class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($program->start_date)->format('M d, Y') }} - 
                                {{ $program->end_date ? \Carbon\Carbon::parse($program->end_date)->format('M d, Y') : 'Ongoing' }}
                            </p>
                            <span class="badge badge-primary">{{ $program->pivot->status }}</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        {{-- Attendance Logs --}}
        <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
            <h3 class="text-xl font-semibold mb-4">Attendance Logs:</h3>

            @if ($volunteer->attendanceLogs->isEmpty())
                <p class="text-gray-500">No attendance logs available.</p>
            @else
                <table class="w-full table-auto border-collapse border border-gray-200">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-3 text-left">Program</th>
                            <th class="p-3 text-left">Clock In</th>
                            <th class="p-3 text-left">Clock Out</th>
                            <th class="p-3 text-left">Total Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($volunteer->attendanceLogs as $log)
                            <tr class="border-t">
                                <td class="p-3">
                                    {{ $log->program->title ?? 'No Program Assigned' }}
                                </td>
                                <td class="p-3">
                                    {{ \Carbon\Carbon::parse($log->clock_in)->format('M d, Y h:i A') }}
                                </td>
                                <td class="p-3">
                                    @if ($log->clock_out)
                                        {{ \Carbon\Carbon::parse($log->clock_out)->format('M d, Y h:i A') }}
                                    @else
                                        <span class="text-red-500">Still Clocked In</span>
                                    @endif
                                </td>
                                <td class="p-3">
                                    @if ($log->clock_out)
                                        @php
                                            $diff = \Carbon\Carbon::parse($log->clock_in)->diff(\Carbon\Carbon::parse($log->clock_out));
                                        @endphp
                                        {{ $diff->h }}h {{ $diff->i }}m {{ $diff->s }}s
                                    @else
                                        <span class="text-red-500">Ongoing</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        {{-- Application --}}
        @if ($volunteer->application)
            <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                <h3 class="text-xl font-semibold mb-4">Application Form Answers:</h3>
                <div class="mb-4">
                    <p><strong>Why Volunteer:</strong> {{ $volunteer->application->why_volunteer }}</p>
                    <p><strong>Interested Programs:</strong> {{ $volunteer->application->interested_programs }}</p>
                    <p><strong>Skills/Experience:</strong> {{ $volunteer->application->skills_experience }}</p>
                    <p><strong>Availability:</strong> {{ $volunteer->application->availability }}</p>
                    <p><strong>Commitment Hours:</strong> {{ $volunteer->application->commitment_hours }}</p>
                    <p><strong>Physical Limitations:</strong> {{ $volunteer->application->physical_limitations }}</p>
                    <p><strong>Emergency Contact:</strong> {{ $volunteer->application->emergency_contact }}</p>
                    <p><strong>Contact Consent:</strong> {{ ucfirst($volunteer->application->contact_consent) }}</p>
                    <p><strong>Volunteered Before:</strong> {{ ucfirst($volunteer->application->volunteered_before) }}</p>
                    <p><strong>Outdoor OK:</strong> {{ ucfirst($volunteer->application->outdoor_ok) }}</p>
                    <p><strong>Short Bio:</strong> {{ $volunteer->application->short_bio }}</p>
                </div>
            </div>
        @else
            <div class="bg-white shadow-lg rounded-lg p-6 mb-6">
                <p class="text-gray-500">No application data available.</p>
            </div>
        @endif
    </div>
@endsection
