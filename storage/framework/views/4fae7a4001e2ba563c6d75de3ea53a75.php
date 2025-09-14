<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'name' => 'file',
    'id' => 'file',
    'accept' => 'image/*,.pdf',
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
    'name' => 'file',
    'id' => 'file',
    'accept' => 'image/*,.pdf',
    'class' => '',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>



<div x-data="{ files: [] }" class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-[#ffb51b] transition-colors <?php echo e($class); ?>">
    <div class="text-center">
        <i class='bx bx-cloud-upload text-3xl text-gray-400 mb-2 group-hover:text-[#ffb51b]'></i>
        <div class="mb-2">
            <label for="<?php echo e($id); ?>" class="cursor-pointer group">
                <span class="text-sm font-medium text-[#ffb51b] group-hover:text-[#1a2235]">Upload a file</span>
                <span class="text-sm text-gray-500"> or drag and drop</span>
            </label>
            <input
                type="file"
                name="<?php echo e($name); ?>"
                id="<?php echo e($id); ?>"
                accept="<?php echo e($accept); ?>"
                <?php echo e($attributes->get('required') ? 'required' : ''); ?>

                <?php echo e($attributes->get('multiple') ? 'multiple' : ''); ?>

                class="hidden"
                x-on:change="files = Array.from($event.target.files).map(f => f.name)"
            >
        </div>
        <p class="text-xs text-gray-500">
            <?php echo e($slot->isEmpty() ? 'PNG, JPG, PDF up to 10MB' : $slot); ?>

        </p>
    </div>
    
    <!-- Show selected files -->
    <template x-if="files.length">
        <p class="text-xs text-[#1a2235] mt-2" x-text="files.join(', ')"></p>
    </template>
</div> <?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/form/input-upload.blade.php ENDPATH**/ ?>