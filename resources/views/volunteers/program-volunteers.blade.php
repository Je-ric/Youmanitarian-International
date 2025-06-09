@extends('layouts.sidebar_final')

@section('content')
    @if (session('toast'))
        <x-toast :message="session('toast')['message']" :type="session('toast')['type']" />
    @endif

    <div x-data="{ 
        activeTab: new URLSearchParams(window.location.search).get('tab') || 'volunteers',
        setTab(tab) {
            this.activeTab = tab;
            const url = new URL(window.location);
            url.searchParams.set('tab', tab);
            window.history.pushState({}, '', url);
        }
    }" class="container mx-auto px-4 sm:px-6 py-6">

        <div class="mb-8">
            <h1 class="text-2xl sm:text-3xl font-bold text-[#1a2235] mb-2">
                Manage Program
            </h1>
            <p class="text-gray-600">{{ $program->title }}</p>
        </div>

        <div class="mb-8">
            <div class="bg-gray-50 p-1 rounded-lg inline-flex space-x-1">
                <button @click="setTab('volunteers')" :class="activeTab === 'volunteers' ? 'bg-white text-[#1a2235] border border-gray-200' : 'text-gray-600 hover:text-[#1a2235]'"
                    class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap">
                    <i class='bx bx-group mr-1'></i>
                    Volunteers
                </button>

                <button @click="setTab('tasks')" :class="activeTab === 'tasks' ? 'bg-white text-[#1a2235] border border-gray-200' : 'text-gray-600 hover:text-[#1a2235]'"
                    class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap">
                    <i class='bx bx-task mr-1'></i>
                    Tasks & Assignments
                </button>

                <button @click="setTab('program')" :class="activeTab === 'program' ? 'bg-white text-[#1a2235] border border-gray-200' : 'text-gray-600 hover:text-[#1a2235]'"
                    class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap">
                    <i class='bx bx-cog mr-1'></i>
                    Program Settings
                </button>

                <button @click="setTab('feedbacks')" :class="activeTab === 'feedbacks' ? 'bg-white text-[#1a2235] border border-gray-200' : 'text-gray-600 hover:text-[#1a2235]'"
                    class="px-4 py-2 text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap">
                    <i class='bx bx-cog mr-1'></i>
                    Program Feedbacks
                </button>
            </div>
        </div>

        <!-- Volunteers Tab -->
        <div x-show="activeTab === 'volunteers'" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

            {{-- <x-button href="{{ route('programs.feedback.view', $program->id) }}" variant="secondary" class="mb-6">
                View Feedbacks
            </x-button> --}}
            {{-- <div class="text-end mb-4">
                <button
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5"
                    type="button" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example"
                    data-drawer-placement="right" aria-controls="drawer-right-example">
                    Assign Volunteers
                </button>
            </div> --}}
            @if($program->volunteers->isEmpty())
                <p class="text-gray-600 text-center py-4">No volunteers assigned to this program.</p>
            @else
                <table class="min-w-full bg-white overflow-hidden border border-gray-200">
                    <thead class="bg-[#1a2235] text-white">
                        <tr>
                            <th class="p-4 text-left text-sm font-medium">#</th>
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
                                    <td class="p-4">{{ $loop->iteration }}</td>
                                    <td class="p-4 text-sm text-[#1a2235] font-semibold">
                                        {{ $volunteer->user->name }}
                                        <span class="text-gray-500">({{ $volunteer->user->email }})</span>
                                    </td>
                                    <td class="p-4 text-sm">
                                        @php
                                            $volunteerLogs = $logs[$volunteer->id]['logs'] ?? collect();
                                        @endphp
                                        @if ($volunteerLogs->isEmpty())
                                            <p class="text-gray-500">N/A</p>
                                        @else
                                            @foreach ($volunteerLogs as $log)
                                                <div class="flex gap-2">
                                                    <span class="text-sm text-gray-600">
                                                        {{ \Carbon\Carbon::parse($log->clock_in)->format('M d, Y h:i A') }}
                                                    </span>
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
                                            <p class="text-gray-600">{{ $logs[$volunteer->id]['totalTime'] ?? 'N/A' }}</p>
                                        @endif
                                    </td>
                                    <td class="p-4 flex items-center gap-2">
                                        @php
                                            $hasLogs = !$volunteerLogs->isEmpty();
                                            $allReviewed = $hasLogs && $volunteerLogs->every(fn($log) => in_array($log->approval_status, ['approved', 'rejected']));
                                        @endphp
                                        <x-button href="{{ route('volunteers.viewUser_details', $volunteer->id) }}" variant="info">
                                            <i class='bx bx-show'></i> View
                                        </x-button>
                                        @if ($allReviewed)
                                            <button class="btn btn-outline text-green-600 border-green-300 hover:bg-green-50"
                                                title="Attendance already reviewed"
                                                onclick="document.getElementById('attendanceModal_{{ $volunteer->id }}').showModal()">
                                                <i class='bx bx-check-double'></i> Reviewed
                                            </button>
                                        @else
                                            <button class="btn btn-info"
                                                onclick="document.getElementById('attendanceModal_{{ $volunteer->id }}').showModal()">
                                                <i class='bx bx-show'></i> Review Attendance
                                            </button>
                                        @endif
                                        @include('volunteers.modals.attendanceApproval', ['volunteer' => $volunteer, 'volunteerLogs' => $volunteerLogs])
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            @endif
            @include('volunteers.partials.offCanvas')

        </div>

        <!-- Tasks & Assignments Tab -->
        <div x-show="activeTab === 'tasks'" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

            @include('volunteers.partials.programTasks', [
                'program' => $program,
                'tasks' => $tasks
            ])

        </div>

        
        <!-- Program Settings Tab -->
        <div x-show="activeTab === 'program'" x-transition:enter="transition ease-out duration-200" 
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

                @include('programs._form', ['route' => route('programs.update', $program), 'method' => 'PUT', 'program' => $program])
        
        </div>


        <!-- Program Feedbacks Tab -->
         <div x-show="activeTab === 'feedbacks'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            {{-- <div class="text-center py-12">
                <i class='bx bx-cog text-4xl text-gray-300 mb-4'></i>
                <p class="text-gray-500 text-lg">Program Feedbacks coming soon.</p>
            </div> --}}

              @include('programs.partials.viewFeedback', [
            'program' => $program,
            'feedbacks' => $feedbacks,
            'totalFeedbacks' => $totalFeedbacks,
            'averageRating' => $averageRating,
            'ratingCounts' => $ratingCounts,
        ])
            
        </div>
        </div>

         <script>
        // Preserve tab state on page reload
        document .addEventListener('DOMContentLoaded', function() {
            document    .querySelectorAll('form').forEach(form => {
                form  .addEventListener('submit', function() {
                    const activeTab = Alpine.store ? Alpine.store.activeTab : 'volunteers';
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'preserve_tab';
                    input.value = activeTab;
                    this.appendChild(input);
            });
        });
    });
    </script>
@endsection
