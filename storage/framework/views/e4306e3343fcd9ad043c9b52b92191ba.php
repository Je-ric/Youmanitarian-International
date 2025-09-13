<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'type' => 'info', // success, error, info, warning
    'icon' => 'bx bx-info-circle',
    'message' => '',
    'variant' => 'default', // default, attendance, flexible, dark
    'bgColor' => '', // custom background color class for flexible variant
    'textColor' => '', // custom text color class for flexible variant
    'borderColor' => '', // custom border color class for flexible variant
    'iconColor' => '', // custom icon color class for flexible variant
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
    'type' => 'info', // success, error, info, warning
    'icon' => 'bx bx-info-circle',
    'message' => '',
    'variant' => 'default', // default, attendance, flexible, dark
    'bgColor' => '', // custom background color class for flexible variant
    'textColor' => '', // custom text color class for flexible variant
    'borderColor' => '', // custom border color class for flexible variant
    'iconColor' => '', // custom icon color class for flexible variant
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $typeClasses = [
        'success' => 'text-green-600 font-medium bg-green-50 border-green-200',
        'error' => 'text-red-600 font-medium bg-red-50 border-red-200',
        'info' => 'text-blue-700 font-medium bg-blue-50 border-blue-200',
        'warning' => 'text-yellow-600 font-medium bg-yellow-50 border-yellow-200',
        'neutral' => 'text-gray-500 font-medium bg-gray-100 border-gray-200',
    ];
    $classes = $typeClasses[$type] ?? $typeClasses['info'];
?>

<?php if($variant === 'attendance'): ?>
    <div class="bg-<?php echo e($type === 'error' ? 'red' : ($type === 'success' ? 'green' : ($type === 'warning' ? 'yellow' : 'blue'))); ?>-50 border border-<?php echo e($type === 'error' ? 'red' : ($type === 'success' ? 'green' : ($type === 'warning' ? 'yellow' : 'blue'))); ?>-200 rounded-lg p-4 mb-4">
        <div class="flex items-start gap-3">
            <i class="<?php echo e($icon); ?> text-<?php echo e($type === 'error' ? 'red' : ($type === 'success' ? 'green' : ($type === 'warning' ? 'yellow' : 'blue') )); ?>-500 mt-0.5"></i>
            <div class="text-sm text-<?php echo e($type === 'error' ? 'red' : ($type === 'success' ? 'green' : ($type === 'warning' ? 'yellow' : 'blue') )); ?>-700">
                <?php echo $message; ?>

            </div>
        </div>
    </div>
<?php elseif($variant === 'flexible'): ?>
    <div class="<?php echo e($bgColor ?: 'bg-gray-50'); ?> border <?php echo e($borderColor ?: 'border-gray-200'); ?> rounded-lg p-4 mb-4">
        <div class="flex items-start gap-3">
            <i class="<?php echo e($icon); ?> <?php echo e($iconColor ?: 'text-gray-500'); ?> mt-0.5"></i>
            <div class="text-sm <?php echo e($textColor ?: 'text-gray-700'); ?>">
                <?php echo $message; ?>

            </div>
        </div>
    </div>
<?php elseif($variant === 'dark'): ?>
    <?php
        $darkBg = [
            'success' => 'bg-green-900 border-green-400',
            'error' => 'bg-red-900 border-red-400',
            'info' => 'bg-slate-800 border-blue-400',
            'warning' => 'bg-yellow-900 border-yellow-400',
            'neutral' => 'bg-gray-800 border-gray-500',
        ];
        $darkClasses = $darkBg[$type] ?? $darkBg['info'];
    ?>
    <div class="<?php echo e($darkClasses); ?> border rounded-lg p-4 mb-4">
        <div class="flex items-start gap-3">
            <i class="<?php echo e($icon); ?> text-white mt-0.5"></i>
            <div class="text-sm text-white/90">
                <?php echo $message; ?>

            </div>
        </div>
    </div>
<?php else: ?>
    <div class="text-sm flex items-center gap-2 justify-center py-3 px-4 border rounded-lg <?php echo e($classes); ?>">
        <i class="<?php echo e($icon); ?>"></i>
        <?php echo $message; ?>

    </div>
<?php endif; ?>

 <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/feedback-status/alert.blade.php ENDPATH**/ ?>