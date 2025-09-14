<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'icon',
    'title',
    'value',
    'percentage' => null,
    'percentage_type' => 'increase',
    'period' => null,
    'href' => '#',
    'bgColor' => 'bg-accent/10',
    'iconColor' => 'text-accent',
    'cardColor' => 'bg-white',
    'cardGradient' => null,
    'gradientVariant' => null,
    'note' => null,
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
    'icon',
    'title',
    'value',
    'percentage' => null,
    'percentage_type' => 'increase',
    'period' => null,
    'href' => '#',
    'bgColor' => 'bg-accent/10',
    'iconColor' => 'text-accent',
    'cardColor' => 'bg-white',
    'cardGradient' => null,
    'gradientVariant' => null,
    'note' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $gradientVariants = [
        // 'emerald' => 'bg-gradient-to-br from-emerald-50 via-emerald-100 to-white',
        // 'rose' => 'bg-gradient-to-br from-red-50 via-rose-100 to-white',
        // 'indigo' => 'bg-gradient-to-br from-indigo-50 via-indigo-100 to-white',
        // 'sky' => 'bg-gradient-to-br from-sky-50 via-sky-100 to-white',
        // 'amber' => 'bg-gradient-to-br from-amber-50 via-amber-100 to-white',
        // 'lime' => 'bg-gradient-to-br from-lime-50 via-lime-100 to-white',
        // 'purple' => 'bg-gradient-to-br from-purple-50 via-purple-100 to-white',
        // 'fuchsia' => 'bg-gradient-to-br from-fuchsia-50 via-fuchsia-100 to-white',
        'brand' => 'bg-gradient-to-br from-[#1a2235] to-[#ffb51b]',
        'slate' => 'bg-gradient-to-br from-slate-700 to-slate-500',
        'deep-rose' => 'bg-gradient-to-br from-red-800 to-rose-600',
        // 'teal' => 'bg-gradient-to-br from-teal-50 via-teal-100 to-white',
        'sunset' => 'bg-gradient-to-br from-orange-600 to-amber-400',
        // 'cyan' => 'bg-gradient-to-br from-cyan-50 via-cyan-100 to-white',
        //'mint' => 'bg-gradient-to-br from-green-200 via-teal-100 to-cyan-100',
        //'lavender' => 'bg-gradient-to-br from-indigo-100 via-purple-100 to-pink-100',
        
        // New gradients inspired by uigradients.com
        'aqua' => 'bg-gradient-to-br from-cyan-400 via-blue-200 to-emerald-100',
        'peach' => 'bg-gradient-to-br from-amber-200 via-orange-100 to-pink-100',
        'midnight' => 'bg-gradient-to-br from-gray-900 via-slate-800 to-indigo-900',
        'sunrise' => 'bg-gradient-to-br from-pink-200 via-yellow-100 to-amber-200',
        'fire' => 'bg-gradient-to-br from-red-500 via-orange-400 to-yellow-300',
        'cherry' => 'bg-gradient-to-br from-rose-400 via-pink-300 to-red-400',
        'ocean' => 'bg-gradient-to-br from-blue-400 via-cyan-300 to-teal-400',
        'forest' => 'bg-gradient-to-br from-green-400 via-emerald-300 to-teal-400',
        'sunset-orange' => 'bg-gradient-to-br from-orange-400 via-red-300 to-pink-400',
        'lavender-purple' => 'bg-gradient-to-br from-purple-400 via-violet-300 to-indigo-400',
        'mint-green' => 'bg-gradient-to-br from-green-300 via-emerald-200 to-teal-300',
        'rose-pink' => 'bg-gradient-to-br from-pink-400 via-rose-300 to-red-400',
        'blue-sky' => 'bg-gradient-to-br from-sky-400 via-blue-300 to-indigo-400',
        'golden' => 'bg-gradient-to-br from-yellow-400 via-amber-300 to-orange-400',
        'emerald-teal' => 'bg-gradient-to-br from-emerald-400 via-teal-300 to-cyan-400',
        'violet-purple' => 'bg-gradient-to-br from-violet-400 via-purple-300 to-indigo-400',
        'coral' => 'bg-gradient-to-br from-orange-300 via-red-200 to-pink-300',
        'azure' => 'bg-gradient-to-br from-blue-300 via-cyan-200 to-teal-300',
        'lime-green' => 'bg-gradient-to-br from-lime-400 via-green-300 to-emerald-400',
        'fuchsia-pink' => 'bg-gradient-to-br from-fuchsia-400 via-pink-300 to-rose-400',
        'indigo-blue' => 'bg-gradient-to-br from-indigo-400 via-blue-300 to-cyan-400',
        'amber-orange' => 'bg-gradient-to-br from-amber-400 via-orange-300 to-red-400',
        'teal-cyan' => 'bg-gradient-to-br from-teal-400 via-cyan-300 to-blue-400',
        'purple-violet' => 'bg-gradient-to-br from-purple-400 via-violet-300 to-indigo-400',
        'green-emerald' => 'bg-gradient-to-br from-green-400 via-emerald-300 to-teal-400',
    ];
    
    $selectedGradient = $cardGradient ?? ($gradientVariant ? ($gradientVariants[$gradientVariant] ?? null) : null);
    
    // Dark variants that need white text
    $darkVariants = ['brand', 'slate', 'deep-rose', 'sunset', 'midnight'];
    $isDarkVariant = in_array($gradientVariant, $darkVariants);
