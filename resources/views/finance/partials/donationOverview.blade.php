@php
    $stats = [
        [
            'title' => 'Total Donations',
            'value' => '₱' . number_format($totalDonations, 2),
            'icon' => 'bx-money',
            'color' => 'blue'
        ],
        [
            'title' => 'Membership Payments',
            'value' => '₱' . number_format($totalMembershipPayments, 2),
            'icon' => 'bx-credit-card',
            'color' => 'green'
        ],
        [
            'title' => 'Pending Donations',
            'value' => $pendingDonations,
            'icon' => 'bx-time',
            'color' => 'yellow'
        ],
        [
            'title' => 'Overdue Payments',
            'value' => $overduePayments,
            'icon' => 'bx-error-circle',
            'color' => 'red'
        ]
    ];
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
    @foreach($stats as $stat)
        <div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-xs sm:text-sm text-gray-600">{{ $stat['title'] }}</p>
                    <p class="text-lg sm:text-2xl font-bold text-[#1a2235]">{{ $stat['value'] }}</p>
                </div>
                <div class="bg-{{ $stat['color'] }}-50 p-2 sm:p-3 rounded-full">
                    <i class='bx {{ $stat['icon'] }} text-xl sm:text-2xl text-{{ $stat['color'] }}-500'></i>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- Financial Summary Chart --}}
<div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm mb-6">
    <h3 class="text-base sm:text-lg font-semibold text-[#1a2235] mb-3 sm:mb-4">Financial Summary</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Percentage</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @php
                    $totalRevenue = $totalDonations + $totalMembershipPayments;
                    $donationPercentage = $totalRevenue > 0 ? round(($totalDonations / $totalRevenue) * 100) : 0;
                    $membershipPercentage = $totalRevenue > 0 ? round(($totalMembershipPayments / $totalRevenue) * 100) : 0;
                @endphp
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Donations</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₱{{ number_format($totalDonations, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $donationPercentage }}%</td>
                </tr>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">Membership Payments</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">₱{{ number_format($totalMembershipPayments, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $membershipPercentage }}%</td>
                </tr>
                <tr class="bg-gray-50">
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">Total Revenue</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">₱{{ number_format($totalRevenue, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">100%</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

{{-- Recent Activity Section --}}
<div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
    <h3 class="text-base sm:text-lg font-semibold text-[#1a2235] mb-3 sm:mb-4">Recent Activity</h3>
    <div class="space-y-3 sm:space-y-4">
        <p class="text-gray-500 text-center py-4">No recent activity to display</p>
    </div>
</div>
