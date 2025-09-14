<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'id' => null,
    'name' => null,
    'value' => '',
    'label' => null,
    'placeholder' => '',
    'rows' => 3,
    'disabled' => false,
    'required' => false,
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
    'id' => null,
    'name' => null,
    'value' => '',
    'label' => null,
    'placeholder' => '',
    'rows' => 3,
    'disabled' => false,
    'required' => false,
    'class' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>



<?php if($label): ?>
    <label for="<?php echo e($id ?? $name); ?>" class="block text-sm font-semibold text-gray-700 mb-2">
        <?php echo e($label); ?>

    </label>
<?php endif; ?>
<textarea
    id="<?php echo e($id ?? $name); ?>"
    name="<?php echo e($name); ?>"
    rows="<?php echo e($rows); ?>"
    <?php if($disabled): ?> disabled <?php endif; ?>
    <?php if($required): ?> required <?php endif; ?>
    placeholder="<?php echo e($placeholder); ?>"
    <?php echo e($attributes->merge(['class' => (
        'w-full p-3 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] transition-colors '.
        ($disabled ? 'bg-gray-50 text-gray-500 cursor-not-allowed ' : '').
        $class
    )])); ?>

><?php echo e(old($name, $value)); ?></textarea>

<?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <span class="text-xs text-red-500 mt-1 block"><?php echo e($message); ?></span>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/form/textarea.blade.php ENDPATH**/ ?>