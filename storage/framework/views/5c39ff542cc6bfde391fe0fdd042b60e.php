<?php $__env->startSection('content'); ?>
    <head>
        <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2/dist/alpine.min.js" defer></script>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>

    <div class="container mx-auto p-6">
        <!-- Profile Header -->
        <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 shadow-lg rounded-2xl p-8 flex flex-col items-center text-white mb-10">
            <div class="relative mb-4">
                <img src="<?php echo e(Auth::user()->profile_pic ?? asset('assets/images/logo/YI_Logo.png')); ?>" alt="Profile Picture" class="w-28 h-28 rounded-full border-4 border-white shadow-md object-cover">
                <span class="absolute bottom-2 right-2 bg-green-400 border-2 border-white rounded-full w-5 h-5"></span>
            </div>
            <h2 class="text-2xl font-bold mb-1"><?php echo e(Auth::user()->name); ?></h2>
            <p class="text-md opacity-90 mb-2 flex items-center"><i class='bx bx-envelope mr-2'></i><?php echo e(Auth::user()->email); ?></p>
            <div class="flex flex-wrap justify-center gap-2 mb-2">
                <?php if(Auth::user()->roles->isNotEmpty()): ?>
                    <?php $__currentLoopData = Auth::user()->roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <span class="bg-white bg-opacity-20 text-white text-xs font-semibold px-3 py-1 rounded-full border border-white flex items-center"><i class='bx bx-user mr-1'></i><?php echo e($role->role_name); ?></span>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <span class="text-white text-xs">No roles assigned.</span>
                <?php endif; ?>
            </div>
        </div>

        

        <!-- Get Involved Section -->
        <div class="bg-gradient-to-r from-green-400 to-blue-500 rounded-2xl shadow-lg p-8 flex flex-col items-center text-white mb-10">
            <h3 class="text-xl font-semibold mb-2 flex items-center"><i class='bx bx-group mr-2'></i>Get Involved!</h3>
            <p class="mb-4 text-center">Become a volunteer and make a difference in your community. Join programs, contribute, and connect with others!</p>
            <?php if(Auth::user()->volunteer): ?>
                <a href="<?php echo e(route('programs.index')); ?>" class="inline-block px-6 py-3 bg-white text-green-600 font-bold rounded-lg shadow hover:bg-gray-100 transition-colors">View Your Programs</a>
            <?php else: ?>
                <a href="<?php echo e(route('volunteers.form')); ?>" class="inline-block px-6 py-3 bg-white text-blue-600 font-bold rounded-lg shadow hover:bg-gray-100 transition-colors">Become a Volunteer</a>
            <?php endif; ?>
        </div>

        <!-- Recent Activity Placeholder -->
        

        <!-- Logout Button -->
        <form action="<?php echo e(route('logout')); ?>" method="POST" class="mt-6 max-w-md mx-auto">
            <?php echo csrf_field(); ?>
            <button type="submit" class="btn btn-error w-full">Logout</button>
        </form>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sidebar_final', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/dashboard.blade.php ENDPATH**/ ?>