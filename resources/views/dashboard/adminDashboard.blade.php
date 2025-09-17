<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Users</div>
        <div class="text-2xl font-semibold">{{ number_format($data['usersCount'] ?? 0) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Programs</div>
        <div class="text-2xl font-semibold">{{ number_format($data['programsCount'] ?? 0) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Contents</div>
        <div class="text-2xl font-semibold">{{ number_format($data['contentsCount'] ?? 0) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow md:col-span-2">
        <div class="text-gray-500">Confirmed Donations</div>
        <div class="text-2xl font-semibold">₱ {{ number_format($data['donationsTotal'] ?? 0, 2) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Pending Donations</div>
        <div class="text-2xl font-semibold">{{ number_format($data['pendingDonations'] ?? 0) }}</div>
    </div>
</div>

