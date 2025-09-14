<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['icon' => 'bx-file','title' => 'Content Management','desc' => 'View, create, and manage all site content, articles, and media.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bx-file','title' => 'Content Management','desc' => 'View, create, and manage all site content, articles, and media.']); ?>

        <?php if (isset($component)) { $__componentOriginale67687e3e4e61f963b25a6bcf3983629 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale67687e3e4e61f963b25a6bcf3983629 = $attributes; } ?>
<?php $component = App\View\Components\Button::resolve(['variant' => 'add-create'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => ''.e(route('content.create')).'','class' => 'mb-6']); ?>
            <i class='bx bx-plus-circle mr-2'></i> Add Content
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale67687e3e4e61f963b25a6bcf3983629)): ?>
<?php $attributes = $__attributesOriginale67687e3e4e61f963b25a6bcf3983629; ?>
<?php unset($__attributesOriginale67687e3e4e61f963b25a6bcf3983629); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale67687e3e4e61f963b25a6bcf3983629)): ?>
<?php $component = $__componentOriginale67687e3e4e61f963b25a6bcf3983629; ?>
<?php unset($__componentOriginale67687e3e4e61f963b25a6bcf3983629); ?>
<?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $attributes = $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e)): ?>
<?php $component = $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e; ?>
<?php unset($__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e); ?>
<?php endif; ?>

    <?php
        $user = Auth::user();
        $isCoordinator = $user->hasRole('Program Coordinator');
        $isManager = $user->hasRole('Content Manager');
        $isAdmin = $user->hasRole('Admin');

        $tabs = [ //all
            ['id' => 'my', 'label' => 'My Content', 'icon' => 'bx-user'],
            ['id' => 'published', 'label' => 'Published', 'icon' => 'bx-globe'],
        ];

        // arcchive para lang kay $isCoordinator || $isAdm
        if ($isManager || $isAdmin) {
            $tabs[] = ['id' => 'archived', 'label' => 'Archived', 'icon' => 'bx-archive'];
        }

        // kay program coordinator lang, since siya lang need ng approval when creating content.
        if ($isCoordinator && !$isAdmin && !$isManager) {
            $tabs[] = ['id' => 'submitted', 'label' => 'Submitted', 'icon' => 'bx-upload'];
            $tabs[] = ['id' => 'needs_revision', 'label' => 'Needs Revision', 'icon' => 'bx-refresh'];
        }

        // then dito opposite ng nasa taas, since sila yung privileged to approve content.
        if ($isManager || $isAdmin) {
            $tabs[] = ['id' => 'needs_approval', 'label' => 'Needs Approval', 'icon' => 'bx-check-circle'];
        }
    ?>

    <?php if (isset($component)) { $__componentOriginal1480261582d61bdc5590b84114c27bf4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1480261582d61bdc5590b84114c27bf4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navigation-layout.tabs-modern','data' => ['tabs' => $tabs,'defaultTab' => 'my']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navigation-layout.tabs-modern'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tabs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabs),'default-tab' => 'my']); ?>
         <?php $__env->slot('slot_my', null, []); ?> 
            <?php if (isset($component)) { $__componentOriginal879d72999cba16bc59a433a99b6fe39e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal879d72999cba16bc59a433a99b6fe39e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.alert','data' => ['type' => 'info','message' => 'This tab lists only the content you created. Drafts are editable; published items are read-only unless updated.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','message' => 'This tab lists only the content you created. Drafts are editable; published items are read-only unless updated.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal879d72999cba16bc59a433a99b6fe39e)): ?>
