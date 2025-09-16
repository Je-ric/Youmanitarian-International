<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youmanitarian International</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body class="bg-gray-50">
    @if (session('toast'))
        <x-feedback-status.toast :message="session('toast')['message']" :type="session('toast')['type']" />
    @endif

    {{-- Header / Navbar --}}
    <header class="bg-white shadow-md fixed top-0 left-0 w-full z-50 h-20">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            {{-- Logo --}}
            <div class="flex items-center space-x-3">
                <img src="{{ asset('assets/images/logo/YI_Logo.png') }}" alt="Logo" class="h-12 sm:h-14 w-auto">
                <h1 class="text-sm sm:text-base lg:text-lg font-bold text-gray-800 whitespace-nowrap">
                    Youmanitarian International
                </h1>
            </div>

            {{-- Desktop Nav --}}
            <nav class="hidden lg:flex items-center space-x-6 text-base">
                <a href="{{ route('website.index') }}"
                    class="text-primary-custom hover:text-accent-custom transition-colors duration-300
                    {{ request()->routeIs('website.index') ? 'text-[#ffb51b] font-bold' : '' }}">
                    Home
                </a>
                <a href="{{ route('website.programs') }}"
                    class="text-primary-custom hover:text-accent-custom transition-colors duration-300
                    {{ request()->routeIs('website.programs') ? 'text-[#ffb51b] font-bold' : '' }}">
                    Programs
                </a>
                <a href="{{ route('website.sponsors') }}"
                    class="text-primary-custom hover:text-accent-custom transition-colors duration-300
                    {{ request()->routeIs('website.sponsors') ? 'text-[#ffb51b] font-bold' : '' }}">
                    Sponsor & Partnership
                </a>
                <a href="{{ route('website.about') }}"
                    class="text-primary-custom hover:text-accent-custom transition-colors duration-300
                    {{ request()->routeIs('website.about') ? 'text-[#ffb51b] font-bold' : '' }}">
                    About Us
                </a>
                <a href="{{ route('website.team') }}"
                    class="text-primary-custom hover:text-accent-custom transition-colors duration-300
                    {{ request()->routeIs('website.team') ? 'text-[#ffb51b] font-bold' : '' }}">
                    Meet the Team
                </a>
                <a href="{{ route('website.donate') }}"
                    class="text-primary-custom hover:text-accent-custom transition-colors duration-300
                    {{ request()->routeIs('website.donate') ? 'text-[#ffb51b] font-bold' : '' }}">
                    Donate Today
                </a>

                @if (Auth::check())
                    <a href="{{ url('/dashboard') }}"
                        class="btn bg-[#101529] text-white border-[#101529] hover:bg-[#1a2235]">Dashboard</a>
                @else
                    <a href="{{ url('/login') }}"
                        class="btn bg-[#101529] text-white border-[#101529] hover:bg-[#1a2235]">Login</a>
                @endif
            </nav>

            {{-- Mobile Hamburger --}}
            <div class="lg:hidden" x-data="{ open: false }">
                <button @click="open = !open" class="text-gray-700 text-3xl focus:outline-none">
                    <i class="bx bx-menu"></i>
                </button>

                <div x-show="open" x-transition class="absolute top-16 left-0 w-full bg-white shadow-lg border-t z-20">
                    <nav class="flex flex-col p-4 space-y-3 text-base">
                        <a href="{{ route('website.index') }}" class="text-gray-600 hover:text-[#ffb51b]">Home</a>
                        <a href="{{ route('website.programs') }}" class="text-gray-600 hover:text-[#ffb51b]">Programs</a>
                        <a href="{{ route('website.sponsors') }}" class="text-gray-600 hover:text-[#ffb51b]">Sponsor & Partnership</a>
                        <a href="{{ route('website.about') }}" class="text-gray-600 hover:text-[#ffb51b]">About Us</a>
                        <a href="{{ route('website.team') }}" class="text-gray-600 hover:text-[#ffb51b]">Meet the Team</a>
                        <a href="{{ route('website.donate') }}" class="text-gray-600 hover:text-[#ffb51b]">Donate Today</a>

                        @if (Auth::check())
                            <a href="{{ url('/dashboard') }}" class="btn bg-[#101529] text-white border-[#101529] hover:bg-[#1a2235]">Dashboard</a>
                        @else
                            <a href="{{ url('/login') }}" class="btn bg-[#101529] text-white border-[#101529] hover:bg-[#1a2235]">Login</a>
                        @endif
                    </nav>
                </div>
            </div>
        </div>
    </header>

    {{-- Main Content --}}
    <main class="pt-20">
        @yield('content')
    </main>


    @include('website.partials.footer')
</body>

</html>
