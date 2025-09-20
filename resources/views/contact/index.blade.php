@extends('layouts.sidebar_final')

@section('content')
<x-page-header
    icon="bx-message-dots"
    title="Contact Inquiries"
    desc="Manage and respond to contact inquiries from visitors">
</x-page-header>

<div class="mx-4 my-4 sm:mx-6 sm:my-6 lg:mx-8 lg:my-8 xl:mx-12 xl:my-12 2xl:mx-16 2xl:my-16">
    <div class="space-y-6">

        <div class="bg-white rounded-xl border-2 border-gray-200 hover:border-[#FFB51B] transition-colors duration-200 p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-4">
                    <h3 class="text-lg font-semibold text-gray-900">All Contact Inquiries</h3>
                    <span class="bg-[#FFB51B] text-white text-xs font-semibold px-3 py-1 rounded-full w-fit">
                        {{ $inquiries->total() }} Total
                    </span>
                </div>

                <div class="flex items-center space-x-3 w-full sm:w-auto">
                    <div class="relative w-full sm:w-auto">
                        <select class="appearance-none bg-white border-2 border-gray-300 rounded-lg px-4 py-2 pr-8 text-sm focus:ring-2 focus:ring-[#FFB51B] focus:border-[#FFB51B] w-full sm:w-auto">
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

        <div class="bg-white rounded-xl border-2 border-gray-200 overflow-hidden">
            @forelse($inquiries as $inquiry)
                <div class="border-b border-gray-100 last:border-b-0 p-4 sm:p-6 hover:bg-gray-50 transition-colors duration-200">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between space-y-4 lg:space-y-0">
                        <div class="flex-1 lg:pr-4">
                            <div class="flex flex-col sm:flex-row sm:items-center space-y-2 sm:space-y-0 sm:space-x-3 mb-3">
                                <h4 class="text-lg font-semibold text-gray-900">{{ $inquiry->name }}</h4>
                                <x-feedback-status.status-indicator
                                    :status="$inquiry->status"
                                    :label="ucfirst($inquiry->status)" />
                            </div>

                            <div class="flex flex-col sm:flex-row sm:items-center sm:space-x-4 space-y-1 sm:space-y-0 text-sm text-gray-600 mb-3">
                                <span class="flex items-center">
                                    <i class='bx bx-envelope mr-2 text-[#FFB51B]'></i>
                                    <span class="break-all">{{ $inquiry->email }}</span>
                                </span>
                                @if($inquiry->phone)
                                    <span class="flex items-center">
                                        <i class='bx bx-phone mr-2 text-[#FFB51B]'></i>
                                        {{ $inquiry->phone }}
                                    </span>
                                @endif
                                <span class="flex items-center">
                                    <i class='bx bx-time mr-2 text-[#FFB51B]'></i>
                                    {{ $inquiry->created_at->format('M d, Y g:i A') }}
                                </span>
                            </div>

                            @if($inquiry->subject)
                                <p class="text-sm font-medium text-gray-800 mb-2">{{ $inquiry->subject }}</p>
                            @endif

                            <p class="text-gray-700 text-sm line-clamp-2">{{ Str::limit($inquiry->message, 150) }}</p>
                        </div>

                        <div class="flex items-center justify-end space-x-2 lg:ml-4">
                            <x-button onclick="document.getElementById('inquiryModal-{{ $inquiry->id }}').showModal()" variant="table-action-view" class="text-xs sm:text-sm">
                                <i class='bx bx-show'></i>
                                <span class="hidden sm:inline ml-1">View</span>
                            </x-button>

                            <x-dropdown-button>
                                <button onclick="updateStatus({{ $inquiry->id }}, 'read')"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <i class='bx bx-check mr-2 text-green-500'></i>Mark as Read
                                </button>
                                <button onclick="updateStatus({{ $inquiry->id }}, 'responded')"
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 flex items-center">
                                    <i class='bx bx-message-check mr-2 text-blue-500'></i>Mark as Responded
                                </button>
                                <hr class="my-1">
                                <button onclick="deleteInquiry({{ $inquiry->id }})"
                                        class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 flex items-center">
                                    <i class='bx bx-trash mr-2'></i>Delete
                                </button>
                            </x-dropdown-button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="p-8 sm:p-12 text-center">
                    <i class='bx bx-message-dots text-4xl sm:text-6xl text-gray-300 mb-4'></i>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No Contact Inquiries</h3>
                    <p class="text-gray-600 text-sm sm:text-base">No contact inquiries have been submitted yet.</p>
                </div>
            @endforelse
        </div>

        @if($inquiries->hasPages())
            <div class="flex justify-center">
                {{ $inquiries->links() }}
            </div>
        @endif
    </div>
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
