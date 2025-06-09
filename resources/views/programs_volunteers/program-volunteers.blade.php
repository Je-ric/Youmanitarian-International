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

                {{-- <button
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5"
                    type="button" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example"
                    data-drawer-placement="right" aria-controls="drawer-right-example">
                    Assign Volunteers
                </button> --}}
            @include('programs_volunteers.partials.volunteerLists')
            {{-- @include('volunteers.partials.offCanvas') --}}

        </div>

        <!-- Tasks & Assignments Tab -->
        <div x-show="activeTab === 'tasks'" x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

            @include('programs_volunteers.partials.programTasks', [
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

              @include('programs_volunteers.partials.viewFeedback', [
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
