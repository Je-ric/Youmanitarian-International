<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'align' => 'end', // start, center, end
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
    'align' => 'end', // start, center, end
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
    $alignmentClasses = [
        'start' => 'justify-start',
        'center' => 'justify-center',
        'end' => 'justify-end',
    ];
    
    // $baseClasses = 'border-t border-slate-200 px-6 py-4 bg-slate-50 flex gap-3 flex-shrink-0 sticky bottom-0 z-10';
    $baseClasses = 'border-t border-slate-200 px-6 py-4 bg-slate-50 flex gap-3 flex-shrink-0';
    $alignmentClass = $alignmentClasses[$align] ?? $alignmentClasses['end'];
?>

<footer <?php echo e($attributes->merge(['class' => "{$baseClasses} {$alignmentClass} {$class}"])); ?>>
    <?php echo e($slot); ?>

</footer>

<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/modal/footer.blade.php ENDPATH**/ ?>