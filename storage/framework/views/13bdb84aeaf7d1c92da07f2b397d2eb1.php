<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name',
    'label' => '',
    'options' => [],
    'class' => '',
    'onchange' => null,
    'required' => false,
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
    'class' => '',
    'onchange' => null,
    'required' => false,
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
        <label for="<?php echo e($name); ?>" class="block text-sm font-semibold text-slate-800 mb-2"><?php echo e($label); ?></label>
    <?php endif; ?>
    <select
        name="<?php echo e($name); ?>"
        id="<?php echo e($name); ?>"
        <?php if($required): ?> required <?php endif; ?>
        <?php if($onchange): ?> onchange="<?php echo e($onchange); ?>" <?php endif; ?>
        <?php echo e($attributes->merge(['class' => 'w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] transition-colors ' . $class])); ?>

    >
        <?php if($slot->isNotEmpty()): ?>
            <?php echo e($slot); ?>

        <?php else: ?>
            <?php $__currentLoopData = $options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($option['value']); ?>" <?php if(!empty($option['selected'])): ?> selected <?php endif; ?>>
                    <?php echo e($option['label']); ?>

                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
    </select> 
</div> <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/form/select-option.blade.php ENDPATH**/ ?>