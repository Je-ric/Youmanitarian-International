@props([
    'name',
    'options' => [],
    'class' => '',
    'onchange' => null,
    'required' => false,
])

<select
    name="{{ $name }}"
    @if($required) required @endif
    @if($onchange) onchange="{{ $onchange }}" @endif
    {{ $attributes->merge(['class' => $class]) }}
>
    @foreach($options as $option)
        <option value="{{ $option['value'] }}" @if(!empty($option['selected'])) selected @endif>
            {{ $option['label'] }}
        </option>
    @endforeach
</select> 