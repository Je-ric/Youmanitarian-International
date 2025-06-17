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
    <div class="modal-box max-w-lg p-0 overflow-hidden rounded-xl bg-white border border-slate-200">
        <!-- Header -->
        <header class="px-6 py-4 border-b border-slate-200 bg-slate-50">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 tracking-tight">
                        {{ $quarter }} {{ $year }} Payment
                    </h3>
                    <p class="text-sm text-slate-600 mt-1">
                        Member: {{ $member->user->name }}
                    </p>
                </div>
                <form method="dialog">
                    <button class="btn btn-ghost btn-sm">
                        <i class='bx bx-x text-xl'></i>
                    </button>
                </form>
            </div>
        </header>

        <!-- Main Content -->
        <div class="p-6 space-y-6">
            @if($payment)
                <!-- Display Payment Details -->
                <div class="space-y-4">
                    <div class="border-b border-slate-200 pb-4">
                        <label class="block font-semibold text-slate-900">Payment Details</label>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Status</label>
                            <div class="w-full bg-white border border-slate-300 rounded-lg p-3 text-sm">
                                <span class="font-medium {{ $statusClass }}">
                                    {{ ucfirst($payment->payment_status) }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Amount</label>
                            <div class="w-full bg-white border border-slate-300 rounded-lg p-3 text-sm">
                                ${{ number_format($payment->amount, 2) }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Payment Date</label>
                            <div class="w-full bg-white border border-slate-300 rounded-lg p-3 text-sm">
                                {{ $payment->payment_date->format('F j, Y') }}
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Payment Method</label>
                            <div class="w-full bg-white border border-slate-300 rounded-lg p-3 text-sm">
                                {{ $paymentMethods[$payment->payment_method] ?? ucfirst(str_replace('_', ' ', $payment->payment_method)) }}
                            </div>
                        </div>

                        @if($payment->receipt_url)
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Receipt</label>
                                <div class="w-full bg-white border border-slate-300 rounded-lg p-3">
                                    <a href="{{ Storage::url($payment->receipt_url) }}" 
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                        <i class='bx bx-file'></i>
                                        View Receipt
                                    </a>
                                </div>
                            </div>
                        @endif

                        @if($payment->notes)
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-1">Notes</label>
                                <div class="w-full bg-white border border-slate-300 rounded-lg p-3 text-sm">
                                    {{ $payment->notes }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            @else
                <!-- Add New Payment Form -->
                <form action="{{ route('finance.membership.payments.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="member_id" value="{{ $member->id }}">
                    <input type="hidden" name="payment_period" value="{{ $quarter }}">
                    <input type="hidden" name="payment_year" value="{{ $year }}">
                    
                    <div class="space-y-4">
                        <div>
                            <label for="amount" class="block text-sm font-medium text-slate-700 mb-1">Amount</label>
                            <input type="number" step="0.01" name="amount" id="amount" required
                                   class="input input-bordered w-full"
                                   placeholder="Enter payment amount">
                        </div>

                        <div>
                            <label for="payment_date" class="block text-sm font-medium text-slate-700 mb-1">Payment Date</label>
                            <input type="date" name="payment_date" id="payment_date" required
                                   class="input input-bordered w-full"
                                   value="{{ now()->format('Y-m-d') }}">
                        </div>

                        <div>
                            <label for="payment_method" class="block text-sm font-medium text-slate-700 mb-1">Payment Method</label>
                            <select name="payment_method" id="payment_method" required
                                    class="select select-bordered w-full">
                                <option value="">Select payment method</option>
                                @foreach($paymentMethods as $value => $label)
                                    <option value="{{ $value }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="receipt" class="block text-sm font-medium text-slate-700 mb-1">Receipt/Proof</label>
                            <input type="file" name="receipt" id="receipt" accept="image/*,.pdf"
                                   class="file-input file-input-bordered w-full">
                            <p class="text-xs text-slate-500 mt-2">Upload receipt or proof of payment (image or PDF)</p>
                        </div>

                        <div>
                            <label for="notes" class="block text-sm font-medium text-slate-700 mb-1">Notes</label>
                            <textarea name="notes" id="notes" rows="3"
                                      class="textarea textarea-bordered w-full"
                                      placeholder="Add any additional notes about the payment"></textarea>
                        </div>

                        <div class="flex justify-end gap-3">
                            <form method="dialog">
                                <button type="button"
                                        class="btn btn-ghost">
                                    Cancel
                                </button>
                            </form>
                            <button type="submit"
                                    class="btn btn-primary">
                                <i class='bx bx-save'></i>
                                Save Payment
                            </button>
                        </div>
                    </div>
                </form>
            @endif
        </div>
    </div>
</dialog>

<style>
/* Responsive adjustments for payment modal */
@media (max-width: 768px) {
    #addPaymentModal .modal-box {
        max-width: 95vw;
        margin: 1rem;
        max-height: 95vh;
    }
}

@media (max-width: 480px) {
    #addPaymentModal .modal-box {
        max-width: 100vw;
        margin: 0.5rem;
        max-height: 98vh;
    }
    
    #addPaymentModal header .px-6,
    #addPaymentModal .p-6,
    #addPaymentModal footer .px-6 {
        padding-left: 1rem;
        padding-right: 1rem;
    }
}
</style>