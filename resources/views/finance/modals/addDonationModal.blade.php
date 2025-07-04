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
                    <div class="flex items-center justify-between mb-0">
                        <x-form.label for="donor_name" class="mb-0">
                            <i class='bx bx-user mr-1 text-blue-600'></i>
                            Donor Name
                        </x-form.label>
                        @if(!$isView)
                            <div class="flex items-center space-x-2">
                                <x-form.checkbox 
                                    id="quick_anonymous" 
                                    name="quick_anonymous" 
                                    value="Anonymous"
                                    onchange="document.getElementById('donor_name').value = this.checked ? this.value : ''"
                                />
                                <label for="quick_anonymous" class="text-xs text-gray-500 font-normal cursor-pointer">
                                    Anonymous
                                </label>
                            </div>
                        @endif
                    </div>
                    @if($isView)
                        <x-form.readonly>{{ $donation->donor_name }}</x-form.readonly>
                    @else
                        <x-form.input name="donor_name" label="" placeholder="Donor Name" value="{{ old('donor_name') }}" required />
                    @endif

                    {{-- Donor Email --}}
                    <div class="flex items-center justify-between mb-1">
                        <x-form.label for="donor_email" class="mb-0">
                            <i class='bx bx-envelope mr-1 text-indigo-600'></i>
                            Donor Email
                            <span class="text-xs text-gray-500 ml-2">(Enter N/A if not available)</span>
                        </x-form.label>
                        @if(!$isView)
                            <div class="flex items-center space-x-2">
                                <x-form.checkbox 
                                    id="quick_na_email" 
                                    name="quick_na_email" 
                                    value="N/A"
                                    onchange="document.getElementById('donor_email').value = this.checked ? this.value : ''"
                                />
                                <label for="quick_na_email" class="text-xs text-gray-500 font-normal cursor-pointer">
                                    N/A
                                </label>
                            </div>
                        @endif
                    </div>
                    @if($isView)
                        <x-form.readonly>{{ $donation->donor_email }}</x-form.readonly>
                    @else
                        <x-form.input name="donor_email" type="text" label="" placeholder="Donor Email" value="{{ old('donor_email') }}" required />
                        @error('donor_email')
                            <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span>
                        @enderror
                    @endif

                    {{-- Amount --}}
                    <x-form.label for="amount">
                        <i class='bx bx-dollar-circle mr-1 text-green-600'></i>
                        Donation Amount (₱)
                    </x-form.label>
                    @if($isView)
                        <x-form.readonly>₱{{ number_format($donation->amount, 2) }}</x-form.readonly>
                    @else
                        <x-form.input name="amount" type="number" label="" placeholder="Amount" min="1" step="0.01" value="{{ old('amount') }}" required />
                    @endif
                </div>
                <div class="space-y-4">
                    {{-- Mode of Donation --}}
                    <x-form.label for="payment_method">
                        <i class='bx bx-credit-card mr-1 text-blue-600'></i>
                        Mode of Donation
                    </x-form.label>
                    @if($isView)
                        <x-form.readonly>{{ collect($donationMethods)->firstWhere('value', $donation->payment_method)['label'] ?? $donation->payment_method }}</x-form.readonly>
                    @else
                        <x-form.select-option name="payment_method" label="" :options="$donationMethods" :selected="old('payment_method')" required />
                    @endif

                    {{-- Date --}}
                    <x-form.label for="donation_date">
                        <i class='bx bx-calendar mr-1 text-purple-600'></i>
                        Date
                    </x-form.label>
                    @if($isView)
                        <x-form.readonly>{{ $donation->donation_date ? $donation->donation_date->format('M d, Y') : '' }}</x-form.readonly>
                    @else
                        <x-form.date-picker id="donation_date" name="donation_date" label="" value="{{ old('donation_date') }}" required />
                    @endif

                    {{-- Status --}}
                    <div class="flex items-center justify-between mb-1">
                        <x-form.label for="status" class="mb-0">
                            <i class='bx bx-info-circle mr-1 text-yellow-600'></i>
                            Status
                        </x-form.label>
                        @if($isView)
                            <x-feedback-status.status-indicator :status="$donation->status === 'Confirmed' ? 'approved' : 'pending'" />
                        @else
                            <x-feedback-status.status-indicator status="pending" />
                        @endif
                    </div>
                    @if($isView)
                        <x-feedback-status.alert 
                            variant="flexible" 
                            :message="$donation->status === 'Confirmed' ? 'Donation has been confirmed and verified as received.' : 'Donation is pending confirmation and verification.'"
                            :bgColor="$donation->status === 'Confirmed' ? 'bg-green-50' : 'bg-yellow-50'"
                            :textColor="$donation->status === 'Confirmed' ? 'text-green-700' : 'text-yellow-700'"
                            :borderColor="$donation->status === 'Confirmed' ? 'border-green-200' : 'border-yellow-200'"
                            :iconColor="$donation->status === 'Confirmed' ? 'text-green-500' : 'text-yellow-500'"
                            :icon="$donation->status === 'Confirmed' ? 'bx bx-check-circle' : 'bx bx-time'"
                        />
                    @else
                        <x-feedback-status.alert 
                            variant="flexible" 
                            message="New donations are marked as pending until confirmed and verified as received."
                            bgColor="bg-yellow-50"
                            textColor="text-yellow-700"
                            borderColor="border-yellow-200"
                            iconColor="text-yellow-500"
                            icon="bx bx-time"
                        />
                    @endif
                </div>
            </div>

            {{-- Receipt/Proof Section (Full Width Below Columns) --}}
            <div class="mt-6">
                <x-form.label for="receipt">
                    <i class='bx bx-receipt mr-1 text-indigo-600'></i>
                    Receipt/Proof (Optional)
                </x-form.label>
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
        </x-modal.body>
        <x-modal.footer>
            <x-modal.close-button :modalId="$modalId" text="Cancel" variant="cancel" />
            @unless($isView)
                <x-button type="submit" variant="save-entry">Submit Donation</x-button>
            @endunless
        </x-modal.footer>
    </form>
</x-modal.dialog>
