<x-navigation-layout.breadcrumb :items="[
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
]" />
