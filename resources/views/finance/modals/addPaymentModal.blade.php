@php
    $currentYear = now()->year;
    $paymentMethods = [
        'cash' => 'Cash',
        'bank_transfer' => 'Bank Transfer',
        'credit_card' => 'Credit Card',
        'paypal' => 'PayPal'
    ];

    $payment = $member->payments()
        ->where('payment_period', $quarter)
        ->where('payment_year', $currentYear)
        ->first();

    $modalId = $modalId ?? 'addPaymentModal';
@endphp

<x-modal.dialog :id="$modalId" maxWidth="max-w-3xl" width="w-11/12" maxHeight="max-h-[90vh]">
        {{-- Header --}}
        <x-modal.header>
                <div class="flex-1 flex-row min-w-0">
                    <div class="flex items-center gap-3">
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900 truncate">
                            {{ $quarter }} {{ $year }} Payment
                        </h3>
                        <x-feedback-status.status-indicator 
                            :status="$status === 'paid' ? 'success' : ($status === 'overdue' ? 'danger' : 'warning')" 
                            :label="ucfirst($status)"
                        />
                    </div>
                    <p class="text-sm text-gray-600 truncate mt-1">
                        {{ $member->user->name }}
                    </p>
                </div>
        </x-modal.header>

        {{-- Main Content --}}
        <form action="{{ route('finance.membership.payments.store') }}" method="POST" enctype="multipart/form-data"
            class="flex flex-col flex-1 min-h-0">
            @csrf
            <input type="hidden" name="member_id" value="{{ $member->id }}">
            <input type="hidden" name="payment_period" value="{{ $quarter }}">
            <input type="hidden" name="payment_year" value="{{ $year }}">
            {{-- <input type="hidden" name="payment_date" value="{{ now()->format('Y-m-d H:i:s') }}"> --}}
            
            <x-modal.body>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                    
                    {{-- Left Column --}}
                    <div class="space-y-4">
                        {{-- Amount --}}
                        <div>
                            @if($payment && $status === 'paid')
                                <x-form.label for="amount" variant="amount">Amount</x-form.label>
                                <x-form.readonly>₱{{ number_format($payment->amount, 2) }}</x-form.readonly>
                                @else
                                <div class="space-y-2">
                                    <x-form.input
                                        id="amount-{{ $modalId }}"
                                        name="amount"
                                        type="number"
                                        step="0.01"
                                        placeholder="0.00"
                                        :value="$payment ? $payment->amount : ''"
                                        required
                                        class="pl-8"
                                        label="Amount"
                                    >
                                        <x-slot name="label">
                                            <i class='bx bx-dollar-circle mr-1 text-green-600'></i>
                                            Amount
                                        </x-slot>
                                    </x-form.input>
                                    
                                    {{-- Quick Amount Checkbox --}}
                                    <div class="flex items-center space-x-2">
                                        <x-form.checkbox 
                                            id="quick_amount-{{ $modalId }}" 
                                            name="quick_amount" 
                                            value="500.00"
                                            onchange="document.getElementById('amount-{{ $modalId }}').value = this.checked ? this.value : ''"
                                        />
                                        <label for="quick_amount-{{ $modalId }}" class="text-sm text-gray-700 font-medium">
                                            Quick Amount: ₱500.00
                                        </label>
                                    </div>
                                    </div>
                                @endif
                        </div>

                        {{-- Payment Method --}}
                        <div>
                            @if($payment && $status === 'paid')
                                <x-form.label for="payment_method" variant="payment-method">Payment Method</x-form.label>
                                <x-form.readonly>{{ $paymentMethods[$payment->payment_method] ?? ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</x-form.readonly>
                            @else
                                <x-form.select-option
                                    name="payment_method"
                                    label="Payment Method"
                                    required
                                >
                                    <x-slot name="label">
                                        <i class='bx bx-credit-card mr-1 text-blue-600'></i>
                                        Payment Method
                                    </x-slot>
                                    <option value="">Select payment method</option>
                                    @foreach($paymentMethods as $value => $label)
                                        <option value="{{ $value }}" {{ (isset($payment) && $payment->payment_method == $value) ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </x-form.select-option>
                            @endif
                        </div>
                    </div>

                    {{-- Right Column --}}
                    <div class="space-y-4">
                        {{-- Payment Date --}}
                        <div>
                            <x-form.label for="payment_date" variant="payment-date">Payment Date</x-form.label>
                            @if($payment && $status === 'paid')
                                <x-form.readonly>
                                    {{ $payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('F j, Y') : 'N/A' }}
                                </x-form.readonly>
                                <div class="mt-2 text-xs text-gray-500 flex flex-col gap-1">
                                    <div>
                                        <span class="font-semibold">Recorded by:</span>
                                        <span class="font-semibold text-gray-700">{{ $payment->recorded_by ? (optional($payment->recorder)->name ?? 'Unknown') : 'Unknown' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">Recorded in System:</span>
                                        {{ $payment->created_at ? $payment->created_at->format('F j, Y h:i A') : 'N/A' }}
                                    </div>
                                </div>
                            @else
                                <x-form.date-picker
                                    id="payment_date-{{ $modalId }}"
                                    name="payment_date"
                                    :value="$payment ? ($payment->payment_date ? \Carbon\Carbon::parse($payment->payment_date)->format('Y-m-d') : '') : (old('payment_date') ?? now()->format('Y-m-d'))"
                                    required
                                />
                                <div class="mt-2 text-xs text-gray-500 flex flex-col gap-1">
                                    <div>
                                        <span class="font-semibold">Recorded by:</span>
                                        <span class="font-semibold text-gray-700">{{ auth()->user()->name ?? 'Unknown' }}</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold">Recorded in System:</span>
                                        {{ now()->format('F j, Y h:i A') }}
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- Status Display (if payment exists) --}}
                        {{-- @if($payment)
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-check-shield mr-1 text-green-600'></i>
                                    Status
                                </label>
                                <div class="w-full bg-gray-50 border border-gray-200 rounded-lg p-3">
                                <span
                                    class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class='bx bx-check mr-1'></i>
                                        Paid
                                    </span>
                                </div>
                            </div>
                        @endif --}}
                    </div>
                </div>

                {{-- Notes Section --}}
                <div>
                    @if($payment && $status === 'paid')
                        <x-form.label for="notes" variant="notes">Notes</x-form.label>
                        <x-form.readonly>{{ $payment->notes ?: 'No notes provided' }}</x-form.readonly>
                    @else
                        <x-form.textarea
                            name="notes"
                            rows="3"
                            :value="$payment ? $payment->notes : ''"
                            placeholder="Add any additional notes about the payment..."
                            required
                            label="Notes"
                        >
                            <x-slot name="label">
                                <i class='bx bx-note mr-1 text-orange-600'></i>
                                Notes
                                <span class="text-xs font-normal text-gray-500">(Required)</span>
                            </x-slot>
                        </x-form.textarea>
                    @endif
                </div>

                {{-- Receipt/Proof Section --}}
                <div>
                    <x-form.label for="receipt" variant="receipt">Receipt</x-form.label>
                    
                    @if($payment && $payment->receipt_url && $status !== 'pending')
                        @php
                            $extension = pathinfo($payment->receipt_url, PATHINFO_EXTENSION);
                        @endphp
                        <div class="border border-gray-200 rounded-lg overflow-hidden bg-gray-50">
                            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                <div class="aspect-video bg-gray-100 flex items-center justify-center">
                                    <img src="{{ Storage::url($payment->receipt_url) }}" alt="Payment Receipt"
                                         class="max-w-full max-h-full object-contain rounded">
                                </div>
                                <div class="p-3 bg-white border-t border-gray-200">
                                    <a href="{{ Storage::url($payment->receipt_url) }}" target="_blank"
                                       class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                                        <i class='bx bx-external-link mr-1'></i>
                                        View Full Size
                                    </a>
                                </div>
                            @else
                                <div class="p-4 text-center">
                                    <i class='bx bx-file text-3xl text-gray-400 mb-2'></i>
                                    <a href="{{ Storage::url($payment->receipt_url) }}" target="_blank"
                                       class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                        <i class='bx bx-download mr-1'></i>
                                        Download Receipt
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <x-form.input-upload name="receipt" :id="'receipt-'.$modalId" accept="image/*,.pdf" required>
                            PNG, JPG, PDF up to 10MB
                        </x-form.input-upload>
                    @endif
                </div>
            </x-modal.body>
            <x-modal.footer>
                <x-modal.close-button :modalId="$modalId" text="Cancel" variant="cancel" />
                {{-- if walang record --}}
                {{-- may record but pending and 0 amount --}}
                @if(!$payment || ($payment && $payment->payment_status === 'pending' && $payment->amount == 0))
                    <x-button type="submit" variant="save-entry" class="w-full sm:w-auto order-1 sm:order-2">
                        <i class='bx bx-save mr-1'></i>
                        Save Payment
                    </x-button>
                @endif
            </x-modal.footer>
        </form>
</x-modal.dialog>