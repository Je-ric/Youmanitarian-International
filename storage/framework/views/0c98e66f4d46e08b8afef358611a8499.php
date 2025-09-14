<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name',
    'label' => '',
    'options' => [],
    'selected' => null,
    'inline' => false,
    'disabled' => false, 
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
    'label' => '',
    'options' => [],
    'selected' => null,
    'inline' => false,
    'disabled' => false, 
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>



<div>
    <?php if($label): ?>
        <label class="block text-sm font-medium text-gray-700 mb-2"><?php echo e($label); ?></label>
    <?php endif; ?>
    <div class="flex <?php echo e($inline ? 'flex-row gap-4' : 'flex-col gap-2'); ?>">
        <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $optionLabel): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
                $id = $name . '_' . \Illuminate\Support\Str::slug($value, '_');
            ?>
            <div class="flex items-center">
                <input
                    id="<?php echo e($id); ?>"
                    type="radio"
                    name="<?php echo e($name); ?>"
                    value="<?php echo e($value); ?>"
                    <?php if($selected == $value): echo 'checked'; endif; ?>
                    <?php if($disabled): echo 'disabled'; endif; ?>
                    class="w-4 h-4 text-[#ffb51b] bg-white border-2 border-gray-300 focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] checked:bg-[#ffb51b] transition-colors"
                >
                <label for="<?php echo e($id); ?>" class="ms-2 text-sm font-medium text-gray-900"><?php echo e($optionLabel); ?></label>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>
<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/form/radio-group.blade.php ENDPATH**/ ?>