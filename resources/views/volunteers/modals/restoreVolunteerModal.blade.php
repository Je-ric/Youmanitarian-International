<x-modal.dialog :id="'restoreVolunteerModal-' . $volunteer->id" maxWidth="xl:max-w-xl lg:max-w-lg md:max-w-md sm:max-w-sm max-w-xs" width="w-full" maxHeight="max-h-[90vh]">
    <x-modal.header>
        <h2 class="text-lg sm:text-xl font-bold text-yellow-600 flex items-center gap-2">
            <i class='bx bx-reset'></i> Restore Volunteer
        </h2>
    </x-modal.header>
    <x-modal.body>
        <div class="flex flex-col items-center text-center gap-3">
            <div class="bg-yellow-100 rounded-full w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center mb-2">
                <i class='bx bx-undo text-2xl sm:text-3xl text-yellow-500'></i>
            </div>
            <h3 class="text-base sm:text-lg font-semibold text-yellow-700">Are you sure you want to restore this volunteer?</h3>
            <div class="bg-gray-50 rounded p-2 w-full mt-2">
                <span class="font-semibold text-gray-800 text-xs sm:text-base">{{ $volunteer->user->name }}</span>
            </div>
        </div>
    </x-modal.body>
    <x-modal.footer>
        <div class="flex gap-2 w-full justify-end flex-col sm:flex-row">
            <x-modal.close-button :modalId="'restoreVolunteerModal-' . $volunteer->id" text="Cancel" />
            <form action="{{ route('volunteers.restore', $volunteer->id) }}" method="POST">
                @csrf
                <x-button type="submit" variant="table-action-success" class="w-full sm:w-auto">
                    <i class='bx bx-undo'></i> Restore
                </x-button>
            </form>
        </div>
    </x-modal.footer>
</x-modal.dialog>
