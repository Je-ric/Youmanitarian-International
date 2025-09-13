<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'user' => null,
    'size' => '8',
    'showName' => false,
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
            // Google photo (highest priority)
            $profilePic = $raw;
        } elseif (Str::startsWith($raw, ['http://', 'https://'])) {
            // Any other absolute URL
            $profilePic = $raw;
        } elseif (Str::startsWith($raw, 'storage/')) {
            // Already public path (e.g. storage/uploads/profile_photo/...)
            $profilePic = asset($raw);
        } elseif (Str::startsWith($raw, 'uploads/')) {
            // Stored without leading storage/
            $profilePic = asset('storage/' . $raw);
        } elseif (Str::contains($raw, 'public/')) {
            //  public/storage/uploads/...
            $relative = Str::after($raw, 'public/');
            $profilePic = asset($relative);
        } else {
            // treat as relative inside storage
            $profilePic = asset('storage/' . ltrim($raw, '/'));
        }
    }

    $initial = $user?->name ? strtoupper(mb_substr($user->name, 0, 1)) : '?';

    $sizeMap = [
        '6' => 'h-6 w-6 text-xs',
        '8' => 'h-8 w-8 text-sm',
        '10' => 'h-10 w-10 text-base',
        '12' => 'h-12 w-12 text-lg',
    ];
    $sizeClass = $sizeMap[$size] ?? $sizeMap['8'];
?>

<div class="flex items-center gap-2">
    <?php if($profilePic): ?>
        <img src="<?php echo e($profilePic); ?>" alt="<?php echo e($user?->name ?? 'User'); ?>"
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
<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/user-avatar.blade.php ENDPATH**/ ?>