<?php $attributes = $__attributesOriginal879d72999cba16bc59a433a99b6fe39e; ?>
<?php unset($__attributesOriginal879d72999cba16bc59a433a99b6fe39e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal879d72999cba16bc59a433a99b6fe39e)): ?>
<?php $component = $__componentOriginal879d72999cba16bc59a433a99b6fe39e; ?>
<?php unset($__componentOriginal879d72999cba16bc59a433a99b6fe39e); ?>
<?php endif; ?>
            <?php echo $__env->make('content.partials.contentTable', ['contents' => $myContent, 'tab' => 'my'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
         <?php $__env->endSlot(); ?>

         <?php $__env->slot('slot_published', null, []); ?> 
            <?php if (isset($component)) { $__componentOriginal879d72999cba16bc59a433a99b6fe39e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal879d72999cba16bc59a433a99b6fe39e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.alert','data' => ['type' => 'neutral','message' => 'All published content visible to users. Editing creates an updated version if workflow requires review.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'neutral','message' => 'All published content visible to users. Editing creates an updated version if workflow requires review.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal879d72999cba16bc59a433a99b6fe39e)): ?>
<?php $attributes = $__attributesOriginal879d72999cba16bc59a433a99b6fe39e; ?>
<?php unset($__attributesOriginal879d72999cba16bc59a433a99b6fe39e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal879d72999cba16bc59a433a99b6fe39e)): ?>
<?php $component = $__componentOriginal879d72999cba16bc59a433a99b6fe39e; ?>
<?php unset($__componentOriginal879d72999cba16bc59a433a99b6fe39e); ?>
<?php endif; ?>
            <?php echo $__env->make('content.partials.contentTable', ['contents' => $publishedContent, 'tab' => 'published'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
         <?php $__env->endSlot(); ?>

        <?php if($isManager || $isAdmin): ?>
             <?php $__env->slot('slot_archived', null, []); ?> 
                <?php if (isset($component)) { $__componentOriginal879d72999cba16bc59a433a99b6fe39e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal879d72999cba16bc59a433a99b6fe39e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.alert','data' => ['type' => 'warning','message' => 'Archived content is hidden from public views. You can restore it by editing and republishing.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'warning','message' => 'Archived content is hidden from public views. You can restore it by editing and republishing.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal879d72999cba16bc59a433a99b6fe39e)): ?>
<?php $attributes = $__attributesOriginal879d72999cba16bc59a433a99b6fe39e; ?>
<?php unset($__attributesOriginal879d72999cba16bc59a433a99b6fe39e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal879d72999cba16bc59a433a99b6fe39e)): ?>
<?php $component = $__componentOriginal879d72999cba16bc59a433a99b6fe39e; ?>
<?php unset($__componentOriginal879d72999cba16bc59a433a99b6fe39e); ?>
<?php endif; ?>
                <?php echo $__env->make('content.partials.contentTable', ['contents' => $archived, 'tab' => 'archived'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
             <?php $__env->endSlot(); ?>
        <?php endif; ?>

        <?php if($isCoordinator && !$isAdmin && !$isManager): ?>
             <?php $__env->slot('slot_submitted', null, []); ?> 
                <?php if (isset($component)) { $__componentOriginal879d72999cba16bc59a433a99b6fe39e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal879d72999cba16bc59a433a99b6fe39e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.alert','data' => ['type' => 'info','message' => 'Submitted items are waiting for a Content Manager to review. You can still edit before approval.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','message' => 'Submitted items are waiting for a Content Manager to review. You can still edit before approval.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal879d72999cba16bc59a433a99b6fe39e)): ?>
<?php $attributes = $__attributesOriginal879d72999cba16bc59a433a99b6fe39e; ?>
<?php unset($__attributesOriginal879d72999cba16bc59a433a99b6fe39e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal879d72999cba16bc59a433a99b6fe39e)): ?>
<?php $component = $__componentOriginal879d72999cba16bc59a433a99b6fe39e; ?>
<?php unset($__componentOriginal879d72999cba16bc59a433a99b6fe39e); ?>
<?php endif; ?>
                <?php echo $__env->make('content.partials.contentTable', ['contents' => $submitted, 'tab' => 'submitted'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
             <?php $__env->endSlot(); ?>

             <?php $__env->slot('slot_needs_revision', null, []); ?> 
                <?php if (isset($component)) { $__componentOriginal879d72999cba16bc59a433a99b6fe39e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal879d72999cba16bc59a433a99b6fe39e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.alert','data' => ['type' => 'warning','message' => 'These items were sent back for revision. Update them and resubmit for approval.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'warning','message' => 'These items were sent back for revision. Update them and resubmit for approval.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal879d72999cba16bc59a433a99b6fe39e)): ?>
<?php $attributes = $__attributesOriginal879d72999cba16bc59a433a99b6fe39e; ?>
<?php unset($__attributesOriginal879d72999cba16bc59a433a99b6fe39e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal879d72999cba16bc59a433a99b6fe39e)): ?>
<?php $component = $__componentOriginal879d72999cba16bc59a433a99b6fe39e; ?>
<?php unset($__componentOriginal879d72999cba16bc59a433a99b6fe39e); ?>
<?php endif; ?>
                <?php echo $__env->make('content.partials.contentTable', ['contents' => $needsRevision, 'tab' => 'needs_revision'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
             <?php $__env->endSlot(); ?>
        <?php endif; ?>

        <?php if($isManager || $isAdmin): ?>
             <?php $__env->slot('slot_needs_approval', null, []); ?> 
                <?php if (isset($component)) { $__componentOriginal879d72999cba16bc59a433a99b6fe39e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal879d72999cba16bc59a433a99b6fe39e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.alert','data' => ['type' => 'info','message' => 'Queue of content awaiting your approval. Approve, request revision, or reject.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'info','message' => 'Queue of content awaiting your approval. Approve, request revision, or reject.']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal879d72999cba16bc59a433a99b6fe39e)): ?>
<?php $attributes = $__attributesOriginal879d72999cba16bc59a433a99b6fe39e; ?>
<?php unset($__attributesOriginal879d72999cba16bc59a433a99b6fe39e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal879d72999cba16bc59a433a99b6fe39e)): ?>
<?php $component = $__componentOriginal879d72999cba16bc59a433a99b6fe39e; ?>
<?php unset($__componentOriginal879d72999cba16bc59a433a99b6fe39e); ?>
<?php endif; ?>
                <?php echo $__env->make('content.partials.contentTable', ['contents' => $needsApproval, 'tab' => 'needs_approval'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
             <?php $__env->endSlot(); ?>
        <?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1480261582d61bdc5590b84114c27bf4)): ?>
<?php $attributes = $__attributesOriginal1480261582d61bdc5590b84114c27bf4; ?>
<?php unset($__attributesOriginal1480261582d61bdc5590b84114c27bf4); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1480261582d61bdc5590b84114c27bf4)): ?>
<?php $component = $__componentOriginal1480261582d61bdc5590b84114c27bf4; ?>
<?php unset($__componentOriginal1480261582d61bdc5590b84114c27bf4); ?>
<?php endif; ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.sidebar_final', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/content/index.blade.php ENDPATH**/ ?>