<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'class' => '',
    'hideOnSmall' => false,
    'align' => 'left',
    'numeric' => false,
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
    'numeric' => false,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $baseClasses = 'px-3 py-2 whitespace-nowrap text-sm font-medium text-gray-900 group-hover:bg-[#fff8e8]';
    if ($hideOnSmall) {
        $baseClasses .= ' hidden sm:table-cell';
    }
    $baseClasses .= ' text-' . $align;
    if ($numeric) {
        $baseClasses .= ' font-mono text-right';
    }
    $classes = trim($baseClasses . ' ' . $class);
?>

<td class="<?php echo e($classes); ?>">
    <?php echo e($slot); ?>

</td> <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/table/td.blade.php ENDPATH**/ ?>