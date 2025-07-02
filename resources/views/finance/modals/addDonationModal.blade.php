@php
    $modalId = $modalId ?? 'addDonationModal';
    $donationMethods = [
        ['value' => 'cash', 'label' => 'Cash'],
        ['value' => 'bank_transfer', 'label' => 'Bank Transfer'],
        ['value' => 'credit_card', 'label' => 'Credit Card'],
        ['value' => 'paypal', 'label' => 'PayPal'],
    ];
@endphp

<x-modal.dialog :id="$modalId" maxWidth="max-w-3xl" width="w-11/12" maxHeight="max-h-[90vh]">
    <x-modal.header>
        <div>
            <h3 class="text-xl font-bold text-[#1a2235]">Manual Donation Entry</h3>
            <p class="text-gray-500 text-sm mt-1">Enter the details of the donation below.</p>
        </div>
    </x-modal.header>
    <form action="{{ route('finance.donations.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col">
        @csrf
        <div class="p-6 space-y-6 max-h-[60vh] overflow-y-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <x-form.input name="donor_name" label="Donor Name" placeholder="Donor Name" required />
                    <x-form.input name="donor_email" type="email" label="Donor Email" placeholder="Donor Email" required />
                    <x-form.input name="amount" type="number" label="Donation Amount (₱)" placeholder="Amount" min="1" step="0.01" required />
                    <x-form.select-option name="payment_method" label="Mode of Donation" :options="$donationMethods" required />
                    <x-form.date-picker id="donation_date" name="donation_date" label="Date" required />
                </div>
                <div class="space-y-4">
                    <label class="block text-sm font-semibold text-[#1a2235] mb-2">Receipt/Proof (Optional)</label>
                    <p class="text-gray-500 text-xs mb-2">You may include an image related to the donation if necessary.</p>
                    <x-form.input-upload name="receipt" id="receipt" accept="image/jpeg,image/png,application/pdf">
                        Supported formats: JPEG, PNG, PDF
                    </x-form.input-upload>
                </div>
            </div>
        </div>
        <x-modal.footer>
            <x-modal.close-button :modalId="$modalId" text="Cancel" />
            <x-button type="submit" variant="save-entry">Submit Donation</x-button>
        </x-modal.footer>
    </form>
</x-modal.dialog>
