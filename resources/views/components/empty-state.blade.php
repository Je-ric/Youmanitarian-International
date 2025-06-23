@props([
    'variant' => 'default',
    'title' => '',
    'description' => '',
    'icon' => null,
    'iconColor' => null,
    'bgColor' => null,
    'size' => 'default', // 'small', 'default', 'large'
    'actionText' => null,
    'actionUrl' => null,
    'actionVariant' => 'primary'
])

@php
    $variants = [
        // General states
        'default' => [
            'icon' => 'bx bx-info-circle',
            'iconColor' => 'text-gray-400',
            'bgColor' => 'bg-gray-100',
            'title' => 'No Data Available',
            'description' => 'There is no information to display at this time.'
        ],
        'loading' => [
            'icon' => 'bx bx-loader-alt',
            'iconColor' => 'text-[#ffb51b]',
            'bgColor' => 'bg-[#ffb51b]/10',
            'title' => 'Loading...',
            'description' => 'Please wait while we fetch your data.'
        ],
        'error' => [
            'icon' => 'bx bx-error-circle',
            'iconColor' => 'text-red-500',
            'bgColor' => 'bg-red-50',
            'title' => 'Something went wrong',
            'description' => 'We encountered an error while loading your data.'
        ],
        
        // Content states
        'no-data' => [
            'icon' => 'bx bx-data',
            'iconColor' => 'text-gray-400',
            'bgColor' => 'bg-gray-100',
            'title' => 'No Data Yet',
            'description' => 'Start by adding your first entry.'
        ],
        'empty-table' => [
            'icon' => 'bx bx-table',
            'iconColor' => 'text-gray-400',
            'bgColor' => 'bg-gray-100',
            'title' => 'No Records Found',
            'description' => 'This table is currently empty.'
        ],
        'no-search' => [
            'icon' => 'bx bx-search-alt',
            'iconColor' => 'text-gray-400',
            'bgColor' => 'bg-gray-100',
            'title' => 'No Results Found',
            'description' => 'Try adjusting your search criteria.'
        ],
        
        // Volunteer & People states
        'no-volunteers' => [
            'icon' => 'bx bx-user-plus',
            'iconColor' => 'text-blue-500',
            'bgColor' => 'bg-blue-50',
            'title' => 'No Volunteers Yet',
            'description' => 'Start recruiting volunteers for your programs.'
        ],
        'no-applications' => [
            'icon' => 'bx bx-user-check',
            'iconColor' => 'text-purple-500',
            'bgColor' => 'bg-purple-50',
            'title' => 'No Applications',
            'description' => 'No volunteer applications have been submitted.'
        ],
        'no-approved' => [
            'icon' => 'bx bx-user-check',
            'iconColor' => 'text-green-500',
            'bgColor' => 'bg-green-50',
            'title' => 'No Approved Volunteers',
            'description' => 'No volunteers have been approved yet.'
        ],
        'no-pending' => [
            'icon' => 'bx bx-user-voice',
            'iconColor' => 'text-amber-500',
            'bgColor' => 'bg-amber-50',
            'title' => 'No Pending Applications',
            'description' => 'All applications have been reviewed.'
        ],
        'no-denied' => [
            'icon' => 'bx bx-user-x',
            'iconColor' => 'text-red-500',
            'bgColor' => 'bg-red-50',
            'title' => 'No Denied Applications',
            'description' => 'No applications have been denied.'
        ],
        
        // Task & Program states
        'no-tasks' => [
            'icon' => 'bx bx-task',
            'iconColor' => 'text-[#ffb51b]',
            'bgColor' => 'bg-[#ffb51b]/10',
            'title' => 'No Tasks Created',
            'description' => 'Create your first task to get started.'
        ],
        'no-assigned-tasks' => [
            'icon' => 'bx bx-user-pin',
            'iconColor' => 'text-indigo-500',
            'bgColor' => 'bg-indigo-50',
            'title' => 'No Assigned Tasks',
            'description' => 'No tasks have been assigned to volunteers yet.'
        ],
        'no-programs' => [
            'icon' => 'bx bx-calendar-event',
            'iconColor' => 'text-[#1a2235]',
            'bgColor' => 'bg-slate-100',
            'title' => 'No Programs Available',
            'description' => 'Create your first humanitarian program.'
        ],
        'no-attendance' => [
            'icon' => 'bx bx-calendar-check',
            'iconColor' => 'text-green-500',
            'bgColor' => 'bg-green-50',
            'title' => 'No Attendance Records',
            'description' => 'Attendance tracking will appear here.'
        ],
        
        // Communication states
        'no-notifications' => [
            'icon' => 'bx bx-bell-off',
            'iconColor' => 'text-gray-400',
            'bgColor' => 'bg-gray-100',
            'title' => 'All Caught Up!',
            'description' => 'You have no new notifications.'
        ],
        'no-messages' => [
            'icon' => 'bx bx-message-square-dots',
            'iconColor' => 'text-blue-500',
            'bgColor' => 'bg-blue-50',
            'title' => 'No Messages',
            'description' => 'Your inbox is empty.'
        ],
        'no-feedback' => [
            'icon' => 'bx bx-comment-detail',
            'iconColor' => 'text-purple-500',
            'bgColor' => 'bg-purple-50',
            'title' => 'No Feedback Yet',
            'description' => 'Feedback from participants will appear here.'
        ],
        
        // Media & Files states
        'no-images' => [
            'icon' => 'bx bx-image-add',
            'iconColor' => 'text-emerald-500',
            'bgColor' => 'bg-emerald-50',
            'title' => 'No Images Uploaded',
            'description' => 'Upload your first image to get started.'
        ],
        'no-files' => [
            'icon' => 'bx bx-file-plus',
            'iconColor' => 'text-blue-500',
            'bgColor' => 'bg-blue-50',
            'title' => 'No Files Uploaded',
            'description' => 'Upload documents and files here.'
        ],
        'no-documents' => [
            'icon' => 'bx bx-file-blank',
            'iconColor' => 'text-gray-500',
            'bgColor' => 'bg-gray-100',
            'title' => 'No Documents',
            'description' => 'Important documents will be stored here.'
        ],
        
        // Financial states
        'no-payments' => [
            'icon' => 'bx bx-credit-card',
            'iconColor' => 'text-green-500',
            'bgColor' => 'bg-green-50',
            'title' => 'No Payment Records',
            'description' => 'Payment history will appear here.'
        ],
        'no-donations' => [
            'icon' => 'bx bx-heart',
            'iconColor' => 'text-red-500',
            'bgColor' => 'bg-red-50',
            'title' => 'No Donations Yet',
            'description' => 'Donation records will be tracked here.'
        ],
        
        // Role & Permission states
        'no-roles' => [
            'icon' => 'bx bx-shield-check',
            'iconColor' => 'text-indigo-500',
            'bgColor' => 'bg-indigo-50',
            'title' => 'No Roles Assigned',
            'description' => 'User roles and permissions will appear here.'
        ],
        'no-permissions' => [
            'icon' => 'bx bx-lock-open',
            'iconColor' => 'text-amber-500',
            'bgColor' => 'bg-amber-50',
            'title' => 'No Permissions Set',
            'description' => 'Configure user permissions here.'
        ],
        
        // Analytics & Reports states
        'no-reports' => [
            'icon' => 'bx bx-bar-chart-alt-2',
            'iconColor' => 'text-[#ffb51b]',
            'bgColor' => 'bg-[#ffb51b]/10',
            'title' => 'No Reports Available',
            'description' => 'Generate your first report to see insights.'
        ],
        'no-analytics' => [
            'icon' => 'bx bx-trending-up',
            'iconColor' => 'text-green-500',
            'bgColor' => 'bg-green-50',
            'title' => 'No Analytics Data',
            'description' => 'Analytics will appear as data is collected.'
        ],
        
        // Success states
        'completed' => [
            'icon' => 'bx bx-check-circle',
            'iconColor' => 'text-green-500',
            'bgColor' => 'bg-green-50',
            'title' => 'All Done!',
            'description' => 'Everything has been completed successfully.'
        ],
        'success' => [
            'icon' => 'bx bx-check-shield',
            'iconColor' => 'text-green-500',
            'bgColor' => 'bg-green-50',
            'title' => 'Success!',
            'description' => 'Your action was completed successfully.'
        ]
    ];

    $variantConfig = $variants[$variant] ?? $variants['default'];
    
    // Size configurations
    $sizeConfig = [
        'small' => [
            'container' => 'py-6',
            'iconSize' => 'w-12 h-12',
            'iconText' => 'text-xl',
            'titleText' => 'text-base',
            'descText' => 'text-sm',
            'buttonSize' => 'px-4 py-2 text-sm'
        ],
        'default' => [
            'container' => 'py-8',
            'iconSize' => 'w-16 h-16',
            'iconText' => 'text-2xl',
            'titleText' => 'text-lg',
            'descText' => 'text-base',
            'buttonSize' => 'px-6 py-3 text-base'
        ],
        'large' => [
            'container' => 'py-12',
            'iconSize' => 'w-20 h-20',
            'iconText' => 'text-3xl',
            'titleText' => 'text-xl',
            'descText' => 'text-lg',
            'buttonSize' => 'px-8 py-4 text-lg'
        ]
    ];
    
    $currentSize = $sizeConfig[$size] ?? $sizeConfig['default'];
    
    // Override with custom props
    $finalIcon = $icon ?? $variantConfig['icon'];
    $finalIconColor = $iconColor ?? $variantConfig['iconColor'];
    $finalBgColor = $bgColor ?? $variantConfig['bgColor'];
    $finalTitle = $title ?: $variantConfig['title'];
    $finalDescription = $description ?: $variantConfig['description'];
    
    // Action button variants
    $actionVariants = [
        'primary' => 'bg-[#1a2235] hover:bg-[#2a3441] text-white',
        'secondary' => 'bg-[#ffb51b] hover:bg-[#ff9500] text-[#1a2235]',
        'outline' => 'border-2 border-[#1a2235] text-[#1a2235] hover:bg-[#1a2235] hover:text-white',
        'ghost' => 'text-[#1a2235] hover:bg-[#1a2235]/10'
    ];
    $actionClass = $actionVariants[$actionVariant] ?? $actionVariants['primary'];
