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
            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold text-[#1a2235] mb-1 sm:mb-2">
                Manage Program
            </h1>
            <p class="text-sm sm:text-base text-gray-600">{{ $program->title }}</p>
        </div>

        <!-- Responsive Tab Navigation -->
        <div class="mb-6 sm:mb-8 overflow-x-auto pb-2 sm:pb-0">
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
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Total Volunteers -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Total Volunteers</p>
                                <h3 class="text-2xl font-bold text-[#1a2235]">{{ $program->volunteers->count() }}</h3>
                            </div>
                            <div class="bg-blue-50 p-3 rounded-full">
                                <i class='bx bx-group text-2xl text-blue-500'></i>
                            </div>
                        </div>
                    </div>

                    <!-- Active Tasks -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Active Tasks</p>
                                <h3 class="text-2xl font-bold text-[#1a2235]">{{ $tasks->where('status', 'active')->count() }}</h3>
                            </div>
                            <div class="bg-yellow-50 p-3 rounded-full">
                                <i class='bx bx-task text-2xl text-yellow-500'></i>
                            </div>
                        </div>
                    </div>

                    <!-- Completed Tasks -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Completed Tasks</p>
                                <h3 class="text-2xl font-bold text-[#1a2235]">{{ $tasks->where('status', 'completed')->count() }}</h3>
                            </div>
                            <div class="bg-green-50 p-3 rounded-full">
                                <i class='bx bx-check-circle text-2xl text-green-500'></i>
                            </div>
                        </div>
                    </div>

                    <!-- Average Rating -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-600">Average Rating</p>
                                <h3 class="text-2xl font-bold text-[#1a2235]">{{ number_format($averageRating, 1) }}/5</h3>
                            </div>
                            <div class="bg-purple-50 p-3 rounded-full">
                                <i class='bx bx-star text-2xl text-purple-500'></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Program Details -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Program Information -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                        <h3 class="text-lg font-semibold text-[#1a2235] mb-4">Program Information</h3>
                        <div class="space-y-3">
                            <div class="flex justify-between">
                                <span class="text-gray-600">Start Date:</span>
                                <span class="font-medium">{{ $program->start_date ? $program->start_date->format('M d, Y') : 'Not set' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">End Date:</span>
                                <span class="font-medium">{{ $program->end_date ? $program->end_date->format('M d, Y') : 'Not set' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Location:</span>
                                <span class="font-medium">{{ $program->location ?? 'Not set' }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-600">Status:</span>
                                <span class="font-medium">{{ ucfirst($program->status ?? 'Not set') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="bg-white rounded-lg border border-gray-200 p-4 shadow-sm">
                        <h3 class="text-lg font-semibold text-[#1a2235] mb-4">Recent Activity</h3>
                        <div class="space-y-4">
                            @php
                                $recentActivities = collect();
                                
                                // Add recent volunteer joins
                                $recentActivities = $recentActivities->concat(
                                    $program->volunteers->map(function($volunteer) {
                                        return [
                                            'type' => 'volunteer_join',
                                            'user' => $volunteer->user,
                                            'date' => $volunteer->pivot->created_at,
                                            'message' => 'joined the program'
                                        ];
                                    })
                                );

                                // Add recent task completions
                                $recentActivities = $recentActivities->concat(
                                    $tasks->where('status', 'completed')->map(function($task) {
                                        return [
                                            'type' => 'task_complete',
                                            'user' => $task->assigned_to ? $task->assignedTo->user : null,
                                            'date' => $task->completed_at,
                                            'message' => 'completed task: ' . $task->title
                                        ];
                                    })
                                );

                                // Add recent feedback
                                $recentActivities = $recentActivities->concat(
                                    $feedbacks->map(function($feedback) {
                                        return [
                                            'type' => 'feedback',
                                            'user' => $feedback->user,
                                            'date' => $feedback->created_at,
                                            'message' => 'submitted feedback'
                                        ];
                                    })
                                );

                                $recentActivities = $recentActivities->sortByDesc('date')->take(5);
                            @endphp

                            @forelse($recentActivities as $activity)
                                <div class="flex items-center justify-between border-b pb-3 last:border-0">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                                            <i class='bx bx-user text-xl text-gray-500'></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-[#1a2235]">{{ $activity['user']->name ?? 'System' }}</p>
                                            <p class="text-sm text-gray-600">{{ $activity['message'] }}</p>
                                        </div>
                                    </div>
                                    <span class="text-sm text-gray-500">
                                        {{ \Carbon\Carbon::parse($activity['date'])->diffForHumans() }}
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
