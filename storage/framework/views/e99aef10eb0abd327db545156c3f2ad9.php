<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['status', 'label' => null, 'icon' => null]));

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

foreach (array_filter((['status', 'label' => null, 'icon' => null]), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars); ?>

<?php
$variant = [
    // General statuses
    'success' => 'bg-green-100 text-green-600',
    'neutral' => 'bg-indigo-50 text-gray-500',
    'info'    => 'bg-blue-50 text-blue-500',
    'warning' => 'bg-yellow-50 text-yellow-500',
    'danger'  => 'bg-red-50 text-red-500',
    // Program/Volunteer statuses
    'completed' => 'bg-green-100 text-green-700',
    'in_progress' => 'bg-blue-50 text-blue-700',
    'pending' => 'bg-yellow-50 text-yellow-700',
    'rejected' => 'bg-red-50 text-red-600',
    'approved' => 'bg-green-50 text-green-600',
    'role' => 'bg-[#1a2235] text-white',
    // Content Types
    'news' => 'bg-blue-100 text-blue-700',
    'program' => 'bg-green-100 text-green-700',
    'announcement' => 'bg-yellow-100 text-yellow-700',
    'event' => 'bg-purple-100 text-purple-700',
    'article' => 'bg-indigo-100 text-indigo-700',
    'blog' => 'bg-pink-100 text-pink-700',
    // Content Statuses
    'draft' => 'bg-gray-100 text-gray-700',
    'published' => 'bg-green-100 text-green-700',
    'archived' => 'bg-red-100 text-red-700',
    // Approval Statuses
    'needs_revision' => 'bg-orange-100 text-orange-700',
    'submitted' => 'bg-blue-100 text-blue-700',
    // draft - pending
    // Role-based 
    'volunteer' => 'bg-blue-600 text-white',
    'admin' => 'bg-purple-700 text-white',
    'program-coordinator' => 'bg-green-700 text-white',
    'financial-coordinator' => 'bg-yellow-600 text-white',
    'content-manager' => 'bg-indigo-700 text-white',
    'member' => 'bg-orange-600 text-white',
    // Account Statuses
    'verified' => 'bg-emerald-100 text-emerald-800',
    'not_verified' => 'bg-red-100 text-red-800',
    'connected' => 'bg-blue-100 text-blue-800',
    'not_connected' => 'bg-gray-100 text-gray-600',
];

$icons = [
    // General statuses
    'success' => 'bx bx-check-circle',
    'neutral' => 'bx bx-minus-circle',
    'info' => 'bx bx-info-circle',
    'warning' => 'bx bx-time',
    'danger' => 'bx bx-x-circle',
    // Program/Volunteer statuses
    'completed' => 'bx bx-check-circle',
    'in_progress' => 'bx bx-time',
    'pending' => 'bx bx-hourglass',
    'rejected' => 'bx bx-x',
    'approved' => 'bx bx-check-double',
    'role' => 'bx bx-check-circle text-xs',
    // Content Types
    'news' => 'bx bx-news',
    'program' => 'bx bx-calendar-event',
    'announcement' => 'bx bx-megaphone',
    'event' => 'bx bx-calendar-star',
    'article' => 'bx bx-file-text',
    'blog' => 'bx bx-pencil',
    // Content Statuses
    'draft' => 'bx bx-edit',
    'published' => 'bx bx-check-circle',
    'archived' => 'bx bx-archive',
    // Approval Statuses
    'needs_revision' => 'bx bx-refresh',
    'submitted' => 'bx bx-upload',
    // Role-based icons
    'volunteer' => 'bx bx-user',
    'admin' => 'bx bx-crown',
    'program-coordinator' => 'bx bx-calendar-event',
    'financial-coordinator' => 'bx bx-wallet',
    'content-manager' => 'bx bx-edit-alt',
    'member' => 'bx bx-group',
    // Account Status icons
    'verified' => 'bx bx-check-circle',
    'not_verified' => 'bx bx-x-circle',
    'connected' => 'bx bxl-google',
    'not_connected' => 'bx bx-x',
];

$style = $variant[$status] ?? 'bg-gray-300 text-black';
$iconClass = $icon ?? ($icons[$status] ?? '');
?>

<span class="inline-flex items-center gap-1 px-3 py-1 text-xs rounded-full font-medium <?php echo e($style); ?>">
    <?php if($iconClass): ?>
        <i class="<?php echo e($iconClass); ?>"></i>
    <?php endif; ?>
    <?php echo e($label ?? ucfirst(str_replace('_', ' ', $status))); ?>

</span>


<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/components/feedback-status/status-indicator.blade.php ENDPATH**/ ?>