<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youmanitarian International</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<header class="bg-white shadow-md fixed top-0 left-0 w-full z-50">
    <div class="container mx-auto px-6 py-4 flex items-center justify-between">
        <div class="flex items-center space-x-4">
            <img src="{{ asset('assets/images/logo/YI_Logo.png') }}" alt="Logo" class="h-14 sm:h-16 w-auto">
            <h1 class="text-base sm:text-lg font-bold text-gray-800 whitespace-nowrap">Youmanitarian International</h1>
        </div>

        <nav class="hidden lg:flex items-center space-x-6 text-base">
            <a href="{{ route('website.index') }}" class="text-gray-600 hover:text-blue-600">Home</a>
            <a href="{{ route('website.news') }}" class="text-gray-600 hover:text-blue-600">News</a>
            <a href="{{ route('website.programs') }}" class="text-gray-600 hover:text-blue-600">Program</a>
            <a href="{{ route('website.sponsors') }}" class="text-gray-600 hover:text-blue-600">Sponsor & Partnership</a>
            <a href="{{ route('website.about') }}" class="text-gray-600 hover:text-blue-600">About Us</a>
            <a href="{{ route('website.team') }}" class="text-gray-600 hover:text-blue-600">Meet the Team</a>

            <a href="{{ route('website.donate') }}" class="text-gray-600 hover:text-blue-600">Donate Today</a>
            
            @if(Auth::check())
                <a href="{{ url('/dashboard') }}" class="btn bg-[#101529] text-white border-[#101529] hover:bg-[#1a2235]">Dashboard</a>
                {{-- <a href="{{ route('logout') }}" class="btn btn-outline border-[#101529] text-[#101529] hover:bg-[#101529] hover:text-white"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    Logout
                </a>--}}
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            @else
                <a href="{{ url('/login') }}" class="btn bg-[#101529] text-white border-[#101529] hover:bg-[#1a2235]">Login</a>
                {{-- <a href="{{ url('/register') }}" class="btn btn-outline border-[#101529] text-[#101529] hover:bg-[#101529] hover:text-white">Register</a> --}}
            @endif
        </nav>
    </div>
</header>



</html>
@yield('content')




