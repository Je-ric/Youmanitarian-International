@extends('layouts.sidebar_final')

@php
    use Carbon\Carbon;
@endphp

@section('content')
    @if (session('toast'))
        <x-toast :message="session('toast')['message']" :type="session('toast')['type']" />
    @endif

    <div x-data="{ 
        activeTab: new URLSearchParams(window.location.search).get('tab') || 'all',
        setTab(tab) {
            this.activeTab = tab;
            const url = new URL(window.location);
            url.searchParams.set('tab', tab);
            window.history.pushState({}, '', url);
        },
        openModal(id) {
            document.getElementById('modal_' + id).showModal();
        }
    }" class="mx-auto px-2 sm:px-4 md:px-6 py-4 sm:py-6">
        <div class="mb-4 sm:mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h1 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">
                        Programs
                    </h1>
                    <p class="text-gray-600">View and manage all programs.</p>
                </div>
                
                @if(Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Admin'))
                    <div class="flex gap-3 w-full lg:w-auto">
                        <x-button href="{{ route('programs.create') }}" variant="primary">
                            <i class='bx bx-plus-circle mr-2'></i> Create Program
                        </x-button>
                    </div>
                @endif
            </div>
        </div>

        <!-- Responsive Tab Navigation -->
        <div class="mb-4 sm:mb-8 overflow-x-auto pb-2 sm:pb-0">
            <div class="bg-gray-50 p-1 rounded-lg inline-flex space-x-1 min-w-max">
                <button @click="setTab('all')" 
                    :class="activeTab === 'all' ? 'bg-white text-[#1a2235] border border-gray-200 shadow-sm' : 'text-gray-600 hover:text-[#1a2235]'"
                    class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap flex items-center">
                    <i class='bx bx-list-ul text-lg sm:mr-1'></i>
                    <span class="hidden sm:inline">All Programs</span>
                </button>

                @if(Auth::user()->hasRole('Volunteer'))
                    <button @click="setTab('joined')" 
                        :class="activeTab === 'joined' ? 'bg-white text-[#1a2235] border border-gray-200 shadow-sm' : 'text-gray-600 hover:text-[#1a2235]'"
                        class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap flex items-center">
                        <i class='bx bx-user-check text-lg sm:mr-1'></i>
                        <span class="hidden sm:inline">Joined Programs</span>
                    </button>
                @endif

                @if(Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Admin'))
                    <button @click="setTab('my')" 
                        :class="activeTab === 'my' ? 'bg-white text-[#1a2235] border border-gray-200 shadow-sm' : 'text-gray-600 hover:text-[#1a2235]'"
                        class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap flex items-center">
                        <i class='bx bx-cog text-lg sm:mr-1'></i>
                        <span class="hidden sm:inline">My Programs</span>
                    </button>
                @endif
            </div>
        </div>

        <!-- Tab Content with Smooth Transitions -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
            <!-- All Programs Tab -->
            <div x-show="activeTab === 'all'" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="space-y-4">
                @include('programs.partials.programs-table', ['programs' => $allPrograms])
            </div>

            <!-- Joined Programs Tab -->
            @if(Auth::user()->hasRole('Volunteer'))
                <div x-show="activeTab === 'joined'" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    class="space-y-4">
                    @include('programs.partials.programs-table', ['programs' => $joinedPrograms])
                </div>
            @endif

            <!-- My Programs Tab -->
            @if(Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Admin'))
                <div x-show="activeTab === 'my'" 
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                    class="space-y-4">
                    @include('programs.partials.programs-table', ['programs' => $myPrograms])
                </div>
            @endif
        </div>

        <!-- Modals Container -->
        <div>
            @foreach($allPrograms as $program)
                @include('programs.modals.program-modal', ['program' => $program])
            @endforeach
            @if(Auth::user()->hasRole('Volunteer'))
                @foreach($joinedPrograms as $program)
                    @include('programs.modals.program-modal', ['program' => $program])
                @endforeach
            @endif
            @if(Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Admin'))
                @foreach($myPrograms as $program)
                    @include('programs.modals.program-modal', ['program' => $program])
                @endforeach
            @endif
        </div>
    </div>

    <script>
        // Preserve tab state on page reload
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    const activeTab = Alpine.store ? Alpine.store.activeTab : 'all';
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