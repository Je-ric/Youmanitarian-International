@props([
    'id',
    'name',
    'value' => '',
    'required' => false,
    'readonly' => false,
    'class' => '',
])

<div class="relative">
    <input
        type="date"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        @if($readonly) readonly @endif
        class="program-field w-full p-3 bg-gray-50 border border-gray-200 rounded-lg text-[#1a2235] transition-all duration-200 focus:bg-white focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b]/20 pr-14 {{ $class }}"
    />
    <span class="pointer-events-none absolute inset-y-0 right-0 w-12 flex items-center justify-center">
        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
    </span>
</div> 