
<div class="space-y-6">
    <?php if (isset($component)) { $__componentOriginald9918ddcf3390853d71668d0bbbc807b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginald9918ddcf3390853d71668d0bbbc807b = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.overview.stat-card-group','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overview.stat-card-group'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <?php if (isset($component)) { $__componentOriginala2a6daa278525171621a6e53b924f9e1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala2a6daa278525171621a6e53b924f9e1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.overview.stat-card','data' => ['icon' => 'bx-user','title' => 'Total Volunteers','value' => $approvedVolunteers->count(),'bgColor' => 'bg-blue-100','iconColor' => 'text-blue-500','gradientVariant' => 'ocean','href' => ''.e(route('volunteers.index', ['tab' => 'approved'])).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overview.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bx-user','title' => 'Total Volunteers','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($approvedVolunteers->count()),'bgColor' => 'bg-blue-100','iconColor' => 'text-blue-500','gradientVariant' => 'ocean','href' => ''.e(route('volunteers.index', ['tab' => 'approved'])).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala2a6daa278525171621a6e53b924f9e1)): ?>
<?php $attributes = $__attributesOriginala2a6daa278525171621a6e53b924f9e1; ?>
<?php unset($__attributesOriginala2a6daa278525171621a6e53b924f9e1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala2a6daa278525171621a6e53b924f9e1)): ?>
<?php $component = $__componentOriginala2a6daa278525171621a6e53b924f9e1; ?>
<?php unset($__componentOriginala2a6daa278525171621a6e53b924f9e1); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginala2a6daa278525171621a6e53b924f9e1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala2a6daa278525171621a6e53b924f9e1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.overview.stat-card','data' => ['icon' => 'bx-time','title' => 'Pending Applications','value' => $applications->count(),'bgColor' => 'bg-yellow-100','iconColor' => 'text-yellow-500','gradientVariant' => 'golden','href' => ''.e(route('volunteers.index', ['tab' => 'applications'])).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overview.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bx-time','title' => 'Pending Applications','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($applications->count()),'bgColor' => 'bg-yellow-100','iconColor' => 'text-yellow-500','gradientVariant' => 'golden','href' => ''.e(route('volunteers.index', ['tab' => 'applications'])).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala2a6daa278525171621a6e53b924f9e1)): ?>
<?php $attributes = $__attributesOriginala2a6daa278525171621a6e53b924f9e1; ?>
<?php unset($__attributesOriginala2a6daa278525171621a6e53b924f9e1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala2a6daa278525171621a6e53b924f9e1)): ?>
<?php $component = $__componentOriginala2a6daa278525171621a6e53b924f9e1; ?>
<?php unset($__componentOriginala2a6daa278525171621a6e53b924f9e1); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginala2a6daa278525171621a6e53b924f9e1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala2a6daa278525171621a6e53b924f9e1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.overview.stat-card','data' => ['icon' => 'bx-x-circle','title' => 'Denied Applications','value' => $deniedApplications->count(),'bgColor' => 'bg-red-100','iconColor' => 'text-red-500','gradientVariant' => 'cherry','href' => ''.e(route('volunteers.index', ['tab' => 'denied'])).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overview.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bx-x-circle','title' => 'Denied Applications','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($deniedApplications->count()),'bgColor' => 'bg-red-100','iconColor' => 'text-red-500','gradientVariant' => 'cherry','href' => ''.e(route('volunteers.index', ['tab' => 'denied'])).'']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala2a6daa278525171621a6e53b924f9e1)): ?>
<?php $attributes = $__attributesOriginala2a6daa278525171621a6e53b924f9e1; ?>
<?php unset($__attributesOriginala2a6daa278525171621a6e53b924f9e1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala2a6daa278525171621a6e53b924f9e1)): ?>
<?php $component = $__componentOriginala2a6daa278525171621a6e53b924f9e1; ?>
<?php unset($__componentOriginala2a6daa278525171621a6e53b924f9e1); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginala2a6daa278525171621a6e53b924f9e1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala2a6daa278525171621a6e53b924f9e1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.overview.stat-card','data' => ['icon' => 'bx-trending-up','title' => 'Approval Rate','value' => ''.e($approvalRate).'%','bgColor' => 'bg-green-100','iconColor' => 'text-green-500','gradientVariant' => 'forest']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overview.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bx-trending-up','title' => 'Approval Rate','value' => ''.e($approvalRate).'%','bgColor' => 'bg-green-100','iconColor' => 'text-green-500','gradientVariant' => 'forest']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala2a6daa278525171621a6e53b924f9e1)): ?>
<?php $attributes = $__attributesOriginala2a6daa278525171621a6e53b924f9e1; ?>
<?php unset($__attributesOriginala2a6daa278525171621a6e53b924f9e1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala2a6daa278525171621a6e53b924f9e1)): ?>
<?php $component = $__componentOriginala2a6daa278525171621a6e53b924f9e1; ?>
<?php unset($__componentOriginala2a6daa278525171621a6e53b924f9e1); ?>
<?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginald9918ddcf3390853d71668d0bbbc807b)): ?>
<?php $attributes = $__attributesOriginald9918ddcf3390853d71668d0bbbc807b; ?>
<?php unset($__attributesOriginald9918ddcf3390853d71668d0bbbc807b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginald9918ddcf3390853d71668d0bbbc807b)): ?>
<?php $component = $__componentOriginald9918ddcf3390853d71668d0bbbc807b; ?>
<?php unset($__componentOriginald9918ddcf3390853d71668d0bbbc807b); ?>
<?php endif; ?>

    
    <?php if (isset($component)) { $__componentOriginal5047e3a08dc66ef13a024f32c8319cd0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5047e3a08dc66ef13a024f32c8319cd0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.overview.card','data' => ['title' => 'Recent Activity','variant' => 'midnight-header']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overview.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Recent Activity','variant' => 'midnight-header']); ?>
        <div class="space-y-3 sm:space-y-4">
            <?php $__empty_1 = true; $__currentLoopData = $recentActivities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $volunteer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="flex items-center justify-between border-b pb-2 sm:pb-3 last:border-0">
                    <div class="flex items-center space-x-2 sm:space-x-3">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-gray-100 flex items-center justify-center">
                            <i class='bx bx-user text-lg sm:text-xl text-gray-500'></i>
                        </div>
                        <div>
                            <p class="text-sm sm:text-base font-medium text-[#1a2235]"><?php echo e($volunteer->user->name); ?></p>
                            <p class="text-xs sm:text-sm text-gray-600">
                                <?php if($volunteer->application_status === 'pending'): ?>
                                    Application submitted
                                <?php elseif($volunteer->application_status === 'approved'): ?>
                                    Application approved
                                <?php else: ?>
                                    Application denied
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <span class="text-xs sm:text-sm text-gray-500 whitespace-nowrap">
                        <?php echo e($volunteer->updated_at->diffForHumans()); ?>

                    </span>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-600 text-center py-4">No recent activity</p>
            <?php endif; ?>
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
</div><?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/volunteers/partials/volunteersOverview.blade.php ENDPATH**/ ?>