<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'class' => '',
    'hover' => true,
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
    'hover' => true,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $baseClasses = 'group [&>td]:border-y [&>td:first-child]:border-l [&>td:last-child]:border-r [&>td:first-child]:rounded-l-lg [&>td:last-child]:rounded-r-lg';
    $classes = trim($baseClasses . ' ' . $class);
?>

<tr class="<?php echo e($classes); ?>">
    <?php echo e($slot); ?>

</tr> <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/table/tr.blade.php ENDPATH**/ ?>