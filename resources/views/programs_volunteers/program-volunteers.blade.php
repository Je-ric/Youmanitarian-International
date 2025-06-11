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
