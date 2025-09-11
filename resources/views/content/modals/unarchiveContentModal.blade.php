@props(['content'])

@if(isset($content))
<x-modal.dialog id="unarchive-modal-{{ $content->id }}" maxWidth="xl:max-w-xl lg:max-w-lg md:max-w-md sm:max-w-sm max-w-xs" width="w-full" maxHeight="max-h-[90vh]">
    <x-modal.header>
        <h2 class="text-lg sm:text-xl font-bold text-green-600 flex items-center gap-2">
            <i class='bx bx-archive-out'></i> Unarchive Content
        </h2>
    </x-modal.header>

    <x-modal.body>
        <div class="flex flex-col items-center text-center gap-3">
            <div class="bg-green-100 rounded-full w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center mb-2">
                <i class='bx bx-archive-out text-2xl sm:text-3xl text-green-600'></i>
            </div>
            <h3 class="text-base sm:text-lg font-semibold text-green-700">
                Restore this content to Draft?
            </h3>
            <x-feedback-status.alert
                variant="flexible"
                icon="bx bx-info-circle text-xl"
                message="Unarchiving will move this content back to Draft. You can edit and publish after restoring."
                bgColor="bg-green-50"
                textColor="text-green-700"
                borderColor="border-green-200"
                iconColor="text-green-600"
            />
            <div class="w-full bg-gray-50 border border-gray-200 rounded p-3 text-center">
                <span class="font-semibold text-gray-800 text-xs sm:text-base">
                    {{ \Illuminate\Support\Str::limit($content->title, 70) }}
                </span>
            </div>
        </div>
    </x-modal.body>

    <x-modal.footer>
        <div class="flex gap-2 w-full justify-end flex-col sm:flex-row">
            <x-modal.close-button :modalId="'unarchive-modal-' . $content->id" text="Cancel" />
            <form action="{{ route('content.unarchive', $content->id) }}" method="POST" class="w-full sm:w-auto">
                @csrf
                <x-button type="submit" variant="table-action-manage" class="w-full sm:w-auto">
                    <i class='bx bx-archive-out'></i> Unarchive to Draft
                </x-button>
            </form>
        </div>
    </x-modal.footer>
</x-modal.dialog>
@endif
