<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name' => 'search',
    'id' => null,
    'value' => '',
    'placeholder' => 'Search...',
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
    'name' => 'search',
    'id' => null,
    'value' => '',
    'placeholder' => 'Search...',
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
    $inputId = $id ?? $name;
?>
<div class="relative w-full">
    <input
        type="search"
        name="<?php echo e($name); ?>"
        id="<?php echo e($inputId); ?>"
        value="<?php echo e(old($name, $value)); ?>"
        placeholder="<?php echo e($placeholder); ?>"
        <?php echo e($attributes->merge(['class' => 'w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] transition-colors ' . $class])); ?>

    />
    <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
        <i class='bx bx-search text-xl text-gray-400'></i>
    </span>
</div> <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/form/search-input.blade.php ENDPATH**/ ?>