<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'icon' => null, 
    'title',
    'desc' => null, 
    'class' => '',
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
    'icon' => null, 
    'title',
    'desc' => null, 
    'class' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<div class="w-full bg-[#f4f5f7] flex flex-col md:flex-row justify-between items-start md:items-center gap-4 px-4 sm:px-6 py-4 border-y border-gray-200 <?php echo e($class); ?>">

    <div class="flex items-start md:items-center gap-3 sm:gap-4">
        <?php if($icon): ?>
            <span class="flex-shrink-0 inline-flex items-center justify-center shadow-lg rounded-lg bg-[#313849] text-[#ffb51b] w-10 h-10 sm:w-12 sm:h-12 text-xl sm:text-2xl">
                <i class="bx <?php echo e($icon); ?>"></i>
            </span>
        <?php endif; ?>
        <div>
            <h1 class="text-lg sm:text-xl font-bold text-[#1a2235]" id="programTitle"><?php echo e($title); ?></h1>
            <?php if($desc): ?>
                <p class="text-sm text-gray-500 mt-1"><?php echo e($desc); ?></p>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="flex-shrink-0 w-full md:w-auto flex flex-row md:justify-end gap-2 mt-2 md:mt-0">
        <?php echo e($slot); ?>

    </div>
</div>

 <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/page-header.blade.php ENDPATH**/ ?>