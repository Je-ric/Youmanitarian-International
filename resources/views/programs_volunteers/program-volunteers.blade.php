@extends('layouts.sidebar_final')

@section('content')

    <div class="mx-auto px-2 sm:px-4 md:px-6 py-4 sm:py-6">
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
                </div>
            </div>
        </div>

        @php
            $tabs = [
                ['id' => 'volunteers', 'label' => 'Volunteers', 'icon' => 'bx-group'],
                ['id' => 'overview', 'label' => 'Overview', 'icon' => 'bx-stats'],
                ['id' => 'tasks', 'label' => 'Tasks & Assignments', 'icon' => 'bx-task'],
                ['id' => 'program', 'label' => 'Program Settings', 'icon' => 'bx-cog'],
                ['id' => 'feedbacks', 'label' => 'Program Feedbacks', 'icon' => 'bx-message-dots']
            ];
        @endphp

        <x-tabs 
            :tabs="$tabs"
            default-tab="{{ request()->query('tab', 'volunteers') }}"
        >
            <x-slot:slot_volunteers>
                    @include('programs_volunteers.partials.volunteerLists')
            </x-slot>

            <x-slot:slot_overview>
                    @include('programs_volunteers.partials.programOverview', [
                        'program' => $program,
                        'tasks' => $tasks,
                        'averageRating' => $averageRating
                    ])
            </x-slot>

            <x-slot:slot_tasks>
                    @include('programs_volunteers.partials.programTasks', [
                        'program' => $program,
                        'tasks' => $tasks
                    ])
            </x-slot>

            <x-slot:slot_program>
                    @include('programs_volunteers.partials.programDetails', [
                        'route' => route('programs.update', $program), 
                        'method' => 'PUT', 
                        'program' => $program
                    ])
            </x-slot>

            <x-slot:slot_feedbacks>
                    @include('programs_volunteers.partials.viewFeedback', [
                        'program' => $program,
                        'feedbacks' => $feedbacks,
                        'totalFeedbacks' => $totalFeedbacks,
                        'averageRating' => $averageRating,
                        'ratingCounts' => $ratingCounts,
                    ])
            </x-slot>
        </x-tabs>
    </div>
@endsection
