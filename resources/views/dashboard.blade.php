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
            @if(Auth::user()->hasRole('Volunteer') && Auth::user()->volunteer) <!-- Check if user has volunteer role AND a volunteer record -->
                <h2 class="text-xl font-semibold text-green-600">You are a Volunteer! 🎉</h2>
                <p class="text-gray-600">You can now join programs and contribute!</p>
        
                <a href="{{ route('programs.index') }}" class="mt-4 inline-block px-6 py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors">
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

    <div class="mt-12">
        <div class="mb-6 flex gap-2">
            <x-button variant="primary">Primary #ffb51b</x-button>
            <x-button variant="secondary">Secondary #1a2235</x-button>
            <x-button variant="success">Delete</x-button>
            <x-button variant="danger">Delete</x-button>
            <x-button variant="warning">Update</x-button>
            <x-button variant="info">Edit</x-button>
            <x-button variant="close">Close</x-button>
            <x-button variant="delete">Delete</x-button>
        </div>
    
       <div class="flex justify-between">
            <div class="mb-6 flex gap-2">
                <x-status-indicator status="success" variant="solid" /> 
                <x-status-indicator status="info" variant="solid" />
                <x-status-indicator status="warning" variant="solid" />
                <x-status-indicator status="neutral" variant="solid" />
                <x-status-indicator status="danger" variant="solid" />
                <x-status-indicator status="news" variant="solid" />
                <x-status-indicator status="program" variant="solid" />
            </div>
            
            <div class="mb-6 flex gap-2">
                <x-status-indicator status="success" variant="outline" />
                <x-status-indicator status="info" variant="outline" />
                <x-status-indicator status="warning" variant="outline" />
                <x-status-indicator status="neutral" variant="outline" />
                <x-status-indicator status="danger" variant="outline" />
                <x-status-indicator status="news" variant="outline" />
                <x-status-indicator status="program" variant="outline" />
            </div>
       </div>
        
       
        

    </div>

</div>

</div>
@endsection
