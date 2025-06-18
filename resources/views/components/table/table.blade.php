@props(['containerClass' => '', 
'tableClass' => ''])

<div class="w-full {{ $containerClass }}">
    <table class="min-w-full {{ $tableClass }}">
        {{ $slot }}
    </table>
</div> 