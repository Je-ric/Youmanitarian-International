<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @vite(['resources/css/editors.css'])
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
                        'accent': '#4f46e5',
                        'sidebar-bg': '#ffffff',
                        'hover-bg': '#f8fafc',
                        'active-bg': '#f1f5f9',
                        'text-default': '#334155',
                        'active-text': '#1f2937',
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 font-sans">
    <x-screen-loader />

    <div id="sidebarOverlay"
        class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden transition-opacity duration-300"
        aria-hidden="true"></div>

    <aside id="sidebar"
        class="fixed top-0 left-0 z-50 h-screen transition-all duration-300 ease-in-out transform -translate-x-full lg:translate-x-0 bg-sidebar-bg border-r border-gray-200 shadow-lg sidebar-expanded"
        aria-label="Sidebar">
        <div class="sticky top-0 z-10 border-b border-gray-200"
            style="background: linear-gradient(to bottom, #FFB51B 0%, #e6a318 50%, #ffffff 50%, #ffffff 100%);">
            <div class="flex items-center justify-center h-28 w-full">
                <img src="{{ asset('assets/images/logo/YI_Logo.png') }}" alt="Company Logo"
                    class="w-24 h-24 object-contain" style="z-index:1;">
            </div>
        </div>

        <div class="h-[calc(100vh-6rem)] overflow-y-auto custom-scrollbar-blue">
            <div class="px-3 py-4">
                <div class="mb-4">
                    <h3 class="flex items-center text-sm font-medium text-primary mb-2">
                        <span class="sidebar-content">Overview</span>
                        <span
                            class="flex-grow border-t border-gray-200 ml-3 sidebar-content sidebar-content-line"></span>
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('dashboard') }}"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                                data-tooltip="Dashboard">
                                <i class="bx bxs-dashboard w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </div>

                {{-- Content Management Section (Content Manager Role) --}}
                @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Content Manager') || Auth::user()->hasRole('Program Coordinator'))
                <div class="mb-4">
                    <h3 class="flex items-center text-sm font-medium text-primary mb-2">
                        <span class="sidebar-content">Content</span>
                        <span
                            class="flex-grow border-t border-gray-200 ml-3 sidebar-content sidebar-content-line"></span>
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('content.index') }}"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item {{ request()->routeIs('content.*') ? 'active' : '' }}"
                                data-tooltip="Contents">
                                <i class="bx bxs-file-doc w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Contents</span>
                            </a>
                        </li>
                    </ul>
                </div>
                @endif

                @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Volunteer'))
                <div class="mb-4">
                    <h3 class="flex items-center text-sm font-medium text-primary mb-2">
                        <span class="sidebar-content">Programs</span>
                        <span
                            class="flex-grow border-t border-gray-200 ml-3 sidebar-content sidebar-content-line"></span>
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('programs.index') }}"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item {{ request()->routeIs('programs.*') ? 'active' : '' }}"
                                data-tooltip="Programs">
                                <i class="bx bx-calendar w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Programs</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('program.chats.index', ['program' => request()->route('program')]) }}"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item {{ request()->routeIs('program.chats.*') ? 'active' : '' }}"
                                data-tooltip="Program Chats">
                                <i class="bx bx-message-square-dots w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Program Chats</span>
                            </a>
                        </li>
                    </ul>
                </div>
                @endif

                {{-- Volunteer Section (All Volunteers) --}}
                {{-- @if(Auth::user()->hasRole('Volunteer'))
                <div class="mb-4">
                    <h3 class="flex items-center text-sm font-medium text-primary mb-2">
                        <span class="sidebar-content">Volunteer</span>
                        <span
                            class="flex-grow border-t border-gray-200 ml-3 sidebar-content sidebar-content-line"></span>
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('volunteers.form') }}"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item {{ request()->routeIs('volunteers.form') ? 'active' : '' }}"
                                data-tooltip="Volunteer Application">
                                <i class="bx bx-user-plus w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Apply as Volunteer</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('programs.index') }}"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item {{ request()->routeIs('programs.index') ? 'active' : '' }}"
                                data-tooltip="View Programs">
                                <i class="bx bx-calendar w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">View Programs</span>
                            </a>
                        </li>
                    </ul>
                </div>
                @endif --}}

                {{-- User Management Section --}}
                <div class="mb-4">
                    <h3 class="flex items-center text-sm font-medium text-primary mb-2">
                        <span class="sidebar-content">User</span>
                        <span
                            class="flex-grow border-t border-gray-200 ml-3 sidebar-content sidebar-content-line"></span>
                    </h3>
                    <ul class="space-y-1">
                        {{-- Volunteers (Program Coordinator Role) --}}
                        @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Program Coordinator'))
                        <li>
                            <a href="{{ route('volunteers.index') }}"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item {{ request()->routeIs('volunteers.*') ? 'active' : '' }}"
                                data-tooltip="Volunteers">
                                <i class="bx bx-group w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Volunteers</span>
                            </a>
                        </li>
                        @endif
                        @if(Auth::user()->hasRole('Admin'))
                        <li>
                            <a href="{{ route('members.index') }}"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item"
                                data-tooltip="Members">
                                <i class="bx bx-group w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Members</span>
                            </a>
                        </li>
                        @endif

                        {{-- Role Management (Admin Role) --}}
                        @if(Auth::user()->hasRole('Admin'))
                        <li>
                            <a href="{{ route('roles.index') }}"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item {{ request()->routeIs('roles.*') ? 'active' : '' }}"
                                data-tooltip="Assign Roles">
                                <i class="bx bx-user-plus w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Assign Roles</span>
                            </a>
                        </li>
                        @endif
                    </ul>
                </div>

                {{-- Financial Section (Financial Coordinator Role) --}}
                @if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Financial Coordinator'))
                <div class="mb-4">
                    <h3 class="flex items-center text-sm font-medium text-primary mb-2">
                        <span class="sidebar-content">Financial</span>
                        <span
                            class="flex-grow border-t border-gray-200 ml-3 sidebar-content sidebar-content-line"></span>
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('finance.index') }}"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item {{ request()->routeIs('finance.index') ? 'active' : '' }}"
                                data-tooltip="Donations">
                                <i class="bx bx-heart w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Donations</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('finance.membership.payments') }}"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item {{ request()->routeIs('finance.membership.payments*') ? 'active' : '' }}"
                                data-tooltip="Membership Payments">
                                <i class="bx bx-credit-card w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Membership</span>
                            </a>
                        </li>
                    </ul>
                </div>
                @endif

                <div class="mb-4">
                    <h3 class="flex items-center text-sm font-medium text-primary mb-2">
                        <span class="sidebar-content">Tools</span>
                        <span
                            class="flex-grow border-t border-gray-200 ml-3 sidebar-content sidebar-content-line"></span>
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="{{ route('weather-forecast.index') }}"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item {{ request()->routeIs('weather-forecast.index') ? 'active' : '' }}"
                                data-tooltip="Weather Forecasts">
                                <i class="bx bx-cloud w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Weather Forecasts</span>
                            </a>
                        </li>
                        @if(Auth::user()->hasRole('Admin') || config('app.env') == 'local')
                            <li>
                                <a href="{{ route('components.showcase') }}"
                                    class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item {{ request()->routeIs('components.showcase') ? 'active' : '' }}"
                                    data-tooltip="Component Showcase">
                                    <i class='bx bx-category w-5 text-center flex-shrink-0 text-primary'></i>
                                    <span class="ml-3 sidebar-content text-sm">Component Showcase</span>
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>

                <div class="mb-4">
                    <h3 class="flex items-center text-sm font-medium text-primary mb-2">
                        <span class="sidebar-content">Settings</span>
                        <span
                            class="flex-grow border-t border-gray-200 ml-3 sidebar-content sidebar-content-line"></span>
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="#"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item"
                                data-tooltip="Settings">
                                <i class="bx bx-cog w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Settings</span>
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item"
                                data-tooltip="Help & Support">
                                <i class="bx bx-help-circle w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Help & Support</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="absolute bottom-0 left-0 right-0 bg-white border-t border-gray-200 p-3">
            <form action="{{ route('logout') }}" method="POST" class="w-full">
                @csrf
                <button type="submit"
                    class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item w-full text-left hover:bg-red-50 hover:text-red-600"
                    data-tooltip="Sign Out">
                    <i class="bx bx-log-out w-5 text-center flex-shrink-0 text-red-500"></i>
                    <span class="ml-3 sidebar-content text-sm">Sign Out</span>
                </button>
            </form>
        </div>
    </aside>

    <nav id="navbar"
        class="bg-white border-b border-gray-200 fixed top-0 right-0 z-40 transition-all duration-300 ease-in-out overflow-x-hidden">
        <div class="navbar-container w-full mx-auto px-4 sm:px-6 lg:px-8 transition-all duration-300 ease-in-out">
            <div class="flex justify-between items-center h-16 w-full">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-2">
                        <button id="sidebarToggle"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-primary hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary transition-all duration-200"
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
                            <div class="hidden lg:block relative">
                                <x-form.search-input name="search" placeholder="Search..." class="w-64" />
                            </div>

                            <a href="{{ route('website.index') }}"
                                class="hidden lg:block text-gray-600 hover:text-primary transition-all duration-200 text-sm">Website</a>
                            <a href="{{ route('weather-forecast.index') }}"
                                class="hidden lg:block text-gray-600 hover:text-primary transition-all duration-200 text-sm">Weather</a>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-3 flex-wrap max-w-full">
                    <button
                        class="sm:hidden p-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-200">
                        <i class="fas fa-search text-lg"></i>
                    </button>

                    <a href="{{ route('notifications.index') }}"
                        class="p-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-200 relative">
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
                            class="flex items-center space-x-2 p-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-200">
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
                                class="hidden lg:block text-sm font-medium max-w-24 truncate text-gray-700">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs hidden lg:block"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div id="mainContent" class="main-content pt-16">
        <div class="container mx-auto">
            <x-navigation-layout.breadcrumb :items="[
        ['label' => 'Dashboard', 'url' => route('dashboard')],
        ...(request()->routeIs('content.*') ? [
            ['label' => 'Content Management', 'url' => route('content.index')],
            ...(request()->routeIs('content.create') ? [['label' => 'Create Content']] : []),
            ...(request()->routeIs('content.edit') ? [['label' => 'Edit Content']] : []),
        ] : []),
        ...(request()->routeIs('programs.*') ? [
            ['label' => 'Programs', 'url' => route('programs.index')],
            ...(request()->routeIs('programs.create') ? [['label' => 'Create Program']] : []),
            ...(request()->routeIs('programs.edit') ? [['label' => 'Edit Program']] : []),
            ...(request()->routeIs('programs.view') ? [['label' => 'Attendance']] : []),
            ...(request()->routeIs('programs.manage_volunteers') ? [['label' => 'Manage']] : []),
        ] : []),
        ...(request()->routeIs('volunteers.*') ? [
            ['label' => 'Volunteers', 'url' => route('volunteers.index')],
        ] : []),
        ...(request()->routeIs('roles.*') ? [
            ['label' => 'Role Management', 'url' => route('roles.index')],
        ] : []),
        ...(request()->routeIs('finance.*') ? [
            ['label' => 'Finance', 'url' => route('finance.index')],
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

    <div id="tooltip"
        class="absolute bg-gray-900 text-white text-sm rounded py-1 px-2 z-50 opacity-0 pointer-events-none transition-opacity duration-200">
    </div>

    <style>
        :root {
            --primary-color: #1A2235;
            --primary-tint-1: #313849;
            --primary-tint-2: #484E5D;
            --primary-tint-3: #5F6472;
            --primary-tint-4: #767A86;
            --primary-tint-5: #8D919A;
            --primary-tint-6: #A3A7AE;
            --accent-color: #FFB51B;
            --sidebar-active-bg: #eef2ff;
            --sidebar-active-text: #1a2235;
            --sidebar-border-active: #4f46e5;
        }

        .sidebar-expanded {
            width: 16rem;
        }

        .sidebar-collapsed {
            width: 5rem;
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

        .sidebar-collapsed .mb-4 {
            position: relative;
            margin-bottom: 1rem !important;
        }

        .sidebar-collapsed .mb-4::after {
            content: '';
            position: absolute;
            bottom: -0.5rem;
            left: 0.75rem;
            right: 0.75rem;
            height: 1px;
            background-color: #e2e8f0;
            display: block;
        }

        .sidebar-collapsed h3 {
            display: none;
        }

        .sidebar-collapsed .sidebar-item {
            padding-left: 0.75rem !important;
            padding-right: 0.75rem !important;
            justify-content: center;
        }

        #navbar {
            transition: all 0.3s ease-in-out;
            left: 16rem;
            width: calc(100% - 16rem);
        }

        .navbar-collapsed {
            left: 4rem !important;
            width: calc(100% - 4rem) !important;
        }

        .main-content {
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

        .sidebar-link {
            color: var(--sidebar-text-default);
            position: relative;
            font-weight: 500;
        }

        .sidebar-link:hover {
            background-color: #ffda8d;
            color: #313849;
            transform: translateX(2px);
        }

        .sidebar-link:hover .sidebar-icon,
        .sidebar-link:hover i {
            color: #313849 !important;
        }

        .sidebar-link.active {
            background-color: var(--sidebar-active-bg);
            color: var(--sidebar-active-text);
            font-weight: 600;
            border-left: 3px solid var(--sidebar-border-active);
            box-shadow: var(--sidebar-shadow-active);
        }

        .sidebar-link.active .sidebar-icon,
        .sidebar-link.active i {
            color: var(--accent-color) !important;
        }

        .sidebar-link.logout-link:hover {
            background-color: var(--logout-bg-hover);
            color: var(--logout-text-hover);
        }

        .sidebar-link.logout-link:hover i {
            color: var(--logout-text-hover) !important;
        }

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

        .sidebar-item {
            transition: all 0.2s ease-in-out;
        }

        .main-content {
            transition: margin-left 0.3s ease-in-out;
        }

        .sidebar-link.active {
            background-color: var(--primary-color);
            color: var(--accent-color);
            font-weight: 600;
            border: 2px solid var(--accent-color);
            box-shadow: 0 2px 8px 0 rgba(26, 34, 53, 0.3);
        }

        .sidebar-link.active .sidebar-icon,
        .sidebar-link.active i {
            color: var(--accent-color) !important;
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

                this.handleResize();
                this.updateLayout();
                this.init();
            }

            init() {
                this.sidebarToggle.addEventListener('click', () => this.handleToggle());
                this.overlay.addEventListener('click', () => this.closeMobile());
                window.addEventListener('resize', () => this.handleResize());

                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape' && this.isOpen && !this.isDesktop) {
                        this.closeMobile();
                    }
                });

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

        document.addEventListener('DOMContentLoaded', () => {
            new SidebarManager();
        });
    </script>
    @stack('scripts')
</body>

</html>
