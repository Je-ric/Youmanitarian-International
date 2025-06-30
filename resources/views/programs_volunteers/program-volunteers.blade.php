@extends('layouts.sidebar_final')

@section('content')
    <x-page-header icon="bx-calendar-event" title="{{ $program->title }}"
        desc="View and manage program details and volunteer participation.">
        <a href="{{ route('program.chats.index', $program) }}"
            class="flex-1 lg:flex-none inline-flex items-center justify-center px-4 py-2 bg-[#ffb51b] text-[#1a2235] rounded-lg hover:bg-[#e6a319] transition-colors font-medium">
            <i class='bx bx-message-square-dots mr-2'></i> Group Chat
        </a>
    </x-page-header>

    @php
        $tabs = [
            ['id' => 'overview', 'label' => 'Overview', 'icon' => 'bx-stats'],
            ['id' => 'volunteers', 'label' => 'Volunteers', 'icon' => 'bx-group'],
            ['id' => 'tasks', 'label' => 'Tasks & Assignments', 'icon' => 'bx-task'],
            ['id' => 'program', 'label' => 'Program Settings', 'icon' => 'bx-cog'],
            ['id' => 'feedbacks', 'label' => 'Program Feedbacks', 'icon' => 'bx-message-dots']
        ];
    @endphp

    <x-navigation-layout.tabs-modern :tabs="$tabs" default-tab="{{ request()->query('tab', 'overview') }}">
        <x-slot:slot_overview>
            @include('programs_volunteers.partials.programOverview', [
                'program' => $program,
                'tasks' => $tasks,
                'averageRating' => $averageRating
            ])
        </x-slot>

        <x-slot:slot_volunteers>
            @include('programs_volunteers.partials.volunteerLists')
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
    </x-navigation-layout.tabs-modern>
</div>
@endsection
