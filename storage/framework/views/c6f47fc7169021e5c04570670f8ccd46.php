<?php $__env->startSection('content'); ?>
    <section class="h-screen flex flex-col items-center justify-center text-center px-6 mt-20">
        <?php if (isset($component)) { $__componentOriginal6a0a1523cc2edf33c83fe20a5d1f7f78 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6a0a1523cc2edf33c83fe20a5d1f7f78 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.section-title','data' => ['first' => 'Our','second' => 'Purpose']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('section-title'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['first' => 'Our','second' => 'Purpose']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6a0a1523cc2edf33c83fe20a5d1f7f78)): ?>
<?php $attributes = $__attributesOriginal6a0a1523cc2edf33c83fe20a5d1f7f78; ?>
<?php unset($__attributesOriginal6a0a1523cc2edf33c83fe20a5d1f7f78); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6a0a1523cc2edf33c83fe20a5d1f7f78)): ?>
<?php $component = $__componentOriginal6a0a1523cc2edf33c83fe20a5d1f7f78; ?>
<?php unset($__componentOriginal6a0a1523cc2edf33c83fe20a5d1f7f78); ?>
<?php endif; ?>
        <p class="mt-4 text-gray-600 text-lg max-w-2xl">Get the latest updates and deeper connection with us!</p>


        <?php if($featuredPost): ?>
            <a href="<?php echo e(route('website.view-content', $featuredPost->slug)); ?>"
                class="container mx-auto px-4 py-8 flex justify-center">
                <div class="w-full md:w-10/12 lg:w-8/12">
                    <?php if($featuredPost->image_content): ?>
                        <img src="<?php echo e(\App\Http\Controllers\WebsiteController::getImageUrl($featuredPost->image_content)); ?>"
                            alt="Featured Content Image" class="w-full h-96 object-cover rounded-2xl">
                    <?php endif; ?>
                    <div class="pt-6 pl-2 text-left">
                        <h2 class="text-3xl font-bold text-gray-800"><?php echo e($featuredPost->title); ?></h2>
                        <p class="text-sm text-gray-500 mt-2">Published on:
                            <?php echo e($featuredPost->created_at->format('F j, Y')); ?></p>
                    </div>
                </div>
            </a>
    </section>

    <div class="container mx-auto px-4 py-6 bg-white flex justify-center">
        <div class="w-9/12">

            <?php $__empty_1 = true; $__currentLoopData = $latestPosts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="py-4"> 
                    <a href="<?php echo e(route('website.view-content', $post->slug)); ?>" class="block w-11/12 mx-auto no-underline">
                        <div
                            class="bg-white flex flex-col mx-3 md:flex-row items-center w-full hover:bg-gray-200 transition duration-200">
                            <?php if($post->image_content): ?>
                                <img src="<?php echo e(\App\Http\Controllers\WebsiteController::getImageUrl($post->image_content)); ?>"
                                    alt="Content Image" class="md:w-1/4 w-full h-40 object-cover">
                            <?php endif; ?>
                            <div class="p-4 flex flex-col justify-center md:w-3/4">
                                <h2 class="text-lg font-bold text-gray-800"><?php echo e($post->title); ?></h2>
                                <p class="text-xs text-gray-500 mt-1">Published on:
                                    <?php echo e($post->created_at->format('F j, Y')); ?></p>
                            </div>
                        </div>
                    </a>
                </div>

                
                <?php if(!$loop->last): ?>
                    <hr class="border-gray-300 my-4 w-11/12 mx-auto">
                <?php endif; ?>

            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                
            <?php endif; ?>

        </div>
    </div>
<?php else: ?>
    <div class="text-center py-16">
        <p class="text-gray-500 text-xl">No news or updates have been posted yet. Please check back later!</p>
    </div>
    <?php endif; ?>


    <div class="bg-[#1A2235] py-4">
        <ul class="flex flex-row items-center justify-evenly">
            <li class="flex flex-col items-center justify-center px-6 text-white font-bold text-2xl leading-tight">
                <span>Quick</span>
                <span>Links</span>
            </li>
            <span class="w-px h-12 bg-gray-500"></span>

            <li class="flex items-center justify-center px-6">
                <a href="#" class="text-gray-300 hover:text-white transition">Programs</a>
            </li>

            <span class="w-px h-12 bg-gray-500"></span>

            <li class="flex items-center justify-center px-6">
                <a href="#" class="text-gray-300 hover:text-white transition">About Us</a>
            </li>

            <span class="w-px h-12 bg-gray-500"></span>

            <li class="flex items-center justify-center px-6">
                <a href="#" class="text-gray-300 hover:text-white transition">Meet the Team</a>
            </li>
        </ul>
    </div>

    <section
        class="w-full min-h-[700px] px-6 md:px-16 lg:px-40 pt-12 md:pt-16 lg:pt-20 pb-4 bg-[url('/assets/images/bg/BG-1.png')] bg-auto relative">
        

        <div class="relative flex flex-col justify-center items-start h-full w-full text-left gap-6">
            <div class="max-w-5xl">
                <p class="text-black text-2xl md:text-3xl lg:text-4xl font-normal mb-4">Be one of us!</p>
                <h2 class="text-3xl md:text-5xl lg:text-6xl font-bold text-black inline">
                    In <span class="text-amber-400">Youmanitarian International</span>
                </h2>
                <p class="mt-6 text-black text-lg md:text-xl lg:text-2xl font-normal leading-relaxed">
                    We believe that every helping hand can change a life.<br />
                    Whether you have time, skills, or simply the will to help, there’s a place for you here.
                </p>
            </div>

            <button
                class="px-4 md:px-5 py-2 md:py-3 bg-sky-950 rounded-full inline-flex items-center gap-4 hover:bg-sky-900 transition">
                <span class="text-white text-base md:text-lg font-bold leading-tight">
                    Become a Volunteer
                </span>
                <span class="w-8 h-8 bg-gray-100/20 rounded-full flex items-center justify-center">
                    <i class="bx bx-right-arrow-alt text-white text-lg md:text-xl"></i>
                </span>
            </button>

        </div>
    </section>





<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/website/index.blade.php ENDPATH**/ ?>