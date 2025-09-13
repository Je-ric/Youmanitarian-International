<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'tabs' => [],
    'defaultTab' => null,
    'preserveState' => true,
    'class' => '',
    'mxAuto' => true,
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
    'tabs' => [],
    'defaultTab' => null,
    'preserveState' => true,
    'class' => '',
    'mxAuto' => true,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $tabIds = collect($tabs)->pluck('id')->toArray();
?>

<div x-data="{
    activeTab: new URLSearchParams(window.location.search).get('tab') || '<?php echo e($defaultTab); ?>',
    setTab(tab) {
        this.activeTab = tab;
        <?php if($preserveState): ?>
            const url = new URL(window.location);
            url.searchParams.set('tab', tab);
            // Reset pagination when switching tabs
            url.searchParams.delete('page');
            window.history.pushState({}, '', url);
        <?php endif; ?>
    }
}" class="<?php echo e($class); ?> <?php echo e($mxAuto ? 'mx-auto' : ''); ?>">

    <div class="border-b border-gray-200">
        <nav class="flex flex-wrap px-2 sm:px-4 gap-x-2 md:gap-x-4" aria-label="Tabs">
            <?php $__currentLoopData = $tabs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tab): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <button type="button"
                    @click="setTab('<?php echo e($tab['id']); ?>')"
                    :class="activeTab === '<?php echo e($tab['id']); ?>'
                        ? 'border-b-2 border-[#1a2235] text-[#1a2235] font-semibold'
                        : 'border-b-0 text-gray-500 hover:text-[#ffb51b] hover:border-b-2 hover:border-[#ffb51b]'"
                    class="whitespace-nowrap py-2 px-3 text-sm transition-all duration-200 focus:outline-none flex items-center gap-2">
                    <?php if(isset($tab['icon'])): ?>
                        <i class="bx <?php echo e($tab['icon']); ?> text-base"></i>
                    <?php endif; ?>
                    <span><?php echo e($tab['label']); ?></span>
                </button>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </nav>
    </div>

    
    <div class="mx-auto bg-[#F8F8FF] px-2 sm:px-4 md:px-6 py-4 sm:py-6">
        <?php $__currentLoopData = $tabIds; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tabId): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div x-show="activeTab === '<?php echo e($tabId); ?>'"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="space-y-4">
                <?php echo e(${'slot_' . $tabId} ?? ''); ?>

            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>


<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/navigation-layout/tabs-modern.blade.php ENDPATH**/ ?>