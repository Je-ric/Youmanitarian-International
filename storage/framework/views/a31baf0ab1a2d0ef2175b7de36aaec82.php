<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'icon' => 'bx bx-info-circle',
    'title' => 'Nothing Here',
    'description' => 'There is no information to display.',
    'size' => 'default',
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
    'icon' => 'bx bx-info-circle',
    'title' => 'Nothing Here',
    'description' => 'There is no information to display.',
    'size' => 'default',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $isSmall = $size === 'small';
?>

<div class="w-full flex flex-col items-center justify-center <?php echo e($isSmall ? 'py-4 px-2' : 'py-10 px-3'); ?> text-center">
    <div class="<?php echo e($isSmall ? 'w-8 h-8 mb-2' : 'w-14 h-14 mb-3'); ?> rounded-full flex items-center justify-center bg-gray-100">
        <i class="<?php echo e($icon); ?> <?php echo e($isSmall ? 'text-lg' : 'text-2xl'); ?> text-gray-400"></i>
    </div>
    <h3 class="<?php echo e($isSmall ? 'text-xs font-medium mb-0.5' : 'text-base md:text-lg font-medium mb-1'); ?> text-gray-700"><?php echo e($title); ?></h3>
    <p class="<?php echo e($isSmall ? 'text-xs' : 'text-sm md:text-base'); ?> text-gray-400 mx-auto leading-normal font-normal"><?php echo e($description); ?></p>
</div>

<style>
@media (max-width: 640px) {
    .max-w-xs { max-width: 16rem; }
    .text-base { font-size: 1rem; }
    .text-xs { font-size: 0.85rem; }
}
@media (max-width: 480px) {
    .max-w-xs { max-width: 12rem; }
    .text-base { font-size: 0.95rem; }
    .text-xs { font-size: 0.8rem; }
}
</style>


<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/empty-state.blade.php ENDPATH**/ ?>