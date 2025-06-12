<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <title>Professional Sidebar Component</title> --}}
    @vite(['resources/css/app.css', 'resources/js/app.js']) 
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn-uicons.flaticon.com/uicons-regular-rounded/css/uicons-regular-rounded.css">
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/3.0.0/uicons-regular-straight/css/uicons-regular-straight.css'>
    <link rel='stylesheet' href='https://cdn-uicons.flaticon.com/3.0.0/uicons-regular-rounded/css/uicons-regular-rounded.css'>
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
                        'accent': '#ffb51b'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 font-sans">
    <!-- Sidebar Overlay (Mobile) -->
    <div 
        id="sidebarOverlay" 
        class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden transition-opacity duration-300"
        aria-hidden="true"
    ></div>

  <!-- Sidebar -->
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
                <h1 class="text-lg font-bold text-primary">Admin Panel</h1>
            </div>
        </div>

        <div class="px-3 py-4">
            <!-- Navigation Menu -->
            <ul class="space-y-1 font-medium">
                <!-- Dashboard -->
                <li>
                    <a href="{{ route('dashboard') }}" 
                       class="sidebar-link flex items-center p-3 rounded-lg transition-colors duration-200 group sidebar-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                       data-tooltip="Dashboard">
                        <i class="bx bxs-dashboard w-5 text-center flex-shrink-0"></i>
                        <span class="ml-3 sidebar-content text-sm">Dashboard</span>
                    </a>
                </li>

                <!-- Contents -->
                <li>
                    <a href="{{ route('content.content_view') }}" 
                       class="sidebar-link flex items-center p-3 rounded-lg transition-colors duration-200 group sidebar-item {{ request()->routeIs('content.*') ? 'active' : '' }}" 
                       data-tooltip="Contents">
                        <i class="bx bx-file w-5 text-center flex-shrink-0"></i>
                        <span class="ml-3 sidebar-content text-sm">Contents</span>
                    </a>
                </li>

                <!-- Programs -->
                <li>
                    <a href="{{ route('programs.index') }}" 
                       class="sidebar-link flex items-center p-3 rounded-lg transition-colors duration-200 group sidebar-item {{ request()->routeIs('programs.*') ? 'active' : '' }}" 
                       data-tooltip="Programs">
                        <i class="bx bx-calendar w-5 text-center flex-shrink-0"></i>
                        <span class="ml-3 sidebar-content text-sm">Programs</span>
                    </a>
                </li>

                <!-- Volunteers -->
                <li>
                    <a href="{{ route('volunteers.index') }}" 
                       class="sidebar-link flex items-center p-3 rounded-lg transition-colors duration-200 group sidebar-item {{ request()->routeIs('volunteers.*') ? 'active' : '' }}" 
                       data-tooltip="Volunteers">
                        <i class="bx bx-group w-5 text-center flex-shrink-0"></i>
                        <span class="ml-3 sidebar-content text-sm">Volunteers</span>
                        <span class="inline-flex items-center justify-center w-3 h-3 p-3 ml-auto text-sm font-medium text-orange-800 bg-orange-100 rounded-full sidebar-content">12</span>
                    </a>
                </li>

                <!-- Content Requests -->
                <li>
                    <a href="{{ route('content_requests.requests_view') }}" 
                       class="sidebar-link flex items-center p-3 rounded-lg transition-colors duration-200 group sidebar-item {{ request()->routeIs('content_requests.*') ? 'active' : '' }}" 
                       data-tooltip="Content Requests">
                        <i class="bx bx-clipboard w-5 text-center flex-shrink-0"></i>
                        <span class="ml-3 sidebar-content text-sm">Content Requests</span>
                        <span class="inline-flex items-center justify-center w-3 h-3 p-3 ml-auto text-sm font-medium text-red-800 bg-red-100 rounded-full sidebar-content">5</span>
                    </a>
                </li>

                <!-- Members -->
                <li>
                    <a href="#" 
                       class="sidebar-link flex items-center p-3 rounded-lg transition-colors duration-200 group sidebar-item" 
                       data-tooltip="Members">
                        <i class="bx bx-group w-5 text-center flex-shrink-0"></i>
                        <span class="ml-3 sidebar-content text-sm">Members</span>
                    </a>
                </li>

                <!-- Donations -->
                <li>
                    <a href="#" 
                       class="sidebar-link flex items-center p-3 rounded-lg transition-colors duration-200 group sidebar-item" 
                       data-tooltip="Donations">
                        <i class="bx bx-heart w-5 text-center flex-shrink-0"></i>
                        <span class="ml-3 sidebar-content text-sm">Donations</span>
                    </a>
                </li>

                <!-- Membership Payments -->
                <li>
                    <a href="#" 
                       class="sidebar-link flex items-center p-3 rounded-lg transition-colors duration-200 group sidebar-item" 
                       data-tooltip="Membership Payments">
                        <i class="bx bx-credit-card w-5 text-center flex-shrink-0"></i>
                        <span class="ml-3 sidebar-content text-sm">Membership Payments</span>
                    </a>
                </li>

                <!-- User Roles -->
                <li>
                    <a href="#" 
                       class="sidebar-link flex items-center p-3 rounded-lg transition-colors duration-200 group sidebar-item" 
                       data-tooltip="User Roles">
                        <i class="bx bx-shield-quarter w-5 text-center flex-shrink-0"></i>
                        <span class="ml-3 sidebar-content text-sm">User Roles</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('weather-forecast.index') }}" 
                       class="sidebar-link flex items-center p-3 rounded-lg transition-colors duration-200 group sidebar-item" 
                       data-tooltip="User Roles">
                        <i class="bx bx-shield-quarter w-5 text-center flex-shrink-0"></i>
                        <span class="ml-3 sidebar-content text-sm">Weather Forecasts</span>
                    </a>
                </li>
            </ul>

            <!-- Divider -->
            <hr class="my-6 border-gray-200 sidebar-content">

            <!-- Settings Section -->
            <ul class="space-y-1 font-medium">
                <li>
                    <a href="#" 
                       class="sidebar-link flex items-center p-3 rounded-lg transition-colors duration-200 group sidebar-item" 
                       data-tooltip="Settings">
                        <i class="bx bx-cog w-5 text-center flex-shrink-0"></i>
                        <span class="ml-3 sidebar-content text-sm">Settings</span>
                    </a>
                </li>
                <li>
                    <a href="#" 
                       class="sidebar-link flex items-center p-3 rounded-lg transition-colors duration-200 group sidebar-item" 
                       data-tooltip="Help & Support">
                        <i class="bx bx-help-circle w-5 text-center flex-shrink-0"></i>
                        <span class="ml-3 sidebar-content text-sm">Help & Support</span>
                    </a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" 
                            class="sidebar-link flex items-center p-3 rounded-lg transition-colors duration-200 group sidebar-item w-full text-left text-red-600 hover:bg-red-50"
                            data-tooltip="Sign Out">
                            <i class="bx bx-log-out text-red-500 w-5 text-center flex-shrink-0"></i>
                            <span class="ml-3 sidebar-content text-sm">Sign Out</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</aside>


    <!-- Navbar -->
