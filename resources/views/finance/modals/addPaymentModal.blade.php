{{-- @php
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

    // Set default modalId if not provided
    $modalId = $modalId ?? 'addPaymentModal';
@endphp

<dialog id="{{ $modalId }}" class="modal">
    <div class="modal-box max-w-lg p-0 overflow-hidden rounded-xl bg-white border border-slate-200">
        <!-- Header -->
        <header class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 tracking-tight">
                        ({{ $quarter }} - {{ $year }}) Payment - {{ $member->user->name }}
                    </h3>
                    <div class="flex items-center gap-2 mt-2">
                        <span class="text-sm font-medium {{ $statusClass }}">
                            {{ ucfirst($status) }}
                        </span>
                        <span class="text-sm text-slate-500">
                            {{ now()->format('F j, Y h:i A') }}
                        </span>
                    </div>
                </div>
                <form method="dialog">
                    <button class="btn btn-ghost btn-sm">×</button>
                </form>
            </div>
        </header>

        <!-- Main Content -->
        <form action="{{ route('finance.membership.payments.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col flex-1 min-h-0">
            @csrf
            <input type="hidden" name="member_id" value="{{ $member->id }}">
            <input type="hidden" name="payment_period" value="{{ $quarter }}">
            <input type="hidden" name="payment_year" value="{{ $year }}">
            <input type="hidden" name="payment_date" value="{{ now()->timestamp }}">
            
            <div class="p-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <div>
                            <label for="amount" class="block text-sm font-medium text-slate-700 mb-1">Amount</label>
                            <div class="w-full bg-slate-50 border border-slate-200 rounded-lg p-3">
                                @if($payment)
                                    <span class="text-sm">${{ number_format($payment->amount, 2) }}</span>
                                @else
                                    <input type="number" step="0.01" name="amount" id="amount" required
                                           class="w-full bg-white border-0 focus:ring-0 p-0 text-sm"
                                           placeholder="Enter payment amount">
                                @endif
                            </div>
                        </div>

                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-slate-700 mb-1">Payment Method</label>
                            <div class="w-full bg-slate-50 border border-slate-200 rounded-lg p-3">
                                @if($payment)
                                    <span class="text-sm">{{ $paymentMethods[$payment->payment_method] ?? ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span>
                                @else
                                    <select name="payment_method" id="payment_method" required
                                            class="w-full bg-white border-0 focus:ring-0 p-0 text-sm">
                                        <option value="">Select payment method</option>
                                        @foreach($paymentMethods as $value => $label)
                                            <option value="{{ $value }}">{{ $label }}</option>
                                        @endforeach
                                    </select>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Payment Date</label>
                            <div class="w-full bg-slate-50 border border-slate-200 rounded-lg p-3 text-sm">
                                {{ now()->format('F j, Y h:i A') }}
                            </div>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-slate-700 mb-1">Notes</label>
                            <div class="w-full bg-slate-50 border border-slate-200 rounded-lg p-3">
                                @if($payment)
                                    <span class="text-sm">{{ $payment->notes }}</span>
                                @else
                                    <textarea name="notes" id="notes" rows="3"
                                              class="w-full bg-white border-0 focus:ring-0 p-0 text-sm resize-none"
                                              placeholder="Add any additional notes about the payment"></textarea>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <label for="receipt" class="block text-sm font-medium text-slate-700 mb-1">Receipt/Proof</label>
                    <div class="w-full bg-slate-50 border border-slate-200 rounded-lg p-4">
                        @if($payment && $payment->receipt_url)
                            @php
                                $extension = pathinfo($payment->receipt_url, PATHINFO_EXTENSION);
                            @endphp
                            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                <img src="{{ Storage::url($payment->receipt_url) }}" 
                                     alt="Payment Receipt"
                                     class="max-w-full h-auto rounded-lg">
                            @else
                                <a href="{{ Storage::url($payment->receipt_url) }}" 
                                   target="_blank"
                                   class="text-blue-600 hover:text-blue-800">
                                    View Receipt
                                </a>
                            @endif
                        @else
                            <input type="file" name="receipt" id="receipt" accept="image/*,.pdf"
                                   class="w-full text-sm text-slate-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-xs text-slate-500 mt-2">Upload receipt or proof of payment (image or PDF)</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <footer class="border-t border-slate-200 px-6 py-4 bg-slate-50 flex justify-end gap-3">
                <form method="dialog">
                    <button type="button"
                            class="px-6 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors">
                        Cancel
                    </button>
                </form>
                @if(!$payment)
                    <button type="submit"
                            class="px-6 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors">
                        Save Payment
                    </button>
                @endif
            </footer>
        </form>
    </div>
</dialog>

<style>
/* Responsive adjustments for payment modal */
@media (max-width: 768px) {
    .modal-box {
        max-width: 95vw;
        margin: 1rem;
        max-height: 95vh;
    }
}

@media (max-width: 480px) {
    .modal-box {
        max-width: 100vw;
        margin: 0.5rem;
        max-height: 98vh;
    }
    
    header .px-6,
    .p-6,
    footer .px-6 {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
</style> --}}

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

    // Set default modalId if not provided
    $modalId = $modalId ?? 'addPaymentModal';
@endphp

<dialog id="{{ $modalId }}" class="modal">
    <div class="modal-box w-11/12 max-w-2xl mx-auto p-0 bg-white border border-gray-200 rounded-xl shadow-xl">
        
        <!-- Header -->
        <header class="px-4 sm:px-6 py-4 border-b border-gray-200 bg-gray-50 rounded-t-xl">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <h3 class="text-lg sm:text-xl font-bold text-gray-900 truncate">
                        {{ $quarter }} {{ $year }} Payment
                    </h3>
                    <p class="text-sm text-gray-600 truncate mt-1">
                        {{ $member->user->name }}
                    </p>
                    <div class="flex flex-wrap items-center gap-2 mt-2">
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $statusClass }}">
                            <div class="w-1.5 h-1.5 rounded-full mr-1.5 {{ $status === 'paid' ? 'bg-green-500' : ($status === 'overdue' ? 'bg-red-500' : 'bg-yellow-500') }}"></div>
                            {{ ucfirst($status) }}
                        </span>
                        <span class="text-xs text-gray-500">
                            {{ now()->format('M j, Y') }}
                        </span>
                    </div>
                </div>
                <x-x-button></x-x-button>
            </div>
        </header>

        <!-- Main Content -->
        <form action="{{ route('finance.membership.payments.store') }}" method="POST" enctype="multipart/form-data" class="flex flex-col">
            @csrf
            <input type="hidden" name="member_id" value="{{ $member->id }}">
            <input type="hidden" name="payment_period" value="{{ $quarter }}">
            <input type="hidden" name="payment_year" value="{{ $year }}">
            <input type="hidden" name="payment_date" value="{{ now()->format('Y-m-d H:i:s') }}">
            
            <div class="p-4 sm:p-6 space-y-6 max-h-[60vh] sm:max-h-[70vh] overflow-y-auto">
                
                <!-- Payment Details Grid -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
                    
                    <!-- Left Column -->
                    <div class="space-y-4">
                        <!-- Amount -->
                        <div>
                            <label for="amount" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class='bx bx-dollar-circle mr-1 text-green-600'></i>
                                Amount
                            </label>
                            <div class="relative">
                                @if($payment)
                                    <div class="w-full bg-gray-50 border border-gray-200 rounded-lg p-3 text-gray-900">
                                        <span class="font-medium">${{ number_format($payment->amount, 2) }}</span>
                                    </div>
                                @else
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm">$</span>
                                        <input type="number" 
                                               step="0.01" 
                                               name="amount" 
                                               id="amount" 
                                               required
                                               class="w-full pl-8 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"
                                               placeholder="0.00">
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label for="payment_method" class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class='bx bx-credit-card mr-1 text-blue-600'></i>
                                Payment Method
                            </label>
                            @if($payment)
                                <div class="w-full bg-gray-50 border border-gray-200 rounded-lg p-3 text-gray-900">
                                    <span class="font-medium">{{ $paymentMethods[$payment->payment_method] ?? ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</span>
                                </div>
                            @else
                                <select name="payment_method" 
                                        id="payment_method" 
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <option value="">Select payment method</option>
                                    @foreach($paymentMethods as $value => $label)
                                        <option value="{{ $value }}">{{ $label }}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <!-- Payment Date -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                <i class='bx bx-calendar mr-1 text-purple-600'></i>
                                Payment Date
                            </label>
                            <div class="w-full bg-gray-50 border border-gray-200 rounded-lg p-3 text-gray-900">
                                <span class="font-medium">{{ now()->format('F j, Y') }}</span>
                                <span class="text-sm text-gray-500 ml-2">{{ now()->format('h:i A') }}</span>
                            </div>
                        </div>

                        <!-- Status Display (if payment exists) -->
                        {{-- @if($payment)
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class='bx bx-check-shield mr-1 text-green-600'></i>
                                    Status
                                </label>
                                <div class="w-full bg-gray-50 border border-gray-200 rounded-lg p-3">
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <i class='bx bx-check mr-1'></i>
                                        Paid
                                    </span>
                                </div>
                            </div>
                        @endif --}}
                    </div>
                </div>

                <!-- Notes Section -->
                <div>
                    <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class='bx bx-note mr-1 text-orange-600'></i>
                        Notes
                        <span class="text-xs font-normal text-gray-500">(Optional)</span>
                    </label>
                    @if($payment)
                        <div class="w-full bg-gray-50 border border-gray-200 rounded-lg p-3 text-gray-900 min-h-[80px]">
                            {{ $payment->notes ?: 'No notes provided' }}
                        </div>
                    @else
                        <textarea name="notes" 
                                  id="notes" 
                                  rows="3"
                                  class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors resize-none"
                                  placeholder="Add any additional notes about the payment..."></textarea>
                    @endif
                </div>

                <!-- Receipt/Proof Section -->
                <div>
                    <label for="receipt" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class='bx bx-receipt mr-1 text-indigo-600'></i>
                        Receipt/Proof
                        @if(!$payment)
                            <span class="text-xs font-normal text-gray-500">(Optional)</span>
                        @endif
                    </label>
                    
                    @if($payment && $payment->receipt_url)
                        @php
                            $extension = pathinfo($payment->receipt_url, PATHINFO_EXTENSION);
                        @endphp
                        <div class="border border-gray-200 rounded-lg overflow-hidden bg-gray-50">
                            @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif']))
                                <div class="aspect-video bg-gray-100 flex items-center justify-center">
                                    <img src="{{ Storage::url($payment->receipt_url) }}" 
                                         alt="Payment Receipt"
                                         class="max-w-full max-h-full object-contain rounded">
                                </div>
                                <div class="p-3 bg-white border-t border-gray-200">
                                    <a href="{{ Storage::url($payment->receipt_url) }}" 
                                       target="_blank"
                                       class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 font-medium">
                                        <i class='bx bx-external-link mr-1'></i>
                                        View Full Size
                                    </a>
                                </div>
                            @else
                                <div class="p-4 text-center">
                                    <i class='bx bx-file text-3xl text-gray-400 mb-2'></i>
                                    <a href="{{ Storage::url($payment->receipt_url) }}" 
                                       target="_blank"
                                       class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                                        <i class='bx bx-download mr-1'></i>
                                        Download Receipt
                                    </a>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 hover:border-gray-400 transition-colors">
                            <div class="text-center">
                                <i class='bx bx-cloud-upload text-3xl text-gray-400 mb-2'></i>
                                <div class="mb-2">
                                    <label for="receipt" class="cursor-pointer">
                                        <span class="text-sm font-medium text-blue-600 hover:text-blue-800">Upload a file</span>
                                        <span class="text-sm text-gray-500"> or drag and drop</span>
                                    </label>
                                    <input type="file" 
                                           name="receipt" 
                                           id="receipt" 
                                           accept="image/*,.pdf"
                                           class="hidden">
                                </div>
                                <p class="text-xs text-gray-500">PNG, JPG, PDF up to 10MB</p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Footer -->
            <footer class="border-t border-gray-200 px-4 sm:px-6 py-4 bg-gray-50 rounded-b-xl">
                <div class="flex flex-col sm:flex-row gap-3 sm:justify-end">
                    <button type="button"
                            onclick="this.closest('dialog').close()"
                            class="w-full sm:w-auto order-2 sm:order-1 px-6 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 transition-colors">
                        <i class='bx bx-x mr-1'></i>
                        Cancel
                    </button>
                    @if(!$payment)
                        <button type="submit"
                                class="w-full sm:w-auto order-1 sm:order-2 px-6 py-2.5 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-lg transition-colors">
                            <i class='bx bx-save mr-1'></i>
                            Save Payment
                        </button>
                    @endif
                </div>
            </footer>
        </form>
    </div>
</dialog>
