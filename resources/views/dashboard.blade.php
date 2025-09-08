@extends('layouts.sidebar_final')

@section('content')
    <head>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>

    <div class="container mx-auto p-6">
        <!-- Profile Header -->
        <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 shadow-lg rounded-2xl p-8 flex flex-col items-center text-white mb-10">
            <div class="relative mb-4">
                <img src="{{ Auth::user()->profile_pic ?? asset('assets/images/logo/YI_Logo.png') }}" alt="Profile Picture" class="w-28 h-28 rounded-full border-4 border-white shadow-md object-cover">
                <span class="absolute bottom-2 right-2 bg-green-400 border-2 border-white rounded-full w-5 h-5"></span>
            </div>
            <h2 class="text-2xl font-bold mb-1">{{ Auth::user()->name }}</h2>
            <p class="text-md opacity-90 mb-2 flex items-center"><i class='bx bx-envelope mr-2'></i>{{ Auth::user()->email }}</p>
            <div class="flex flex-wrap justify-center gap-2 mb-2">
                @if(Auth::user()->roles->isNotEmpty())
                    @foreach(Auth::user()->roles as $role)
                        <span class="bg-white bg-opacity-20 text-white text-xs font-semibold px-3 py-1 rounded-full border border-white flex items-center"><i class='bx bx-user mr-1'></i>{{ $role->role_name }}</span>
                    @endforeach
                @else
                    <span class="text-white text-xs">No roles assigned.</span>
                @endif
            </div>
        </div>

        {{-- <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                <i class='bx bx-briefcase-alt-2 text-3xl text-indigo-500 mb-2'></i>
                <div class="text-2xl font-bold">--</div>
                <div class="text-gray-500">Programs Joined</div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                <i class='bx bx-task text-3xl text-green-500 mb-2'></i>
                <div class="text-2xl font-bold">--</div>
                <div class="text-gray-500">Tasks Assigned</div>
            </div>
            <div class="bg-white rounded-xl shadow p-6 flex flex-col items-center">
                <i class='bx bx-calendar-event text-3xl text-pink-500 mb-2'></i>
                <div class="text-2xl font-bold">--</div>
                <div class="text-gray-500">Upcoming Events</div>
            </div>
        </div> --}}

        <!-- Get Involved Section -->
        <div class="bg-gradient-to-r from-green-400 to-blue-500 rounded-2xl shadow-lg p-8 flex flex-col items-center text-white mb-10">
            <h3 class="text-xl font-semibold mb-2 flex items-center"><i class='bx bx-group mr-2'></i>Get Involved!</h3>
            <p class="mb-4 text-center">Become a volunteer and make a difference in your community. Join programs, contribute, and connect with others!</p>
            @if(Auth::user()->volunteer)
                <a href="{{ route('programs.index') }}" class="inline-block px-6 py-3 bg-white text-green-600 font-bold rounded-lg shadow hover:bg-gray-100 transition-colors">View Your Programs</a>
            @else
                <a href="{{ route('volunteers.form') }}" class="inline-block px-6 py-3 bg-white text-blue-600 font-bold rounded-lg shadow hover:bg-gray-100 transition-colors">Become a Volunteer</a>
            @endif
        </div>

        <!-- Recent Activity Placeholder -->
        {{-- <div class="bg-white rounded-2xl shadow p-8 mb-10">
            <h3 class="text-lg font-semibold mb-4 flex items-center"><i class='bx bx-bell mr-2 text-yellow-500'></i>Recent Activity</h3>
            <ul class="text-gray-600 space-y-2">
                <li class="flex items-center"><i class='bx bx-chevron-right mr-2'></i>Activity feed coming soon...</li>
            </ul>
        </div> --}}

        <!-- Logout Button -->
        <form action="{{ route('logout') }}" method="POST" class="mt-6 max-w-md mx-auto">
            @csrf
            <button type="submit" class="btn btn-error w-full">Logout</button>
        </form>
    </div>
@endsection