<nav id="navbar" class="bg-white shadow-lg border-b border-gray-200 fixed top-0 left-0 right-0 z-40 transition-all duration-300 ease-in-out overflow-x-hidden">
  <div class="navbar-container w-full max-w-screen-xl mx-auto px-4 sm:px-6 lg:px-8 transition-all duration-300 ease-in-out">
    <div class="flex justify-between items-center h-16 w-full">
        
                <div class="flex items-center space-x-4">
                    <button 
                        id="sidebarToggle" 
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-600 hover:text-gray-900 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500 transition-colors duration-200"
                        aria-label="Toggle sidebar"
                        aria-expanded="false"
                    >
                        <svg class="h-6 w-6 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="hamburgerIcon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <svg class="h-6 w-6 hidden transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" id="closeIcon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    
                    <div id="navbarLogo" class="navbar-logo">
                        <h1 class="text-xl font-bold text-primary">Admin Panel</h1>
                    </div>
                </div>

                <!-- Right side  -->
                <div class="flex items-center space-x-2 sm:space-x-4 flex-wrap max-w-full">
                    
                    <button class="sm:hidden p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                        <i class="fas fa-search text-lg"></i>
                    </button>
                    
                    <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors duration-200 relative">
                        <i class="fas fa-bell text-lg"></i>
                        <span class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">3</span>
                    </button>
                    
                    <div class="relative">
                        <button class="flex items-center space-x-2 p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors duration-200">
                            @if(Auth::user()->profile_pic)
                                <img src="{{ Auth::user()->profile_pic }}" alt="Profile" class="h-8 w-8 rounded-full object-cover">
                            @else
                                <div class="h-8 w-8 bg-primary rounded-full flex items-center justify-center text-white text-sm">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                            @endif
                            <span class="hidden lg:block text-sm font-medium max-w-24 truncate">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down text-xs hidden lg:block"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div id="mainContent" class="main-content pt-16">
        @yield('content')
    </div>

    <!-- Tooltip -->
    <div id="tooltip" class="absolute bg-gray-900 text-white text-sm rounded py-1 px-2 z-50 opacity-0 pointer-events-none transition-opacity duration-200"></div>

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
        
        .sidebar-collapsed .sidebar-profile > div:last-child {
            display: none;
        }

        /* Navbar adjustments - NO ANIMATIONS ON LAYOUT CHANGES */
        .navbar-expanded {
            margin-left: 16rem;
        }
        
        .navbar-collapsed {
            margin-left: 4rem;
        }
        
        /* Main content adjustments - NO ANIMATIONS ON LAYOUT CHANGES */
        .content-expanded {
            margin-left: 16rem;
        }
        
        .content-collapsed {
            margin-left: 4rem;
        }
        
        /* Remove transitions from layout elements to prevent page switch animations */
        #navbar, #mainContent {
            transition: margin-left 0.3s ease-in-out;
        }
        
        /* Logo visibility */
        .navbar-logo {
            display: none;
        }
        
        .navbar-logo.show {
            display: block;
        }

        /* Sidebar link styles */
        .sidebar-link {
            color: #6b7280;
        }

        .sidebar-link:hover {
            background-color: #f3f4f6;
            color: var(--primary-color);
        }

        .sidebar-link:hover i {
            color: var(--accent-color) !important;
        }

        .sidebar-link.active {
            background-color: #f0f9ff;
            color: var(--primary-color);
            border-left: 4px solid var(--accent-color);
            font-weight: 600;
        }

        .sidebar-link.active i {
            color: var(--accent-color) !important;
        }

        /* Responsive adjustments */
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

        /* Smooth transitions only for user interactions */
        .sidebar-item {
            transition: all 0.2s ease-in-out;
        }

        /* Remove any unwanted animations from content area */
        .main-content {
            transition: margin-left 0.3s ease-in-out;
        }

        /* Ensure responsive navbar elements don't overflow */
        .navbar-container {
            max-width: 100%;
            overflow: hidden;
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
                
                // Set active state based on current URL
                this.setActiveState();
            }
            
            handleToggle() {
                if (this.isDesktop) {
                    if (this.isCollapsed) {
                        this.expandSidebar();
                    } else {
                        this.collapseSidebar();
                    }
                } else {
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
                
                // Update navbar and content without animations during page loads
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
                    this.navbarLogo.classList.remove('show');
                }
            }
            
            setActiveState() {
                // This will be handled by Laravel's route checking in the blade template
                // No JavaScript needed for active state since it's server-side rendered
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
</body>
</html>