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
        type="time"
        id="{{ $id }}"
        name="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        @if($readonly) readonly @endif
        class="program-field w-full p-3 bg-gray-50 border border-gray-200 rounded-lg text-[#1a2235] transition-all duration-200 focus:bg-white focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b]/20 pr-10 {{ $class }}"
    />
    <span class="absolute inset-y-0 right-3 flex items-center">
        <button type="button" onclick="document.getElementById('{{ $id }}').focus()" tabindex="-1" class="focus:outline-none bg-transparent border-0 p-0 m-0">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </button>
    </span>
</div>
