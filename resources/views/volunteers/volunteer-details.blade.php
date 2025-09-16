@extends('layouts.sidebar_final')

@section('content')
    <x-page-header
        icon="bx-user"
        title="Volunteer Details"
        desc="Complete information about {{ $volunteer->user->name }}">
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
