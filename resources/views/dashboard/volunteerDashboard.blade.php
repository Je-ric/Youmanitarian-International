<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Joined Programs</div>
        <div class="text-2xl font-semibold">{{ number_format($data['joinedPrograms'] ?? 0) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Total Hours</div>
        <div class="text-2xl font-semibold">{{ number_format($data['totalHours'] ?? 0, 2) }}</div>
    </div>
</div>

