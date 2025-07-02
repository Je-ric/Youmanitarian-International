@props([
    'title',
    'description' => null,
])

<div class="w-full mx-auto flex flex-col md:flex-row justify-between items-start md:items-center gap-6 md:gap-0 mb-5">
    <div class="flex flex-col flex-grow">
        <h2 class="text-black text-xl md:text-2xl font-semibold tracking-tight mb-2">
            {{ $title }}
        </h2>

        @if ($description)
            <p class="text-black text-base md:text-lg font-light tracking-tight leading-relaxed">
                {{ $description }}
            </p>
        @endif
        
    </div>
    <div class="mt-4 md:mt-0">
        {{ $slot }} {{-- Anything, HAHAHAHA atleast hindi nagcecenter  --}}
    </div>
</div>

{{--
Usage: <x-header-with-button title="User Management" description="Manage user accounts and permissions">
            <x-button href="/users/create" variant="primary">Add User</x-button>
        </x-header-with-button>
       <x-header-with-button title="Dashboard">
            <x-button href="/settings" variant="secondary">Settings</x-button>
        </x-header-with-button>

Note: This component is currently not used in the codebase but available for future use.
--}}
