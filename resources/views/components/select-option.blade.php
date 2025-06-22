@props([
    'name',
    'label' => '',
    'options' => [],
    'class' => '',
    'onchange' => null,
    'required' => false,
])

<div>
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-semibold text-slate-800 mb-2">{{ $label }}</label>
    @endif
    <select
        name="{{ $name }}"
        id="{{ $name }}"
        @if($required) required @endif
        @if($onchange) onchange="{{ $onchange }}" @endif
        {{ $attributes->merge(['class' => 'w-full px-3 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b] transition ' . $class]) }}
    >
        @if ($slot->isNotEmpty())
            {{ $slot }}
        @else
            @foreach($options as $option)
                <option value="{{ $option['value'] }}" @if(!empty($option['selected'])) selected @endif>
                    {{ $option['label'] }}
                </option>
            @endforeach
        @endif
    </select> 
</div> 