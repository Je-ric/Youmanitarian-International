<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['content']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['content']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php if(isset($content)): ?>
<?php if (isset($component)) { $__componentOriginal6eb288a80e68f6f6b1755bcc863df159 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6eb288a80e68f6f6b1755bcc863df159 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.dialog','data' => ['id' => 'unarchive-modal-'.e($content->id).'','maxWidth' => 'xl:max-w-xl lg:max-w-lg md:max-w-md sm:max-w-sm max-w-xs','width' => 'w-full','maxHeight' => 'max-h-[90vh]']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.dialog'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['id' => 'unarchive-modal-'.e($content->id).'','maxWidth' => 'xl:max-w-xl lg:max-w-lg md:max-w-md sm:max-w-sm max-w-xs','width' => 'w-full','maxHeight' => 'max-h-[90vh]']); ?>
    <?php if (isset($component)) { $__componentOriginalbe09faad1c8b3f6fb64e0c479030b4cf = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbe09faad1c8b3f6fb64e0c479030b4cf = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.header','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.header'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <h2 class="text-lg sm:text-xl font-bold text-green-600 flex items-center gap-2">
            <i class='bx bx-archive-out'></i> Unarchive Content
        </h2>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbe09faad1c8b3f6fb64e0c479030b4cf)): ?>
<?php $attributes = $__attributesOriginalbe09faad1c8b3f6fb64e0c479030b4cf; ?>
<?php unset($__attributesOriginalbe09faad1c8b3f6fb64e0c479030b4cf); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbe09faad1c8b3f6fb64e0c479030b4cf)): ?>
<?php $component = $__componentOriginalbe09faad1c8b3f6fb64e0c479030b4cf; ?>
<?php unset($__componentOriginalbe09faad1c8b3f6fb64e0c479030b4cf); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginal0ad23ec26c64eb1a0d6e4c82d27f0428 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0ad23ec26c64eb1a0d6e4c82d27f0428 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.body','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.body'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <div class="flex flex-col items-center text-center gap-3">
            <div class="bg-green-100 rounded-full w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center mb-2">
                <i class='bx bx-archive-out text-2xl sm:text-3xl text-green-600'></i>
            </div>
            <h3 class="text-base sm:text-lg font-semibold text-green-700">
                Restore this content to Draft?
            </h3>
            <?php if (isset($component)) { $__componentOriginal879d72999cba16bc59a433a99b6fe39e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal879d72999cba16bc59a433a99b6fe39e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.feedback-status.alert','data' => ['variant' => 'flexible','icon' => 'bx bx-info-circle text-xl','message' => 'Unarchiving will move this content back to Draft. You can edit and publish after restoring.','bgColor' => 'bg-green-50','textColor' => 'text-green-700','borderColor' => 'border-green-200','iconColor' => 'text-green-600']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('feedback-status.alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'flexible','icon' => 'bx bx-info-circle text-xl','message' => 'Unarchiving will move this content back to Draft. You can edit and publish after restoring.','bgColor' => 'bg-green-50','textColor' => 'text-green-700','borderColor' => 'border-green-200','iconColor' => 'text-green-600']); ?>
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
            <div class="w-full bg-gray-50 border border-gray-200 rounded p-3 text-center">
                <span class="font-semibold text-gray-800 text-xs sm:text-base">
                    <?php echo e(\Illuminate\Support\Str::limit($content->title, 70)); ?>

                </span>
            </div>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0ad23ec26c64eb1a0d6e4c82d27f0428)): ?>
<?php $attributes = $__attributesOriginal0ad23ec26c64eb1a0d6e4c82d27f0428; ?>
<?php unset($__attributesOriginal0ad23ec26c64eb1a0d6e4c82d27f0428); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0ad23ec26c64eb1a0d6e4c82d27f0428)): ?>
<?php $component = $__componentOriginal0ad23ec26c64eb1a0d6e4c82d27f0428; ?>
<?php unset($__componentOriginal0ad23ec26c64eb1a0d6e4c82d27f0428); ?>
<?php endif; ?>

    <?php if (isset($component)) { $__componentOriginalf6cca9f771ea92c42bfffab22cf7806c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalf6cca9f771ea92c42bfffab22cf7806c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.footer','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.footer'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
        <div class="flex gap-2 w-full justify-end flex-col sm:flex-row">
            <?php if (isset($component)) { $__componentOriginaled059d8d932fd09048df3e5a42bf4f05 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginaled059d8d932fd09048df3e5a42bf4f05 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.close-button','data' => ['modalId' => 'unarchive-modal-' . $content->id,'text' => 'Cancel']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.close-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['modalId' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute('unarchive-modal-' . $content->id),'text' => 'Cancel']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginaled059d8d932fd09048df3e5a42bf4f05)): ?>
<?php $attributes = $__attributesOriginaled059d8d932fd09048df3e5a42bf4f05; ?>
<?php unset($__attributesOriginaled059d8d932fd09048df3e5a42bf4f05); ?>
<?php endif; ?>
<?php if (isset($__componentOriginaled059d8d932fd09048df3e5a42bf4f05)): ?>
<?php $component = $__componentOriginaled059d8d932fd09048df3e5a42bf4f05; ?>
<?php unset($__componentOriginaled059d8d932fd09048df3e5a42bf4f05); ?>
<?php endif; ?>
            <form action="<?php echo e(route('content.unarchive', $content->id)); ?>" method="POST" class="w-full sm:w-auto">
                <?php echo csrf_field(); ?>
                <?php if (isset($component)) { $__componentOriginale67687e3e4e61f963b25a6bcf3983629 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale67687e3e4e61f963b25a6bcf3983629 = $attributes; } ?>
<?php $component = App\View\Components\Button::resolve(['variant' => 'table-action-manage'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\Button::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','class' => 'w-full sm:w-auto']); ?>
                    <i class='bx bx-archive-out'></i> Unarchive to Draft
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
            </form>
        </div>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalf6cca9f771ea92c42bfffab22cf7806c)): ?>
<?php $attributes = $__attributesOriginalf6cca9f771ea92c42bfffab22cf7806c; ?>
<?php unset($__attributesOriginalf6cca9f771ea92c42bfffab22cf7806c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf6cca9f771ea92c42bfffab22cf7806c)): ?>
<?php $component = $__componentOriginalf6cca9f771ea92c42bfffab22cf7806c; ?>
<?php unset($__componentOriginalf6cca9f771ea92c42bfffab22cf7806c); ?>
<?php endif; ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6eb288a80e68f6f6b1755bcc863df159)): ?>
<?php $attributes = $__attributesOriginal6eb288a80e68f6f6b1755bcc863df159; ?>
<?php unset($__attributesOriginal6eb288a80e68f6f6b1755bcc863df159); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6eb288a80e68f6f6b1755bcc863df159)): ?>
<?php $component = $__componentOriginal6eb288a80e68f6f6b1755bcc863df159; ?>
<?php unset($__componentOriginal6eb288a80e68f6f6b1755bcc863df159); ?>
<?php endif; ?>
<?php endif; ?>
<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/content/modals/unarchiveContentModal.blade.php ENDPATH**/ ?>