@props([
    'tabs' => [], // Array of tab items with 'id', 'label', 'icon' keys
    'defaultTab' => null, // Default active tab
    'preserveState' => true, // Whether to preserve tab state in URL
    'class' => '', // Additional classes for the tabs container
    'transition' => true, // Whether to enable transition animations
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
    <!-- Tab Navigation -->
    <div class="mb-4 sm:mb-8 overflow-x-auto pb-2 sm:pb-0">
        <div class="bg-gray-50 p-1 rounded-lg inline-flex space-x-1 min-w-max">
            @foreach($tabs as $tab)
                <button @click="setTab('{{ $tab['id'] }}')" 
                    :class="activeTab === '{{ $tab['id'] }}' ? 'bg-white text-[#1a2235] border border-gray-200 shadow-sm' : 'text-gray-600 hover:text-[#1a2235]'"
                    class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap flex items-center">
                    @if(isset($tab['icon']))
                        <i class='bx {{ $tab['icon'] }} text-lg sm:mr-1'></i>
                    @endif
                    <span class="hidden sm:inline">{{ $tab['label'] }}</span>
                </button>
            @endforeach
        </div>
    </div>

    <!-- Tab Content -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 sm:p-6">
        @foreach($tabIds as $tabId)
            <div x-show="activeTab === '{{ $tabId }}'"
                @if($transition)
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 transform translate-y-4"
                    x-transition:enter-end="opacity-100 transform translate-y-0"
                @endif
                class="space-y-4">
                {{ ${'slot_' . $tabId} ?? '' }}
            </div>
        @endforeach
    </div>
</div>

@push('scripts')
<script>
    // Preserve tab state on page reload
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const activeTab = Alpine.store ? Alpine.store.activeTab : '{{ $defaultTab }}';
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'preserve_tab';
                input.value = activeTab;
                this.appendChild(input);
            });
        });
    });
</script>
@endpush 