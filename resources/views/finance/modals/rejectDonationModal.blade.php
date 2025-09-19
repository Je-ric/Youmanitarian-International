<x-modal.dialog :id="'rejectDonationModal-' . $donation->id" maxWidth="xl:max-w-xl lg:max-w-lg md:max-w-md sm:max-w-sm max-w-xs" width="w-full" maxHeight="max-h-[90vh]">
    <x-modal.header>
        <h2 class="text-lg sm:text-xl font-bold text-red-600 flex items-center gap-2">
            <i class='bx bx-x'></i> Reject Donation
        </h2>
    </x-modal.header>
    <x-modal.body>
        <div class="flex flex-col items-center text-center gap-3">
            <div class="bg-red-100 rounded-full w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center mb-2">
                <i class='bx bx-x text-2xl sm:text-3xl text-red-500'></i>
            </div>
            <h3 class="text-base sm:text-lg font-semibold text-red-700">Are you sure you want to reject this donation?</h3>
            <p class="text-sm text-gray-600">This will mark the donation as rejected and it will not be counted as received.</p>

            <div class="bg-gray-50 rounded-lg p-4 w-full mt-2 text-left">
                <div class="space-y-2">
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700 text-sm">Donor:</span>
                        <span class="text-sm text-gray-800">
                            @if($donation->is_anonymous)
                                Anonymous
                            @else
                                {{ $donation->donor_name ?? 'Not provided' }}
                            @endif
                        </span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700 text-sm">Amount:</span>
                        <span class="text-sm font-semibold text-red-600">₱{{ number_format($donation->amount, 2) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700 text-sm">Date:</span>
                        <span class="text-sm text-gray-800">{{ $donation->donation_date->format('M d, Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-700 text-sm">Method:</span>
                        <span class="text-sm text-gray-800">{{ $donation->payment_method }}</span>
                    </div>
                </div>
            </div>

            <div class="bg-red-50 border-l-4 border-red-400 p-3 w-full">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <i class='bx bx-error-circle text-red-400'></i>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-red-700">
                            <strong>Warning:</strong> This action cannot be easily undone.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </x-modal.body>
    <x-modal.footer>
        <div class="flex gap-2 w-full justify-end flex-col sm:flex-row">
            <x-modal.close-button :modalId="'rejectDonationModal-' . $donation->id" text="Cancel" />
            <form action="{{ route('finance.donations.reject', $donation) }}" method="POST">
                @csrf
                @method('PATCH')
                <x-button type="submit" variant="table-action-danger" class="w-full sm:w-auto">
                    <i class='bx bx-x'></i> Reject Donation
                </x-button>
            </form>
        </div>
    </x-modal.footer>
</x-modal.dialog>
