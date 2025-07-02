@php
    $donationMethods = [
        ['value' => 'cash', 'label' => 'Cash'],
        ['value' => 'bank_transfer', 'label' => 'Bank Transfer'],
        ['value' => 'credit_card', 'label' => 'Credit Card'],
        ['value' => 'paypal', 'label' => 'PayPal'],
    ];
    $modalId = $modalId ?? 'addDonationModal';
    $isView = isset($donation) && !is_null($donation);
@endphp

<x-modal.dialog :id="$modalId" maxWidth="max-w-3xl" width="w-11/12" maxHeight="max-h-[90vh]">
    <x-modal.header>
        <div>
            <h3 class="text-xl font-bold text-[#1a2235]">
                {{ $isView ? 'Donation Details' : 'Manual Donation Entry' }}
            </h3>
            <p class="text-gray-500 text-sm mt-1">
                {{ $isView ? 'View the details of this donation below.' : 'Enter the details of the donation below.' }}
            </p>
        </div>
    </x-modal.header>
    <form 
        @if(!$isView)
            action="{{ route('finance.donations.store') }}" method="POST"
        @endif
        enctype="multipart/form-data" class="flex flex-col flex-1 min-h-0">
        @csrf
        <x-modal.body>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    {{-- Donor Name --}}
                    <x-form.label for="donor_name">Donor Name</x-form.label>
                    @if($isView)
                        <div class="w-full bg-gray-50 border border-gray-200 rounded-lg p-3 text-gray-900">
                            {{ $donation->donor_name }}
                        </div>
                    @else
                        <x-form.input name="donor_name" label="" placeholder="Donor Name" value="{{ old('donor_name') }}" required />
                    @endif

                    {{-- Donor Email --}}
                    <x-form.label for="donor_email">Donor Email</x-form.label>
                    @if($isView)
                        <div class="w-full bg-gray-50 border border-gray-200 rounded-lg p-3 text-gray-900">
                            {{ $donation->donor_email }}
                        </div>
                    @else
                        <x-form.input name="donor_email" type="email" label="" placeholder="Donor Email" value="{{ old('donor_email') }}" required />
                    @endif

                    {{-- Amount --}}
                    <x-form.label for="amount">Donation Amount (₱)</x-form.label>
                    @if($isView)
                        <div class="w-full bg-gray-50 border border-gray-200 rounded-lg p-3 text-gray-900">
                            ₱{{ number_format($donation->amount, 2) }}
                        </div>
                    @else
                        <x-form.input name="amount" type="number" label="" placeholder="Amount" min="1" step="0.01" value="{{ old('amount') }}" required />
                    @endif

                    {{-- Mode of Donation --}}
                    <x-form.label for="payment_method">Mode of Donation</x-form.label>
                    @if($isView)
                        <div class="w-full bg-gray-50 border border-gray-200 rounded-lg p-3 text-gray-900">
                            {{ collect($donationMethods)->firstWhere('value', $donation->payment_method)['label'] ?? $donation->payment_method }}
                        </div>
                    @else
                        <x-form.select-option name="payment_method" label="" :options="$donationMethods" :selected="old('payment_method')" required />
                    @endif

                    {{-- Date --}}
                    <x-form.label for="donation_date">Date</x-form.label>
                    @if($isView)
                        <div class="w-full bg-gray-50 border border-gray-200 rounded-lg p-3 text-gray-900">
                            {{ $donation->donation_date ? $donation->donation_date->format('M d, Y') : '' }}
                        </div>
                    @else
                        <x-form.date-picker id="donation_date" name="donation_date" label="" value="{{ old('donation_date') }}" required />
                    @endif
                </div>
                <div class="space-y-4">
                    <x-form.label for="receipt">Receipt/Proof (Optional)</x-form.label>
                    <p class="text-gray-500 text-xs mb-2">You may include an image related to the donation if necessary.</p>
                    @if($isView && $donation->receipt_url)
                        @php
                            $ext = pathinfo($donation->receipt_url, PATHINFO_EXTENSION);
                        @endphp
                        <div class="border border-gray-200 rounded-lg overflow-hidden bg-gray-50 p-4">
                            @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif']))
                                <img src="{{ asset('storage/' . $donation->receipt_url) }}" alt="Donation Proof" class="max-w-full max-h-60 object-contain rounded mx-auto">
                                <div class="text-center mt-2">
                                    <a href="{{ asset('storage/' . $donation->receipt_url) }}" target="_blank" class="text-blue-600 hover:underline text-sm"><i class='bx bx-external-link mr-1'></i>View Full Size</a>
                                </div>
                            @elseif(strtolower($ext) === 'pdf')
                                <div class="text-center">
                                    <a href="{{ asset('storage/' . $donation->receipt_url) }}" target="_blank" class="text-blue-600 hover:underline text-sm"><i class='bx bx-download mr-1'></i>Download PDF</a>
                                </div>
                            @endif
                        </div>
                    @elseif($isView && !$donation->receipt_url)
                        <div class="text-gray-400 italic text-xs">No proof uploaded.</div>
                    @else
                        <x-form.input-upload name="receipt" id="receipt" accept="image/jpeg,image/png,application/pdf">
                            Supported formats: JPEG, PNG, PDF
                        </x-form.input-upload>
                    @endif
                </div>
            </div>
        </x-modal.body>
        <x-modal.footer>
            <x-modal.close-button :modalId="$modalId" text="Cancel" variant="cancel" />
            @unless($isView)
                <x-button type="submit" variant="save-entry">Submit Donation</x-button>
            @endunless
        </x-modal.footer>
    </form>
</x-modal.dialog>
