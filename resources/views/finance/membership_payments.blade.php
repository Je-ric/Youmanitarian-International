@extends('layouts.sidebar_final')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div x-data="{ 
        activeTab: new URLSearchParams(window.location.search).get('tab') || 'overview',
        setTab(tab) {
            this.activeTab = tab;
            const url = new URL(window.location);
            url.searchParams.set('tab', tab);
            window.history.pushState({}, '', url);
        }
    }">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Membership Payments</h1>
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

        <!-- Tab Navigation -->
        <div class="mb-4 sm:mb-8 overflow-x-auto pb-2 sm:pb-0">
            <div class="bg-gray-50 p-1 rounded-lg inline-flex space-x-1 min-w-max">
                <button @click="setTab('overview')" 
                    :class="activeTab === 'overview' ? 'bg-white text-[#1a2235] border border-gray-200 shadow-sm' : 'text-gray-600 hover:text-[#1a2235]'"
                    class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap flex items-center">
                    <i class='bx bx-line-chart text-lg sm:mr-1'></i>
                    <span class="hidden sm:inline">Overview</span>
                </button>

                <button @click="setTab('members')" 
                    :class="activeTab === 'members' ? 'bg-white text-[#1a2235] border border-gray-200 shadow-sm' : 'text-gray-600 hover:text-[#1a2235]'"
                    class="px-3 sm:px-4 py-2 text-xs sm:text-sm font-medium rounded-md transition-all duration-200 whitespace-nowrap flex items-center">
                    <i class='bx bx-user-check text-lg sm:mr-1'></i>
                    <span class="hidden sm:inline">Active Members</span>
                </button>
            </div>
        </div>

        <!-- Tab Content -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <!-- Overview Tab -->
            <div x-show="activeTab === 'overview'" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Total Members Card -->
                    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Members</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $members->total() }}</p>
                            </div>
                            <div class="p-3 bg-blue-50 rounded-full">
                                <i class='bx bx-group text-blue-500 text-xl'></i>
                            </div>
                        </div>
                    </div>

                    <!-- Active Members Card -->
                    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Active Members</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $members->where('membership_status', 'active')->count() }}</p>
                            </div>
                            <div class="p-3 bg-green-50 rounded-full">
                                <i class='bx bx-user-check text-green-500 text-xl'></i>
                            </div>
                        </div>
                    </div>

                    <!-- Total Payments Card -->
                    <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600">Total Payments</p>
                                <p class="text-2xl font-bold text-gray-900">{{ $members->sum(function($member) { return $member->payments->count(); }) }}</p>
                            </div>
                            <div class="p-3 bg-purple-50 rounded-full">
                                <i class='bx bx-money text-purple-500 text-xl'></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Status Chart -->
                <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Status Overview</h3>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quarter</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Paid</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pending</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Overdue</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach(['Q1', 'Q2', 'Q3', 'Q4'] as $quarter)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $quarter }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $members->sum(function($member) use ($quarter) { 
                                                return $member->payments->where('payment_period', $quarter)
                                                    ->where('payment_status', 'paid')->count(); 
                                            }) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $members->sum(function($member) use ($quarter) { 
                                                return $member->payments->where('payment_period', $quarter)
                                                    ->where('payment_status', 'pending')->count(); 
                                            }) }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $members->sum(function($member) use ($quarter) { 
                                                return $member->payments->where('payment_period', $quarter)
                                                    ->where('payment_status', 'overdue')->count(); 
                                            }) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Members Tab -->
            <div x-show="activeTab === 'members'" 
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform translate-y-4"
                x-transition:enter-end="opacity-100 transform translate-y-0"
                class="overflow-x-auto">
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

                                            $buttonClass = 'px-3 py-1.5 rounded-lg text-sm font-medium transition-colors duration-200 flex items-center gap-2';
                                            
                                            if (!$shouldShowPayment) {
                                                $buttonClass .= ' bg-gray-100 text-gray-400 cursor-not-allowed';
                                            } else if ($payment) {
                                                if ($payment->isPaid()) {
                                                    $buttonClass .= ' bg-green-100 text-green-700 hover:bg-green-200';
                                                } else if ($payment->isOverdue()) {
                                                    $buttonClass .= ' bg-red-100 text-red-700 hover:bg-red-200';
                                                } else {
                                                    $buttonClass .= ' bg-yellow-100 text-yellow-700 hover:bg-yellow-200';
                                                }
                                            } else {
                                                $buttonClass .= ' bg-blue-100 text-blue-700 hover:bg-blue-200';
                                            }
                                        @endphp

                                        @php
                                            $status = $payment ? ($payment->isPaid() ? 'Paid' : ($payment->isOverdue() ? 'Overdue' : 'Pending')) : 'Unpaid';
                                            $statusClass = $payment ? ($payment->isPaid() ? 'text-green-600' : ($payment->isOverdue() ? 'text-red-600' : 'text-yellow-600')) : 'text-gray-600';
                                        @endphp
                                        <button 
                                            onclick="{{ $shouldShowPayment ? 'document.getElementById(\'addPaymentModal\').showModal(); document.getElementById(\'modal_member_id\').value = \'' . $member->id . '\'; document.getElementById(\'modal_quarter\').value = \'' . $quarter . '\'; document.getElementById(\'modal_payment_id\').value = \'' . ($payment ? $payment->id : '') . '\'; document.getElementById(\'modal_member_name\').textContent = \'' . $member->user->name . '\'; document.getElementById(\'modal_quarter_display\').textContent = \'' . $quarter . '\'; document.getElementById(\'modal_payment_status\').textContent = \'' . $status . '\'; document.getElementById(\'modal_payment_status\').className = \'font-medium ' . $statusClass . '\'' : '' }}"
                                            class="{{ $buttonClass }}"
                                            {{ !$shouldShowPayment ? 'disabled' : '' }}>
                                            @if($payment)
                                                @if($payment->isPaid())
                                                    <i class='bx bx-check-circle'></i>
                                                    Paid
                                                @elseif($payment->isOverdue())
                                                    <i class='bx bx-error-circle'></i>
                                                    Overdue
                                                @else
                                                    <i class='bx bx-time'></i>
                                                    Pending
                                                @endif
                                            @else
                                                <i class='bx bx-plus-circle'></i>
                                                Add Payment
                                            @endif
                                        </button>
                                    </td>
                                @endforeach
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    Remind, download, view
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
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $members->links() }}
                </div>
            </div>
        </div>
    </div>
</div>

@include('finance.modals.addPaymentModal')
@endsection 