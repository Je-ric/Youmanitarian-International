<?php $__env->startSection('content'); ?>
<?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['icon' => 'bx-group','title' => 'Member Management','desc' => 'Manage and view details of all members.']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bx-group','title' => 'Member Management','desc' => 'Manage and view details of all members.']); ?>
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
        $tabs = [
            ['id' => 'overview', 'label' => 'Overview', 'icon' => 'bx-stats'],
            ['id' => 'full_pledge', 'label' => 'Full-Pledge', 'icon' => 'bx-user-check'],
            ['id' => 'honorary', 'label' => 'Honorary', 'icon' => 'bx-award'],
            ['id' => 'pending', 'label' => 'Pending Invitations', 'icon' => 'bx-mail-send'],
        ];
    ?>

    <?php if (isset($component)) { $__componentOriginal1480261582d61bdc5590b84114c27bf4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1480261582d61bdc5590b84114c27bf4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navigation-layout.tabs-modern','data' => ['tabs' => $tabs,'defaultTab' => 'overview']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navigation-layout.tabs-modern'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tabs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($tabs),'default-tab' => 'overview']); ?>
         <?php $__env->slot('slot_overview', null, []); ?> 
            <?php echo $__env->make('member.partials.membersOverview', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
         <?php $__env->endSlot(); ?>

         <?php $__env->slot('slot_full_pledge', null, []); ?> 
            <?php echo $__env->make('member.partials.membersTable', ['members' => $fullPledgeMembers, 'tab' => 'full_pledge'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
         <?php $__env->endSlot(); ?>

         <?php $__env->slot('slot_honorary', null, []); ?> 
            <?php echo $__env->make('member.partials.membersTable', ['members' => $honoraryMembers, 'tab' => 'honorary'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
         <?php $__env->endSlot(); ?>

         <?php $__env->slot('slot_pending', null, []); ?> 
            <?php echo $__env->make('member.partials.membersTable', ['members' => $pendingMembers, 'tab' => 'pending'], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
         <?php $__env->endSlot(); ?>
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

<?php echo $__env->make('layouts.sidebar_final', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/member/index.blade.php ENDPATH**/ ?>