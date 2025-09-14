<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'for' => null,
    'class' => '',
    'icon' => null,
    'iconColor' => 'text-gray-600',
    'variant' => null, // 'title', 'description', 'date', 'time', 'location', 'user', 'amount', 'notes', 'image'
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
    'for' => null,
    'class' => '',
    'icon' => null,
    'iconColor' => 'text-gray-600',
    'variant' => null, // 'title', 'description', 'date', 'time', 'location', 'user', 'amount', 'notes', 'image'
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $variants = [
        'title' => ['icon' => 'bx-book', 'color' => 'text-blue-600'],
        'description' => ['icon' => 'bx-align-left', 'color' => 'text-green-600'],
        'date' => ['icon' => 'bx-calendar', 'color' => 'text-purple-500'],
        'time' => ['icon' => 'bx-time-five', 'color' => 'text-green-600'],
        'time-in' => ['icon' => 'bx-time-five', 'color' => 'text-green-600'],
        'time-out' => ['icon' => 'bx-time-five', 'color' => 'text-red-600'],
        'start-time' => ['icon' => 'bx-time-five', 'color' => 'text-green-600'],
        'end-time' => ['icon' => 'bx-time-five', 'color' => 'text-red-600'],
        'location' => ['icon' => 'bx-map', 'color' => 'text-red-500'],
        'user' => ['icon' => 'bx-user', 'color' => 'text-blue-500'],
        'volunteer' => ['icon' => 'bx-group', 'color' => 'text-indigo-500'],
        'volunteer-name' => ['icon' => 'bx-user', 'color' => 'text-blue-500'],
        'volunteer-count' => ['icon' => 'bx-group', 'color' => 'text-indigo-500'],
        'amount' => ['icon' => 'bx-dollar-circle', 'color' => 'text-green-600'],
        'payment-method' => ['icon' => 'bx-credit-card', 'color' => 'text-indigo-500'],
        'payment-date' => ['icon' => 'bx-calendar', 'color' => 'text-purple-500'],
        'donation-date' => ['icon' => 'bx-calendar', 'color' => 'text-purple-500'],
        'notes' => ['icon' => 'bx-note', 'color' => 'text-yellow-600'],
        'image' => ['icon' => 'bx-image', 'color' => 'text-orange-600'],
        'proof' => ['icon' => 'bx-image', 'color' => 'text-orange-600'],
        'receipt' => ['icon' => 'bx-image', 'color' => 'text-orange-600'],
        'feedback' => ['icon' => 'bx-message', 'color' => 'text-green-600'],
        'rating' => ['icon' => 'bx-star', 'color' => 'text-yellow-500'],
        'task' => ['icon' => 'bx-task', 'color' => 'text-blue-600'],
        'tasks' => ['icon' => 'bx-task', 'color' => 'text-blue-600'],
        'email' => ['icon' => 'bx-envelope', 'color' => 'text-purple-500'],
        'donor-name' => ['icon' => 'bx-user', 'color' => 'text-blue-500'],
        'donor-email' => ['icon' => 'bx-envelope', 'color' => 'text-purple-500'],
        'payer-name' => ['icon' => 'bx-user', 'color' => 'text-blue-500'],
        'status' => ['icon' => 'bx-info-circle', 'color' => 'text-blue-600'],
        'time-info' => ['icon' => 'bx-time-five', 'color' => 'text-yellow-500'],
        'attendance-proof' => ['icon' => 'bx-image', 'color' => 'text-orange-600'],
        'assigned-tasks' => ['icon' => 'bx-task', 'color' => 'text-blue-600'],
        'coordinator' => ['icon' => 'bx-user', 'color' => 'text-blue-500'],
        'why-volunteer' => ['icon' => 'bx-message', 'color' => 'text-green-600'],
        'short-bio' => ['icon' => 'bx-align-left', 'color' => 'text-green-600'],
        'upload-image' => ['icon' => 'bx-image', 'color' => 'text-orange-600'],
        'your-feedback' => ['icon' => 'bx-message', 'color' => 'text-green-600'],
    ];
    
    if ($variant && isset($variants[$variant])) {
        $icon = $variants[$variant]['icon'];
        $iconColor = $variants[$variant]['color'];
    }
?>

<label
    <?php if($for): ?> for="<?php echo e($for); ?>" <?php endif; ?>
    class="flex items-center text-sm font-medium sm:gap-2 text-[#1a2235] mb-2 <?php echo e($class); ?>"
>
    <?php if($icon): ?>
        <i class="bx <?php echo e($icon); ?> <?php echo e($iconColor); ?> mr-1"></i>
    <?php endif; ?>
    <?php echo e($slot); ?>

</label>


<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/form/label.blade.php ENDPATH**/ ?>