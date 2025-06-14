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
    }" class="mx-auto px-2 sm:px-4 md:px-6 py-4 sm:py-6">

        <div class="mb-4 sm:mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h1 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">
                        "{{ $program->title }}"
                    </h1>
                    <p class="text-gray-600">View and manage program details and volunteer participation.</p>
                </div>
                
                <div class="flex gap-3 w-full lg:w-auto">
                    <a href="{{ route('program.chats.index', $program) }}" 
                       class="flex-1 lg:flex-none inline-flex items-center justify-center px-4 py-2 bg-[#ffb51b] text-[#1a2235] rounded-lg hover:bg-[#e6a319] transition-colors font-medium">
                        <i class='bx bx-message-square-dots mr-2'></i> Group Chat
                    </a>
                    <button
                        type="button"
                        id="editBtn"
                        class="flex-1 lg:flex-none inline-flex items-center justify-center px-4 py-2 bg-white border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors font-medium"
                    >
                        <i class='bx bx-edit mr-2'></i> Edit Program
                    </button>
                    <button
                        type="button"
                        id="discardBtn"
                        class="hidden flex-1 lg:flex-none items-center justify-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors"
                    >
                        <i class='bx bx-x mr-2'></i> Discard
                    </button>
                    <button
                        type="submit"
                        id="saveBtn"
                        class="hidden flex-1 lg:flex-none items-center justify-center px-4 py-2 bg-[#ffb51b] text-[#1a2235] rounded-lg hover:bg-[#e6a319] transition-colors font-medium"
                    >
                        <i class='bx bx-save mr-2'></i> Save Changes
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Tab Navigation -->
        <div class="mb-4 sm:mb-8 overflow-x-auto pb-2 sm:pb-0">
            <div class="bg-gray-50 p-1 rounded-lg inline-flex space-x-1 min-w-max">
                <button @click="setTab('volunteers')" 
                    :class="activeTab === 'volunteers' ? 'bg-white text-[#1a2235] border border-gray-200 shadow-sm' : 'text-gray-600 hover:text-[#1a2235]'"
                    class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap flex items-center">
                    <i class='bx bx-group text-lg sm:mr-1'></i>
                    <span class="hidden sm:inline">Volunteers</span>
                </button>

                <button @click="setTab('overview')" 
                    :class="activeTab === 'overview' ? 'bg-white text-[#1a2235] border border-gray-200 shadow-sm' : 'text-gray-600 hover:text-[#1a2235]'"
                    class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap flex items-center">
                    <i class='bx bx-stats text-lg sm:mr-1'></i>
                    <span class="hidden sm:inline">Overview</span>
                </button>

                <button @click="setTab('tasks')" 
                    :class="activeTab === 'tasks' ? 'bg-white text-[#1a2235] border border-gray-200 shadow-sm' : 'text-gray-600 hover:text-[#1a2235]'"
                    class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap flex items-center">
                    <i class='bx bx-task text-lg sm:mr-1'></i>
                    <span class="hidden sm:inline">Tasks & Assignments</span>
                </button>

                <button @click="setTab('program')" 
                    :class="activeTab === 'program' ? 'bg-white text-[#1a2235] border border-gray-200 shadow-sm' : 'text-gray-600 hover:text-[#1a2235]'"
                    class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap flex items-center">
                    <i class='bx bx-cog text-lg sm:mr-1'></i>
                    <span class="hidden sm:inline">Program Settings</span>
                </button>

                <button @click="setTab('feedbacks')" 
                    :class="activeTab === 'feedbacks' ? 'bg-white text-[#1a2235] border border-gray-200 shadow-sm' : 'text-gray-600 hover:text-[#1a2235]'"
                    class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap flex items-center">
                    <i class='bx bx-message-dots text-lg sm:mr-1'></i>
                    <span class="hidden sm:inline">Program Feedbacks</span>
                </button>
            </div>
        </div>

        <!-- Tab Content with Smooth Transitions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
            <!-- Volunteers Tab -->
            <div x-show="activeTab === 'volunteers'" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="space-y-4">
                @include('programs_volunteers.partials.volunteerLists')
            </div>

            <!-- Overview Tab -->
            <div x-show="activeTab === 'overview'" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="space-y-6">
                
                <!-- Program Statistics -->
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
                    <!-- Total Volunteers -->
                    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600">Total Volunteers</p>
                                <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">{{ $program->volunteers->count() }}</h3>
                            </div>
                            <div class="bg-blue-50 p-2 sm:p-3 rounded-full">
                                <i class='bx bx-group text-xl sm:text-2xl text-blue-500'></i>
                            </div>
                        </div>
                    </div>

                    <!-- Active Tasks -->
                    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600">Active Tasks</p>
                                <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">{{ $tasks->where('status', 'active')->count() }}</h3>
                            </div>
                            <div class="bg-yellow-50 p-2 sm:p-3 rounded-full">
                                <i class='bx bx-task text-xl sm:text-2xl text-yellow-500'></i>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Tasks -->
                    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600">Completed Tasks</p>
                                <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">{{ $tasks->where('status', 'completed')->count() }}</h3>
                            </div>
                            <div class="bg-green-50 p-2 sm:p-3 rounded-full">
                                <i class='bx bx-check-circle text-xl sm:text-2xl text-green-500'></i>
                            </div>
                        </div>
                    </div>

                    <!-- Average Rating -->
                    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-xs sm:text-sm text-gray-600">Average Rating</p>
                                <h3 class="text-lg sm:text-2xl font-bold text-[#1a2235]">{{ number_format($averageRating, 1) }}/5</h3>
                            </div>
                            <div class="bg-purple-50 p-2 sm:p-3 rounded-full">
                                <i class='bx bx-star text-xl sm:text-2xl text-purple-500'></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Program Details -->
                <div class="grid grid-cols-1 xl:grid-cols-2 gap-3 sm:gap-6">
                    <!-- Program Information -->
                    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
                        <h3 class="text-base sm:text-lg font-semibold text-[#1a2235] mb-3 sm:mb-4">Attendance Overview</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-1 gap-3 sm:space-y-4">
                            @php
                                $totalVolunteers = $program->volunteers()->where('program_volunteers.status', 'approved')->count();
                                $totalAttendanceRecords = 0;
                                $approvedCount = 0;
                                $pendingCount = 0;
                                $rejectedCount = 0;
                                $noRecordsCount = 0;

                                foreach ($program->volunteers()->where('program_volunteers.status', 'approved')->get() as $volunteer) {
                                    $attendanceRecords = $volunteer->attendanceLogs()->where('program_id', $program->id)->get();
                                    if ($attendanceRecords->isEmpty()) {
                                        $noRecordsCount++;
                                    } else {
                                        $totalAttendanceRecords += $attendanceRecords->count();
                                        foreach ($attendanceRecords as $record) {
                                            switch ($record->approval_status) {
                                                case 'approved':
                                                    $approvedCount++;
                                                    break;
                                                case 'pending':
                                                    $pendingCount++;
                                                    break;
                                                case 'rejected':
                                                    $rejectedCount++;
                                                    break;
                                            }
                                        }
                                    }
                                }
                            @endphp

                            <!-- Total Attendance Records -->
                            <div class="bg-blue-50 p-2 sm:p-4 rounded-lg">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h4 class="text-xs sm:text-sm font-medium text-blue-800">Total Records</h4>
                                        <p class="text-lg sm:text-2xl font-bold text-blue-900">{{ $totalAttendanceRecords }}</p>
                                    </div>
                                    <div class="bg-blue-100 p-2 rounded-full">
                                        <i class='bx bx-time text-lg sm:text-2xl text-blue-600'></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Volunteers Without Records -->
                            <div class="bg-yellow-50 p-2 sm:p-4 rounded-lg">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <h4 class="text-xs sm:text-sm font-medium text-yellow-800">No Records</h4>
                                        <p class="text-lg sm:text-2xl font-bold text-yellow-900">{{ $noRecordsCount }}</p>
                                        <p class="text-xs text-yellow-700">of {{ $totalVolunteers }}</p>
                                    </div>
                                    <div class="bg-yellow-100 p-2 rounded-full">
                                        <i class='bx bx-user-x text-lg sm:text-2xl text-yellow-600'></i>
                                    </div>
                                </div>
                            </div>

                            <!-- Approval Status Breakdown -->
                            <div class="col-span-2 sm:col-span-1">
                                <h4 class="text-xs sm:text-sm font-medium text-gray-700 mb-2">Status Breakdown</h4>
                                <div class="grid grid-cols-3 gap-2">
                                    <!-- Approved -->
                                    <div class="bg-green-50 p-2 rounded-lg">
                                        <div class="flex items-center gap-1 mb-1">
                                            <span class="w-2 h-2 rounded-full bg-green-500"></span>
                                            <span class="text-xs text-gray-600">Approved</span>
                                        </div>
                                        <span class="text-base font-semibold text-green-700">{{ $approvedCount }}</span>
                                    </div>
                                    <!-- Pending -->
                                    <div class="bg-yellow-50 p-2 rounded-lg">
                                        <div class="flex items-center gap-1 mb-1">
                                            <span class="w-2 h-2 rounded-full bg-yellow-500"></span>
                                            <span class="text-xs text-gray-600">Pending</span>
                                        </div>
                                        <span class="text-base font-semibold text-yellow-700">{{ $pendingCount }}</span>
                                    </div>
                                    <!-- Rejected -->
                                    <div class="bg-red-50 p-2 rounded-lg">
                                        <div class="flex items-center gap-1 mb-1">
                                            <span class="w-2 h-2 rounded-full bg-red-500"></span>
                                            <span class="text-xs text-gray-600">Rejected</span>
                                        </div>
                                        <span class="text-base font-semibold text-red-700">{{ $rejectedCount }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-lg border border-gray-200 p-3 sm:p-4 shadow-sm">
                        <h3 class="text-base sm:text-lg font-semibold text-[#1a2235] mb-3 sm:mb-4">Recent Activity</h3>
                        <div class="max-h-[300px] sm:max-h-[400px] overflow-y-auto pr-2">
                            @php
                                $recentActivities = $program->volunteers()
                                    ->where('program_volunteers.status', 'approved')
                                    ->orderBy('program_volunteers.created_at', 'desc')
                                    ->get()
                                    ->map(function($volunteer) {
                                        return [
                                            'user' => $volunteer->user,
                                            'date' => $volunteer->pivot->created_at,
                                            'message' => 'joined the program'
                                        ];
                                    });
                            @endphp

                            @forelse($recentActivities as $activity)
                                <div class="flex items-center justify-between border-b pb-2 sm:pb-3 last:border-0">
                                    <div class="flex items-center space-x-2 sm:space-x-3">
                                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                            <i class='bx bx-user text-lg sm:text-xl text-gray-500'></i>
                                        </div>
                                        <div>
                                            <p class="text-sm sm:text-base font-medium text-[#1a2235]">{{ $activity['user']->name }}</p>
                                            <p class="text-xs sm:text-sm text-gray-600">{{ $activity['message'] }}</p>
                                        </div>
                                    </div>
                                    <span class="text-xs sm:text-sm text-gray-500 whitespace-nowrap">
                                        {{ \Carbon\Carbon::parse($activity['date'])->format('M d, Y h:i A') }}
                                    </span>
                                </div>
                            @empty
                                <p class="text-gray-600 text-center py-4">No recent activity</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tasks & Assignments Tab -->
            <div x-show="activeTab === 'tasks'" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="space-y-4">
                @include('programs_volunteers.partials.programTasks', [
                    'program' => $program,
                    'tasks' => $tasks
                ])
            </div>

            <!-- Program Settings Tab -->
            <div x-show="activeTab === 'program'" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="space-y-4">
                @include('programs_volunteers.partials.programDetails', [
                    'route' => route('programs.update', $program), 
                    'method' => 'PUT', 
                    'program' => $program
                ])
            </div>

            <!-- Program Feedbacks Tab -->
            <div x-show="activeTab === 'feedbacks'" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="space-y-4">
                @include('programs_volunteers.partials.viewFeedback', [
                    'program' => $program,
                    'feedbacks' => $feedbacks,
                    'totalFeedbacks' => $totalFeedbacks,
                    'averageRating' => $averageRating,
                    'ratingCounts' => $ratingCounts,
                ])
            </div>
        </div>
    </div>

    <script>
        // Preserve tab state on page reload
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
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
