<x-modal.dialog id="programParticipants-modal-{{ $program->id }}"
    maxWidth="xl:max-w-xl lg:max-w-lg md:max-w-md sm:max-w-sm max-w-xs"
    width="w-full" maxHeight="max-h-[90vh]">

    <x-modal.header>
        <h2 class="text-lg sm:text-xl font-bold text-[#1a2235] flex items-center gap-2">
            <i class='bx bx-group text-[#ffb51b]'></i> Program Participants
        </h2>
    </x-modal.header>

    <x-modal.body>
        @if(empty($participantLists))
            <x-empty-state
                icon="bx bx-group"
                title="No Participants Yet"
                description="This program doesn’t have any participants at the moment."
                size="medium" />
        @else
            <x-accordion :items="$participantLists" />
        @endif
    </x-modal.body>

    <x-modal.footer>
        <div class="flex gap-2 w-full justify-end flex-col sm:flex-row">
            <x-modal.close-button :modalId="'programParticipants-modal-' . $program->id" text="Close" />
        </div>
    </x-modal.footer>
</x-modal.dialog>
