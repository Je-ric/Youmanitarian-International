@php
    $currentYear = now()->year;
@endphp

<dialog id="addPaymentModal" class="modal p-0">
    <div class="modal-box max-w-lg p-0 overflow-hidden rounded-xl bg-white border border-slate-200 transition-all max-h-[90vh] flex flex-col mx-4 sm:mx-auto">
        
        <!-- Header -->
        <header class="px-6 py-4 border-b border-slate-200 bg-slate-50 flex-shrink-0">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-2xl font-bold text-slate-900 tracking-tight">
                        <span id="modal_quarter_display"></span> Payment - <span id="modal_member_name"></span>
                    </h3>
                    <p class="text-sm text-slate-600 mt-1">
                        Status: <span id="modal_payment_status" class="font-medium"></span>
                    </p>
                </div>
                <x-x-button></x-x-button>
            </div>
        </header>

        <!-- Main Content - Scrollable -->
        <form action="{{ route('finance.membership.payments.store') }}" method="POST" class="flex flex-col flex-1 min-h-0">
            @csrf
            <input type="hidden" name="member_id" id="modal_member_id">
            <input type="hidden" name="payment_period" id="modal_quarter">
            <input type="hidden" name="payment_id" id="modal_payment_id">
            <input type="hidden" name="payment_date" id="modal_payment_date" value="{{ now()->format('Y-m-d H:i:s') }}">
            
            <div class="p-6 space-y-6 overflow-y-auto flex-1">
                <!-- Payment Details -->
                <div class="space-y-4">
                    <div class="border-b border-slate-200 pb-4">
                        <label class="block font-semibold text-slate-900">Payment Details</label>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-4 space-y-4">
                        <!-- Amount -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Amount</label>
                            <input type="number" step="0.01" name="amount" id="amount" required
                                   class="w-full bg-white border border-slate-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                   placeholder="Enter payment amount">
                        </div>

                        <!-- Payment Date (Display Only) -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Payment Date</label>
                            <div class="w-full bg-white border border-slate-300 rounded-lg p-3 text-sm text-slate-600">
                                {{ now()->format('F j, Y g:i A') }}
                            </div>
                        </div>

                        <!-- Payment Method -->
                        <div>
                            <label class="block text-sm font-medium text-slate-700 mb-1">Payment Method</label>
                            <select name="payment_method" id="payment_method" required
                                    class="w-full bg-white border border-slate-300 rounded-lg p-3 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200">
                                <option value="">Select payment method</option>
                                <option value="cash">Cash</option>
                                <option value="bank_transfer">Bank Transfer</option>
                                <option value="credit_card">Credit Card</option>
                                <option value="paypal">PayPal</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Receipt/Proof -->
                <div class="space-y-4">
                    <div class="border-b border-slate-200 pb-4">
                        <label class="block font-semibold text-slate-900">Receipt/Proof</label>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                        <input type="file" name="receipt" id="receipt" accept="image/*,.pdf"
                               class="w-full text-sm text-slate-700 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 file:transition-colors file:duration-200">
                        <p class="text-xs text-slate-500 mt-2">Upload receipt or proof of payment (image or PDF)</p>
                    </div>
                </div>

                <!-- Notes -->
                <div class="space-y-4">
                    <div class="border-b border-slate-200 pb-4">
                        <label class="block font-semibold text-slate-900">Notes</label>
                    </div>

                    <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                        <textarea name="notes" id="notes" rows="3"
                                  class="w-full bg-white border border-slate-300 rounded-lg p-3 text-sm resize-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                  placeholder="Add any additional notes about the payment"></textarea>
                    </div>
                </div>
            </div>

            <!-- Footer - Always Visible -->
            <footer class="border-t border-slate-200 px-6 py-4 bg-slate-50 flex justify-end gap-3 flex-shrink-0">
                <button type="button" onclick="document.getElementById('addPaymentModal').close()"
                        class="px-6 py-2 text-sm font-medium text-slate-700 bg-white border border-slate-300 rounded-lg hover:bg-slate-50 transition-colors duration-200">
                    Cancel
                </button>
                <button type="submit"
                        class="px-6 py-2 text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <i class='bx bx-save'></i>
                    Save Payment
                </button>
            </footer>
        </form>
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