<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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

    <!-- Left Sidebar Overlay -->
    <div id="sidebarOverlay"
         class="fixed inset-0 top-16 bg-black bg-opacity-50 z-40 lg:hidden hidden transition-opacity duration-300"
         aria-hidden="true"></div>

    <!-- Right Sidebar Overlay for mobile navbar content -->
    <div id="rightSidebarOverlay"
         class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden transition-opacity duration-300"
         aria-hidden="true"></div>

    <!-- Left Sidebar -->
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
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item {{ request()->routeIs('content.index') ? 'active' : '' }}"
                                data-tooltip="Contents">
                                <i class="bx bxs-file-doc w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Contents</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('content.teamMembers.index') }}"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item {{ request()->routeIs('content.teamMembers.*') ? 'active' : '' }}"
                                data-tooltip="Team Members">
                                <i class="bx bx-user-pin w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Team Members</span>
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
                        <li>
                            <a href="{{ route('program_requests.index') }}"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item {{ request()->routeIs('program_requests.*') ? 'active' : '' }}"
                                data-tooltip="Program Requests">
                                <i class="bx bx-bulb w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Program Requests</span>
                            </a>
                        </li>
                    </ul>
                </div>
                @endif

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

    <!-- Right Sidebar for mobile navbar content -->
    <aside id="rightSidebar"
        class="fixed top-0 right-0 z-50 h-screen w-80 transition-all duration-300 ease-in-out transform translate-x-full lg:hidden bg-white border-l border-gray-200 shadow-lg"
        aria-label="Right Sidebar">
        <div class="h-full overflow-y-auto">
            <div class="p-4 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900">Menu</h2>
                    <button id="rightSidebarClose"
                        class="p-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-200">
                        <i class="fas fa-times text-lg"></i>
                    </button>
                </div>
            </div>

            <div class="p-4 space-y-4">
                <!-- User Profile Section -->
                <div class="pb-4 border-b border-gray-200">
                    <a href="{{ route('profile.me') }}"
                        class="flex items-center space-x-3 p-3 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-200">
                        <x-user-avatar :user="Auth::user()" size="10" />
                        <div>
                            <div class="font-medium text-gray-900">{{ Auth::user()->name }}</div>
                            <div class="text-sm text-gray-500">View Profile</div>
                        </div>
                    </a>
                </div>

                <!-- Navigation Links -->
                <div class="space-y-2">
                    <a href="{{ route('website.index') }}"
                        class="flex items-center space-x-3 p-3 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-200">
                        <i class="fas fa-globe w-5 text-center"></i>
                        <span>Website</span>
                    </a>

                    <a href="{{ route('consultation-hours.browse') }}"
                        class="flex items-center space-x-3 p-3 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-200">
                        <i class="fas fa-clock w-5 text-center"></i>
                        <span>Consultations</span>
                    </a>

                    <a href="{{ route('consultation-chats.index') }}"
                        class="flex items-center space-x-3 p-3 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-200">
                        <i class="fas fa-comments w-5 text-center"></i>
                        <span>Consultation Chats</span>
                    </a>

                    <a href="{{ route('consultation-hours.index') }}"
                        class="flex items-center space-x-3 p-3 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-200">
                        <i class="fas fa-clock w-5 text-center"></i>
                        <span>Consultation Hours</span>
                    </a>

                    <a href="{{ route('program_requests.index') }}"
                        class="flex items-center space-x-3 p-3 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-200">
                        <i class='bx bx-bulb w-5 text-center'></i>
                        <span>Program Requests</span>
                    </a>
                </div>

                <!-- Notifications -->
                <div class="pt-4 border-t border-gray-200">
                    <a href="{{ route('notifications.index') }}"
                        class="flex items-center justify-between p-3 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-200">
                        <div class="flex items-center space-x-3">
                            <i class="fas fa-bell w-5 text-center"></i>
                            <span>Notifications</span>
                        </div>
                        @if(Auth::check() && Auth::user()->unreadNotifications->count() > 0)
                            <span class="h-5 w-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                                {{ Auth::user()->unreadNotifications->count() }}
                            </span>
                        @endif
                    </a>
                </div>
            </div>
        </div>
    </aside>

    <!-- Top Navbar -->
    <nav id="navbar"
     class="bg-white border-b border-gray-200 fixed top-0 left-0 w-full z-50 transition-all duration-300 ease-in-out overflow-x-hidden">
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

                        <!-- Desktop-only search and navigation -->
                        <div class="hidden lg:flex items-center space-x-4">
                            <div class="relative">
                                <x-form.search-input name="search" placeholder="Search..." class="w-64" />
                            </div>

                            <a href="{{ route('website.index') }}"
                                class="text-gray-600 hover:text-primary transition-all duration-200 text-sm">Website</a>
                            <a href="{{ route('consultation-hours.browse') }}"
                                class="text-gray-600 hover:text-primary transition-all duration-200 text-sm">Consultations</a>
                            <a href="{{ route('consultation-hours.index') }}"
                                class="text-gray-600 hover:text-primary transition-all duration-200 text-sm">Consultation Hours</a>
                            <a href="{{ route('consultation-chats.index') }}"
                                class="text-gray-600 hover:text-primary transition-all duration-200 text-sm">Consultation Chats</a>
                        </div>
                    </div>
                </div>

                <!-- Desktop navbar items and mobile menu button -->
                <div class="flex items-center space-x-3">
                    <!-- Desktop items -->
                    <div class="hidden lg:flex items-center space-x-3">
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
                            <a href="{{ route('profile.me') }}"
                                class="flex items-center space-x-2 p-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-200"
                                title="My Profile">
                                <x-user-avatar :user="Auth::user()" size="8" :showName="true" />
                            </a>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <button id="rightSidebarToggle"
                        class="lg:hidden inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-primary hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-primary transition-all duration-200"
                        aria-label="Toggle menu">
                        <i class="fas fa-bars text-lg"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>

    <div id="mainContent" class="main-content pt-16">
        @include('layouts.partials.breadcrumb')

        @if (session('toast'))
            <x-feedback-status.toast :message="session('toast')['message']" :type="session('toast')['type']" />
        @endif

        @yield('content')
    </div>

    <div id="tooltip"
        class="absolute bg-gray-900 text-white text-sm rounded py-1 px-2 z-50 opacity-0 pointer-events-none transition-opacity duration-200">
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-...sha..." crossorigin="anonymous"></script>
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const rightSidebar = document.getElementById('rightSidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const rightOverlay = document.getElementById('rightSidebarOverlay');
            const toggleBtn = document.getElementById('sidebarToggle');
            const rightToggleBtn = document.getElementById('rightSidebarToggle');
            const rightCloseBtn = document.getElementById('rightSidebarClose');
            const hamburger = document.getElementById('hamburgerIcon');
            const closeIcon = document.getElementById('closeIcon');

            function openSidebar(){
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
                requestAnimationFrame(()=>overlay.classList.remove('opacity-0'));
                hamburger.classList.add('hidden');
                closeIcon.classList.remove('hidden');
            }
            function closeSidebar(){
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('opacity-0');
                setTimeout(()=>overlay.classList.add('hidden'),150);
                closeIcon.classList.add('hidden');
                hamburger.classList.remove('hidden');
            }

            function openRightSidebar(){
                rightSidebar.classList.remove('translate-x-full');
                rightOverlay.classList.remove('hidden');
                requestAnimationFrame(()=>rightOverlay.classList.remove('opacity-0'));
                document.body.style.overflow = 'hidden';
            }
            function closeRightSidebar(){
                rightSidebar.classList.add('translate-x-full');
                rightOverlay.classList.add('opacity-0');
                setTimeout(()=>rightOverlay.classList.add('hidden'),150);
                document.body.style.overflow = '';
            }

            if(toggleBtn){
                toggleBtn.addEventListener('click', ()=>{
                    if(sidebar.classList.contains('-translate-x-full')) openSidebar();
                    else closeSidebar();
                });
            }
            if(rightToggleBtn){
                rightToggleBtn.addEventListener('click', openRightSidebar);
            }
            if(rightCloseBtn){
                rightCloseBtn.addEventListener('click', closeRightSidebar);
            }
            if(overlay){
                overlay.addEventListener('click', closeSidebar);
            }
            if(rightOverlay){
                rightOverlay.addEventListener('click', closeRightSidebar);
            }

            // Close right sidebar on escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !rightSidebar.classList.contains('translate-x-full')) {
                    closeRightSidebar();
                }
            });
        });

        class SidebarManager {
            constructor() {
                this.sidebar = document.getElementById('sidebar');
                this.rightSidebar = document.getElementById('rightSidebar');
                this.navbar = document.getElementById('navbar');
                this.mainContent = document.getElementById('mainContent');
                this.overlay = document.getElementById('sidebarOverlay');
                this.rightOverlay = document.getElementById('rightSidebarOverlay');
                this.sidebarToggle = document.getElementById('sidebarToggle');
                this.rightSidebarToggle = document.getElementById('rightSidebarToggle');
                this.rightSidebarClose = document.getElementById('rightSidebarClose');
                this.hamburgerIcon = document.getElementById('hamburgerIcon');
                this.closeIcon = document.getElementById('closeIcon');
                this.tooltip = document.getElementById('tooltip');

                this.isOpen = false;
                this.isRightOpen = false;
                this.isCollapsed = false;
                this.isDesktop = window.innerWidth >= 1024;

                this.handleResize();
                this.updateLayout();
                this.init();
            }

            init() {
                this.sidebarToggle.addEventListener('click', () => this.handleToggle());
                if(this.rightSidebarToggle) {
                    this.rightSidebarToggle.addEventListener('click', () => this.openRightMobile());
                }
                if(this.rightSidebarClose) {
                    this.rightSidebarClose.addEventListener('click', () => this.closeRightMobile());
                }
                this.overlay.addEventListener('click', () => this.closeMobile());
                if(this.rightOverlay) {
                    this.rightOverlay.addEventListener('click', () => this.closeRightMobile());
                }
                window.addEventListener('resize', () => this.handleResize());

                document.addEventListener('keydown', (e) => {
                    if (e.key === 'Escape') {
                        if (this.isOpen && !this.isDesktop) {
                            this.closeMobile();
                        }
                        if (this.isRightOpen && !this.isDesktop) {
                            this.closeRightMobile();
                        }
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
                    this.closeRightMobile();
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

            openRightMobile() {
                this.isRightOpen = true;
                this.rightSidebar.classList.remove('translate-x-full');
                this.rightOverlay.classList.remove('hidden');
                document.body.style.overflow = 'hidden';
            }

            closeRightMobile() {
                this.isRightOpen = false;
                this.rightSidebar.classList.add('translate-x-full');
                this.rightOverlay.classList.add('hidden');
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
</body>

</html>
