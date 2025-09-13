<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Youmanitarian International</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Anton&family=Oswald:wght@200..700&family=Source+Sans+3:ital,wght@0,200..900;1,200..900&display=swap" rel="stylesheet">

    <style>
        *{
            font-family: "Source Sans 3", sans-serif;
        }
        :root {
            --primary-color: #1A2235;
            --primary-tint-1: #313849;
            --primary-tint-2: #484E5D;
            --primary-tint-3: #5F6472;
            --primary-tint-4: #767A86;
            --primary-tint-5: #8D919A;
            --primary-tint-6: #A3A7AE;
            --accent-color: #FFB51B;
        }

        .text-primary-custom {
            color: var(--primary-color);
        }

        .text-accent-custom {
            color: var(--accent-color);
        }

        .bg-primary-custom {
            background-color: var(--primary-color);
        }

        .bg-accent-custom {
            background-color: var(--accent-color);
        }

        .border-accent-custom {
            border-color: var(--accent-color);
        }

        .ring-accent-custom {
            --tw-ring-color: var(--accent-color);
        }

    </style>
</head>

<body class="bg-gray-50">
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

    
    <header class="bg-white shadow-md fixed top-0 left-0 w-full z-50 h-20">
        <div class="container mx-auto px-6 py-4 flex items-center justify-between">
            
            <div class="flex items-center space-x-3">
                <img src="<?php echo e(asset('assets/images/logo/YI_Logo.png')); ?>" alt="Logo" class="h-12 sm:h-14 w-auto">
                <h1 class="text-sm sm:text-base lg:text-lg font-bold text-gray-800 whitespace-nowrap">
                    Youmanitarian International
                </h1>
            </div>

            
            <nav class="hidden lg:flex items-center space-x-6 text-base">
                <a href="<?php echo e(route('website.index')); ?>"
                    class="text-primary-custom hover:text-accent-custom transition-colors duration-300
   <?php echo e(request()->routeIs('website.index') ? 'text-accent-custom font-bold' : ''); ?>">
                    Home
                </a>

                

                <a href="<?php echo e(route('website.programs')); ?>"
                    class="text-primary-custom hover:text-accent-custom transition-colors duration-300
   <?php echo e(request()->routeIs('website.programs') ? 'text-accent-custom font-bold' : ''); ?>">
                    Program
                </a>

                <a href="<?php echo e(route('website.sponsors')); ?>"
                    class="text-primary-custom hover:text-accent-custom active:text-accent-custom transition-colors duration-300">
                    Sponsor & Partnership
                </a>
                <a href="<?php echo e(route('website.about')); ?>"
                    class="text-primary-custom hover:text-accent-custom active:text-accent-custom transition-colors duration-300">
                    About Us
                </a>
                <a href="<?php echo e(route('website.team')); ?>"
                    class="text-primary-custom hover:text-accent-custom active:text-accent-custom transition-colors duration-300">
                    Meet the Team
                </a>
                <a href="<?php echo e(route('website.donate')); ?>"
                    class="text-primary-custom hover:text-accent-custom active:text-accent-custom transition-colors duration-300">
                    Donate Today
                </a>

                <?php if(Auth::check()): ?>
                    <a href="<?php echo e(url('/dashboard')); ?>"
                        class="btn bg-[#101529] text-white border-[#101529] hover:bg-[#1a2235]">
                        Dashboard
                    </a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="hidden"><?php echo csrf_field(); ?></form>
                <?php else: ?>
                    <a href="<?php echo e(url('/login')); ?>"
                        class="btn bg-[#101529] text-white border-[#101529] hover:bg-[#1a2235]">
                        Login
                    </a>
                <?php endif; ?>
            </nav>


            
            <div class="lg:hidden" x-data="{ open: false }">
                <button @click="open = !open" class="text-gray-700 text-3xl focus:outline-none">
                    <i class="bx bx-menu"></i>
                </button>

                
                <div x-show="open" x-transition class="absolute top-16 left-0 w-full bg-white shadow-lg border-t z-20">
                    <nav class="flex flex-col p-4 space-y-3 text-base">
                        <a href="<?php echo e(route('website.index')); ?>" class="text-gray-600 hover:text-blue-600">Home</a>
                        
                        <a href="<?php echo e(route('website.programs')); ?>" class="text-gray-600 hover:text-blue-600">Program</a>
                        <a href="<?php echo e(route('website.sponsors')); ?>" class="text-gray-600 hover:text-blue-600">Sponsor &
                            Partnership</a>
                        <a href="<?php echo e(route('website.about')); ?>" class="text-gray-600 hover:text-blue-600">About Us</a>
                        <a href="<?php echo e(route('website.team')); ?>" class="text-gray-600 hover:text-blue-600">Meet the
                            Team</a>
                        <a href="<?php echo e(route('website.donate')); ?>" class="text-gray-600 hover:text-blue-600">Donate
                            Today</a>

                        <?php if(Auth::check()): ?>
                            <a href="<?php echo e(url('/dashboard')); ?>"
                                class="btn bg-[#101529] text-white border-[#101529] hover:bg-[#1a2235]">Dashboard</a>
                            <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="hidden"><?php echo csrf_field(); ?>
                            </form>
                        <?php else: ?>
                            <a href="<?php echo e(url('/login')); ?>"
                                class="btn bg-[#101529] text-white border-[#101529] hover:bg-[#1a2235]">Login</a>
                        <?php endif; ?>
                    </nav>
                </div>
            </div>
        </div>
    </header>

    
    <main class="pt-20"> 
        <?php echo $__env->yieldContent('content'); ?>
    </main>
</body>

</html>
<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/layouts/navbar.blade.php ENDPATH**/ ?>