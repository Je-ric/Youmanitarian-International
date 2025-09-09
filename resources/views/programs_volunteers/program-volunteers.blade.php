@extends('layouts.sidebar_final')

@section('content')
    {{-- Im thinking about kung ididisplay pa ba title,
    since nag-add tayo ng ajax, di mababago yung title dito --}}
    <x-page-header icon="bx-calendar-event" title="{{ $program->title }}"
        desc="View and manage program details and volunteer participation.">
        <x-button variant="primary" href="{{ route('program.chats.index', $program) }}">
             <i class='bx bx-message-square-dots mr-2'></i> Group Chat
        </x-button>
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

    <x-navigation-layout.tabs-modern :tabs="$tabs" default-tab="overview">
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
            <div id="programDetailsSection">
                @include('programs_volunteers.partials.programDetails', [
                    'route' => route('programs.update', $program),
                    'method' => 'PUT',
                    'program' => $program
                ])
            </div>
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
@endsection