@endphp

<div class="text-center {{ $currentSize['container'] }}">
    <!-- Icon -->
    <div class="{{ $currentSize['iconSize'] }} mx-auto mb-4 rounded-full flex items-center justify-center {{ $finalBgColor }}">
        <i class="{{ $finalIcon }} {{ $finalIconColor }} {{ $currentSize['iconText'] }}"></i>
    </div>
    
    <!-- Title -->
    <h3 class="{{ $currentSize['titleText'] }} font-semibold text-[#1a2235] mb-2">
        {{ $slot->isNotEmpty() ? $slot : $finalTitle }}
    </h3>
    
    <!-- Description -->
    <p class="text-gray-600 {{ $currentSize['descText'] }} max-w-md mx-auto leading-relaxed">
        {{ $finalDescription }}
    </p>
    
    <!-- Action Button -->
    @if($actionText && $actionUrl)
        <div class="mt-6">
            <a href="{{ $actionUrl }}" 
               class="inline-flex items-center gap-2 {{ $currentSize['buttonSize'] }} {{ $actionClass }} font-medium rounded-lg transition-colors duration-200">
                <i class='bx bx-plus'></i>
                {{ $actionText }}
            </a>
        </div>
    @endif
</div>

<style>
/* Responsive adjustments */
@media (max-width: 640px) {
    .max-w-md {
        max-width: 20rem;
    }
}

@media (max-width: 480px) {
    .max-w-md {
        max-width: 16rem;
    }
}

/* Animation for loading state */
@keyframes spin {
    from { transform: rotate(0deg); }
    to { transform: rotate(360deg); }
}

.bx-loader-alt {
    animation: spin 1s linear infinite;
}
</style>
