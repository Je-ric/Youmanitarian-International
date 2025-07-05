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

        <x-overview.card title="Welcome, {{ Auth::user()->name }}!" icon="bx-user" variant="elevated" class="text-center w-full max-w-md mx-auto">
            <p class="text-gray-600 mb-4">{{ Auth::user()->email }}</p>

            <div class="mb-4">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Your Roles:</h2>
                <div class="flex flex-wrap justify-center gap-2">
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
        </x-overview.card>




    </div>

@endsection