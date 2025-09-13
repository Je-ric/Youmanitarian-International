<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'class' => '',
]));

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

foreach (array_filter(([
    'class' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $baseClasses = 'px-6 py-4 border-b border-slate-200 bg-slate-50 flex-shrink-0';
    $finalClasses = $class ? "{$baseClasses} {$class}" : $baseClasses;
?>

<header <?php echo e($attributes->merge(['class' => $finalClasses])); ?>>
    <div class="flex items-center justify-between">
        <div class="flex-1">
            <?php echo e($slot); ?>

        </div>
        <?php if (isset($component)) { $__componentOriginalaecb870b7c5f717ea8787c80177d59d1 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalaecb870b7c5f717ea8787c80177d59d1 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.modal.x-button','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('modal.x-button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalaecb870b7c5f717ea8787c80177d59d1)): ?>
<?php $attributes = $__attributesOriginalaecb870b7c5f717ea8787c80177d59d1; ?>
<?php unset($__attributesOriginalaecb870b7c5f717ea8787c80177d59d1); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalaecb870b7c5f717ea8787c80177d59d1)): ?>
<?php $component = $__componentOriginalaecb870b7c5f717ea8787c80177d59d1; ?>
<?php unset($__componentOriginalaecb870b7c5f717ea8787c80177d59d1); ?>
<?php endif; ?>
    </div>
</header>

 <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/modal/header.blade.php ENDPATH**/ ?>