<?php $__env->startSection('content'); ?>
    <?php if (isset($component)) { $__componentOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf8d4ea307ab1e58d4e472a43c8548d8e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.page-header','data' => ['icon' => 'bx-user','title' => 'Volunteer Details','desc' => 'Complete information about '.e($volunteer->user->name).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('page-header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['icon' => 'bx-user','title' => 'Volunteer Details','desc' => 'Complete information about '.e($volunteer->user->name).'']); ?>
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

    <div x-data="{
        openModal(id) {
            document.getElementById('modal_' + id).showModal();
        }
    }">

    <?php if (isset($component)) { $__componentOriginal1480261582d61bdc5590b84114c27bf4 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1480261582d61bdc5590b84114c27bf4 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navigation-layout.tabs-modern','data' => ['tabs' => [
            ['id' => 'overview', 'label' => 'Overview', 'icon' => 'bx-user-circle'],
            ['id' => 'application', 'label' => 'Application Details', 'icon' => 'bx-file-text'],
            ['id' => 'programs', 'label' => 'Programs & Attendance', 'icon' => 'bx-calendar']
        ],'defaultTab' => 'overview','preserveState' => false,'class' => 'mb-6']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navigation-layout.tabs-modern'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['tabs' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
            ['id' => 'overview', 'label' => 'Overview', 'icon' => 'bx-user-circle'],
            ['id' => 'application', 'label' => 'Application Details', 'icon' => 'bx-file-text'],
            ['id' => 'programs', 'label' => 'Programs & Attendance', 'icon' => 'bx-calendar']
        ]),'defaultTab' => 'overview','preserveState' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false),'class' => 'mb-6']); ?>

         <?php $__env->slot('slot_overview', null, []); ?> 
            <?php echo $__env->make('volunteers.partials.overviewProfile', ['volunteer' => $volunteer], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
         <?php $__env->endSlot(); ?>

         <?php $__env->slot('slot_application', null, []); ?> 
            <?php echo $__env->make('volunteers.partials.applicationProfile', ['volunteer' => $volunteer], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
         <?php $__env->endSlot(); ?>

         <?php $__env->slot('slot_programs', null, []); ?> 
            <?php echo $__env->make('volunteers.partials.programsProfile', ['volunteer' => $volunteer], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
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

<?php echo $__env->make('layouts.sidebar_final', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/volunteers/volunteer-details.blade.php ENDPATH**/ ?>