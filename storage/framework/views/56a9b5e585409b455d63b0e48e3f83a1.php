<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'modalId' => null,
    'text' => 'Close',
    'class' => '',
    'variant' => 'close', // 'close' or 'cancel'
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
    'modalId' => null,
    'text' => 'Close',
    'class' => '',
    'variant' => 'close', // 'close' or 'cancel'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $baseClasses = 'px-6 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 hover:border-slate-400 hover:text-slate-900 active:bg-slate-100 active:border-slate-400 transition-all duration-200';
    $finalClasses = $class ? "{$baseClasses} {$class}" : $baseClasses;
?>

<?php if($variant === 'cancel'): ?>
    <button 
        type="button"
        onclick="document.getElementById('<?php echo e($modalId); ?>').close()"
        <?php echo e($attributes->merge(['class' => $finalClasses])); ?>

    >
        <?php echo e($text); ?>

    </button>
<?php else: ?>
    <button 
        onclick="document.getElementById('<?php echo e($modalId); ?>').close()"
        <?php echo e($attributes->merge(['class' => $finalClasses])); ?>

    >
        <?php echo e($text); ?>

    </button>
<?php endif; ?>

<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/modal/close-button.blade.php ENDPATH**/ ?>