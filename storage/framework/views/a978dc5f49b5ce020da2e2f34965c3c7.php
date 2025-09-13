<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'user' => null,
    'size' => '8',
    'showName' => false,
    'bare' => false, // When true, render only the circle (for compact/chat use)
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
    'user' => null,
    'size' => '8',
    'showName' => false,
    'bare' => false, // When true, render only the circle (for compact/chat use)
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    use Illuminate\Support\Str;

    $raw = $user?->profile_pic;
    $profilePic = null;

    if ($raw) {
        if (Str::startsWith($raw, 'https://lh3.googleusercontent.com')) {
            // Google photo
            $profilePic = $raw;
        } elseif (Str::startsWith($raw, ['http://', 'https://'])) {
            // Any other absolute URL
            $profilePic = $raw;
        } elseif (Str::startsWith($raw, 'storage/')) {
            $profilePic = asset($raw);
        } elseif (Str::startsWith($raw, 'uploads/')) {
            $profilePic = asset('storage/' . $raw);
        } elseif (Str::contains($raw, 'public/')) {
            $relative = Str::after($raw, 'public/');
            $profilePic = asset($relative);
        } else {
            $profilePic = asset('storage/' . ltrim($raw, '/'));
        }
    }

    $initial = $user?->name ? strtoupper(mb_substr($user->name, 0, 1)) : '?';

    $sizeMap = [
        '6' => 'h-6 w-6 text-[10px]',
        '8' => 'h-8 w-8 text-sm',
        '10' => 'h-10 w-10 text-base',
        '12' => 'h-12 w-12 text-lg',
    ];
    $sizeClass = $sizeMap[$size] ?? $sizeMap['8'];
?>

<?php if($bare): ?>
    <?php if($profilePic): ?>
        <img src="<?php echo e($profilePic); ?>" alt="<?php echo e($user?->name ?? $initial); ?>"
             class="<?php echo e($sizeClass); ?> rounded-full object-cover">
    <?php else: ?>
        <div class="<?php echo e($sizeClass); ?> bg-primary rounded-full flex items-center justify-center text-white">
            <?php echo e($initial); ?>

        </div>
    <?php endif; ?>
<?php else: ?>
    <div class="flex items-center gap-2">
        <?php if($profilePic): ?>
            <img src="<?php echo e($profilePic); ?>" alt="<?php echo e($user?->name ?? $initial); ?>"
                 class="<?php echo e($sizeClass); ?> rounded-full object-cover">
        <?php else: ?>
            <div class="<?php echo e($sizeClass); ?> bg-primary rounded-full flex items-center justify-center text-white">
                <?php echo e($initial); ?>

            </div>
        <?php endif; ?>

        <?php if($showName && $user?->name): ?>
            <span class="hidden lg:block text-sm font-medium max-w-24 truncate text-gray-700">
                <?php echo e($user->name); ?>

            </span>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/user-avatar.blade.php ENDPATH**/ ?>