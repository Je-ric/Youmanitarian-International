@props(['content'])

@if (isset($content))
    <x-modal.dialog id="needs-revision-modal-{{ $content->id }}"
        maxWidth="xl:max-w-xl lg:max-w-lg md:max-w-md sm:max-w-sm max-w-xs" width="w-full" maxHeight="max-h-[90vh]">
        <x-modal.header>
            <h2 class="text-lg sm:text-xl font-bold text-amber-600 flex items-center gap-2">
                <i class='bx bx-edit-alt text-2xl'></i>
                Mark as Needs Revision
            </h2>
        </x-modal.header>

        <x-modal.body>
            <div class="flex flex-col items-center text-center gap-4">
                <div class="bg-amber-100 rounded-full w-12 h-12 flex items-center justify-center">
                    <i class='bx bx-edit text-2xl text-amber-600'></i>
                </div>

                <h3 class="text-base sm:text-lg font-semibold text-amber-700">Are you sure you want to mark this content as needing revision?</h3>

                <x-feedback-status.alert 
                    variant="flexible"
                    icon="bx bx-info-circle text-xl"
                    message="This will return the content to the author with a status of 
                        <span class='font-semibold'>Needs Revision</span>. 
                        It will not be published until resubmitted and approved."
                    bgColor="bg-amber-50"
                    textColor="text-amber-700"
                    borderColor="border-amber-200"
                    iconColor="text-amber-500"
                />

                <div class="w-full bg-gray-50 border border-gray-200 rounded p-3 text-center">
                    <p class="text-sm font-semibold text-gray-800 line-clamp-2">
                        {{ $content->title }}
                    </p>
                </div>
            </div>

            <div class="space-y-4 mt-4">
                {{--
        <form id="needsRevisionForm-{{ $content->id }}" action="{{ route('content.needs_revision', $content->id) }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label for="revision_message_{{ $content->id }}" class="text-sm font-medium text-gray-700">
                    Revision Notes (optional)
                </label>
                <textarea
                    id="revision_message_{{ $content->id }}"
                    name="revision_message"
                    rows="4"
                    class="mt-1 w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-amber-400 focus:border-amber-400"
                    placeholder="Explain what needs to be updated, corrected, or improved..."></textarea>
                <p class="text-xs text-gray-500 mt-1">These notes will help the author make the correct changes.</p>
            </div>
        </form>
        --}}
            </div>
        </x-modal.body>


        <x-modal.footer>
            <div class="flex gap-2 w-full justify-end flex-col sm:flex-row">
                <x-modal.close-button :modalId="'needs-revision-modal-' . $content->id" text="Cancel" />
                <x-button
                    type="submit"
                    form="needsRevisionForm-{{ $content->id }}"
                    variant="table-action-edit"
                    class="w-full sm:w-auto">
                    <i class="bx bx-send"></i> Send Back
                </x-button>
            </div>
        </x-modal.footer>
    </x-modal.dialog>
@endif
