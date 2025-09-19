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

    <form action="{{ ($action ?? null) ? $action : route('finance.donations.store') }}"
    {{-- we are using this in two pages website (public) and system (fc) --}}
    {{-- If the request is coming from the website, use the website route --}}
        method="POST"
        enctype="multipart/form-data" class="flex flex-col flex-1 min-h-0">
        @csrf

        <x-modal.body>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    {{-- Anonymous Checkbox --}}
                    @if(!$isView)
                        <div class="flex items-center space-x-2 mb-4 p-3 bg-gray-50 rounded-lg">
                            <x-form.checkbox
                                id="is_anonymous"
                                name="is_anonymous"
                                value="1"
                                :checked="old('is_anonymous')"
                                onchange="if(this.checked) { document.getElementById('donor_name').value = 'Anonymous'; } else { document.getElementById('donor_name').value = ''; }"
                            />
                            <label for="is_anonymous" class="text-sm font-medium text-gray-700 cursor-pointer">
                                Mark this donation as anonymous
                            </label>
                            <span class="text-xs text-gray-500 ml-2">(Will display as "Anonymous" publicly)</span>
                        </div>
                    @endif

                    {{-- Donor Name --}}
                    <div class="flex items-center justify-between mb-0">
                        <x-form.label for="donor_name" class="mb-0" variant="donor-name">Donor Name</x-form.label>

                        @if($isView && $donation->is_anonymous)
                            <x-feedback-status.status-indicator status="role" label="Anonymous" />
                        @endif
                    </div>
                    @if($isView)
                        <x-form.readonly>
                            @if($donation->is_anonymous && !$donation->donor_name)
                                Anonymous
                            @else
                                {{ $donation->donor_name ?? 'Not provided' }}
                            @endif
                        </x-form.readonly>
                    @else
                        <x-form.input
                            name="donor_name"
                            label=""
                            placeholder="Donor Name (optional)"
                            value="{{ old('is_anonymous') ? 'Anonymous' : (old('donor_name') ?? '') }}"
                        />
                    @endif

                    {{-- Donor Email --}}
                    <div class="flex items-center justify-between mb-1">
                        <x-form.label for="donor_email" class="mb-0" variant="donor-email">Donor Email</x-form.label>
                        @if(!$isView)
                            <div class="flex items-center space-x-2">
                                <x-form.checkbox
                                    id="quick_na_email"
                                    name="quick_na_email"
                                    value="N/A"
                                    onchange="if(this.checked) { document.getElementById('donor_email').value = 'N/A'; document.getElementById('donor_email').disabled = true; } else { document.getElementById('donor_email').value = ''; document.getElementById('donor_email').disabled = false; }"
                                />
                                <label for="quick_na_email" class="text-xs text-gray-500 font-normal cursor-pointer">
                                    N/A
                                </label>
                            </div>
                        @endif
                    </div>
                    @if($isView)
                        <x-form.readonly>{{ $donation->donor_email ?? 'Not provided' }}</x-form.readonly>
                    @else
                        <x-form.input
                            name="donor_email"
                            type="text"
                            label=""
                            placeholder="Donor Email (optional)"
                            value="{{ old('donor_email') }}"
                            id="donor_email"
                        />
                    @endif

                    {{-- Amount --}}
                    <x-form.label for="amount" variant="amount">Amount</x-form.label>
                    @if($isView)
                        <x-form.readonly>₱{{ number_format($donation->amount, 2) }}</x-form.readonly>
                    @else
                        <x-form.input name="amount" type="number" label="" placeholder="Amount" min="1" step="0.01" value="{{ old('amount') }}" required />
                    @endif
                </div>
                <div class="space-y-4">
                    {{-- Mode of Donation --}}
                    <x-form.label for="payment_method" variant="payment-method">Payment Method</x-form.label>
                    @if($isView)
                        <x-form.readonly>{{ collect($donationMethods)->firstWhere('value', $donation->payment_method)['label'] ?? $donation->payment_method }}</x-form.readonly>
                    @else
                        <x-form.select-option name="payment_method" label="" :options="$donationMethods" :selected="old('payment_method')" required />
                    @endif

                    {{-- Date --}}
                    <x-form.label for="donation_date" variant="donation-date">Donation Date</x-form.label>
                    @if($isView)
                        <x-form.readonly>{{ $donation->donation_date ? $donation->donation_date->format('M d, Y') : '' }}</x-form.readonly>
                    @else
                        <x-form.date-picker id="donation_date" name="donation_date" label="" value="{{ old('donation_date') }}" required />
                    @endif

                    {{-- Status --}}
                    <div class="flex items-center justify-between mb-1">
                        <x-form.label for="status" class="mb-0" variant="status">Status</x-form.label>
                        @if($isView)
                            <x-feedback-status.status-indicator
                                :status="$donation->status === 'Confirmed' ? 'completed' : ($donation->status === 'Rejected' ? 'danger' : 'pending')"
                                :label="$donation->status"
                            />
                        @else
                            <x-feedback-status.status-indicator status="pending" />
                        @endif
                    </div>
                    @if($isView)
                        <x-feedback-status.alert
                            variant="flexible"
                            :message="($donation->status === 'Confirmed')
                                ? 'Donation has been confirmed and verified as received.'
                                : (($donation->status === 'Rejected')
                                    ? 'Donation has been rejected and will not be counted as received.'
                                    : 'Donation is pending confirmation and verification.')"
                            :bgColor="($donation->status === 'Confirmed')
                                ? 'bg-green-50'
                                : (($donation->status === 'Rejected')
                                    ? 'bg-red-50'
                                    : 'bg-yellow-50')"
                            :textColor="($donation->status === 'Confirmed')
                                ? 'text-green-700'
                                : (($donation->status === 'Rejected')
                                    ? 'text-red-700'
                                    : 'text-yellow-700')"
                            :borderColor="($donation->status === 'Confirmed')
                                ? 'border-green-200'
                                : (($donation->status === 'Rejected')
                                    ? 'border-red-200'
                                    : 'border-yellow-200')"
                            :iconColor="($donation->status === 'Confirmed')
                                ? 'text-green-500'
                                : (($donation->status === 'Rejected')
                                    ? 'text-red-500'
                                    : 'text-yellow-500')"
                            :icon="($donation->status === 'Confirmed')
                                ? 'bx bx-check-circle'
                                : (($donation->status === 'Rejected')
                                    ? 'bx bx-x-circle'
                                    : 'bx bx-time')"
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

            {{-- Notes Section (Full Width) --}}
            <div class="mt-6">
                <x-form.label for="notes" variant="notes">Notes</x-form.label>
                @if($isView)
                    <x-form.readonly>{{ $donation->notes ?? 'No notes added' }}</x-form.readonly>
                @else
                    <x-form.textarea
                        name="notes"
                        id="notes"
                        label=""
                        placeholder="Add any additional notes about this donation..."
                        rows="3"
                        value="{{ old('notes') }}"
                    />
                @endif
            </div>

            <div class="mt-6">
                <x-form.label for="receipt" variant="receipt">Receipt</x-form.label>
                <p class="text-gray-500 text-xs mb-2">You may include an image related to the donation if necessary.</p>
                @if($isView && $donation->receipt_url)
                    @php
                        $ext = pathinfo($donation->receipt_url, PATHINFO_EXTENSION);
                    @endphp
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif']))
                            <img src="{{ asset('storage/' . $donation->receipt_url) }}" alt="Donation Proof" class="w-full max-w-sm rounded-lg border border-gray-300 mb-4 object-contain mx-auto">
                            <div class="text-center">
                                <a href="{{ asset('storage/' . $donation->receipt_url) }}" target="_blank" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium text-sm transition-colors duration-200">
                                    <i class='bx bx-fullscreen mr-1'></i> View Full Size
                                </a>
                            </div>
                        @elseif(strtolower($ext) === 'pdf')
                            <div class="text-center">
                                <a href="{{ asset('storage/' . $donation->receipt_url) }}" target="_blank" class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium text-sm transition-colors duration-200">
                                    <i class='bx bx-download'></i>
                                    Download PDF
                                </a>
                            </div>
                        @endif
                    </div>
                @elseif($isView && !$donation->receipt_url)
                    <x-empty-state
                        icon="bx bx-image"
                        title="No Proof Uploaded"
                        description="There is no proof of donation for this entry."
                        size="small"
                    />
                @else
                    <x-form.input-upload name="receipt" id="receipt" accept="image/*,application/pdf">
                        Supported formats: JPEG, JPG, PNG, GIF, PDF (up to 10MB)
                    </x-form.input-upload>
                @endif
            </div>

            @if($isView)
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <div class="text-xs text-gray-500 flex flex-col gap-1">
                        <div>
                            <span class="font-semibold">Recorded by:</span>
                            <span class="font-semibold text-gray-700">{{ $donation->recorded_by ? (optional($donation->recorder)->name ?? 'Unknown') : 'Unknown' }}</span>
                        </div>
                        <div>
                            <span class="font-semibold">Recorded in System:</span>
                            {{ $donation->created_at ? $donation->created_at->format('F j, Y h:i A') : 'N/A' }}
                        </div>
                        @if($donation->confirmed_at)
                            <div>
                                <span class="font-semibold">Confirmed on:</span>
                                {{ $donation->confirmed_at->format('F j, Y h:i A') }}
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <div class="text-xs text-gray-500 flex flex-col gap-1">
                        <div>
                            <span class="font-semibold">Recorded by:</span>
                            <span class="font-semibold text-gray-700">{{ auth()->user()->name ?? 'Unknown' }}</span>
                        </div>
                        <div>
                            <span class="font-semibold">Recorded in System:</span>
                            {{ now()->format('F j, Y h:i A') }}
                        </div>
                    </div>
                </div>
            @endif
        </x-modal.body>
        <x-modal.footer>
            <x-modal.close-button :modalId="$modalId" text="Cancel" variant="cancel" />
            @unless($isView)
                <x-button type="submit" variant="save-entry">Submit Donation</x-button>
            @endunless
        </x-modal.footer>
    </form>
</x-modal.dialog>
