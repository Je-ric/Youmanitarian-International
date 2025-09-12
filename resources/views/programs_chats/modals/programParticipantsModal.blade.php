<x-modal.dialog id="programParticipants-modal-{{ $program->id }}"
    maxWidth="xl:max-w-xl lg:max-w-lg md:max-w-md sm:max-w-sm max-w-xs"
    width="w-full" maxHeight="max-h-[90vh]">

    <x-modal.header>
        <h2 class="text-lg sm:text-xl font-bold text-green-600 flex items-center gap-2">
            <i class='bx bx-archive-out'></i> Program Participants
        </h2>
    </x-modal.header>

    <x-modal.body>
        @forelse ($participants as $participant)
            <div class="flex items-center gap-3 p-2 border-b">

                <x-user-avatar :user="$participant->user" size="10" />

                <div>
                    <p class="font-semibold text-gray-800 flex items-center gap-2">
                        {{ $participant->user->name }}

                        @if ($participant->user->hasRole('Program Coordinator'))
                            <span class="px-2 py-0.5 text-xs rounded-full bg-green-100 text-green-700 font-medium">
                                Coordinator
                            </span>
                        @endif
                    </p>
                    <p class="text-sm text-gray-500">Status: {{ ucfirst($participant->status) }}</p>
                </div>
            </div>
        @empty
            <x-empty-state
                icon="bx bx-group"
                title="No Participants Yet"
                description="This program doesn’t have any participants at the moment."
                size="medium" />
        @endforelse
    </x-modal.body>

    <x-modal.footer>
        <div class="flex gap-2 w-full justify-end flex-col sm:flex-row">
            <x-modal.close-button :modalId="'programParticipants-modal-' . $program->id" text="CLose" />
        </div>
    </x-modal.footer>
</x-modal.dialog>
