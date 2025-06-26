@props(
    ['containerClass' => '', 
    'tableClass' => '']
    )

<div class="w-full {{ $containerClass }}">
    <table class="min-w-full border-separate border-spacing-y-2 {{ $tableClass }}">
        {{ $slot }}
    </table>
</div> 