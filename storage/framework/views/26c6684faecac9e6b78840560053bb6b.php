

<?php $__env->startSection('content'); ?>
<div class="px-4 sm:px-6 lg:px-8 py-6">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl font-semibold text-[#1a2235]">Program Requests</h1>
            <p class="text-sm text-gray-500 mt-1">All submitted program ideas.</p>
        </div>
        <a href="<?php echo e(route('website.programs')); ?>#request-form"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#ffb51b] text-[#1a2235] text-sm font-medium hover:bg-[#e6a319] transition">
            <i class='bx bx-plus'></i> Submit New
        </a>
    </div>

    <!-- Empty State -->
    <?php if($requests->isEmpty()): ?>
        <?php if (isset($component)) { $__componentOriginal074a021b9d42f490272b5eefda63257c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal074a021b9d42f490272b5eefda63257c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.empty-state','data' => ['icon' => 'bx bx-folder-open','title' => 'No Program Requests','description' => 'Be the first to submit a program idea.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('empty-state'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bx bx-folder-open','title' => 'No Program Requests','description' => 'Be the first to submit a program idea.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $attributes = $__attributesOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__attributesOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal074a021b9d42f490272b5eefda63257c)): ?>
<?php $component = $__componentOriginal074a021b9d42f490272b5eefda63257c; ?>
<?php unset($__componentOriginal074a021b9d42f490272b5eefda63257c); ?>
<?php endif; ?>
    <?php else: ?>
        <!-- Responsive Grid -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            <?php $__currentLoopData = $requests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $req): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $short = \Illuminate\Support\Str::limit($req->description, 120);
                ?>

                <?php if (isset($component)) { $__componentOriginal5047e3a08dc66ef13a024f32c8319cd0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5047e3a08dc66ef13a024f32c8319cd0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.overview.card','data' => ['title' => $req->title,'icon' => 'bx-bulb','variant' => 'default']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overview.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($req->title),'icon' => 'bx-bulb','variant' => 'default']); ?>
                    <div class="space-y-3 text-sm">
                        <!-- Meta info -->
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="bx bx-user-pin text-[#ffb51b] text-sm"></i>
                                <span class="font-medium"><?php echo e($req->name); ?></span>
                            </span>
                            <span>
                                <?php echo e($req->proposed_date ? \Carbon\Carbon::parse($req->proposed_date)->format('M j, Y') : 'TBD'); ?>

                            </span>
                        </div>

                        <!-- Short description -->
                        <p class="text-gray-600 leading-relaxed line-clamp-3">
                            <?php echo e($short); ?>

                        </p>

                        <!-- Tags -->
                        <div class="flex flex-wrap gap-2 text-xs">
                            <?php if($req->target_audience): ?>
                                <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-600">
                                    <?php echo e($req->target_audience); ?>

                                </span>
                            <?php endif; ?>
                            <?php if($req->location): ?>
                                <span class="px-2 py-0.5 rounded bg-[#ffb51b]/10 text-[#b37f13]">
                                    <?php echo e($req->location); ?>

                                </span>
                            <?php endif; ?>
                        </div>

                        <!-- Footer -->
                        <div class="pt-2 flex items-center justify-between text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="bx bx-time-five text-[#ffb51b]"></i>
                                <?php echo e($req->created_at->diffForHumans()); ?>

                            </span>
                            <button type="button"
                                class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-[#1a2235]/10 text-[#1a2235] text-xs font-medium hover:bg-[#1a2235]/20 transition"
                                onclick="document.getElementById('programRequest-<?php echo e($req->id); ?>').showModal()">
                                <i class="bx bx-show"></i> View
                            </button>
                        </div>
                    </div>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5047e3a08dc66ef13a024f32c8319cd0)): ?>
<?php $attributes = $__attributesOriginal5047e3a08dc66ef13a024f32c8319cd0; ?>
<?php unset($__attributesOriginal5047e3a08dc66ef13a024f32c8319cd0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5047e3a08dc66ef13a024f32c8319cd0)): ?>
<?php $component = $__componentOriginal5047e3a08dc66ef13a024f32c8319cd0; ?>
<?php unset($__componentOriginal5047e3a08dc66ef13a024f32c8319cd0); ?>
<?php endif; ?>

                <?php echo $__env->make('program_requests.modals.programRequestDetails', [
                    'req' => $req,
                    'modalId' => 'programRequest-'.$req->id
                ], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            <?php echo e($requests->links()); ?>

        </div>
    <?php endif; ?>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sidebar_final', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/program_requests/index.blade.php ENDPATH**/ ?>