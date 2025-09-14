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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.overview.stat-card','data' => ['icon' => 'bx-group','title' => 'Total Members','value' => $totalMembersCount,'bgColor' => 'bg-green-100','iconColor' => 'text-green-500','gradientVariant' => 'emerald-teal']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overview.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bx-group','title' => 'Total Members','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($totalMembersCount),'bgColor' => 'bg-green-100','iconColor' => 'text-green-500','gradientVariant' => 'emerald-teal']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.overview.stat-card','data' => ['icon' => 'bx-user-check','title' => 'Active Members','value' => $activeMembersCount,'bgColor' => 'bg-green-100','iconColor' => 'text-green-500','gradientVariant' => 'golden']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overview.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bx-user-check','title' => 'Active Members','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($activeMembersCount),'bgColor' => 'bg-green-100','iconColor' => 'text-green-500','gradientVariant' => 'golden']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.overview.stat-card','data' => ['icon' => 'bx-star','title' => 'Full-Pledge Members','value' => $fullPledgeMembersCount,'bgColor' => 'bg-yellow-100','iconColor' => 'text-yellow-500','gradientVariant' => 'cherry']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overview.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bx-star','title' => 'Full-Pledge Members','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($fullPledgeMembersCount),'bgColor' => 'bg-yellow-100','iconColor' => 'text-yellow-500','gradientVariant' => 'cherry']); ?>
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
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.overview.stat-card','data' => ['icon' => 'bx-award','title' => 'Honorary Members','value' => $honoraryMembersCount,'bgColor' => 'bg-purple-100','iconColor' => 'text-purple-500','gradientVariant' => 'ocean']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overview.stat-card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bx-award','title' => 'Honorary Members','value' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($honoraryMembersCount),'bgColor' => 'bg-purple-100','iconColor' => 'text-purple-500','gradientVariant' => 'ocean']); ?>
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

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    
    <?php if (isset($component)) { $__componentOriginal5047e3a08dc66ef13a024f32c8319cd0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5047e3a08dc66ef13a024f32c8319cd0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.overview.card','data' => ['title' => 'Recently Joined Members','variant' => 'midnight-header']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overview.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Recently Joined Members','variant' => 'midnight-header']); ?>
        <?php $__empty_1 = true; $__currentLoopData = $recentlyJoinedMembers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php if (isset($component)) { $__componentOriginalcdcb34575a83a716bcff48a337f08f34 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcdcb34575a83a716bcff48a337f08f34 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.overview.summary-list-item','data' => ['imageUrl' => $member->profile_photo_url]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overview.summary-list-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['imageUrl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($member->profile_photo_url)]); ?>
                 <?php $__env->slot('title', null, []); ?> <?php echo e($member->user->name); ?> <?php $__env->endSlot(); ?>
                 <?php $__env->slot('subtitle', null, []); ?> Joined on <?php echo e($member->start_date->format('M d, Y')); ?> <?php $__env->endSlot(); ?>
                 <?php $__env->slot('action', null, []); ?> 
                    <span class="text-sm text-gray-600"><?php echo e(ucfirst(str_replace('_', ' ', $member->membership_type))); ?></span>
                 <?php $__env->endSlot(); ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcdcb34575a83a716bcff48a337f08f34)): ?>
<?php $attributes = $__attributesOriginalcdcb34575a83a716bcff48a337f08f34; ?>
<?php unset($__attributesOriginalcdcb34575a83a716bcff48a337f08f34); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcdcb34575a83a716bcff48a337f08f34)): ?>
<?php $component = $__componentOriginalcdcb34575a83a716bcff48a337f08f34; ?>
<?php unset($__componentOriginalcdcb34575a83a716bcff48a337f08f34); ?>
<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-gray-500 text-center py-4">No recently joined members.</p>
        <?php endif; ?>
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

    
    <?php if (isset($component)) { $__componentOriginal5047e3a08dc66ef13a024f32c8319cd0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5047e3a08dc66ef13a024f32c8319cd0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.overview.card','data' => ['title' => 'Oldest Pending Invitations','variant' => 'midnight-header']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overview.card'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['title' => 'Oldest Pending Invitations','variant' => 'midnight-header']); ?>
        <?php $__empty_1 = true; $__currentLoopData = $oldestPendingInvitations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $member): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php if (isset($component)) { $__componentOriginalcdcb34575a83a716bcff48a337f08f34 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalcdcb34575a83a716bcff48a337f08f34 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.overview.summary-list-item','data' => ['imageUrl' => $member->profile_photo_url]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('overview.summary-list-item'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['imageUrl' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($member->profile_photo_url)]); ?>
                 <?php $__env->slot('title', null, []); ?> <?php echo e($member->user->name); ?> <?php $__env->endSlot(); ?>
                 <?php $__env->slot('subtitle', null, []); ?> Invited on <?php echo e($member->invited_at->format('M d, Y')); ?> (<?php echo e($member->invited_at->diffForHumans()); ?>) <?php $__env->endSlot(); ?>
                 <?php $__env->slot('action', null, []); ?> 
                    <form action="<?php echo e(route('members.resend-invitation', $member)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="text-sm text-indigo-600 hover:text-indigo-900 font-medium">Resend</button>
                    </form>
                 <?php $__env->endSlot(); ?>
             <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalcdcb34575a83a716bcff48a337f08f34)): ?>
<?php $attributes = $__attributesOriginalcdcb34575a83a716bcff48a337f08f34; ?>
<?php unset($__attributesOriginalcdcb34575a83a716bcff48a337f08f34); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalcdcb34575a83a716bcff48a337f08f34)): ?>
<?php $component = $__componentOriginalcdcb34575a83a716bcff48a337f08f34; ?>
<?php unset($__componentOriginalcdcb34575a83a716bcff48a337f08f34); ?>
<?php endif; ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-gray-500 text-center py-4">No pending invitations.</p>
        <?php endif; ?>
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
</div> <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/member/partials/membersOverview.blade.php ENDPATH**/ ?>