

<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames(([
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
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
    'href' => null,
    'type' => 'button',
    'variant' => 'primary',
]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
    $variant = strval($variant);
    $styles = [
        'primary' => 'btn px-4 py-2 rounded-md text-white text-sm md:text-sm font-semibold
                shadow-[0px_5.28px_13.2px_rgba(255,225,164,1)] active:scale-95 transition-transform duration-200
                bg-[#ffb51b] hover:bg-[#ffc449] border-0 outline-none focus:outline-none focus:ring-2 focus:ring-yellow-400/70',
        'secondary' => 'btn px-4 py-2 rounded-md text-white text-sm md:text-sm font-semibold
                shadow-[0px_5px_13px_rgba(15,21,36,0.8)] active:scale-95 transition-transform duration-200
                bg-[#1a2235] hover:bg-[#0F1524] border-0 outline-none focus:outline-none focus:ring-2 focus:ring-yellow-700/70',

        'success'   => 'btn btn-success text-white hover:bg-green-600 active:scale-95 transition-transform duration-200',
        'danger'    => 'btn bg-red-600 text-white hover:bg-red-400 active:scale-95 transition-transform duration-200',
        'warning'   => 'btn btn-warning text-white hover:bg-[#e6a011] active:scale-95 transition-transform duration-200',
        'info'      => 'btn btn-info text-white hover:bg-blue-600 active:scale-95 transition-transform duration-200',
        'manage'    => 'btn bg-emerald-500 text-white hover:bg-emerald-600 active:scale-95 transition-transform duration-200',

        'restore'   => 'btn bg-blue-500 text-white hover:bg-blue-600 active:scale-95 transition-transform duration-200',
        'approve'   => 'btn bg-green-500 text-white hover:bg-green-600 active:scale-95 transition-transform duration-200',

        'delete'    => 'text-white bg-red-600 hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center',

        'attendance' => '
            bg-[#ffb51b] hover:bg-[#ffc449]
            text-white
            px-4 py-2
            text-sm sm:text-base md:text-base font-semibold
            rounded-md
            shadow-[0px_5.28px_13.2px_0px_rgba(255,225,164,1.00)]
            w-full
            active:scale-95
            transition-transform duration-200
        ',

        'reviewed'  => 'btn btn-outline text-green-600 text-sm border-green-300 hover:bg-green-50 font-semibold',
        'attendance-approve' => 'w-full bg-green-50 text-sm border border-green-300 text-green-700 hover:bg-green-100 font-semibold rounded-lg flex items-center justify-center gap-2 py-2 transition',
        'attendance-reject'  => 'w-full bg-red-50 text-sm border border-red-300 text-red-700 hover:bg-red-100 font-semibold rounded-lg flex items-center justify-center gap-2 py-2 transition',

        'task-primary' => 'px-3 py-1 text-sm bg-[#ffb51b] text-[#1a2235] rounded-md hover:bg-[#e6a319] font-semibold transition-colors',
        'task-secondary' => 'px-3 py-1 text-sm bg-[#1a2235] text-white rounded-md hover:bg-[#2a3245] font-semibold transition-colors',

        'table-action-view' => 'flex items-center justify-center bg-blue-50 border border-blue-100 rounded-md hover:bg-blue-100 hover:border-blue-300 text-[#1a2235] text-sm px-3 py-2 shadow-sm focus:ring-2 focus:ring-blue-200 transition gap-2',
        'table-action-manage' => 'flex items-center justify-center bg-green-50 border border-green-100 rounded-md hover:bg-green-100 hover:border-green-300 text-green-600 text-sm px-3 py-2 shadow-sm focus:ring-2 focus:ring-green-200 transition gap-2',
        'table-action-edit' => 'flex items-center justify-center bg-yellow-50 border border-yellow-100 rounded-md hover:bg-yellow-100 hover:border-yellow-300 text-yellow-500 text-sm px-3 py-2 shadow-sm focus:ring-2 focus:ring-yellow-200 transition gap-2',
        'table-action-danger' => 'flex items-center justify-center bg-red-50 border border-red-100 rounded-md hover:bg-red-100 hover:border-red-300 text-red-500 text-sm px-3 py-2 shadow-sm focus:ring-2 focus:ring-red-200 transition gap-2',
        'table-action-archive' => 'flex items-center justify-center bg-orange-50 border border-orange-100 rounded-md hover:bg-orange-100 hover:border-orange-300 text-orange-500 text-sm px-3 py-2 shadow-sm focus:ring-2 focus:ring-orange-200 transition gap-2',

        'save-entry' => 'btn px-6 py-2 text-sm font-semibold flex items-center gap-2 bg-[#283658] hover:bg-[#313849] text-[#FFB51B] rounded shadow active:scale-95 transition-transform duration-200 border-0 outline-none focus:outline-none focus:ring-2 focus:ring-[#283658]',
        'manual-entry' => 'btn bg-[#FFB51B] hover:bg-[#FFCB5F] text-white font-semibold px-2 py-1 text-xs rounded shadow active:scale-95 transition-transform duration-200 border-0 outline-none focus:outline-none focus:ring-2 focus:ring-[#FFB51B]',
        'review-attendance' => 'btn bg-[#1A2235] hover:bg-[#313849] text-white font-semibold px-2 py-1 text-xs rounded shadow active:scale-95 transition-transform duration-200 border-0 outline-none focus:outline-none focus:ring-2 focus:ring-[#1A2235]',

        'disabled' => 'px-6 py-2 text-sm font-medium text-slate-400 bg-slate-100 border border-slate-300 rounded-lg cursor-not-allowed',
        'disabled-dark' => 'px-6 py-2 text-sm font-medium text-[#ffb51b] bg-slate-700 border border-slate-600 rounded-lg cursor-not-allowed opacity-60',
        'cancel' => 'px-3 py-1.5 bg-slate-100 text-slate-600 rounded-md text-xs font-medium hover:bg-slate-200 transition-colors',
        'discard' => 'px-4 py-2 bg-gray-100 text-gray-700 rounded-lg border border-gray-300 hover:bg-gray-200 hover:border-gray-400 transition-colors shadow-[0px_5.28px_13.2px_rgba(60,60,60,0.18)] focus:ring-2 focus:ring-gray-300/60',
        'assign' => 'w-full py-2.5 text-xs font-semibold text-amber-700 bg-gradient-to-r from-amber-50 to-yellow-100 hover:from-amber-100 hover:to-yellow-200 rounded-lg border border-amber-200 transition-all duration-200 flex items-center justify-center gap-2 shadow-sm hover:shadow-md',
        'attendance-dark' => 'btn px-4 py-2 rounded-md text-[#ffb51b] text-sm md:text-sm font-semibold
                shadow-[0px_5.28px_13.2px_rgba(30,41,59,0.5)] active:scale-95 transition-transform duration-200
                bg-slate-800 hover:bg-slate-700 border border-[#ffb51b] outline-none focus:outline-none focus:ring-2 focus:ring-yellow-400/70',

        'mobile-toggle' => 'md:hidden inline-flex items-center justify-center w-8 h-8
                            bg-white/10 hover:bg-white/20 border border-white/20 text-white rounded-lg
                            transition-all duration-200',

        'glass-button' => 'inline-flex items-center justify-center px-3 py-1.5
                            bg-white/10 hover:bg-white/20 border border-white/20 text-white
                            rounded-lg transition-all duration-200 backdrop-blur-sm',

    ];

    $class = "inline-flex items-center justify-center gap-1 px-4 py-2 rounded-md font-semibold transition duration-200 " . ($styles[$variant] ?? $styles['primary']);
?>


<?php if($href): ?>
    <a href="<?php echo e($href); ?>" <?php echo e($attributes->merge(['class' => $class])); ?>>
        <?php echo e($slot); ?>

    </a>
<?php else: ?>
    <button type="<?php echo e($type); ?>" <?php echo e($attributes->merge(['class' => $class])); ?>>

        <?php echo e($slot); ?>

    </button>
<?php endif; ?>


<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/button.blade.php ENDPATH**/ ?>