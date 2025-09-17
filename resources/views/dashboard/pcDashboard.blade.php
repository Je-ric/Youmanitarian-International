<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">My Programs</div>
        <div class="text-2xl font-semibold">{{ number_format($data['myPrograms'] ?? 0) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Ongoing</div>
        <div class="text-2xl font-semibold">{{ number_format($data['ongoing'] ?? 0) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Upcoming</div>
        <div class="text-2xl font-semibold">{{ number_format($data['upcoming'] ?? 0) }}</div>
    </div>
</div>

