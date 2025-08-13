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
            // Reset pagination when switching tabs
            url.searchParams.delete('page');
            window.history.pushState({}, '', url);
        @endif
    }
}" class="{{ $class }}">

    <div class="border-b border-gray-200">
        <nav class="flex flex-wrap px-2 sm:px-4 gap-x-2 md:gap-x-4" aria-label="Tabs">
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

    {{-- still undecided kung may bg --}}
    <div class="mx-auto bg-[#F8F8FF] px-2 sm:px-4 md:px-6 py-4 sm:py-6">
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

{{--
Usage: <x-navigation-layout.tabs-modern :tabs="[
            ['id' => 'overview', 'label' => 'Overview', 'icon' => 'bx-home'],
            ['id' => 'details', 'label' => 'Details', 'icon' => 'bx-info-circle'],
            ['id' => 'settings', 'label' => 'Settings', 'icon' => 'bx-cog']
        ]" defaultTab="overview">
            <x-slot name="slot_overview">
                <p>Overview content here</p>
            </x-slot>
            <x-slot name="slot_details">
                <p>Details content here</p>
            </x-slot>
            <x-slot name="slot_settings">
                <p>Settings content here</p>
            </x-slot>
        </x-navigation-layout.tabs-modern>

Used in:
- resources/views/volunteers/index.blade.php
- resources/views/roles/index.blade.php
- resources/views/programs_volunteers/program-volunteers.blade.php
- resources/views/programs/index.blade.php
- resources/views/member/index.blade.php
- resources/views/finance/membership_payments.blade.php
- resources/views/finance/donations.blade.php
- resources/views/components/showcase.blade.php
--}}
