@extends('layouts.sidebar_final')

@section('content')
    <div class="mx-auto px-2 sm:px-4 md:px-6 py-4 sm:py-6">
        <div class="mb-4 sm:mb-8">
            <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
                <div>
                    <h1 class="text-lg sm:text-xl font-bold text-gray-900 mb-2">
                        Membership Payments
                    </h1>
                    <p class="text-gray-600">View and manage the members membership type, status, and payment activity.</p>
                </div>
                <p>Future Buttones</p>
            </div>
        </div>

        @php
            $tabs = [
                ['id' => 'overview', 'label' => 'Overview', 'icon' => 'bx-line-chart'],
                ['id' => 'members', 'label' => 'Active Members', 'icon' => 'bx-user-check']
            ];
        @endphp

        <x-tabs 
            :tabs="$tabs"
            default-tab="{{ request()->query('tab', 'overview') }}"
        >
            <x-slot:slot_overview>
                @include('finance.partials.membershipOverview')
            </x-slot>

            <x-slot:slot_members>
                    <div class="overflow-x-auto">
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
            </x-slot>
        </x-tabs>
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