?>

<a href="<?php echo e($href); ?>"
   class="relative block p-3 sm:p-4 <?php echo e($selectedGradient ?? $cardColor); ?> rounded-lg shadow-lg hover:shadow-sm hover:border-primary transition-all duration-300 ease-in-out <?php echo e($isDarkVariant ? 'text-white' : ''); ?>">
    <div class="flex items-center justify-between">
        <div>
            <p class="text-xs sm:text-sm <?php echo e($isDarkVariant ? 'text-white/80' : 'text-gray-600'); ?>"><?php echo e($title); ?></p>
            <h3 class="text-lg sm:text-2xl font-bold <?php echo e($isDarkVariant ? 'text-white' : 'text-[#1a2235]'); ?>"><?php echo e($value); ?></h3>
            <?php if($note): ?>
                <p class="text-xs <?php echo e($isDarkVariant ? 'text-white/80' : 'text-gray-500'); ?> mt-1">
                    <?php echo e($note); ?>

                </p>
            <?php endif; ?>
        </div>
        <div class="flex-shrink-0 flex items-center justify-center w-10 h-10 sm:w-12 sm:h-12 rounded-full <?php echo e($isDarkVariant ? 'bg-white/10 text-white' : $bgColor . ' ' . $iconColor); ?>">
            <i class="bx <?php echo e($icon); ?> text-xl sm:text-2xl"></i>
        </div>
    </div>
    <?php if($percentage): ?>
        <div class="mt-4 flex items-center space-x-2 text-sm">
            <?php if($percentage_type === 'increase'): ?>
                <span class="flex items-center <?php echo e($isDarkVariant ? 'text-white' : 'text-green-600'); ?> font-semibold">
                    <i class='bx bx-up-arrow-alt'></i>
                    <span><?php echo e($percentage); ?></span>
                </span>
            <?php else: ?>
                <span class="flex items-center <?php echo e($isDarkVariant ? 'text-white' : 'text-red-600'); ?> font-semibold">
                    <i class='bx bx-down-arrow-alt'></i>
                    <span><?php echo e($percentage); ?></span>
                </span>
            <?php endif; ?>
            <?php if($period): ?>
                <span class="<?php echo e($isDarkVariant ? 'text-white/80' : 'text-gray-500'); ?>"><?php echo e($period); ?></span>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</a>

 <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/overview/stat-card.blade.php ENDPATH**/ ?>