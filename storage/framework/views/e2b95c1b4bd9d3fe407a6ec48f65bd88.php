<?php if (isset($component)) { $__componentOriginal1036886855ff706e6843b57504ed189a = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal1036886855ff706e6843b57504ed189a = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.navigation-layout.breadcrumb','data' => ['items' => [
    ['label' => 'Dashboard', 'url' => route('dashboard')],
    ...request()->routeIs('content.*')
        ? [
            ['label' => 'Content Management', 'url' => route('content.index')],
            ...request()->routeIs('content.create') ? [['label' => 'Create Content']] : [],
            ...request()->routeIs('content.edit') ? [['label' => 'Edit Content']] : [],
            ...request()->routeIs('content.team-members') ? [['label' => 'Team Members']] : [],
        ]
        : [],
    ...request()->routeIs('programs.*')
        ? [
            ['label' => 'Programs', 'url' => route('programs.index')],
            ...request()->routeIs('programs.create') ? [['label' => 'Create Program']] : [],
            ...request()->routeIs('programs.edit') ? [['label' => 'Edit Program']] : [],
            ...request()->routeIs('programs.view') ? [['label' => 'Attendance']] : [],
            ...request()->routeIs('programs.manage_volunteers') ? [['label' => 'Manage']] : [],
        ]
        : [],
    ...request()->routeIs('volunteers.*') ? [['label' => 'Volunteers', 'url' => route('volunteers.index')]] : [],
    ...request()->routeIs('roles.*') ? [['label' => 'Role Management', 'url' => route('roles.index')]] : [],
    ...request()->routeIs('finance.*')
        ? [
            ['label' => 'Finance', 'url' => route('finance.index')],
            ...request()->routeIs('finance.membership.payments') ? [['label' => 'Membership Payments']] : [],
            ...request()->routeIs('members.index*') ? [['label' => 'Members']] : [],
        ]
        : [],
    ...request()->routeIs('profile.me') ? [['label' => 'My Profile']] : [],
]]] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('navigation-layout.breadcrumb'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['items' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute([
    ['label' => 'Dashboard', 'url' => route('dashboard')],
    ...request()->routeIs('content.*')
        ? [
            ['label' => 'Content Management', 'url' => route('content.index')],
            ...request()->routeIs('content.create') ? [['label' => 'Create Content']] : [],
            ...request()->routeIs('content.edit') ? [['label' => 'Edit Content']] : [],
            ...request()->routeIs('content.team-members') ? [['label' => 'Team Members']] : [],
        ]
        : [],
    ...request()->routeIs('programs.*')
        ? [
            ['label' => 'Programs', 'url' => route('programs.index')],
            ...request()->routeIs('programs.create') ? [['label' => 'Create Program']] : [],
            ...request()->routeIs('programs.edit') ? [['label' => 'Edit Program']] : [],
            ...request()->routeIs('programs.view') ? [['label' => 'Attendance']] : [],
            ...request()->routeIs('programs.manage_volunteers') ? [['label' => 'Manage']] : [],
        ]
        : [],
    ...request()->routeIs('volunteers.*') ? [['label' => 'Volunteers', 'url' => route('volunteers.index')]] : [],
    ...request()->routeIs('roles.*') ? [['label' => 'Role Management', 'url' => route('roles.index')]] : [],
    ...request()->routeIs('finance.*')
        ? [
            ['label' => 'Finance', 'url' => route('finance.index')],
            ...request()->routeIs('finance.membership.payments') ? [['label' => 'Membership Payments']] : [],
            ...request()->routeIs('members.index*') ? [['label' => 'Members']] : [],
        ]
        : [],
    ...request()->routeIs('profile.me') ? [['label' => 'My Profile']] : [],
])]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal1036886855ff706e6843b57504ed189a)): ?>
<?php $attributes = $__attributesOriginal1036886855ff706e6843b57504ed189a; ?>
<?php unset($__attributesOriginal1036886855ff706e6843b57504ed189a); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal1036886855ff706e6843b57504ed189a)): ?>
<?php $component = $__componentOriginal1036886855ff706e6843b57504ed189a; ?>
<?php unset($__componentOriginal1036886855ff706e6843b57504ed189a); ?>
<?php endif; ?>
<?php /**PATH C:\Users\Janice\youmanitarian-international\resources\views/layouts/partials/breadcrumb.blade.php ENDPATH**/ ?>