<x-modal.dialog id="programParticipants-modal-{{ $program->id }}" maxWidth="xl:max-w-xl lg:max-w-lg md:max-w-md sm:max-w-sm max-w-xs" width="w-full" maxHeight="max-h-[90vh]">
    <x-modal.header>
        <h2 class="text-lg sm:text-xl font-bold text-green-600 flex items-center gap-2">
            <i class='bx bx-archive-out'></i> Program Participants
        </h2>
    </x-modal.header>

    <x-modal.body>
        <h1>Testing</h1>
        @foreach ($participants as $participant)
            <div class="flex items-center gap-3 p-2 border-b">
                <img src="{{ $participant->user->profile_pic ? asset('storage/' . $participant->user->profile_pic) : asset('images/default-profile.png') }}" alt="{{ $participant->user->name }}" class="w-10 h-10 rounded-full object-cover">
                <div>
                    <p class="font-semibold text-gray-800">{{ $participant->user->name }}</p>
                    <p class="text-sm text-gray-500">Status: {{ ucfirst($participant->status) }}</p>
                </div>
            </div>

        @endforeach
    </x-modal.body>

    <x-modal.footer>
        <div class="flex gap-2 w-full justify-end flex-col sm:flex-row">
            <x-modal.close-button :modalId="'programParticipants-modal-' . $program->id" text="Cancel" />

            <x-modal.close-button :modalId="'programParticipants-modal-' . $program->id" text="Cancel" />

        </div>
    </x-modal.footer>
</x-modal.dialog>

