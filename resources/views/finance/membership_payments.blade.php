@extends('layouts.sidebar_final')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Membership Payments</h1>
        <div class="flex space-x-4">
            <button onclick="document.getElementById('addPaymentModal').classList.remove('hidden')" 
                    class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                Add Payment
            </button>
            <a href="{{ route('finance.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                Back to Dashboard
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Member</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Q1</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Q2</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Q3</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Q4</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($members as $member)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-medium text-gray-900">{{ $member->user->name }}</div>
                                <div class="text-sm text-gray-500">{{ $member->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-gray-900">{{ ucfirst($member->membership_type) }}</div>
                            </td>
                            @php
                                $currentYear = now()->year;
                                $startYear = $member->start_date ? $member->start_date->year : null;
                                $startQuarter = $member->start_date ? ceil($member->start_date->month / 3) : null;
                            @endphp
                            
                            @foreach(['Q1', 'Q2', 'Q3', 'Q4'] as $quarter)
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $quarterNumber = substr($quarter, 1);
                                        $shouldShowPayment = $startYear && 
                                            ($currentYear > $startYear || 
                                            ($currentYear == $startYear && $quarterNumber >= $startQuarter));
                                        
                                        $payment = $member->payments
                                            ->where('payment_period', $quarter)
                                            ->where('payment_year', $currentYear)
                                            ->first();
                                    @endphp

                                    @if($shouldShowPayment)
                                        @if($payment)
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                                {{ $payment->isPaid() ? 'bg-green-100 text-green-800' : 
                                                   ($payment->isOverdue() ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                                {{ $payment->payment_status }}
                                            </span>
                                            @if($payment->receipt_url)
                                                <a href="{{ $payment->receipt_url }}" target="_blank" 
                                                   class="text-blue-600 hover:text-blue-900 text-xs ml-1">
                                                    Receipt
                                                </a>
                                            @endif
                                        @else
                                            <span class="text-gray-400 text-xs">Not Paid</span>
                                        @endif
                                    @else
                                        <span class="text-gray-300 text-xs">N/A</span>
                                    @endif
                                </td>
                            @endforeach
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button onclick="showAddPaymentModal('{{ $member->id }}')" 
                                        class="text-indigo-600 hover:text-indigo-900">
                                    Add Payment
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                No active members found
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $members->links() }}
        </div>
    </div>
</div>

<!-- Add Payment Modal -->
<div id="addPaymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium leading-6 text-gray-900 mb-4">Add New Payment</h3>
            <form action="{{ route('finance.membership.payments.store') }}" method="POST">
                @csrf
                <input type="hidden" name="member_id" id="modal_member_id">
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="amount">
                        Amount
                    </label>
                    <input type="number" step="0.01" name="amount" id="amount" required
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="payment_period">
                        Payment Period
                    </label>
                    <select name="payment_period" id="payment_period" required
                            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                        <option value="Q1">Q1</option>
                        <option value="Q2">Q2</option>
                        <option value="Q3">Q3</option>
                        <option value="Q4">Q4</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="payment_year">
                        Year
                    </label>
                    <input type="number" name="payment_year" id="payment_year" required
                           value="{{ date('Y') }}"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="receipt_url">
                        Receipt URL (Optional)
                    </label>
                    <input type="url" name="receipt_url" id="receipt_url"
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                </div>
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="notes">
                        Notes (Optional)
                    </label>
                    <textarea name="notes" id="notes" rows="3"
                              class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"></textarea>
                </div>
                <div class="flex justify-end space-x-4">
                    <button type="button" onclick="document.getElementById('addPaymentModal').classList.add('hidden')"
                            class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                        Cancel
                    </button>
                    <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded-lg">
                        Save Payment
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showAddPaymentModal(memberId) {
    document.getElementById('modal_member_id').value = memberId;
    document.getElementById('addPaymentModal').classList.remove('hidden');
}
</script>
@endpush
@endsection 