<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'class' => '',
    'hideOnSmall' => false,
    'align' => 'left',
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
    'hideOnSmall' => false,
    'align' => 'left',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $baseClasses = 'px-6 py-3 text-left font-medium tracking-wider text-xs';
    if ($hideOnSmall) {
        $baseClasses .= ' hidden sm:table-cell';
    }
    if ($align !== 'left') {
        $baseClasses = str_replace('text-left', 'text-' . $align, $baseClasses);
    }
    $classes = trim($baseClasses . ' ' . $class);
?>

<th scope="col" class="<?php echo e($classes); ?>">
    <?php echo e($slot); ?>

</th> <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/table/th.blade.php ENDPATH**/ ?>