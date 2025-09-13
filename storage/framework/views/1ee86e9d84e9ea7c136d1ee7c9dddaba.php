<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
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
    <?php if (isset($component)) { $__componentOriginalba514aae05f9b3538fc06d4d11058e0d = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalba514aae05f9b3538fc06d4d11058e0d = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.screen-loader','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('screen-loader'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalba514aae05f9b3538fc06d4d11058e0d)): ?>
<?php $attributes = $__attributesOriginalba514aae05f9b3538fc06d4d11058e0d; ?>
<?php unset($__attributesOriginalba514aae05f9b3538fc06d4d11058e0d); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalba514aae05f9b3538fc06d4d11058e0d)): ?>
<?php $component = $__componentOriginalba514aae05f9b3538fc06d4d11058e0d; ?>
<?php unset($__componentOriginalba514aae05f9b3538fc06d4d11058e0d); ?>
<?php endif; ?>

    <div id="sidebarOverlay"
        class="fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden hidden transition-opacity duration-300"
        aria-hidden="true"></div>

    <aside id="sidebar"
        class="fixed top-0 left-0 z-50 h-screen transition-all duration-300 ease-in-out transform -translate-x-full lg:translate-x-0 bg-sidebar-bg border-r border-gray-200 shadow-lg sidebar-expanded"
        aria-label="Sidebar">
        <div class="sticky top-0 z-10 border-b border-gray-200"
            style="background: linear-gradient(to bottom, #FFB51B 0%, #e6a318 50%, #ffffff 50%, #ffffff 100%);">
            <div class="flex items-center justify-center h-28 w-full">
                <img src="<?php echo e(asset('assets/images/logo/YI_Logo.png')); ?>" alt="Company Logo"
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
                            <a href="<?php echo e(route('dashboard')); ?>"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>"
                                data-tooltip="Dashboard">
                                <i class="bx bxs-dashboard w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Dashboard</span>
                            </a>
                        </li>
                    </ul>
                </div>

                
                <?php if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Content Manager') || Auth::user()->hasRole('Program Coordinator')): ?>
                <div class="mb-4">
                    <h3 class="flex items-center text-sm font-medium text-primary mb-2">
                        <span class="sidebar-content">Content</span>
                        <span
                            class="flex-grow border-t border-gray-200 ml-3 sidebar-content sidebar-content-line"></span>
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="<?php echo e(route('content.index')); ?>"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item <?php echo e(request()->routeIs('content.index') ? 'active' : ''); ?>"
                                data-tooltip="Contents">
                                <i class="bx bxs-file-doc w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Contents</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('content.teamMembers.index')); ?>"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item <?php echo e(request()->routeIs('content.teamMembers.*') ? 'active' : ''); ?>"
                                data-tooltip="Team Members">
                                <i class="bx bx-user-pin w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Team Members</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <?php endif; ?>

                <?php if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Program Coordinator') || Auth::user()->hasRole('Volunteer')): ?>
                <div class="mb-4">
                    <h3 class="flex items-center text-sm font-medium text-primary mb-2">
                        <span class="sidebar-content">Programs</span>
                        <span
                            class="flex-grow border-t border-gray-200 ml-3 sidebar-content sidebar-content-line"></span>
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="<?php echo e(route('programs.index')); ?>"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item <?php echo e(request()->routeIs('programs.*') ? 'active' : ''); ?>"
                                data-tooltip="Programs">
                                <i class="bx bx-calendar w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Programs</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('program.chats.index', ['program' => request()->route('program')])); ?>"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item <?php echo e(request()->routeIs('program.chats.*') ? 'active' : ''); ?>"
                                data-tooltip="Program Chats">
                                <i class="bx bx-message-square-dots w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Program Chats</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <?php endif; ?>

                
                

                
                <div class="mb-4">
                    <h3 class="flex items-center text-sm font-medium text-primary mb-2">
                        <span class="sidebar-content">User</span>
                        <span
                            class="flex-grow border-t border-gray-200 ml-3 sidebar-content sidebar-content-line"></span>
                    </h3>
                    <ul class="space-y-1">
                        
                        <?php if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Program Coordinator')): ?>
                        <li>
                            <a href="<?php echo e(route('volunteers.index')); ?>"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item <?php echo e(request()->routeIs('volunteers.*') ? 'active' : ''); ?>"
                                data-tooltip="Volunteers">
                                <i class="bx bx-group w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Volunteers</span>
                            </a>
                        </li>
                        <?php endif; ?>
                        <?php if(Auth::user()->hasRole('Admin')): ?>
                        <li>
                            <a href="<?php echo e(route('members.index')); ?>"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item"
                                data-tooltip="Members">
                                <i class="bx bx-group w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Members</span>
                            </a>
                        </li>
                        <?php endif; ?>

                        
                        <?php if(Auth::user()->hasRole('Admin')): ?>
                        <li>
                            <a href="<?php echo e(route('roles.index')); ?>"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item <?php echo e(request()->routeIs('roles.*') ? 'active' : ''); ?>"
                                data-tooltip="Assign Roles">
                                <i class="bx bx-user-plus w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Assign Roles</span>
                            </a>
                        </li>
                        <?php endif; ?>
                    </ul>
                </div>

                
                <?php if(Auth::user()->hasRole('Admin') || Auth::user()->hasRole('Financial Coordinator')): ?>
                <div class="mb-4">
                    <h3 class="flex items-center text-sm font-medium text-primary mb-2">
                        <span class="sidebar-content">Financial</span>
                        <span
                            class="flex-grow border-t border-gray-200 ml-3 sidebar-content sidebar-content-line"></span>
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="<?php echo e(route('finance.index')); ?>"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item <?php echo e(request()->routeIs('finance.index') ? 'active' : ''); ?>"
                                data-tooltip="Donations">
                                <i class="bx bx-heart w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Donations</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo e(route('finance.membership.payments')); ?>"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item <?php echo e(request()->routeIs('finance.membership.payments*') ? 'active' : ''); ?>"
                                data-tooltip="Membership Payments">
                                <i class="bx bx-credit-card w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Membership</span>
                            </a>
                        </li>
                    </ul>
                </div>
                <?php endif; ?>

                <div class="mb-4">
                    <h3 class="flex items-center text-sm font-medium text-primary mb-2">
                        <span class="sidebar-content">Tools</span>
                        <span
                            class="flex-grow border-t border-gray-200 ml-3 sidebar-content sidebar-content-line"></span>
                    </h3>
                    <ul class="space-y-1">
                        <li>
                            <a href="<?php echo e(route('weather-forecast.index')); ?>"
                                class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item <?php echo e(request()->routeIs('weather-forecast.index') ? 'active' : ''); ?>"
                                data-tooltip="Weather Forecasts">
                                <i class="bx bx-cloud w-5 text-center flex-shrink-0 text-primary"></i>
                                <span class="ml-3 sidebar-content text-sm">Weather Forecasts</span>
                            </a>
                        </li>
                        <?php if(Auth::user()->hasRole('Admin') || config('app.env') == 'local'): ?>
                            <li>
                                <a href="<?php echo e(route('components.showcase')); ?>"
                                    class="sidebar-link flex items-center py-2 px-3 rounded-lg transition-all duration-200 group sidebar-item <?php echo e(request()->routeIs('components.showcase') ? 'active' : ''); ?>"
                                    data-tooltip="Component Showcase">
                                    <i class='bx bx-category w-5 text-center flex-shrink-0 text-primary'></i>
                                    <span class="ml-3 sidebar-content text-sm">Component Showcase</span>
                                </a>
                            </li>
                        <?php endif; ?>
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
            <form action="<?php echo e(route('logout')); ?>" method="POST" class="w-full">
                <?php echo csrf_field(); ?>
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
                                <?php if (isset($component)) { $__componentOriginal894294112bf23c4166443c90d4833959 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal894294112bf23c4166443c90d4833959 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.form.search-input','data' => ['name' => 'search','placeholder' => 'Search...','class' => 'w-64']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('form.search-input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['name' => 'search','placeholder' => 'Search...','class' => 'w-64']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal894294112bf23c4166443c90d4833959)): ?>
