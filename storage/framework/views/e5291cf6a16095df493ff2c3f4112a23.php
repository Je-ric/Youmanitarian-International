<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['class' => '', 'striped' => true]));

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

foreach (array_filter((['class' => '', 'striped' => true]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $baseClasses = '';
    if ($striped) {
        // $baseClasses .= ' [&>tr:nth-child(odd)>td]:bg-white';
        // $baseClasses .= ' [&>tr:nth-child(even)>td]:bg-gray-100';
        $baseClasses .= 'bg-white';
    }
    $classes = trim($baseClasses . ' ' . $class);
?>

<tbody class="<?php echo e($classes); ?>">
    <?php echo e($slot); ?>

</tbody>
<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/table/tbody.blade.php ENDPATH**/ ?>