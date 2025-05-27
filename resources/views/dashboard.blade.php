@extends('layouts.sidebar')

@section('content')

    <head>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
    </head>

    <div class="container mx-auto p-6">
        <h1 class="text-3xl font-bold text-[#1a2235] mb-6">Welcome to Your Dashboard</h1>

        <input type="checkbox" value="synthwave" class="toggle theme-controller" />

        <div class="bg-white p-6 rounded-lg shadow-lg text-center w-full max-w-md mx-auto">
            <h1 class="text-2xl font-bold text-black">Hello, {{ Auth::user()->name }}!</h1>
            <p class="text-gray-600">{{ Auth::user()->email }}</p>

            @if(Auth::user()->profile_pic)
                <img src="{{ Auth::user()->profile_pic }}" alt="Profile Picture" class="mt-4 w-24 h-24 rounded-full mx-auto">
            @endif


            <div>
                @if(Auth::user()->volunteer) <!-- Check if user has a volunteer record -->
                    <a href="{{ route('volunteers.form') }}" class="hidden">Go to Volunteer Form</a>
                @else
                    <a href="{{ route('volunteers.form') }}">Go to Volunteer Form</a>
                @endif
            </div>

            <div class="mt-6">
                @if(Auth::user()->hasRole('Volunteer') && Auth::user()->volunteer)
                    <!-- Check if user has volunteer role AND a volunteer record -->
                    <h2 class="text-xl font-semibold text-green-600">You are a Volunteer! 🎉</h2>
                    <p class="text-gray-600">You can now join programs and contribute!</p>

                    <a href="{{ route('programs.index') }}"
                        class="mt-4 inline-block px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
                        View Your Programs
                    </a>
                @elseif(Auth::user()->hasRole('Volunteer') && !Auth::user()->volunteer)

                @endif
            </div>


            <!-- Logout Button -->
            <form action="{{ route('logout') }}" method="POST" class="mt-6">
                @csrf
                <button type="submit" class="btn btn-error w-full">Logout</button>
            </form>
        </div>

        <x-header-with-button title="Contents"
            description="Manage and view your content. You can add new content or modify existing entries."
            buttonText="Add New" />

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

                <div class="mb-6 flex gap-2">
                    <x-status-indicator status="success" />
                    <x-status-indicator status="info" />
                    <x-status-indicator status="warning" />
                    <x-status-indicator status="neutral" />
                    <x-status-indicator status="danger" />

                    <x-status-indicator status="approved" />
                    <x-status-indicator status="denied" />
                    <x-status-indicator status="completed" />
                    <x-status-indicator status="in_progress" />
                    <x-status-indicator status="pending" />
                    <x-status-indicator status="archived" />
                    <x-status-indicator status="published" />
                    <x-status-indicator status="draft" />
                    <x-status-indicator status="news" />
                    <x-status-indicator status="program" />
                </div>
            </div>

        </div>

    </div>

    </div>
@endsection