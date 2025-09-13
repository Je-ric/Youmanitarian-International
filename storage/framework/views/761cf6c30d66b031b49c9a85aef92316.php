<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['items' => []]));

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

foreach (array_filter((['items' => []]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<nav class="flex px-5 py-3 text-gray-700 border-b border-gray-200 bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-3">
        <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <div class="flex items-center">
                    <?php if(!$loop->first): ?>
                        <i class="bx bx-chevron-right text-gray-400"></i>
                    <?php endif; ?>
                    <?php if(isset($item['url'])): ?>
                        <a href="<?php echo e($item['url']); ?>" class="ml-1 text-sm font-medium text-gray-700 hover:text-[#ffb51b] md:ml-2 dark:text-gray-400 dark:hover:text-white">
                            <?php if($loop->first): ?>
                                <i class="bx bxs-home mr-2"></i>
                            <?php endif; ?>
                            <?php echo e($item['label']); ?>

                        </a>
                    <?php else: ?>
                        <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">
                            <?php echo e($item['label']); ?>

                        </span>
                    <?php endif; ?>
                </div>
            </li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ol>
</nav>

 <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/navigation-layout/breadcrumb.blade.php ENDPATH**/ ?>