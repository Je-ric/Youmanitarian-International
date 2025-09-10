@props(['content'])

@if(isset($content))
<x-modal.dialog id="approve-modal-{{ $content->id }}" maxWidth="xl:max-w-xl lg:max-w-lg md:max-w-md sm:max-w-sm max-w-xs" width="w-full" maxHeight="max-h-[90vh]">
    <x-modal.header>
        <h2 class="text-lg sm:text-xl font-bold text-green-600 flex items-center gap-2">
            <i class='bx bx-check-circle text-2xl'></i>
            Approve & Publish
        </h2>
    </x-modal.header>

    <x-modal.body>
        <div class="flex flex-col items-center text-center gap-4">
            <div class="bg-green-100 rounded-full w-12 h-12 flex items-center justify-center">
                <i class='bx bx-check text-2xl text-green-600'></i>
            </div>

            <h3 class="text-base sm:text-lg font-semibold text-green-700">Are you sure you want to approve and publish this content?</h3>

            <x-feedback-status.alert 
                variant="flexible"
                type="success"
                icon="bx bx-info-circle"
                message="Approving this content will mark it as 
                        <span class='font-semibold text-green-700'>Approved and Published</span>
                        and visible wherever published items appear."
                bgColor="bg-green-50"
                textColor="text-green-700"
                borderColor="border-green-200"
                iconColor="text-green-500"
            />


            <div class="w-full bg-gray-50 border border-gray-200 rounded p-3 text-center">
                <p class="text-sm font-semibold text-gray-800 line-clamp-2">
                    {{ $content->title }}
                </p>
            </div>
        </div>
    </x-modal.body>

    <x-modal.footer>
        <div class="flex gap-2 w-full justify-end flex-col sm:flex-row">
            <x-modal.close-button :modalId="'approve-modal-' . $content->id" text="Cancel" />
            <form action="{{ route('content.approve', $content->id) }}" method="POST" class="w-full sm:w-auto">
                @csrf
                <x-button type="submit" variant="table-action-manage" class="w-full sm:w-auto">
                    <i class='bx bx-check-circle'></i> Approve & Publish
                </x-button>
            </form>
        </div>
    </x-modal.footer>
</x-modal.dialog>
@endif