<?php $attributes = $__attributesOriginal894294112bf23c4166443c90d4833959; ?>
<?php unset($__attributesOriginal894294112bf23c4166443c90d4833959); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal894294112bf23c4166443c90d4833959)): ?>
<?php $component = $__componentOriginal894294112bf23c4166443c90d4833959; ?>
<?php unset($__componentOriginal894294112bf23c4166443c90d4833959); ?>
<?php endif; ?>
                            </div>

                            <a href="<?php echo e(route('website.index')); ?>"
                                class="hidden lg:block text-gray-600 hover:text-primary transition-all duration-200 text-sm">Website</a>
                            <a href="<?php echo e(route('weather-forecast.index')); ?>"
                                class="hidden lg:block text-gray-600 hover:text-primary transition-all duration-200 text-sm">Weather</a>
                            <a href="<?php echo e(route('consultation-hours.index')); ?>"
                                class="hidden lg:block text-gray-600 hover:text-primary transition-all duration-200 text-sm">Consultation Hours</a>
                            <a href="<?php echo e(route('consultation-chats.index')); ?>"
                                class="hidden lg:block text-gray-600 hover:text-primary transition-all duration-200 text-sm">Consultation Chats</a>
                        </div>
                    </div>
                </div>

                <div class="flex items-center space-x-3 flex-wrap max-w-full">
                    <button
                        class="sm:hidden p-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-200">
                        <i class="fas fa-search text-lg"></i>
                    </button>

                    <a href="<?php echo e(route('notifications.index')); ?>"
                        class="p-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-200 relative">
                        <i class="fas fa-bell text-lg"></i>
                        <?php if(Auth::check() && Auth::user()->unreadNotifications->count() > 0): ?>
                            <span
                                class="absolute -top-1 -right-1 h-4 w-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center">
                                <?php echo e(Auth::user()->unreadNotifications->count()); ?>

                            </span>
                        <?php endif; ?>
                    </a>

                    <div class="relative">
                        <a href="<?php echo e(route('profile.me')); ?>"
                            class="flex items-center space-x-2 p-2 text-gray-600 hover:text-primary hover:bg-gray-100 rounded-lg transition-all duration-200"
                            title="My Profile">
                            <?php if (isset($component)) { $__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-avatar','data' => ['user' => Auth::user(),'size' => '8','showName' => true]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(Auth::user()),'size' => '8','showName' => true]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e)): ?>
<?php $attributes = $__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e; ?>
<?php unset($__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e)): ?>
<?php $component = $__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e; ?>
<?php unset($__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e); ?>
<?php endif; ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <div id="mainContent" class="main-content pt-16">
        <?php echo $__env->make('layouts.partials.breadcrumb', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        

        <?php if(session('toast')): ?>
            <?php if (isset($component)) { $__componentOriginal4369abbb857f0aa87adb9fbdd60d2750 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4369abbb857f0aa87adb9fbdd60d2750 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.toast','data' => ['message' => session('toast')['message'],'type' => session('toast')['type']]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.toast'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['message' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(session('toast')['message']),'type' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(session('toast')['type'])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4369abbb857f0aa87adb9fbdd60d2750)): ?>
<?php $attributes = $__attributesOriginal4369abbb857f0aa87adb9fbdd60d2750; ?>
<?php unset($__attributesOriginal4369abbb857f0aa87adb9fbdd60d2750); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4369abbb857f0aa87adb9fbdd60d2750)): ?>
<?php $component = $__componentOriginal4369abbb857f0aa87adb9fbdd60d2750; ?>
<?php unset($__componentOriginal4369abbb857f0aa87adb9fbdd60d2750); ?>
<?php endif; ?>
        <?php endif; ?>

        <?php echo $__env->yieldContent('content'); ?>
    </div>

    <div id="tooltip"
        class="absolute bg-gray-900 text-white text-sm rounded py-1 px-2 z-50 opacity-0 pointer-events-none transition-opacity duration-200">
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-...sha..." crossorigin="anonymous"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>

</html>
<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/layouts/sidebar_final.blade.php ENDPATH**/ ?>