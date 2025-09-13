<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['program']));

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

foreach (array_filter((['program']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $status = $program->progress_status_with_style;
    
    $statusConfig = [
        'incoming' => [
            'icon' => 'bx-calendar-event',
            'bg' => 'bg-blue-50',
            'text' => 'text-blue-700',
            'border' => 'border-blue-200',
            'iconColor' => 'text-blue-500'
        ],
        'ongoing' => [
            'icon' => 'bx-play-circle',
            'bg' => 'bg-green-50',
            'text' => 'text-green-700',
            'border' => 'border-green-200',
            'iconColor' => 'text-green-500'
        ],
        'done' => [
            'icon' => 'bx-check-circle',
            'bg' => 'bg-gray-50',
            'text' => 'text-gray-700',
            'border' => 'border-gray-200',
            'iconColor' => 'text-gray-500'
        ]
    ];

    $config = $statusConfig[$program->progress_status] ?? $statusConfig['done'];
?>

<div class="inline-flex items-center gap-2 px-3 py-1 text-[11px] md:text-xs rounded-full font-semibold <?php echo e($config['bg']); ?> <?php echo e($config['text']); ?>">
    <i class='bx <?php echo e($config['icon']); ?> text-lg <?php echo e($config['iconColor']); ?>'></i>
    <span><?php echo e($status['label']); ?></span>
</div>


<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/feedback-status/programProgress.blade.php ENDPATH**/ ?>