<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#1a2235">
    <title>Dashboard</title>
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

</head>
<body class="flex bg-gray-50">

    <div class="w-64 min-h-screen bg-white text-white border-r border-gray-300 p-6">
        <h2 class="text-2xl font-bold mb-8 text-center text-[#ffb51b]">Youmanitarian</h2>

        <div class="flex items-center gap-3 mb-8">
            @if(Auth::user()->profile_pic)
                <img src="{{ Auth::user()->profile_pic }}" alt="Profile" class="w-12 h-12 rounded-full">
            @else
                <div class="w-12 h-12 bg-gray-700 rounded-full flex items-center justify-center">
                    <span class="text-xl text-white">{{ substr(Auth::user()->name, 0, 1) }}</span>
                </div>
            @endif
            <div>
                <p class="font-semibold text-[#1a2235]">{{ Auth::user()->name }}</p>
                <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
            </div>
        </div>

        <ul class="space-y-2 text-[#1a2235]">
            <li>
                <a href="{{ route('dashboard') }}" 
                    class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#ffb51b] hover:text-[#1a2235] transition-colors">
                    <i class='bx bxs-dashboard'></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('content.content_view') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#ffb51b] hover:text-[#1a2235] transition-colors">
                    <i class='bx bxs-book-content' ></i>
                    <span>Content</span>
                </a>
            </li>
            <li>
                <a href="{{ route('content_requests.requests_view') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#ffb51b] hover:text-[#1a2235] transition-colors">
                    <i class='bx bx-envelope'></i>
                    <span>Content Requests</span>
                </a>
            </li>
            <li>
                <a href="{{ route('programs.index') }}" 
                   class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#ffb51b] hover:text-[#1a2235] transition-colors">
                    <i class='bx bx-list-ul text-xl'></i>
                    <span>Programs</span>
                </a>
            </li>
            {{-- <li>
                <a href="{{ route('volunteers.requests') }}" 
                   class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#ffb51b] hover:text-[#1a2235] transition-colors">
                    <i class='bx bx-user-check text-xl'></i>
                    <span>Volunteer Requests</span>
                </a>
            </li> --}}

            <li>
                <a href="{{ route('weather-forecast.index') }}" 
                   class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#ffb51b] hover:text-[#1a2235] transition-colors">
                   <i class='bx bx-leaf'></i>
                    <span>Weather Forecasts</span>
                </a>
            </li>
            <li>
                <a href="{{ route('chatbot.index') }}" 
                   class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#ffb51b] hover:text-[#1a2235] transition-colors">
                   <i class='bx bx-bot'></i>
                    <span>Chatbot</span>
                </a>
            </li>
            <li>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="flex items-center gap-3 w-full text-left px-4 py-2 rounded-lg hover:bg-red-600 hover:text-white transition-colors">
                        <i class='bx bx-log-out text-xl'></i>
                        <span>Logout</span>
                    </button>
                </form>
            </li>
        </ul>
        
    </div>

    <!-- Main Content -->
    <div class="flex-1 p-8 bg-gray-50">
        @yield('content')
    </div>

    
</body>
</html>
