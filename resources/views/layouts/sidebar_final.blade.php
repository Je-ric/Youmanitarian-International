<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Sidebar Component</title>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/3.0.0/uicons-regular-straight/css/uicons-regular-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/3.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    animation: {
                        'slide-in': 'slideIn 0.3s ease-out',
                        'slide-out': 'slideOut 0.3s ease-in',
                        'fade-in': 'fadeIn 0.3s ease-out',
                        'fade-out': 'fadeOut 0.3s ease-in'
                    },
                    keyframes: {
                        slideIn: {
                            '0%': { transform: 'translateX(-100%)' },
                            '100%': { transform: 'translateX(0)' }
                        },
                        slideOut: {
                            '0%': { transform: 'translateX(0)' },
                            '100%': { transform: 'translateX(-100%)' }
                        },
                        fadeIn: {
                            '0%': { opacity: '0' },
                            '100%': { opacity: '1' }
                        },
                        fadeOut: {
                            '0%': { opacity: '1' },
                            '100%': { opacity: '0' }
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 font-sans">
    <!-- Sidebar Overlay (Mobile) -->
    <div 
        id="sidebarOverlay" 
        class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden"
        aria-hidden="true"
    ></div>

    <!-- Sidebar -->
    <aside 
        id="sidebar" 
        class="fixed top-0 left-0 z-50 h-screen transition-all duration-300 ease-in-out transform -translate-x-full lg:translate-x-0 bg-white border-r border-gray-200 shadow-lg sidebar-expanded"
        aria-label="Sidebar"
    >
        <div class="h-full overflow-y-auto bg-white">
            <!-- Sidebar Header -->
            <div class="flex items-center p-4 border-b border-gray-200">
                <div class="sidebar-content">
                    <h1 class="text-xl font-bold text-gray-900">Admin Panel</h1>
                </div>
            </div>

            <div class="px-3 py-4">
                <!-- User Profile Section -->
                <div class="flex flex-col sm:flex-row sm:items-center gap-4 p-4 mb-6 bg-gradient-to-r from-blue-50 to-indigo-50 rounded-lg border border-blue-100 sidebar-profile">
                    @if(Auth::user()->profile_pic)
                        <img src="{{ Auth::user()->profile_pic }}" alt="Profile" class="w-14 h-14 rounded-full object-cover flex-shrink-0">
                    @else
                        <div class="w-14 h-14 bg-gray-700 rounded-full flex items-center justify-center text-white text-xl flex-shrink-0">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                    @endif

                    <div class="flex flex-col justify-center">
                        <p class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</p>
                        <p class="text-xs text-gray-600">{{ Auth::user()->email }}</p>
                    </div>
                </div>


                <!-- Navigation Menu -->
                <ul class="space-y-2 font-medium">
                    <!-- Dashboard -->
                    <li>
                        <a href="{{ route('dashboard') }}" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 group sidebar-item" data-tooltip="Contents">
                            <i class="fas fa-tachometer-alt text-gray-500 group-hover:text-blue-700 w-5 text-center"></i>
                            <span class="ml-3 sidebar-content">Dashboard</span>
                        </a>
                    </li>
                    
                    <!-- Contents -->
                    <li>
                        <a href="{{ route('content.content_view') }}" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 group sidebar-item" data-tooltip="Contents">
                            <i class="fas fa-file-alt text-gray-500 group-hover:text-blue-700 w-5 text-center"></i>
                            <span class="ml-3 sidebar-content">Contents</span>
                        </a>
                    </li>
                    
                    <!-- Programs -->
                    <li>
                        <a href="{{ route('programs.index') }}" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 group sidebar-item" data-tooltip="Programs">
                            <i class="fas fa-calendar-alt text-gray-500 group-hover:text-blue-700 w-5 text-center"></i>
                            <span class="ml-3 sidebar-content">Programs</span>
                        </a>
                    </li>
                    
                    <!-- Volunteers -->
                    <li>
                        <a href="#" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 group sidebar-item" data-tooltip="Volunteers">
                            <i class="fas fa-hands-helping text-gray-500 group-hover:text-blue-700 w-5 text-center"></i>
                            <span class="ml-3 sidebar-content">Volunteers</span>
                        </a>
                    </li>
                    
                    <!-- Volunteer Applications -->
                    <li>
                        <a href="{{ route('volunteers.requests') }}" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 group sidebar-item" data-tooltip="Volunteer Applications">
                            <i class="fas fa-user-plus text-gray-500 group-hover:text-blue-700 w-5 text-center"></i>
                            <span class="ml-3 sidebar-content">Volunteer Applications</span>
                            <span class="inline-flex items-center justify-center w-3 h-3 p-3 ml-auto text-sm font-medium text-orange-800 bg-orange-100 rounded-full sidebar-content">12</span>
                        </a>
                    </li>
                    
                    <!-- Content Requests -->
                    <li>
                        <a href="{{ route('content_requests.requests_view') }}" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 group sidebar-item" data-tooltip="Content Requests">
                            <i class="fas fa-clipboard-list text-gray-500 group-hover:text-blue-700 w-5 text-center"></i>
                            <span class="ml-3 sidebar-content">Content Requests</span>
                            <span class="inline-flex items-center justify-center w-3 h-3 p-3 ml-auto text-sm font-medium text-red-800 bg-red-100 rounded-full sidebar-content">5</span>
                        </a>
                    </li>
                    
                    <!-- Members -->
                    <li>
                        <a href="#" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 group sidebar-item" data-tooltip="Members">
                            <i class="fas fa-users text-gray-500 group-hover:text-blue-700 w-5 text-center"></i>
                            <span class="ml-3 sidebar-content">Members</span>
                        </a>
                    </li>
                    
                    <!-- Donations -->
                    <li>
                        <a href="#" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 group sidebar-item" data-tooltip="Donations">
                            <i class="fas fa-heart text-gray-500 group-hover:text-blue-700 w-5 text-center"></i>
                            <span class="ml-3 sidebar-content">Donations</span>
                        </a>
                    </li>
                    
                    <!-- Membership Payments -->
                    <li>
                        <a href="#" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 group sidebar-item" data-tooltip="Membership Payments">
                            <i class="fas fa-credit-card text-gray-500 group-hover:text-blue-700 w-5 text-center"></i>
                            <span class="ml-3 sidebar-content">Membership Payments</span>
                        </a>
                    </li>
                    
                    <!-- User Roles -->
                    <li>
                        <a href="#" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 group sidebar-item" data-tooltip="User Roles">
                            <i class="fas fa-user-shield text-gray-500 group-hover:text-blue-700 w-5 text-center"></i>
                            <span class="ml-3 sidebar-content">User Roles</span>
                        </a>
                    </li>
                </ul>

                <!-- Divider -->
                <hr class="my-6 border-gray-200 sidebar-content">

                <!-- Settings Section -->
                <ul class="space-y-2 font-medium">
                    <li>
                        <a href="#" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 group sidebar-item" data-tooltip="Settings">
                            <i class="fas fa-cog text-gray-500 group-hover:text-blue-700 w-5 text-center"></i>
                            <span class="ml-3 sidebar-content">Settings</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="flex items-center p-3 text-gray-900 rounded-lg hover:bg-blue-50 hover:text-blue-700 transition-all duration-200 group sidebar-item" data-tooltip="Help & Support">
                            <i class="fas fa-question-circle text-gray-500 group-hover:text-blue-700 w-5 text-center"></i>
                            <span class="ml-3 sidebar-content">Help & Support</span>
                        </a>
                    </li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" class="flex items-center p-3 text-red-600 rounded-lg hover:bg-red-50 transition-all duration-200 group sidebar-item" data-tooltip="Sign Out">
                            @csrf
                            <button type="submit" 
                                class="flex items-center gap-3 w-full px-4 py-2 text-red-600 hover:bg-red-600 hover:text-white rounded-lg transition-colors sidebar-item group"
                                data-tooltip="Sign Out">
                                <i class="fas fa-sign-out-alt text-red-500 w-5 text-center"></i>
                                <span class="ml-3 sidebar-content">Sign Out</span>
                            </button>
                        </form>
                    </li>

                </ul>
            </div>
        </div>
    </aside>

    <!-- Navbar -->
    <nav id="navbar" class="bg-white shadow-lg border-b border-gray-200 fixed w-full top-0 z-40 transition-all duration-300 ease-in-out">
        <div class="navbar-container transition-all duration-300 ease-in-out">
            <div class="flex justify-between items-center h-16 px-4 sm:px-6 lg:px-8">
                <!-- Left side with hamburger and logo -->
                <div class="flex items-center space-x-4">
                    <!-- Universal Hamburger Menu Button -->
                    <button 
                        id="sidebarToggle" 
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-colors duration-200"
                        aria-label="Toggle sidebar"
                        aria-expanded="false"
                    >
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="hamburgerIcon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="closeIcon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    
                    <!-- Logo (visible when sidebar is collapsed or on mobile) -->
                    <div id="navbarLogo" class="navbar-logo">
                        <h1 class="text-xl font-bold text-gray-900">Admin Panel</h1>
                    </div>
                </div>

                <!-- Right side navigation -->
                <div class="flex items-center space-x-4">
                    <!-- Search -->
                    <div class="hidden md:block">
                        <div class="relative">
                            <input 
                                type="text" 
                                placeholder="Search..." 
                                class="w-64 pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                            >
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-search text-gray-400"></i>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Notifications -->
                    <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors duration-200 relative">
                        <i class="fas fa-bell text-lg"></i>
                        <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                    </button>
                    
                    <!-- Profile -->
                    <div class="relative">
                        <button class="flex items-center space-x-2 p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                            <img class="h-8 w-8 rounded-full" src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="Profile">
                            <span class="hidden md:block text-sm font-medium">John Doe</span>
                            <i class="fas fa-chevron-down text-xs hidden md:block"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div id="mainContent" class="main-content transition-all duration-300 ease-in-out pt-16">
        <div class="p-6">
            
        </div>

        
        @yield('content')
    </div>

    <!-- Tooltip -->
    <div id="tooltip" class="absolute bg-gray-900 text-white text-sm rounded py-1 px-2 z-50 opacity-0 pointer-events-none transition-opacity duration-200"></div>

    <style>
        /* Sidebar states */
        .sidebar-expanded {
            width: 16rem;
        }
        
        .sidebar-collapsed {
            width: 4rem;
        }
        
        .sidebar-collapsed .sidebar-content {
            opacity: 0;
            visibility: hidden;
        }
        
        .sidebar-collapsed .sidebar-profile {
            padding: 0.75rem;
            justify-content: center;
        }
        
        .sidebar-collapsed .sidebar-profile img {
            width: 2rem;
            height: 2rem;
        }
        
        /* Navbar adjustments */
        .navbar-expanded {
            margin-left: 16rem;
        }
        
        .navbar-collapsed {
            margin-left: 4rem;
        }
        
        /* Main content adjustments */
        .content-expanded {
            margin-left: 16rem;
        }
        
        .content-collapsed {
            margin-left: 4rem;
        }
        
        /* Logo visibility */
        .navbar-logo {
            display: none;
        }
        
        .navbar-logo.show {
            display: block;
        }
        
        @media (max-width: 1023px) {
            .navbar-expanded,
            .navbar-collapsed,
            .content-expanded,
            .content-collapsed {
                margin-left: 0;
            }
            
            .navbar-logo {
                display: block;
            }
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
                this.navbarLogo = document.getElementById('navbarLogo');
                this.tooltip = document.getElementById('tooltip');
                
                this.isOpen = false;
                this.isCollapsed = false;
                this.isDesktop = window.innerWidth >= 1024;
                
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
                
                // Set initial state
                this.handleResize();
                this.updateLayout();
            }
            
            handleToggle() {
                if (this.isDesktop) {
                    if (this.isCollapsed) {
                        // Expand sidebar
                        this.expandSidebar();
                    } else {
                        // Collapse sidebar
                        this.collapseSidebar();
                    }
                } else {
                    // Mobile behavior
                    this.toggleMobile();
                }
            }
            
            expandSidebar() {
                this.isCollapsed = false;
                this.updateSidebarState();
                this.updateLayout();
            }
            
            collapseSidebar() {
                this.isCollapsed = true;
                this.updateSidebarState();
                this.updateLayout();
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
                
                if (!this.isDesktop) {
                    this.overlay.classList.remove('hidden');
                    this.overlay.classList.add('animate-fade-in');
                    document.body.style.overflow = 'hidden';
                }
                
                this.hamburgerIcon.classList.add('hidden');
                this.closeIcon.classList.remove('hidden');
                this.sidebarToggle.setAttribute('aria-expanded', 'true');
            }
            
            closeMobile() {
                this.isOpen = false;
                this.sidebar.classList.add('-translate-x-full');
                this.sidebar.classList.remove('translate-x-0');
                this.overlay.classList.add('hidden');
                this.overlay.classList.remove('animate-fade-in');
                this.hamburgerIcon.classList.remove('hidden');
                this.closeIcon.classList.add('hidden');
                this.sidebarToggle.setAttribute('aria-expanded', 'false');
                
                document.body.style.overflow = '';
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
                
                // Update navbar
                this.navbar.classList.remove('navbar-expanded', 'navbar-collapsed');
                this.mainContent.classList.remove('content-expanded', 'content-collapsed');
                
                if (this.isCollapsed) {
                    this.navbar.classList.add('navbar-collapsed');
                    this.mainContent.classList.add('content-collapsed');
                    this.navbarLogo.classList.add('show');
                } else {
                    this.navbar.classList.add('navbar-expanded');
                    this.mainContent.classList.add('content-expanded');
                    this.navbarLogo.classList.remove('show');
                }
            }
            
            handleResize() {
                const wasDesktop = this.isDesktop;
                this.isDesktop = window.innerWidth >= 1024;
                
                if (this.isDesktop && !wasDesktop) {
                    // Switched to desktop
                    this.closeMobile();
                    this.sidebar.classList.remove('-translate-x-full');
                    this.sidebar.classList.add('translate-x-0');
                    this.isOpen = true;
                    this.updateLayout();
                } else if (!this.isDesktop && wasDesktop) {
                    // Switched to mobile
                    this.sidebar.classList.add('-translate-x-full');
                    this.sidebar.classList.remove('translate-x-0');
                    this.isOpen = false;
                    this.isCollapsed = false;
                    this.updateSidebarState();
                    this.navbar.classList.remove('navbar-expanded', 'navbar-collapsed');
                    this.mainContent.classList.remove('content-expanded', 'content-collapsed');
                    this.navbarLogo.classList.remove('show');
                }
            }
            
            initTooltips() {
                const sidebarItems = document.querySelectorAll('.sidebar-item[data-tooltip]');
                
                sidebarItems.forEach(item => {
                    item.addEventListener('mouseenter', (e) => {
                        if (this.isCollapsed && this.isDesktop) {
                            this.showTooltip(e.target, e.target.getAttribute('data-tooltip'));
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
        
        // Add active state management
        const sidebarLinks = document.querySelectorAll('aside a');
        sidebarLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                // e.preventDefault();
                
                // Remove active class from all links
                sidebarLinks.forEach(l => {
                    l.classList.remove('bg-blue-100', 'text-blue-700');
                    l.querySelector('i').classList.remove('text-blue-700');
                    l.querySelector('i').classList.add('text-gray-500', 'group-hover:text-blue-700');
                });
                
                // Add active class to clicked link
                this.classList.add('bg-blue-100', 'text-blue-700');
                this.querySelector('i').classList.remove('text-gray-500', 'group-hover:text-blue-700');
                this.querySelector('i').classList.add('text-blue-700');
            });
        });
    </script>
</body>
</html>