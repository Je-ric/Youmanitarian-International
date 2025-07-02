<x-modal.dialog :id="$modalId" maxWidth="xl:max-w-xl lg:max-w-lg md:max-w-md sm:max-w-sm max-w-xs" width="w-full" maxHeight="max-h-[90vh]">
    <x-modal.header>
        <h2 id="delete-program-title-{{ $program->id }}" class="text-lg sm:text-xl font-bold text-red-600 flex items-center gap-2">
            <i class='bx bx-trash'></i> Delete Program
        </h2>
    </x-modal.header>
    <x-modal.body>
        <div class="flex flex-col items-center text-center gap-3">
            <div class="bg-red-100 rounded-full w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center mb-2">
                <i class='bx bx-error text-2xl sm:text-3xl text-red-500'></i>
            </div>
            <h3 class="text-base sm:text-lg font-semibold text-red-700">Are you sure you want to delete this program?</h3>
            <p class="text-gray-600 text-xs sm:text-sm">This action cannot be undone. All related data will be permanently removed.</p>
            <div class="bg-gray-50 rounded p-2 w-full mt-2">
                <span class="font-semibold text-gray-800 text-xs sm:text-base">{{ $program->title }}</span>
            </div>
        </div>
    </x-modal.body>
    <x-modal.footer>
        <div class="flex gap-2 w-full justify-end flex-col sm:flex-row">
            <x-modal.close-button :modalId="$modalId" text="Cancel" />
            <form action="{{ route('programs.destroy', $program) }}" method="POST">
                @csrf
                @method('DELETE')
                <x-button type="submit" variant="danger" class="w-full sm:w-auto">
                    <i class='bx bx-trash'></i> Delete
                </x-button>
            </form>
        </div>
    </x-modal.footer>
</x-modal.dialog> 