@props([
    'tabs' => [], 
    'defaultTab' => null,
    'preserveState' => true,
    'class' => '', 
])

@php
    $tabIds = collect($tabs)->pluck('id')->toArray();
@endphp

<div x-data="{ 
    activeTab: new URLSearchParams(window.location.search).get('tab') || '{{ $defaultTab }}',
    setTab(tab) {
        this.activeTab = tab;
        @if($preserveState)
            const url = new URL(window.location);
            url.searchParams.set('tab', tab);
            window.history.pushState({}, '', url);
        @endif
    }
}" class="{{ $class }}">

    <div class="border-b border-gray-200">
        <nav class="-mb-px flex px-2 sm:px-4 space-x-4 sm:space-x-8 overflow-x-auto min-w-max scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-transparent" aria-label="Tabs">
            @foreach($tabs as $tab)
                <button type="button"
                    @click="setTab('{{ $tab['id'] }}')"
                    :class="activeTab === '{{ $tab['id'] }}'
                        ? 'border-b-2 border-[#1a2235] text-[#1a2235] font-semibold'
                        : 'border-b-0 text-gray-500 hover:text-[#ffb51b] hover:border-b-2 hover:border-[#ffb51b]'"
                    class="whitespace-nowrap py-2 px-3 text-sm transition-all duration-200 focus:outline-none flex items-center gap-2">
                    @if(isset($tab['icon']))
                        <i class="bx {{ $tab['icon'] }} text-base"></i>
                    @endif
                    <span>{{ $tab['label'] }}</span>
                </button>
            @endforeach
        </nav>
    </div>

    <div class="mx-auto px-2 sm:px-4 md:px-6 py-4 sm:py-6">
        @foreach($tabIds as $tabId)
            <div x-show="activeTab === '{{ $tabId }}'"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 translate-y-4"
                x-transition:enter-end="opacity-100 translate-y-0"
                class="space-y-4">
                {{ ${'slot_' . $tabId} ?? '' }}
            </div>
        @endforeach
    </div>
</div> 