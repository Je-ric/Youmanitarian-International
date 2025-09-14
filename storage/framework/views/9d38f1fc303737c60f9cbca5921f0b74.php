<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'imageUrl' => null,
    'icon' => null,
    'fallbackIcon' => 'bx-user',
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
    'imageUrl' => null,
    'icon' => null,
    'fallbackIcon' => 'bx-user',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div <?php echo e($attributes->merge(['class' => 'flex items-center justify-between border-b border-gray-100 pb-3 last:border-0 last:pb-0'])); ?>>
    <div class="flex items-center gap-3 sm:gap-4">
        <?php if($imageUrl): ?>
            <img src="<?php echo e($imageUrl); ?>" class="w-10 h-10 rounded-full object-cover">
        <?php elseif($icon): ?>
            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                <i class='bx <?php echo e($icon); ?> text-xl sm:text-2xl text-gray-500'></i>
            </div>
        <?php else: ?>
            <div class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center">
                <i class='bx <?php echo e($fallbackIcon); ?> text-xl sm:text-2xl text-gray-500'></i>
            </div>
        <?php endif; ?>
        
        <div class="flex-grow">
            <?php if(isset($title)): ?>
                <div class="text-sm font-semibold text-gray-800"><?php echo e($title); ?></div>
            <?php endif; ?>
            <?php if(isset($subtitle)): ?>
                <div class="text-xs sm:text-sm text-gray-500"><?php echo e($subtitle); ?></div>
            <?php endif; ?>
        </div>
    </div>

    <?php if(isset($action)): ?>
        <div class="text-xs sm:text-sm text-gray-600 whitespace-nowrap">
            <?php echo e($action); ?>

        </div>
    <?php endif; ?>
</div>

 <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/overview/summary-list-item.blade.php ENDPATH**/ ?>