@props([
    'for' => null,
    'class' => '',
    'icon' => null,
    'iconColor' => 'text-gray-600',
    'variant' => null, // 'title', 'description', 'date', 'time', 'location', 'user', 'amount', 'notes', 'image'
])

@php
    $variants = [
        'title' => ['icon' => 'bx-book', 'color' => 'text-blue-600'],
        'description' => ['icon' => 'bx-align-left', 'color' => 'text-green-600'],
        'date' => ['icon' => 'bx-calendar', 'color' => 'text-purple-500'],
        'time' => ['icon' => 'bx-time-five', 'color' => 'text-green-600'],
        'time-in' => ['icon' => 'bx-time-five', 'color' => 'text-green-600'],
        'time-out' => ['icon' => 'bx-time-five', 'color' => 'text-red-600'],
        'start-time' => ['icon' => 'bx-time-five', 'color' => 'text-green-600'],
        'end-time' => ['icon' => 'bx-time-five', 'color' => 'text-red-600'],
        'location' => ['icon' => 'bx-map', 'color' => 'text-red-500'],
        'user' => ['icon' => 'bx-user', 'color' => 'text-blue-500'],
        'volunteer' => ['icon' => 'bx-group', 'color' => 'text-indigo-500'],
        'volunteer-name' => ['icon' => 'bx-user', 'color' => 'text-blue-500'],
        'volunteer-count' => ['icon' => 'bx-group', 'color' => 'text-indigo-500'],
        'amount' => ['icon' => 'bx-dollar-circle', 'color' => 'text-green-600'],
        'payment-method' => ['icon' => 'bx-credit-card', 'color' => 'text-indigo-500'],
        'payment-date' => ['icon' => 'bx-calendar', 'color' => 'text-purple-500'],
        'donation-date' => ['icon' => 'bx-calendar', 'color' => 'text-purple-500'],
        'notes' => ['icon' => 'bx-note', 'color' => 'text-yellow-600'],
        'image' => ['icon' => 'bx-image', 'color' => 'text-orange-600'],
        'proof' => ['icon' => 'bx-image', 'color' => 'text-orange-600'],
        'receipt' => ['icon' => 'bx-image', 'color' => 'text-orange-600'],
        'feedback' => ['icon' => 'bx-message', 'color' => 'text-green-600'],
        'rating' => ['icon' => 'bx-star', 'color' => 'text-yellow-500'],
        'task' => ['icon' => 'bx-task', 'color' => 'text-blue-600'],
        'tasks' => ['icon' => 'bx-task', 'color' => 'text-blue-600'],
        'email' => ['icon' => 'bx-envelope', 'color' => 'text-purple-500'],
        'donor-name' => ['icon' => 'bx-user', 'color' => 'text-blue-500'],
        'donor-email' => ['icon' => 'bx-envelope', 'color' => 'text-purple-500'],
        'payer-name' => ['icon' => 'bx-user', 'color' => 'text-blue-500'],
        'status' => ['icon' => 'bx-info-circle', 'color' => 'text-blue-600'],
        'time-info' => ['icon' => 'bx-time-five', 'color' => 'text-yellow-500'],
        'attendance-proof' => ['icon' => 'bx-image', 'color' => 'text-orange-600'],
        'assigned-tasks' => ['icon' => 'bx-task', 'color' => 'text-blue-600'],
        'coordinator' => ['icon' => 'bx-user', 'color' => 'text-blue-500'],
        'why-volunteer' => ['icon' => 'bx-message', 'color' => 'text-green-600'],
        'short-bio' => ['icon' => 'bx-align-left', 'color' => 'text-green-600'],
        'upload-image' => ['icon' => 'bx-image', 'color' => 'text-orange-600'],
        'your-feedback' => ['icon' => 'bx-message', 'color' => 'text-green-600'],
    ];
    
    if ($variant && isset($variants[$variant])) {
        $icon = $variants[$variant]['icon'];
        $iconColor = $variants[$variant]['color'];
    }
@endphp

<label
    @if($for) for="{{ $for }}" @endif
    class="flex items-center text-sm font-medium sm:gap-2 text-[#1a2235] mb-2 {{ $class }}"
>
    @if($icon)
        <i class="bx {{ $icon }} {{ $iconColor }} mr-1"></i>
    @endif
    {{ $slot }}
</label>

{{--
Usage: <x-form.label for="email">Email Address</x-form.label>
       <x-form.label for="phone" class="text-lg">
           <i class="bx bx-phone"></i> Phone Number
       </x-form.label>
       <x-form.label for="title" icon="bx-book" icon-color="text-blue-600">Program Title</x-form.label>
       <x-form.label for="description" icon="bx-align-left" icon-color="text-green-600">Description</x-form.label>
       
       // Using predefined variants:
       <x-form.label for="title" variant="title">Program Title</x-form.label>
       <x-form.label for="description" variant="description">Description</x-form.label>
       <x-form.label for="date" variant="date">Date</x-form.label>
       <x-form.label for="user" variant="user">User Name</x-form.label>

Used in:
- resources/views/programs_volunteers/modals/manualAttendanceModal.blade.php
- resources/views/programs_volunteers/partials/programDetails.blade.php
- resources/views/programs_volunteers/modals/attendanceApproval.blade.php
- resources/views/programs/modals/feedbackModal.blade.php
- resources/views/programs/create.blade.php
- resources/views/finance/modals/addPaymentModal.blade.php
--}}
