@extends('layouts.sidebar_final')

@section('content')
    <x-page-header
        icon="bx-user"
        title="Volunteer Details"
        desc="Complete information about {{ $volunteer->user->name }}">
        <div class="flex items-center gap-2">
            <a href="{{ route('reports.volunteers.show', ['volunteer' => $volunteer->id, 'format' => 'csv']) }}"
               class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-green-700 bg-green-100 rounded hover:bg-green-200">
                <i class='bx bx-table'></i> CSV
            </a>
            <a href="{{ route('reports.volunteers.show', ['volunteer' => $volunteer->id, 'format' => 'pdf']) }}"
               class="inline-flex items-center gap-2 px-3 py-2 text-sm font-medium text-red-700 bg-red-100 rounded hover:bg-red-200">
                <i class='bx bx-file'></i> PDF
            </a>
        </div>
    </x-page-header>

    <div x-data="{
        openModal(id) {
            document.getElementById('modal_' + id).showModal();
        }
    }">

    <x-navigation-layout.tabs-modern
        :tabs="[
            ['id' => 'overview', 'label' => 'Overview', 'icon' => 'bx-user-circle'],
            ['id' => 'application', 'label' => 'Application Details', 'icon' => 'bx-file-text'],
            ['id' => 'programs', 'label' => 'Programs & Attendance', 'icon' => 'bx-calendar'],
            ['id' => 'consultation_hours', 'label' => 'Consultation Hours', 'icon' => 'bx-time-five']
        ]"
        defaultTab="overview"
        :preserveState="false"
        class="mb-6">

        <x-slot name="slot_overview">
            @include('volunteers.partials.overviewProfile', ['volunteer' => $volunteer])
        </x-slot>

        <x-slot name="slot_application">
            @include('volunteers.partials.applicationProfile', ['volunteer' => $volunteer])
        </x-slot>

        <x-slot name="slot_programs">
            @include('volunteers.partials.programsProfile', ['volunteer' => $volunteer])
        </x-slot>

        <x-slot name="slot_consultation_hours">
            @include('volunteers.partials.consultationHoursProfile', ['volunteer' => $volunteer])
        </x-slot>
    </x-navigation-layout.tabs-modern>

@endsection
