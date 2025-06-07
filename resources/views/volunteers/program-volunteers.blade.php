@extends('layouts.sidebar_final')

@section('content')
    <div class="container mx-auto p-6">
        <h1 class="font-bold text-[#1a2235] mb-6">Manage Volunteers for {{ $program->title }}</h1>
        @if (session('toast'))
            <x-toast :message="session('toast')['message']" :type="session('toast')['type']" />
        @endif

        <x-button href="{{ route('programs.feedback.view', $program->id) }}" variant="secondary" class="mb-6">
            View Feedbacks
        </x-button>

        <div class="text-end">
            <button
                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                type="button" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example"
                data-drawer-placement="right" aria-controls="drawer-right-example">
                Assign Volunteers
            </button>
        </div>

        <h2 class="text-xl font-semibold text-[#1a2235] mb-4">Assigned Volunteers</h2>

        @if($program->volunteers->isEmpty())
            <p class="text-gray-600 text-center py-4">No volunteers assigned to this program.</p>
        @else
            <table class="min-w-full bg-white shadow-lg rounded-lg overflow-hidden border border-gray-200">
                <thead class="bg-[#1a2235] text-white">
                    <tr>
                        <th class="p-4 text-left text-sm font-medium">Name</th>
                        <th class="p-4 text-left text-sm font-medium">Clock In</th>
                        <th class="p-4 text-left text-sm font-medium">Clock Out</th>
                        <th class="p-4 text-left text-sm font-medium">Total Time</th>
                        <th class="p-4 text-left text-sm font-medium">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($program->volunteers as $volunteer)
                        @if($volunteer->pivot->status == 'approved')
                            <tr class="border-t hover:bg-gray-50 transition-all duration-200">
                                <td class="p-4 text-sm text-[#1a2235] font-semibold">{{ $volunteer->user->name }} <span
                                        class="text-gray-500">({{ $volunteer->user->email }})</span></td>
                                <td class="p-4 text-sm">
                                    @php
                                        $volunteerLogs = $logs[$volunteer->id]['logs'];
                                    @endphp

                                    @if ($volunteerLogs->isEmpty())
                                        <p class="text-gray-500">N/A</p>
                                    @else
                                        @foreach ($volunteerLogs as $log)
                                            <div class="flex gap-2">
                                                <span
                                                    class="text-sm text-gray-600">{{ \Carbon\Carbon::parse($log->clock_in)->format('M d, Y h:i A') }}</span>
                                            </div>
                                        @endforeach
                                    @endif
                                </td>

                                <td class="p-4 text-sm">
                                    @if ($volunteerLogs->isEmpty())
                                        <p class="text-gray-500">N/A</p>
                                    @else
                                        @foreach ($volunteerLogs as $log)
                                            <div class="flex gap-2">
                                                <span class="text-sm text-gray-600">
                                                    @if ($log->clock_out)
                                                        {{ \Carbon\Carbon::parse($log->clock_out)->format('M d, Y h:i A') }}
                                                    @else
                                                        <span class="text-red-500">Still Clocked In</span>
                                                    @endif
                                                </span>
                                            </div>
                                        @endforeach
                                    @endif
                                </td>

                                <td class="p-4 text-sm">
                                    @if ($volunteerLogs->isEmpty())
                                        <p class="text-gray-500">N/A</p>
                                    @else
                                        <p class="text-gray-600">{{ $logs[$volunteer->id]['totalTime'] }}</p>
                                    @endif
                                </td>

                                <td class="p-4 flex items-center gap-2">
                                    <x-button href="{{ route('volunteers.viewUser_details', $volunteer->id) }}" variant="info">
                                        <i class='bx bx-show'></i> View
                                    </x-button>

                                    <button class="btn btn-info"
                                        onclick="document.getElementById('attendanceModal_{{ $volunteer->id }}').showModal()">
                                        <i class='bx bx-show'></i> Review Attendance
                                    </button>
                                    @include('volunteers.modals.attendanceApproval', ['volunteer' => $volunteer, 'volunteerLogs' => $logs[$volunteer->id]['logs']])

                                    {{-- <form action="{{ route('programs.restore_volunteer', [$program, $volunteer]) }}" method="POST">
                                        @csrf
                                        <x-button type="submit" variant="restore">Restore</x-button>
                                    </form> --}}
                                </td>
                            </tr>




                        @endif
                    @endforeach
                </tbody>
            </table>
        @endif



        @include('volunteers.partials.offCanvas')


    </div>




@endsection