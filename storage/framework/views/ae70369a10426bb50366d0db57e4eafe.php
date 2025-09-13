<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'id',
    'maxWidth' => 'max-w-2xl',
    'width' => 'w-11/12',
    'maxHeight' => 'max-h-[90vh]',
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
    'id',
    'maxWidth' => 'max-w-2xl',
    'width' => 'w-11/12',
    'maxHeight' => 'max-h-[90vh]',
    'class' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<dialog id="<?php echo e($id); ?>" class="modal" <?php echo e($attributes); ?>>
    <div class="modal-box <?php echo e($width); ?> <?php echo e($maxWidth); ?> <?php echo e($maxHeight); ?> p-0 overflow-hidden rounded-xl bg-white border border-slate-200 shadow-xl flex flex-col <?php echo e($class); ?>">
        <?php echo e($slot); ?>

    </div>
</dialog>

 <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/modal/dialog.blade.php ENDPATH**/ ?>