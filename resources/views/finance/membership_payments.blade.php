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
        <!-- Header -->
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">Membership Payments</h1>
        </div>

        <!-- Alerts -->
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
                <!-- Stats Cards -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    @php
                        $stats = [
                            [
                                'title' => 'Total Members',
                                'value' => $members->total(),
                                'icon' => 'bx-group',
                                'color' => 'blue'
                            ],
                            [
                                'title' => 'Active Members',
                                'value' => $members->where('membership_status', 'active')->count(),
                                'icon' => 'bx-user-check',
                                'color' => 'green'
                            ],
                            [
                                'title' => 'Total Payments',
                                'value' => $members->sum(function($member) { return $member->payments->count(); }),
                                'icon' => 'bx-money',
                                'color' => 'purple'
                            ]
                        ];
                    @endphp

                    @foreach($stats as $stat)
                        <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-gray-600">{{ $stat['title'] }}</p>
                                    <p class="text-2xl font-bold text-gray-900">{{ $stat['value'] }}</p>
                                </div>
                                <div class="p-3 bg-{{ $stat['color'] }}-50 rounded-full">
                                    <i class='bx {{ $stat['icon'] }} text-{{ $stat['color'] }}-500 text-xl'></i>
                                </div>
                            </div>
                        </div>
                    @endforeach
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
                                        @php
                                            $statuses = ['paid', 'pending', 'overdue'];
                                            $counts = array_map(function($status) use ($members, $quarter) {
                                                return $members->sum(function($member) use ($quarter, $status) {
                                                    return $member->payments->where('payment_period', $quarter)
                                                        ->where('payment_status', $status)->count();
                                                });
                                            }, $statuses);
                                        @endphp
                                        @foreach($counts as $count)
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $count }}</td>
                                        @endforeach
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
                            @foreach(['Q1', 'Q2', 'Q3', 'Q4'] as $quarter)
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">{{ $quarter }}</th>
                            @endforeach
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
                                            $status = $payment ? $payment->payment_status : app(App\Http\Controllers\MembershipController::class)->determinePaymentStatus($quarter, $payment);
                                            // Icon and color mapping
                                            if (!$shouldShowPayment) {
                                                $icon = 'bx-lock';
                                                $bg = 'bg-gray-300';
                                                $iconColor = 'text-white';
                                            } else if ($payment) {
                                                if ($status === 'paid') {
                                                    $icon = 'bx-check-circle';
                                                    $bg = 'bg-green-500';
                                                    $iconColor = 'text-white';
                                                } else if ($status === 'overdue') {
                                                    $icon = 'bx-error';
                                                    $bg = 'bg-red-500';
                                                    $iconColor = 'text-white';
                                                } else {
                                                    $icon = 'bx-time';
                                                    $bg = 'bg-yellow-400';
                                                    $iconColor = 'text-white';
                                                }
                                            } else {
                                                $icon = 'bx-time'; // treat as pending for add payment
                                                $bg = 'bg-yellow-400';
                                                $iconColor = 'text-white';
                                            }
                                        @endphp
                                        @if($shouldShowPayment)
                                            @php $modalId = 'paymentModal_' . $member->id . '_' . $quarter; @endphp
                                            <button type="button"
                                                onclick="document.getElementById('{{ $modalId }}').showModal()"
                                                class="w-9 h-9 flex items-center justify-center rounded-full {{ $bg }} {{ $iconColor }} focus:outline-none">
                                                <i class='bx {{ $icon }} text-xl'></i>
                                            </button>
                                            @include('finance.modals.addPaymentModal', [
                                                'modalId' => $modalId,
                                                'member' => $member,
                                                'quarter' => $quarter,
                                                'year' => $currentYear,
                                                'payment' => $payment,
                                                'status' => $status,
                                                'statusClass' => $status === 'paid' ? 'text-green-600' : ($status === 'overdue' ? 'text-red-600' : 'text-yellow-600')
                                            ])
                                        @else
                                            <button class="w-9 h-9 flex items-center justify-center rounded-full {{ $bg }} {{ $iconColor }} cursor-not-allowed" disabled>
                                                <i class='bx {{ $icon }} text-xl'></i>
                                            </button>
                                        @endif
                                    </td>
                                @endforeach
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex items-center space-x-2">
                                        @if($payment && $payment->receipt_url)
                                            <a href="{{ Storage::url($payment->receipt_url) }}" 
                                               target="_blank"
                                               class="text-blue-600 hover:text-blue-800 flex items-center gap-1">
                                                <i class='bx bx-file'></i>
                                                View Proof
                                            </a>
                                        @endif
                                        <button class="text-gray-600 hover:text-gray-800">
                                            <i class='bx bx-bell'></i>
                                        </button>
                                        <button class="text-gray-600 hover:text-gray-800">
                                            <i class='bx bx-download'></i>
                                        </button>
                                    </div>
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

<!-- Payment Modal -->
@include('finance.modals.addPaymentModal', [
    'member' => $member,
    'quarter' => $quarter,
    'year' => $currentYear,
    'payment' => $payment,
    'status' => $status,
    'statusClass' => $status === 'paid' ? 'text-green-600' : ($status === 'overdue' ? 'text-red-600' : 'text-yellow-600')
])
@endsection 