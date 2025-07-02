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
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 truncate">
                        {{ $quarter }} {{ $year }} Payment
                    </h3>
                    <p class="text-sm text-gray-600 truncate mt-1">
                        {{ $member->user->name }}
                    </p>
                    <div class="flex flex-wrap items-center gap-2 mt-2">
                    <span
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                        <div
                            class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $status === 'paid' ? 'bg-green-500' : ($status === 'overdue' ? 'bg-red-500' : 'bg-yellow-500') }}">
                        </div>
                            {{ ucfirst($status) }}
                        </span>
                        <span class="text-xs text-gray-500">
                            {{ now()->format('M j, Y') }}
                        </span>
                </div>
                    </div>
        </x-modal.header>

        {{-- Main Content --}}
        <form action="{{ route('finance.membership.payments.store') }}" method="POST" enctype="multipart/form-data"
            class="flex flex-col flex-1 min-h-0">
            @csrf
            <input type="hidden" name="member_id" value="{{ $member->id }}">
            <input type="hidden" name="payment_period" value="{{ $quarter }}">
            <input type="hidden" name="payment_year" value="{{ $year }}">
            <input type="hidden" name="payment_date" value="{{ now()->format('Y-m-d H:i:s') }}">
            
            <div class="flex-1 min-h-0 overflow-y-auto sm:p-6 pb-32 p-6 space-y-6 max-h-[60vh] sm:max-h-[70vh]">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                    
                    {{-- Left Column --}}
                    <div class="space-y-4">
                        {{-- Amount --}}
                        <div>
                            <x-form.label for="amount">
                                <i class='bx bx-dollar-circle mr-1 text-green-600'></i>
                                Amount
                            </x-form.label>
                            <div class="relative">
                                @if($payment && $status !== 'pending')
                                    <div class="w-full bg-gray-50 border border-gray-200 rounded-lg p-3 text-gray-900">
                                        <span class="font-medium">₱{{ number_format($payment->amount, 2) }}</span>
                                    </div>
                                @else
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">₱</span>
                                        <input type="number" step="0.01" name="amount" id="amount" required
                                               class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                               placeholder="0.00"
                                               value="{{ $payment ? $payment->amount : '' }}">
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Payment Method --}}
                        <div>
                            <x-form.label for="payment_method">
                                <i class='bx bx-credit-card mr-1 text-blue-600'></i>
                                Payment Method
                            </x-form.label>
                            @if($payment && $status !== 'pending')
                                <div class="w-full bg-gray-50 border border-gray-200 rounded-lg p-3 text-gray-900">
                                    <span class="font-medium">{{ $paymentMethods[$payment->payment_method] ?? ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span>
                                </div>
                            @else
                                <select name="payment_method" id="payment_method" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <option value="">Select payment method</option>
                                    @foreach($paymentMethods as $value => $label)
                                        <option value="{{ $value }}" {{ (isset($payment) && $payment->payment_method == $value) ? 'selected' : '' }}>{{ $label }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>

                    {{-- Right Column --}}
                    <div class="space-y-4">
                        {{-- Payment Date --}}
                        <div>
                            <x-form.label>
                                <i class='bx bx-calendar mr-1 text-purple-600'></i>
                                Payment Date
                            </x-form.label>
                            <div class="w-full bg-gray-50 border border-gray-200 rounded-lg p-3 text-gray-900">
                                <span class="font-medium">{{ now()->format('F j, Y') }}</span>
                                <span class="text-sm text-gray-500 ml-2">{{ now()->format('h:i A') }}</span>
                            </div>
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
                    <x-form.label for="notes">
                        <i class='bx bx-note mr-1 text-orange-600'></i>
                        Notes
                        <span class="text-xs font-normal text-gray-500">(Required)</span>
                    </x-form.label>
                    @if($payment && $status !== 'pending')
                        <div class="w-full bg-gray-50 border border-gray-200 rounded-lg p-3 text-gray-900 min-h-[80px]">
                            {{ $payment->notes ?: 'No notes provided' }}
                        </div>
                    @else
                        <x-form.textarea
                            name="notes"
                            id="notes"
                            rows="3"
                            :value="old('notes', $payment ? $payment->notes : '')"
                            placeholder="Add any additional notes about the payment..."
                            required
                        />
                    @endif
                </div>

                {{-- Receipt/Proof Section --}}
                <div>
                    <x-form.label for="receipt">
                        <i class='bx bx-receipt mr-1 text-indigo-600'></i>
                        Receipt/Proof
                        <span class="text-xs font-normal text-gray-500">(Required)</span>
                    </x-form.label>
                    
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
                        <x-form.input-upload name="receipt" id="receipt" accept="image/*,.pdf" required>
                            PNG, JPG, PDF up to 10MB
                        </x-form.input-upload>
                    @endif
                </div>
            </div>
            <x-modal.footer>
                <x-modal.close-button :modalId="$modalId" text="Cancel" variant="cancel" />
                @if(!$payment)
                    <x-button type="submit" variant="save-entry" class="w-full sm:w-auto order-1 sm:order-2">
                        <i class='bx bx-save mr-1'></i>
                        Save Payment
                    </x-button>
                @endif
            </x-modal.footer>
        </form>
</x-modal.dialog>