<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name',
    'id' => null,
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'class' => '',
    'label' => null,
    'pattern' => null,
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
    'name',
    'id' => null,
    'type' => 'text',
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'class' => '',
    'label' => null,
    'pattern' => null,
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>



<?php
    $inputId = $id ?? $name;
    $inputType = $type === 'name' ? 'text' : $type;
    $inputPattern = $pattern;
    if ($type === 'name' && !$pattern) {
        $inputPattern = '[A-Za-z\s]+';
    }
    // pattern="^(https?://)?([a-zA-Z0-9]([a-zA-Z0-9\-].*[a-zA-Z0-9])?\.)+[a-zA-Z].*$"
?>

<?php if($label): ?>
    <label for="<?php echo e($inputId); ?>" class="block text-sm font-semibold text-[#1a2235] mb-2"><?php echo e($label); ?></label>
<?php endif; ?>
<input
    name="<?php echo e($name); ?>"
    id="<?php echo e($inputId); ?>"
    type="<?php echo e($inputType); ?>"
    value="<?php echo e(old($name, $value)); ?>"
    placeholder="<?php echo e($placeholder); ?>"
    <?php if($required): ?> required <?php endif; ?>
    <?php if($inputPattern): ?> pattern="<?php echo e($inputPattern); ?>" <?php endif; ?>
    <?php echo e($attributes->merge(['class' => 'w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] focus:ring-offset-0 transition-colors ' . $class])); ?>

/>
<?php $__errorArgs = [$name];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
    <span class="text-xs text-red-500 mt-1 block"><?php echo e($message); ?></span>
<?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/form/input.blade.php ENDPATH**/ ?>