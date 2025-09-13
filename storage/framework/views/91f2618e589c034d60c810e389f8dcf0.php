<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'first' => '',
    'second' => '',
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
    'first' => '',
    'second' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<h2 class="text-4xl lg:text-5xl font-bold text-center text-balance mb-16">
    <span class="text-[#1A2235]"><?php echo e($first); ?></span>
    <span class="text-[#FFB51B]"><?php echo e($second); ?></span>
</h2>


<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/section-title.blade.php ENDPATH**/ ?>