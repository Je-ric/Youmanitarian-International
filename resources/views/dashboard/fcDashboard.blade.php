<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <div class="p-4 bg-white rounded shadow md:col-span-2">
        <div class="text-gray-500">Membership Revenue (Paid)</div>
        <div class="text-2xl font-semibold">₱ {{ number_format($data['membershipRevenue'] ?? 0, 2) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Overdue Payments</div>
        <div class="text-2xl font-semibold">{{ number_format($data['overduePayments'] ?? 0) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Donations (Confirmed)</div>
        <div class="text-2xl font-semibold">{{ number_format($data['donationsConfirmed'] ?? 0) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Donations (Pending)</div>
        <div class="text-2xl font-semibold">{{ number_format($data['donationsPending'] ?? 0) }}</div>
    </div>
</div>


<div class="mt-6 grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="bg-white rounded shadow p-4 lg:col-span-2">
        <div class="font-semibold mb-2">Quarterly Payments Summary ({{ now()->year }})</div>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            @php($quarters = $data['quarterly'] ?? [])
            @foreach($quarters as $q => $row)
                <div class="border rounded p-3">
                    <div class="text-gray-500 font-medium mb-1">{{ $q }}</div>
                    <div class="text-sm text-green-700">Paid: {{ number_format($row['paid_count'] ?? 0) }} (₱ {{ number_format($row['paid_amount'] ?? 0, 2) }})</div>
                    <div class="text-sm text-amber-600">Pending: {{ number_format($row['pending_count'] ?? 0) }}</div>
                    <div class="text-sm text-red-600">Overdue: {{ number_format($row['overdue_count'] ?? 0) }}</div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="bg-white rounded shadow p-4">
        <div class="font-semibold mb-2">Top Donation Methods</div>
        <ul class="space-y-2">
            @forelse(($data['topDonationMethods'] ?? []) as $m)
                <li class="flex items-center justify-between">
                    <div class="text-gray-700">{{ $m->payment_method ?? 'Unknown' }}</div>
                    <div class="text-gray-900 font-medium">₱ {{ number_format($m->total ?? 0, 2) }}</div>
                </li>
            @empty
                <li class="text-gray-500">No donations yet.</li>
            @endforelse
        </ul>
    </div>
</div>

<div class="mt-6 bg-white rounded shadow p-4">
    <div class="font-semibold mb-2">Recent Donations</div>
    <ul class="divide-y">
        @forelse(($data['recentDonations'] ?? []) as $d)
            <li class="py-2 flex items-center justify-between">
                <div class="truncate">
                    <div class="text-gray-900">₱ {{ number_format($d->amount ?? 0, 2) }}</div>
                    <div class="text-gray-500 text-sm">{{ $d->donor_name ?? 'Anonymous' }} • {{ $d->payment_method ?? 'N/A' }} • {{ optional($d->donation_date)->format('M d, Y') }}</div>
                </div>
                <div class="text-sm {{ ($d->status === 'Confirmed') ? 'text-green-600' : 'text-amber-600' }}">{{ $d->status }}</div>
            </li>
        @empty
            <li class="py-2 text-gray-500">No recent donations.</li>
        @endforelse
    </ul>

</div>

