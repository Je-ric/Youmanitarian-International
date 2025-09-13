<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((
    ['containerClass' => '', 
    'tableClass' => '']
    ));

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

foreach (array_filter((
    ['containerClass' => '', 
    'tableClass' => '']
    ), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="w-full overflow-x-auto <?php echo e($containerClass); ?>">
    <table class="min-w-full border-separate border-spacing-y-2 <?php echo e($tableClass); ?>">
        <?php echo e($slot); ?>

    </table>
</div> <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/table/table.blade.php ENDPATH**/ ?>