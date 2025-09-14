<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name',
    'checked' => false,
    'label' => '',
    'id' => null,
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
    'name',
    'checked' => false,
    'label' => '',
    'id' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>



<?php
    $id = $id ?? $name . '_' . uniqid();
?>
<label for="<?php echo e($id); ?>" class="flex items-center cursor-pointer select-none gap-2">
    <input
        type="checkbox"
        name="<?php echo e($name); ?>"
        id="<?php echo e($id); ?>"
        value="1"
        <?php echo e($checked ? 'checked' : ''); ?>

        class="w-10 h-5 rounded-full border-2 border-gray-300 focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] checked:bg-[#ffb51b] transition-colors"
    >
    <?php if($label): ?>
        <span class="text-sm text-gray-700"><?php echo e($label); ?></span>
    <?php endif; ?>
</label> <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/form/toggle.blade.php ENDPATH**/ ?>