<x-modal.dialog id="{{ $modalId }}" maxWidth="max-w-md" width="w-11/12">
    <x-modal.header>
        <div>
            <h3 class="text-xl font-bold text-[#1a2235]">
                {{ $title }}
            </h3>
            <p class="text-gray-500 text-sm mt-1">
                {{ $description }}
            </p>
        </div>
    </x-modal.header>

    <x-modal.body>
        <div class="space-y-4">
            <div class="text-center">
                <p class="text-gray-600 mb-4">Select the format you'd like to download:</p>
            </div>

            <div class="grid grid-cols-1 gap-3">
                @foreach($options as $option)
                    <a href="{{ $option['url'] }}"
                        class="flex items-center justify-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        <i class='{{ $option['icon'] }} text-2xl {{ $option['color'] }}'></i>
                        <div class="text-left">
                            <div class="font-semibold text-gray-900">{{ $option['title'] }}</div>
                            <div class="text-sm text-gray-500">{{ $option['description'] }}</div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </x-modal.body>

    <x-modal.footer>
        <x-modal.close-button :modalId="$modalId" text="Cancel" variant="cancel" />
    </x-modal.footer>
</x-modal.dialog>
