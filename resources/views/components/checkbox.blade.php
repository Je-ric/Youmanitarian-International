<input 
    type="checkbox"
    {{ $attributes->merge([
        'class' => 'w-4 h-4 text-[#ffb51b] bg-white border-gray-300 rounded focus:ring-[#ffb51b] focus:ring-2 transition-colors'
    ]) }}
    @if($checked) checked="checked" @endif
>
 