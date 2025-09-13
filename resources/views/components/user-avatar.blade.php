@props([
    'user' => null,
    'size' => '8',
    'showName' => false,
    'bare' => false, // When true, render only the circle (for compact/chat use)
])

@php
    use Illuminate\Support\Str;

    $raw = $user?->profile_pic;
    $profilePic = null;

    if ($raw) {
        if (Str::startsWith($raw, 'https://lh3.googleusercontent.com')) {
            // Google photo
            $profilePic = $raw;
        } elseif (Str::startsWith($raw, ['http://', 'https://'])) {
            // Any other absolute URL
            $profilePic = $raw;
        } elseif (Str::startsWith($raw, 'storage/')) {
            $profilePic = asset($raw);
        } elseif (Str::startsWith($raw, 'uploads/')) {
            $profilePic = asset('storage/' . $raw);
        } elseif (Str::contains($raw, 'public/')) {
            $relative = Str::after($raw, 'public/');
            $profilePic = asset($relative);
        } else {
            $profilePic = asset('storage/' . ltrim($raw, '/'));
        }
    }

    $initial = $user?->name ? strtoupper(mb_substr($user->name, 0, 1)) : '?';

    $sizeMap = [
        '6' => 'h-6 w-6 text-[10px]',
        '8' => 'h-8 w-8 text-sm',
        '10' => 'h-10 w-10 text-base',
        '12' => 'h-12 w-12 text-lg',
    ];
    $sizeClass = $sizeMap[$size] ?? $sizeMap['8'];
@endphp

@if($bare)
    @if ($profilePic)
        <img src="{{ $profilePic }}" alt="{{ $user?->name ?? $initial }}"
             class="{{ $sizeClass }} rounded-full object-cover">
    @else
        <div class="{{ $sizeClass }} bg-primary rounded-full flex items-center justify-center text-white">
            {{ $initial }}
        </div>
    @endif
@else
    <div class="flex items-center gap-2">
        @if ($profilePic)
            <img src="{{ $profilePic }}" alt="{{ $user?->name ?? $initial }}"
                 class="{{ $sizeClass }} rounded-full object-cover">
        @else
            <div class="{{ $sizeClass }} bg-primary rounded-full flex items-center justify-center text-white">
                {{ $initial }}
            </div>
        @endif

        @if ($showName && $user?->name)
            <span class="hidden lg:block text-sm font-medium max-w-24 truncate text-gray-700">
                {{ $user->name }}
            </span>
        @endif
    </div>
@endif
