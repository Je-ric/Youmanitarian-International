<x-modal.dialog id="archive-modal-{{ $content->id }}" maxWidth="xl:max-w-xl lg:max-w-lg md:max-w-md sm:max-w-sm max-w-xs" width="w-full" maxHeight="max-h-[90vh]">
    <x-modal.header>
        <h2 id="archive-content-title-{{ $content->id }}" class="text-lg sm:text-xl font-bold text-blue-600 flex items-center gap-2">
            <i class='bx bx-archive'></i> Archive Content
        </h2>
    </x-modal.header>
    <x-modal.body>
        <div class="flex flex-col items-center text-center gap-3">
            <div class="bg-blue-100 rounded-full w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center mb-2">
                <i class='bx bx-archive text-2xl sm:text-3xl text-blue-500'></i>
            </div>
            <h3 class="text-base sm:text-lg font-semibold text-blue-700">Are you sure you want to archive this content?</h3>

            <x-feedback-status.alert
                variant="flexible"
                icon="bx bx-info-circle text-xl"
                message="Archiving will remove this content from public view. <br>
                    <span class='font-semibold'>This action cannot be undone.</span>"
                bgColor="bg-blue-50"
                textColor="text-blue-700"
                borderColor="border-blue-200"
                iconColor="text-blue-500"
            />

            <div class="w-full bg-gray-50 border border-gray-200 rounded p-3 text-center">
                <span class="font-semibold text-gray-800 text-xs sm:text-base">{{ $content->title }}</span>
            </div>
        </div>
    </x-modal.body>
    <x-modal.footer>
        <div class="flex gap-2 w-full justify-end flex-col sm:flex-row">
            <x-modal.close-button :modalId="'archive-modal-' . $content->id" text="Cancel" />
            <form action="{{ route('content.archive', $content->id) }}" method="POST" class="w-full sm:w-auto">
                @csrf
                <x-button type="submit" variant="table-action-danger" class="w-full sm:w-auto">
                    <i class='bx bx-archive'></i> Archive
                </x-button>
            </form>
        </div>
    </x-modal.footer>
</x-modal.dialog>
