@props([
    'name',
    'label' => '',
    'options' => [],
    'selected' => null,
])

<div>
    @if($label)
        <label class="block text-sm font-medium text-gray-700 mb-2">{{ $label }}</label>
    @endif
    <div class="flex flex-col gap-2">
        @foreach($options as $value => $optionLabel)
            @php
                $id = $name . '_' . \Illuminate\Support\Str::slug($value, '_');
            @endphp
            <div class="flex items-center">
                <input
                    id="{{ $id }}"
                    type="radio"
                    name="{{ $name }}"
                    value="{{ $value }}"
                    @checked($selected == $value)
                    class="w-4 h-4 text-[#ffb51b] bg-gray-100 border-[#1a2235] focus:ring-[#ffb51b] focus:ring-2"
                >
                <label for="{{ $id }}" class="ms-2 text-sm font-medium text-gray-900">{{ $optionLabel }}</label>
            </div>
        @endforeach
    </div>
</div> 