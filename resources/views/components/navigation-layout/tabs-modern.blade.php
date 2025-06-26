@props([
    'tabs' => [], // Array of tab items with 'id', 'label', 'icon' keys (icon optional)
    'defaultTab' => null, // Default active tab
    'preserveState' => true, // Whether to preserve tab state in URL
    'class' => '', // Additional classes for the tabs container
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
    <!-- Modern Tab Navigation -->
    <div class="border-b border-gray-200 mb-6">
        <nav class="-mb-px flex px-4 space-x-8" aria-label="Tabs">
            @foreach($tabs as $tab)
                <button type="button"
                    @click="setTab('{{ $tab['id'] }}')"
                    :class="activeTab === '{{ $tab['id'] }}' 
                        ? 'border-[#ffb51b] text-[#ffb51b] font-semibold border-b-2' 
                        : 'border-transparent text-gray-500 hover:text-[#1a2235] hover:border-[#1a2235]'"
                    class="whitespace-nowrap py-2 px-3 border-b-2 text-sm transition-all duration-200 focus:outline-none flex items-center gap-2">
                    @if(isset($tab['icon']))
                        <i class="bx {{ $tab['icon'] }} text-base"></i>
                    @endif
                    <span>{{ $tab['label'] }}</span>
                </button>
            @endforeach
        </nav>
    </div>

    <!-- Tab Content -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 sm:p-6">
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