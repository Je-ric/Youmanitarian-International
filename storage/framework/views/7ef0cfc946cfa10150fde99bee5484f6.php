<div class="flex items-center gap-2 <?php if($participant['is_coordinator']): ?> pr-2 <?php endif; ?>">
    <span class="inline-flex items-center justify-center font-semibold text-gray-500 text-[11px]">
        <?php echo e($participant['index']); ?>

    </span>

    <?php if (isset($component)) { $__componentOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalaa6ddd3b8ee0acee5a2d1d7ac5c7e40e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.user-avatar','data' => ['user' => $participant['user'],'size' => '8','showName' => false]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('user-avatar'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['user' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($participant['user']),'size' => '8','showName' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(false)]); ?>
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

    <span class="text-sm font-medium text-[#1a2235] truncate max-w-[140px]">
        <?php echo e($participant['user']->name ?? 'Unknown'); ?>

        <?php if($participant['is_coordinator']): ?>
            <span class="ml-2 px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-[10px] font-semibold">
                (PC)
            </span>
        <?php endif; ?>
    </span>

    <?php if($participant['hours_count'] > 0): ?>
        <span class="text-xs text-gray-500 ml-2">
            (<?php echo e($participant['hours_count']); ?>)
        </span>
    <?php endif; ?>
</div>
    <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/programs_chats/partials/participant.blade.php ENDPATH**/ ?>