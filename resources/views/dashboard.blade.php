@extends('layouts.sidebar_final')

@section('content')
    <head>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>

    <x-page-header icon="bx-grid-alt" title="Dashboard" desc="Overview and analytics based on your roles." />

    @php
            $tabs = [
                ['id' => 'volunteer', 'label' => 'Volunteers', 'icon' => 'bx-user'],
                ['id' => 'admin', 'label' => 'Admins', 'icon' => 'bx-crown'],
                ['id' => 'program_coordinator', 'label' => 'Program Coordinators', 'icon' => 'bx-calendar-event'],
                ['id' => 'financial_coordinator', 'label' => 'Financial Coordinators', 'icon' => 'bx-wallet'],
                ['id' => 'content_manager', 'label' => 'Content Managers', 'icon' => 'bx-edit-alt'],
            ];

            $currentTab = request()->query('tab', 'overview'); // fallback to overview
        @endphp
<x-navigation-layout.tabs-modern :tabs="$tabs" :default-tab="$currentTab">
    @if(Auth::user()->hasRole('Admin'))
        <x-slot name="slot_admin">
            @include('dashboard.adminDashboard', ['data' => $data['admin'] ?? []])
        </x-slot>
    @endif

    @if(Auth::user()->hasRole('Content Manager'))
        <x-slot name="slot_content_manager">
            @include('dashboard.cmDashboard', ['data' => $data['cm'] ?? []])
        </x-slot>
    @endif

    @if(Auth::user()->hasRole('Program Coordinator'))
        <x-slot name="slot_program_coordinator">
            @include('dashboard.pcDashboard', ['data' => $data['pc'] ?? []])
        </x-slot>
    @endif

    @if(Auth::user()->hasRole('Financial Coordinator'))
        <x-slot name="slot_financial_coordinator">
            @include('dashboard.fcDashboard', ['data' => $data['fc'] ?? []])
        </x-slot>
    @endif

    @if(Auth::user()->hasRole('Volunteer'))
        <x-slot name="slot_volunteer">
            @include('dashboard.volunteerDashboard', ['data' => $data['volunteer'] ?? []])
        </x-slot>
    @endif
</x-navigation-layout.tabs-modern>


    {{-- Profile Header --}}
    <div class="container mx-auto p-6">
        <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 shadow-lg rounded-2xl p-8 flex flex-col items-center text-white mb-10">
            <div class="relative mb-4">
                <img src="{{ Auth::user()->profile_pic ?? asset('assets/images/logo/YI_Logo.png') }}"
                     alt="Profile Picture"
                     class="w-28 h-28 rounded-full border-4 border-white shadow-md object-cover">
                <span class="absolute bottom-2 right-2 bg-green-400 border-2 border-white rounded-full w-5 h-5"></span>
            </div>
            <h2 class="text-2xl font-bold mb-1">{{ Auth::user()->name }}</h2>
            <p class="text-md opacity-90 mb-2 flex items-center">
                <i class='bx bx-envelope mr-2'></i>{{ Auth::user()->email }}
            </p>
            <div class="flex flex-wrap justify-center gap-2 mb-2">
                @forelse(Auth::user()->roles as $role)
                    <span class="bg-white bg-opacity-20 text-white text-xs font-semibold px-3 py-1 rounded-full border border-white flex items-center">
                        <i class='bx bx-user mr-1'></i>{{ $role->role_name }}
                    </span>
                @empty
                    <span class="text-white text-xs">No roles assigned.</span>
                @endforelse
            </div>
        </div>

        {{-- Get Involved Section --}}
        <div class="bg-gradient-to-r from-green-400 to-blue-500 rounded-2xl shadow-lg p-8 flex flex-col items-center text-white mb-10">
            <h3 class="text-xl font-semibold mb-2 flex items-center"><i class='bx bx-group mr-2'></i>Get Involved!</h3>
            <p class="mb-4 text-center">Become a volunteer and make a difference in your community. Join programs, contribute, and connect with others!</p>
            @if(Auth::user()->hasRole('Volunteer'))
                <a href="{{ route('programs.index') }}"
                   class="inline-block px-6 py-3 bg-white text-green-600 font-bold rounded-lg shadow hover:bg-gray-100 transition-colors">
                   View Your Programs
                </a>
            @else
                <a href="{{ route('volunteers.form') }}"
                   class="inline-block px-6 py-3 bg-white text-blue-600 font-bold rounded-lg shadow hover:bg-gray-100 transition-colors">
                   Become a Volunteer
                </a>
            @endif
        </div>
    </div>
@endsection
