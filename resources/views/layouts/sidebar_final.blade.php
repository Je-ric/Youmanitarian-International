<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>Professional Sidebar Component</title> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/editors.css'])
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/3.0.0/uicons-regular-straight/css/uicons-regular-straight.css'>
    <link rel='stylesheet'
        href='https://cdn-uicons.flaticon.com/3.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'primary': '#1a2235',
                        'accent': '#ffb51b',
                        'sidebar-bg': '#f8fafc',
                        'hover-bg': '#f1f5f9',
                        'active-bg-light': '#FEF0E7',
                        'text-default': '#334155',
                        'active-text': '#1f2937', /* Dark grey for active text and icon */
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 font-sans">
    <!-- Sidebar Overlay (Mobile) -->
    <div id="sidebarOverlay"
        class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden transition-opacity duration-300"
        aria-hidden="true"></div>

    <!-- Sidebar -->
    <aside id="sidebar"
        class="fixed top-0 left-0 z-50 h-screen transition-all duration-300 ease-in-out transform -translate-x-full lg:translate-x-0 bg-sidebar-bg border-r border-gray-200 shadow-lg sidebar-expanded"
        aria-label="Sidebar">
        <!-- Fixed Header -->
        <div class="sticky top-0 z-10 bg-sidebar-bg border-b border-gray-200">
            <div class="flex flex-col items-center p-4">
                <img src="{{ asset('assets/images/logo/YI_Logo.png') }}" alt="Company Logo"
                    class="w-16 h-16 object-contain mb-2">
            </div>
        </div>

        <!-- Scrollable Content -->
        <div class="h-[calc(100vh-6rem)] overflow-y-auto custom-scrollbar">
            <div class="px-5 py-4">
                <!-- Overview Section -->
                <div class="mb-6">
                    <h3 class="flex items-center text-sm font-medium text-gray-500 mb-2">
                        <span class="sidebar-content">Overview</span>
                        <span
                            class="flex-grow border-t border-gray-200 ml-3 sidebar-content sidebar-content-line"></span>
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('dashboard') }}"
                                class="sidebar-link flex items-center py-2.5 px-3 rounded-lg transition-colors duration-200 group sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                data-tooltip="Dashboard">
                                <i class="bx bxs-dashboard w-5 text-center flex-shrink-0"></i>
                                <span class="ml-3 sidebar-content text-sm">Dashboard</span>
                                <i class="bx bx-chevron-down ml-auto text-gray-400 sidebar-content"></i>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Content Management Section -->
                <div class="mb-6">
                    <h3 class="flex items-center text-sm font-medium text-gray-500 mb-2">
                        <span class="sidebar-content">Content Management</span>
                        <span
                            class="flex-grow border-t border-gray-200 ml-3 sidebar-content sidebar-content-line"></span>
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('content.content_view') }}"
                                class="sidebar-link flex items-center py-2.5 px-3 rounded-lg transition-colors duration-200 group sidebar-item {{ request()->routeIs('content.*') ? 'active' : '' }}"
                                data-tooltip="Contents">
                                <i class="bx bx-file w-5 text-center flex-shrink-0"></i>
                                <span class="ml-3 sidebar-content text-sm">Contents</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('programs.index') }}"
                                class="sidebar-link flex items-center py-2.5 px-3 rounded-lg transition-colors duration-200 group sidebar-item {{ request()->routeIs('programs.*') ? 'active' : '' }}"
                                data-tooltip="Programs">
                                <i class="bx bx-calendar w-5 text-center flex-shrink-0"></i>
                                <span class="ml-3 sidebar-content text-sm">Programs</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('program.chats.index', ['program' => request()->route('program')]) }}"
                                class="sidebar-link flex items-center py-2.5 px-3 rounded-lg transition-colors duration-200 group sidebar-item {{ request()->routeIs('program.chats.*') ? 'active' : '' }}"
                                data-tooltip="Program Chats">
                                <i class="bx bx-message-square-dots w-5 text-center flex-shrink-0"></i>
                                <span class="ml-3 sidebar-content text-sm">Program Chats</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('content_requests.requests_view') }}"
                                class="sidebar-link flex items-center py-2.5 px-3 rounded-lg transition-colors duration-200 group sidebar-item {{ request()->routeIs('content_requests.*') ? 'active' : '' }}"
                                data-tooltip="Content Requests">
                                <i class="bx bx-clipboard w-5 text-center flex-shrink-0"></i>
                                <span class="ml-3 sidebar-content text-sm">Content Requests</span>
                                {{-- <span
                                    class="inline-flex items-center justify-center w-3 h-3 p-3 ml-auto text-sm font-medium text-red-800 bg-red-100 rounded-full sidebar-content">5</span>
                                --}}
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- User Management Section -->
                <div class="mb-6">
                    <h3 class="flex items-center text-sm font-medium text-gray-500 mb-2">
                        <span class="sidebar-content">User Management</span>
                        <span
                            class="flex-grow border-t border-gray-200 ml-3 sidebar-content sidebar-content-line"></span>
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('volunteers.index') }}"
                                class="sidebar-link flex items-center py-2.5 px-3 rounded-lg transition-colors duration-200 group sidebar-item {{ request()->routeIs('volunteers.*') ? 'active' : '' }}"
                                data-tooltip="Volunteers">
                                <i class="bx bx-group w-5 text-center flex-shrink-0"></i>
                                <span class="ml-3 sidebar-content text-sm">Volunteers</span>
                                <span
                                    class="inline-flex items-center justify-center w-3 h-3 p-3 ml-auto text-sm font-medium text-orange-800 bg-orange-100 rounded-full sidebar-content">12</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('members.index') }}"
                                class="sidebar-link flex items-center py-2.5 px-3 rounded-lg transition-colors duration-200 group sidebar-item"
                                data-tooltip="Members">
                                <i class="bx bx-group w-5 text-center flex-shrink-0"></i>
                                <span class="ml-3 sidebar-content text-sm">Members</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('roles.index') }}"
                                class="sidebar-link flex items-center py-2.5 px-3 rounded-lg transition-colors duration-200 group sidebar-item {{ request()->routeIs('roles.*') ? 'active' : '' }}"
                                data-tooltip="Assign Roles">
                                <i class="bx bx-user-plus w-5 text-center flex-shrink-0"></i>
                                <span class="ml-3 sidebar-content text-sm">Assign Roles</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Financial Section -->
                <div class="mb-6">
                    <h3 class="flex items-center text-sm font-medium text-gray-500 mb-2">
                        <span class="sidebar-content">Financial</span>
                        <span
                            class="flex-grow border-t border-gray-200 ml-3 sidebar-content sidebar-content-line"></span>
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('finance.index') }}"
                                class="sidebar-link flex items-center py-2.5 px-3 rounded-lg transition-colors duration-200 group sidebar-item {{ request()->routeIs('finance.index') ? 'active' : '' }}"
                                data-tooltip="Finance Dashboard">
                                <i class="bx bx-line-chart w-5 text-center flex-shrink-0"></i>
                                <span class="ml-3 sidebar-content text-sm">Finance Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('finance.donations') }}"
                                class="sidebar-link flex items-center py-2.5 px-3 rounded-lg transition-colors duration-200 group sidebar-item {{ request()->routeIs('finance.donations') ? 'active' : '' }}"
                                data-tooltip="Donations">
                                <i class="bx bx-heart w-5 text-center flex-shrink-0"></i>
                                <span class="ml-3 sidebar-content text-sm">Donations</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('finance.membership.payments') }}"
                                class="sidebar-link flex items-center py-2.5 px-3 rounded-lg transition-colors duration-200 group sidebar-item {{ request()->routeIs('finance.membership.payments*') ? 'active' : '' }}"
                                data-tooltip="Membership Payments">
                                <i class="bx bx-credit-card w-5 text-center flex-shrink-0"></i>
                                <span class="ml-3 sidebar-content text-sm">Membership</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Tools Section -->
                <div class="mb-6">
                    <h3 class="flex items-center text-sm font-medium text-gray-500 mb-2">
                        <span class="sidebar-content">Tools</span>
                        <span
                            class="flex-grow border-t border-gray-200 ml-3 sidebar-content sidebar-content-line"></span>
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('weather-forecast.index') }}"
                                class="sidebar-link flex items-center py-2.5 px-3 rounded-lg transition-colors duration-200 group sidebar-item {{ request()->routeIs('weather-forecast.index') ? 'active' : '' }}"
                                data-tooltip="Weather Forecasts">
                                <i class="bx bx-cloud w-5 text-center flex-shrink-0"></i>
                                <span class="ml-3 sidebar-content text-sm">Weather Forecasts</span>
                            </a>
                        </li>
                        {{-- <li>
                            <a href="{{ route('chatbot.index') }}"
                                class="sidebar-link flex items-center py-2.5 px-3 rounded-lg transition-colors duration-200 group sidebar-item {{ request()->routeIs('chatbot.index') ? 'active' : '' }}"
                                data-tooltip="Chatbot">
                                <i class='bx bx-bot w-5 text-center flex-shrink-0'></i>
                                <span class="ml-3 sidebar-content text-sm">Chatbot</span>
                            </a>
                        </li> --}}
                        @if (config('app.env') == 'local')
                            <li>
                                <a href="{{ route('components.showcase') }}"
                                    class="sidebar-link flex items-center py-2.5 px-3 rounded-lg transition-colors duration-200 group sidebar-item {{ request()->routeIs('components.showcase') ? 'active' : '' }}"
                                    data-tooltip="Component Showcase">
                                    <i class='bx bx-category w-5 text-center flex-shrink-0'></i>
                                    <span class="ml-3 sidebar-content text-sm">Component Showcase</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>

                <!-- Settings Section -->
                <div class="mb-6">
                    <h3 class="flex items-center text-sm font-medium text-gray-500 mb-2">
                        <span class="sidebar-content">Settings</span>
                        <span
                            class="flex-grow border-t border-gray-200 ml-3 sidebar-content sidebar-content-line"></span>
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="#"
                                class="sidebar-link flex items-center py-2.5 px-3 rounded-lg transition-colors duration-200 group sidebar-item"
                                data-tooltip="Settings">
                                <i class="bx bx-cog w-5 text-center flex-shrink-0"></i>
                                <span class="ml-3 sidebar-content text-sm">Settings</span>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="sidebar-link flex items-center py-2.5 px-3 rounded-lg transition-colors duration-200 group sidebar-item"
                                data-tooltip="Help & Support">
                                <i class="bx bx-help-circle w-5 text-center flex-shrink-0"></i>
                                <span class="ml-3 sidebar-content text-sm">Help & Support</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Fixed Logout Button -->
        <div class="absolute bottom-0 left-0 right-0 bg-sidebar-bg border-t border-gray-200 p-3">
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit"
                    class="sidebar-link flex items-center py-2.5 px-3 rounded-lg transition-colors duration-200 group sidebar-item w-full text-left text-red-500 logout-link"
                    data-tooltip="Sign Out">
                    <i class="bx bx-log-out text-red-500 w-5 text-center flex-shrink-0"></i>
                    <span class="ml-3 sidebar-content text-sm">Sign Out</span>
                </button>
            </form>
        </div>
    </aside>

    <!-- Navbar -->
    <nav id="navbar"
        class="bg-white shadow-lg border-b border-gray-200 fixed top-0 right-0 z-40 transition-all duration-300 ease-in-out overflow-x-hidden">
        <div class="navbar-container w-full mx-auto px-4 sm:px-6 lg:px-8 transition-all duration-300 ease-in-out">
            <div class="flex justify-between items-center h-16 w-full">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <button id="sidebarToggle"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-colors duration-200"
                            aria-label="Toggle sidebar" aria-expanded="false">
                            <svg class="h-6 w-6 transition-transform duration-200" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" id="hamburgerIcon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg class="h-6 w-6 hidden transition-transform duration-200" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" id="closeIcon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>

                        <div class="flex items-center space-x-4">
                            <!-- Search Bar (Desktop) -->
                            <div class="hidden lg:block relative">
                                <input type="text" placeholder="Search..."
                                    class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent text-sm w-64">
                                <i
                                    class="bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>

                            <!-- Navbar Links (Desktop) -->
                            <a href="#"
                                class="hidden lg:block text-gray-600 hover:text-primary transition-colors duration-200 text-sm">Website</a>
                            <a href="#"
                                class="hidden lg:block text-gray-600 hover:text-primary transition-colors duration-200 text-sm">Weather</a>
                        </div>
                    </div>
                </div>

                <!-- Right side  -->
                <div class="flex items-center space-x-3 flex-wrap max-w-full">

                    <button
                        class="sm:hidden p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                        <i class="fas fa-search text-lg"></i>
                    </button>

                    <a href="{{ route('notifications.index') }}"
                        class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors duration-200 relative">
                        <i class="fas fa-bell text-lg"></i>
                        @if(Auth::check() && Auth::user()->unreadNotifications->count() > 0)
                            <span
                                class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>

                    <div class="relative">
                        <button
                            class="flex items-center space-x-2 p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                            @if(Auth::user()->profile_pic)
                                <img src="{{ Auth::user()->profile_pic }}" alt="Profile"
                                    class="h-8 w-8 rounded-full object-cover">
                            @else
                                <div
                                    class="h-8 w-8 bg-primary rounded-full flex items-center justify-center text-white text-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <span
                                class="hidden lg:block text-sm font-medium max-w-24 truncate">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs hidden lg:block"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div id="mainContent" class="main-content pt-16">
        <div class="container mx-auto px-4 py-4">
            <x-navigation-layout.breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ...(request()->routeIs('content.*') ? [
            ['label' => 'Content Management', 'url' => route('content.content_view')],
            ...(request()->routeIs('content.create') ? [['label' => 'Create Content']] : []),
            ...(request()->routeIs('content.edit') ? [['label' => 'Edit Content']] : []),
        ] : []),
        ...(request()->routeIs('programs.*') ? [
            ['label' => 'Programs', 'url' => route('programs.index')],
            ...(request()->routeIs('programs.create') ? [['label' => 'Create Program']] : []),
            ...(request()->routeIs('programs.edit') ? [['label' => 'Edit Program']] : []),
            ...(request()->routeIs('programs.view') ? [['label' => 'Attendance']] : []),
            ...(request()->routeIs('programs.manage_volunteers') ? [['label' => 'Manage Program & Volunteers']] : []),            
        ] : []),
        ...(request()->routeIs('volunteers.*') ? [
            ['label' => 'Volunteers', 'url' => route('volunteers.index')],
        ] : []),
        ...(request()->routeIs('roles.*') ? [
            ['label' => 'Role Management', 'url' => route('roles.index')],
        ] : []),
        ...(request()->routeIs('finance.*') ? [
            ['label' => 'Finance', 'url' => route('finance.index')],
            ...(request()->routeIs('finance.donations') ? [['label' => 'Donations']] : []),
            ...(request()->routeIs('finance.membership.payments') ? [['label' => 'Membership Payments']] : []),
            ...(request()->routeIs('members.index*') ? [['label' => 'Members']] : []),
        ] : []),
    ]" />
        </div>

        @if (session('toast'))
            <x-feedback-status.toast :message="session('toast')['message']" :type="session('toast')['type']" />
        @endif
        
        @yield('content')
    </div>

    <!-- Tooltip -->
    <div id="tooltip"
        class="absolute bg-gray-900 text-white text-sm rounded py-1 px-2 z-50 opacity-0 pointer-events-none transition-opacity duration-200">
    </div>

    <style>
        /* Custom colors */
        :root {
            --primary-color: #1a2235;
            --accent-color: #ffb51b;
        }

        /* Sidebar states */
        .sidebar-expanded {
            width: 16rem;
        }

        .sidebar-collapsed {
            width: 5rem;
            /* 4 */
        }

        .sidebar-collapsed .sidebar-content {
            opacity: 0;
            visibility: hidden;
            width: 0;
            margin: 0 !important;
            padding: 0 !important;
            overflow: hidden;
            white-space: nowrap;
            transition: opacity 0.2s ease-in-out, width 0.2s ease-in-out, margin 0.2s ease-in-out, padding 0.2s ease-in-out;
        }

        /* Add divider for collapsed state */
        .sidebar-collapsed .mb-6 {
            position: relative;
            margin-bottom: 1.5rem !important;
        }

        .sidebar-collapsed .mb-6::after {
            content: '';
            position: absolute;
            bottom: -0.75rem;
            left: 0.75rem;
            right: 0.75rem;
            height: 1px;
            background-color: #e2e8f0;
            display: block;
        }

        /* Hide group headers in collapsed state */
        .sidebar-collapsed h3 {
            display: none;
        }

        /* Adjust spacing for collapsed state */
        .sidebar-collapsed .sidebar-item {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
            justify-content: center;
        }

        /* Navbar adjustments */
        #navbar {
            transition: all 0.3s ease-in-out;
            left: 16rem;
            width: calc(100% - 16rem);
        }

        .navbar-collapsed {
            left: 4rem !important;
            width: calc(100% - 4rem) !important;
        }

        /* Main content adjustments */
        .main-content {
            /* margin-left: 16rem; */
            transition: margin-left 0.3s ease-in-out;
        }

        @media (min-width: 1024px) {
            .main-content {
                margin-left: 16rem;
            }

            .content-collapsed {
                margin-left: 4rem;
            }
        }

        @media (max-width: 1023px) {
            .main-content {
                margin-left: 0;
            }
        }

        /* Custom scrollbar */
        .custom-scrollbar {
            height: calc(100vh - 10rem) !important;
            overflow-y: auto;
            scrollbar-width: thin;
            scrollbar-color: #cbd5e1 transparent;
            -ms-overflow-style: none;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
            border: 2px solid transparent;
            background-clip: padding-box;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
            border: 2px solid transparent;
            background-clip: padding-box;
        }

        /* Ensure scrollbar is always visible */
        .custom-scrollbar:hover::-webkit-scrollbar-thumb {
            background: #94a3b8;
        }

        /* Sidebar link styles */
        .sidebar-link {
            color: var(--text-default);
            position: relative;
            font-weight: 400;
        }

        .sidebar-link i {
            width: 1.5rem !important;
            /* Fixed width for icons */
            margin: 0 0.5rem;
            /* Add margin around icons */
        }

        .sidebar-link:hover {
            background-color: theme('colors.gray.100');
            color: var(--text-default);
        }

        .sidebar-link:hover i {
            color: var(--text-default) !important;
        }

        .sidebar-link.active {
            background-color: var(--active-bg-light);
            color: var(--active-text);
            font-weight: 600;
            border-radius: 0.375rem;
            /* Equivalent to rounded-md */
        }

        .sidebar-link.active i {
            color: var(--active-text) !important;
        }

        .sidebar-link.logout-link:hover {
            background-color: theme('colors.gray.100');
            color: theme('colors.red.500');
            /* Keep text red on hover */
        }

        .sidebar-link.logout-link:hover i {
            color: theme('colors.red.500') !important;
            /* Keep icon red on hover */
        }

        /* Responsive adjustments */
        @media (max-width: 1023px) {
            #navbar {
                left: 0 !important;
                width: 100% !important;
            }

            .navbar-expanded,
            .navbar-collapsed,
            .content-expanded,
            .content-collapsed {
                margin-left: 0;
            }
        }

        /* Smooth transitions */
        .sidebar-item {
            transition: all 0.2s ease-in-out;
        }

        .main-content {
            transition: margin-left 0.3s ease-in-out;
        }
    </style>

    <script>
        class SidebarManager {
            constructor() {
                this.sidebar = document.getElementById('sidebar');
                this.navbar = document.getElementById('navbar');
                this.mainContent = document.getElementById('mainContent');
                this.overlay = document.getElementById('sidebarOverlay');
                this.sidebarToggle = document.getElementById('sidebarToggle');
                this.hamburgerIcon = document.getElementById('hamburgerIcon');
                this.closeIcon = document.getElementById('closeIcon');
                this.tooltip = document.getElementById('tooltip');

                this.isOpen = false;
                this.isCollapsed = false;
                this.isDesktop = window.innerWidth >= 1024;

                // Set initial state immediately
                this.handleResize();
                this.updateLayout();

                this.init();
            }

            init() {
                // Event listeners
                this.sidebarToggle.addEventListener('click', () => this.handleToggle());
                this.overlay.addEventListener('click', () => this.closeMobile());

                // Handle window resize
                window.addEventListener('resize', () => this.handleResize());

                // Handle escape key
                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && this.isOpen && !this.isDesktop) {
                        this.closeMobile();
                    }
                });

                // Initialize tooltips
                this.initTooltips();
            }

            handleToggle() {
                if (this.isDesktop) {
                    this.isCollapsed = !this.isCollapsed;
                    this.updateSidebarState();
                    this.updateLayout();
                } else {
                    this.toggleMobile();
                }
            }

            updateSidebarState() {
                if (this.isCollapsed) {
                    this.sidebar.classList.remove('sidebar-expanded');
                    this.sidebar.classList.add('sidebar-collapsed');
                } else {
                    this.sidebar.classList.remove('sidebar-collapsed');
                    this.sidebar.classList.add('sidebar-expanded');
                }
            }

            updateLayout() {
                if (!this.isDesktop) return;

                if (this.isCollapsed) {
                    this.navbar.classList.add('navbar-collapsed');
                    this.mainContent.classList.add('content-collapsed');
                } else {
                    this.navbar.classList.remove('navbar-collapsed');
                    this.mainContent.classList.remove('content-collapsed');
                }
            }

            handleResize() {
                const wasDesktop = this.isDesktop;
                this.isDesktop = window.innerWidth >= 1024;

                if (this.isDesktop && !wasDesktop) {
                    this.closeMobile();
                    this.sidebar.classList.remove('-translate-x-full');
                    this.sidebar.classList.add('translate-x-0');
                    this.isOpen = true;
                    this.updateLayout();
                } else if (!this.isDesktop && wasDesktop) {
                    this.sidebar.classList.add('-translate-x-full');
                    this.sidebar.classList.remove('translate-x-0');
                    this.isOpen = false;
                    this.isCollapsed = false;
                    this.updateSidebarState();
                    this.navbar.classList.remove('navbar-expanded', 'navbar-collapsed');
                    this.mainContent.classList.remove('content-expanded', 'content-collapsed');
                }
            }

            toggleMobile() {
                if (this.isOpen) {
                    this.closeMobile();
                } else {
                    this.openMobile();
                }
            }

            openMobile() {
                this.isOpen = true;
                this.sidebar.classList.remove('-translate-x-full');
                this.sidebar.classList.add('translate-x-0');
                this.overlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
                this.hamburgerIcon.classList.add('hidden');
                this.closeIcon.classList.remove('hidden');
                this.sidebarToggle.setAttribute('aria-expanded', 'true');
            }

            closeMobile() {
                this.isOpen = false;
                this.sidebar.classList.add('-translate-x-full');
                this.sidebar.classList.remove('translate-x-0');
                this.overlay.classList.add('hidden');
                this.hamburgerIcon.classList.remove('hidden');
                this.closeIcon.classList.add('hidden');
                this.sidebarToggle.setAttribute('aria-expanded', 'false');
                document.body.style.overflow = '';
            }

            initTooltips() {
                const sidebarItems = document.querySelectorAll('.sidebar-item[data-tooltip]');

                sidebarItems.forEach(item => {
                    item.addEventListener('mouseenter', (e) => {
                        if (this.isCollapsed && this.isDesktop) {
                            this.showTooltip(e.target.closest('.sidebar-item'), e.target.closest('.sidebar-item').getAttribute('data-tooltip'));
                        }
                    });

                    item.addEventListener('mouseleave', () => {
                        this.hideTooltip();
                    });
                });
            }

            showTooltip(element, text) {
                const rect = element.getBoundingClientRect();
                this.tooltip.textContent = text;
                this.tooltip.style.left = rect.right + 10 + 'px';
                this.tooltip.style.top = rect.top + (rect.height / 2) - (this.tooltip.offsetHeight / 2) + 'px';
                this.tooltip.classList.remove('opacity-0');
                this.tooltip.classList.add('opacity-100');
            }

            hideTooltip() {
                this.tooltip.classList.remove('opacity-100');
                this.tooltip.classList.add('opacity-0');
            }
        }

        // Initialize sidebar when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            new SidebarManager();
        });
    </script>
    @stack('scripts')
    {{-- "put all the scripts that were pushed here" --}}
</body>

</html>