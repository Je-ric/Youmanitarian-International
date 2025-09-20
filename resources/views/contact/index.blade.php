@extends('layouts.sidebar_final')

@section('content')
<x-page-header
    icon="bx-message-dots"
    title="Contact Inquiries"
    desc="Manage and respond to contact inquiries from visitors">
</x-page-header>

<div class="space-y-6">

    <!-- Filters and Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center space-x-4">
                <h3 class="text-lg font-semibold text-gray-900">All Contact Inquiries</h3>
                <span class="bg-[#FFB51B] text-white text-xs font-semibold px-2 py-1 rounded-full">
                    {{ $inquiries->total() }} Total
                </span>
            </div>

            <div class="flex items-center space-x-3">
                <div class="relative">
                    <select class="appearance-none bg-white border border-gray-300 rounded-lg px-4 py-2 pr-8 text-sm focus:ring-2 focus:ring-[#FFB51B] focus:border-[#FFB51B]">
                        <option value="">All Status</option>
                        <option value="new">New</option>
                        <option value="read">Read</option>
                        <option value="responded">Responded</option>
                    </select>
                    <i class='bx bx-chevron-down absolute right-2 top-1/2 transform -translate-y-1/2 text-gray-400'></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Inquiries List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @forelse($inquiries as $inquiry)
            <div class="border-b border-gray-100 last:border-b-0 p-6 hover:bg-gray-50 transition-colors duration-200">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center space-x-3 mb-2">
                            <h4 class="text-lg font-semibold text-gray-900">{{ $inquiry->name }}</h4>
                            <x-feedback-status.status-indicator
                                :status="$inquiry->status"
                                :label="ucfirst($inquiry->status)" />
                        </div>

                        <div class="flex items-center space-x-4 text-sm text-gray-600 mb-3">
                            <span class="flex items-center">
                                <i class='bx bx-envelope mr-1'></i>
                                {{ $inquiry->email }}
                            </span>
                            @if($inquiry->phone)
                                <span class="flex items-center">
                                    <i class='bx bx-phone mr-1'></i>
                                    {{ $inquiry->phone }}
                                </span>
                            @endif
                            <span class="flex items-center">
                                <i class='bx bx-time mr-1'></i>
                                {{ $inquiry->created_at->format('M d, Y g:i A') }}
                            </span>
                        </div>

                        @if($inquiry->subject)
                            <p class="text-sm font-medium text-gray-800 mb-2">{{ $inquiry->subject }}</p>
                        @endif

                        <p class="text-gray-700 text-sm line-clamp-2">{{ Str::limit($inquiry->message, 150) }}</p>
                    </div>

                    <div class="flex items-center space-x-2 ml-4">
                        <x-button onclick="document.getElementById('inquiryModal-{{ $inquiry->id }}').showModal()" variant="table-action-view">
                            <i class='bx bx-show'></i>
                            View
                        </x-button>

                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open"
                                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-3 py-2 rounded-lg text-sm transition-colors duration-200">
                                <i class='bx bx-dots-vertical'></i>
                            </button>

                            <div x-show="open" @click.away="open = false"
                                 class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-10">
                                <div class="py-1">
                                    <button onclick="updateStatus({{ $inquiry->id }}, 'read')"
                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <i class='bx bx-check mr-2'></i>Mark as Read
                                    </button>
                                    <button onclick="updateStatus({{ $inquiry->id }}, 'responded')"
                                            class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                        <i class='bx bx-message-check mr-2'></i>Mark as Responded
                                    </button>
                                    <hr class="my-1">
                                    <button onclick="deleteInquiry({{ $inquiry->id }})"
                                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                        <i class='bx bx-trash mr-2'></i>Delete
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="p-12 text-center">
                <i class='bx bx-message-dots text-6xl text-gray-300 mb-4'></i>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No Contact Inquiries</h3>
                <p class="text-gray-600">No contact inquiries have been submitted yet.</p>
            </div>
        @endforelse
    </div>

    @if($inquiries->hasPages())
        <div class="flex justify-center">
            {{ $inquiries->links() }}
        </div>
    @endif
</div>

@foreach($inquiries as $inquiry)
    @include('contact.modals.inquiryModal', ['contactInquiry' => $inquiry])
@endforeach

<script>
function updateStatus(inquiryId, status) {
    if (confirm('Are you sure you want to update the status?')) {
        fetch(`/admin/contact-inquiries/${inquiryId}/status`, {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ status: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}

function deleteInquiry(inquiryId) {
    if (confirm('Are you sure you want to delete this inquiry? This action cannot be undone.')) {
        fetch(`/admin/contact-inquiries/${inquiryId}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
}
</script>
@endsection
