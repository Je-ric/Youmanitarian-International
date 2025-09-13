<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    // items: array of ['id'=>string, 'title'=>HTML, 'content'=>HTML, 'open'=>bool]
    'items' => [],
    'flush' => false, // optional: if true, removes bg/shadow for a minimal look
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
    // items: array of ['id'=>string, 'title'=>HTML, 'content'=>HTML, 'open'=>bool]
    'items' => [],
    'flush' => false, // optional: if true, removes bg/shadow for a minimal look
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $base = $flush
        ? 'collapse collapse-arrow border-b border-gray-200'
        : 'collapse collapse-arrow bg-white border border-gray-200 shadow-sm';
?>

<div class="space-y-2">
    <?php $__currentLoopData = $items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $open    = $i['open']   ?? false;
            $title   = $i['title']  ?? 'Item';
            $content = $i['content'] ?? '';
            $id      = $i['id']     ?? 'acc-'.uniqid();
        ?>

        <div class="<?php echo e($base); ?> rounded-xl overflow-hidden">
            <input type="checkbox" id="<?php echo e($id); ?>" <?php if($open): ?> checked <?php endif; ?>>
            <div class="collapse-title flex items-center gap-3 font-medium text-sm text-[#1a2235]">
                <?php echo $title; ?>

            </div>
            <div class="collapse-content text-sm text-gray-600 leading-relaxed">
                <?php echo $content; ?>

            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div>



<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/accordion.blade.php ENDPATH**/ ?>