<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Awaiting Review</div>
        <div class="text-2xl font-semibold">{{ number_format($data['needsApproval'] ?? 0) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">Published</div>
        <div class="text-2xl font-semibold">{{ number_format($data['published'] ?? 0) }}</div>
    </div>
    <div class="p-4 bg-white rounded shadow">
        <div class="text-gray-500">My Drafts</div>
        <div class="text-2xl font-semibold">{{ number_format($data['myDrafts'] ?? 0) }}</div>
    </div>
</div>

