<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'class' => '',
    'padded' => true,
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
    'padded' => true,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $paddingClass = $padded ? 'p-6' : '';
?>

<div <?php echo e($attributes->merge([
    'class' => "flex-1 min-h-0 overflow-y-auto space-y-6 max-h-[60vh] sm:max-h-[70vh] custom-scrollbar-gold $paddingClass $class"
])); ?>>
    <?php echo e($slot); ?>

</div>

<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/modal/body.blade.php ENDPATH**/ ?>