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

