@extends('layouts.sidebar_final')

@section('content')

    <head>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    </head>

    <div class="container mx-auto p-6">

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard Overview</h1>
            <p class="text-gray-600">Welcome back! Here's what's happening with your organization today.</p>
        </div>

        <div class="bg-white p-6 rounded-lg shadow-lg text-center w-full max-w-md mx-auto">
            <h1 class="text-2xl font-bold text-black">Hello, {{ Auth::user()->name }}!</h1>
            <p class="text-gray-600">{{ Auth::user()->email }}</p>

            <div class="mt-4">
                <h2 class="text-lg font-semibold text-gray-800">Your Roles:</h2>
                <div class="flex flex-wrap justify-center gap-2 mt-2">
                    @if(Auth::user()->roles->isNotEmpty())
                        @foreach(Auth::user()->roles as $role)
                            <span
                                class="bg-indigo-100 text-indigo-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-indigo-900 dark:text-indigo-300">{{ $role->role_name }}</span>
                        @endforeach
                    @else
                        <p class="text-gray-500">No roles assigned.</p>
                    @endif
                </div>
            </div>

            @if(Auth::user()->profile_pic)
                <img src="{{ Auth::user()->profile_pic }}" alt="Profile Picture" class="mt-4 w-24 h-24 rounded-full mx-auto">
            @endif


            <div>
                @if(Auth::user()->volunteer)
                    <a href="{{ route('volunteers.form') }}" class="hidden">Go to Volunteer Form</a>
                @else
                    <a href="{{ route('volunteers.form') }}">Go to Volunteer Form</a>
                @endif
            </div>

            <div class="mt-6">
                @if(Auth::user()->hasRole('Volunteer') && Auth::user()->volunteer)
                    <h2 class="text-xl font-semibold text-green-600">You are a Volunteer! 🎉</h2>
                    <p class="text-gray-600">You can now join programs and contribute!</p>

                    <a href="{{ route('programs.index') }}"
                        class="mt-4 inline-block px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                        View Your Programs
                    </a>
                @elseif(Auth::user()->hasRole('Volunteer') && !Auth::user()->volunteer)

                @endif
            </div>


            <form action="{{ route('logout') }}" method="POST" class="mt-6">
                @csrf
                <button type="submit" class="btn btn-error w-full">Logout</button>
            </form>
        </div>

        <x-header-with-button title="Any Title" description="Description that match with the shown content.">

        </x-header-with-button>


        <div class="mt-12">
            <div class="mb-6 flex gap-2 flex-wrap">
                <x-button variant="primary">Primary</x-button>
                <x-button variant="secondary">Secondary</x-button>
                <x-button variant="success">Success</x-button>
                <x-button variant="danger">Danger</x-button>
                <x-button variant="warning">Warning</x-button>
                <x-button variant="info">Info</x-button>
                <x-button variant="manage">Manage</x-button>
                <x-button variant="restore">Restore</x-button>
                <x-button variant="approve">Approve</x-button>
                <x-button variant="delete">Delete</x-button>
                <x-button variant="close">Close</x-button>
            </div>

            <div class="flex justify-between">
                <div class="mb-6 flex gap-2 flex-wrap">
                    <x-feedback-status.status-indicator status="success" />
                    <x-feedback-status.status-indicator status="info" />
                    <x-feedback-status.status-indicator status="warning" />
                    <x-feedback-status.status-indicator status="neutral" />
                    <x-feedback-status.status-indicator status="danger" />
                </div>
            </div>
        </div>

        <x-feedback-status.alert type="error" icon="bx bx-task" message="You cannot leave this program because you have assigned tasks." />
        <x-feedback-status.alert type="info" icon="bx bx-lock" message="You cannot leave this program because it is already done." />
        <x-feedback-status.alert type="success" icon="bx bx-check-circle" message="You are already joined in this program." />
        <x-feedback-status.alert type="warning" icon="bx bx-check-circle" message="You are already joined in this program." />
        <x-feedback-status.alert type="neutral" icon="bx bx-check-circle" message="You are already joined in this program." />

        {{-- Usage Examples --}}

{{-- Basic usage with variant --}}
<x-empty-state variant="no-volunteers" />

{{-- Custom title and description --}}
<x-empty-state 
    variant="no-tasks" 
    title="No Tasks Available"
    description="Create your first task to start managing your project."
/>

{{-- With action button --}}
<x-empty-state 
    variant="no-programs" 
    actionText="Create Program"
    actionUrl="{{ route('programs.create') }}"
    actionVariant="primary"
/>

{{-- Small size for compact spaces --}}
<x-empty-state 
    variant="no-data" 
    size="small"
/>

{{-- Large size for main content areas --}}
<x-empty-state 
    variant="no-images" 
    size="large"
    actionText="Upload Images"
    {{-- actionUrl="{{ route('images.upload') }}" --}}
/>

{{-- Custom icon and colors --}}
<x-empty-state 
    variant="custom"
    icon="bx bx-star"
    iconColor="text-yellow-500"
    bgColor="bg-yellow-50"
    title="No Favorites Yet"
    description="Items you favorite will appear here."
/>

{{-- Using slot for custom title --}}
<x-empty-state variant="no-feedback">
    No Customer Feedback
</x-empty-state>

{{-- Table empty state --}}
<x-empty-state 
    variant="empty-table"
    title="No Records in Database"
    description="This table will populate as data is added."
    size="small"
/>

{{-- Search results empty state --}}
<x-empty-state 
    variant="no-search"
    {{-- title="No matches found for '{{ $searchTerm }}'" --}}
    description="Try different keywords or check your spelling."
    actionText="Clear Search"
    {{-- actionUrl="{{ route('search.clear') }}" --}}
    actionVariant="outline"
/>

{{-- Loading state --}}
<x-empty-state variant="loading" />

{{-- Error state --}}
<x-empty-state 
    variant="error"
    title="Failed to Load Data"
    description="Please refresh the page or try again later."
    actionText="Retry"
    {{-- actionUrl="{{ request()->url() }}" --}}
    actionVariant="secondary"
/>

    </div>

    </div>
@endsection