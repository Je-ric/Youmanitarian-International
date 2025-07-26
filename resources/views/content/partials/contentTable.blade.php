@php
    $user = Auth::user();
@endphp
<x-table.table>
    <x-table.thead>
        <x-table.tr>
            <x-table.th>Title</x-table.th>
            <x-table.th>Type</x-table.th>
            <x-table.th>Status</x-table.th>
            <x-table.th>Approval</x-table.th>
            <x-table.th>Last Updated</x-table.th>
            <x-table.th>Actions</x-table.th>
        </x-table.tr>
    </x-table.thead>
    <x-table.tbody>
        @forelse($contents as $content)
            <x-table.tr>
                <x-table.td>{{ $content->title }}</x-table.td>
                <x-table.td>
                    <x-feedback-status.status-indicator status="{{ $content->content_type }}" />
                </x-table.td>
                <x-table.td>
                    <x-feedback-status.status-indicator status="{{ $content->content_status }}" />
                </x-table.td>
                <x-table.td>
                    @if($content->approval_status === 'pending' || $content->approval_status === 'submitted')
                        <x-feedback-status.status-indicator
                            status="{{ $content->approval_status }}"
                            label="Awaiting Approval"
                        />
                    @elseif($content->approval_status === 'approved')
                        <x-feedback-status.status-indicator
                            status="approved"
                            label="Approved"
                        />
                    @elseif($content->approval_status === 'needs_revision')
                        <x-feedback-status.status-indicator
                            status="needs_revision"
                            label="Needs Revision"
                        />
                    @elseif($content->approval_status === 'rejected')
                        <x-feedback-status.status-indicator
                            status="rejected"
                            label="Rejected"
                        />
                    @else
                    <x-feedback-status.status-indicator
                        status="{{ $content->approval_status }}"
                            label="{{ ucfirst(str_replace('_', ' ', $content->approval_status)) }}"
                        />
                        @endif
                </x-table.td>
                <x-table.td>{{ $content->updated_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') }}</x-table.td>
                <x-table.td>
                    <div class="flex items-center space-x-2">
                        @if(auth()->user())
                        <x-button href="{{ route('content.edit', $content->id) }}"
                            variant="table-action-edit" size="sm"
                            class="tooltip" data-tip="Edit">
                            <i class='bx bx-edit'></i>
                        </x-button>
                        @endif

                        @if($tab === 'published')
                            <x-button variant="table-action-view" size="sm"
                                class="tooltip" data-tip="Archive"
                                onclick="document.getElementById('archive-modal-{{ $content->id }}').showModal(); return false;">
                                <i class='bx bx-archive'></i>
                            </x-button>
                        @endif

                        @if($tab === 'needs_approval' && Auth::user()->hasRole('Content Manager'))
                            <a href="{{ route('content.review', $content->id) }}"
                               class="inline-block">
                                <x-button variant="table-action-view" size="sm" class="tooltip" data-tip="Review">
                                    <i class='bx bx-search'></i>
                                </x-button>
                            </a>
                            <form action="{{ route('content.approve', $content->id) }}" method="POST" class="inline">
                                @csrf
                                <x-button type="submit" variant="table-action-manage" size="sm" class="tooltip" data-tip="Approve">
                                    <i class='bx bx-check'></i>
                                </x-button>
                            </form>
                            <form action="{{ route('content.needs_revision', $content->id) }}" method="POST" class="inline">
                                @csrf
                                <x-button type="submit" variant="warning" size="sm" class="tooltip" data-tip="Needs Revision">
                                    <i class='bx bx-refresh'></i>
                                </x-button>
                            </form>
                            <form action="{{ route('content.reject', $content->id) }}" method="POST" class="inline">
                                @csrf
                                <x-button type="submit" variant="danger" size="sm" class="tooltip" data-tip="Reject">
                                    <i class='bx bx-x'></i>
                                </x-button>
                            </form>
                        @endif
                    </div>
                </x-table.td>
            </x-table.tr>
        @empty
            <x-table.tr>
                <x-table.td colspan="6">
                    <x-empty-state
                        icon="bx bx-file"
                        title="No Content Found"
                        description="There is no content to display for this category."
                    />
                </x-table.td>
            </x-table.tr>
        @endforelse
    </x-table.tbody>
</x-table.table>

@foreach($contents as $content)
    @include('content.modals.archiveContentModal', ['content' => $content])
@endforeach

@if(method_exists($contents, 'links'))
    <div class="mt-6">
        {{ $contents->appends(['tab' => $tab ?? ''])->links() }}
    </div>
@endif
