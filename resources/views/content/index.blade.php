@extends('layouts.sidebar_final')

@section('content')
    <x-page-header icon="bx-file" title="Content Management"
        desc="View, create, and manage all site content, articles, and media.">

        <x-button href="{{ route('content.create') }}" variant="add-create" class="mb-6">
            <i class='bx bx-plus-circle mr-2'></i> Add Content
        </x-button>
    </x-page-header>

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
            @foreach($contents as $content)
                <x-table.tr>
                    <x-table.td>{{ $content->title }}</x-table.td>
                    <x-table.td>
                        <x-feedback-status.status-indicator status="{{ $content->content_type }}" />
                    </x-table.td>
                    <x-table.td>
                        <x-feedback-status.status-indicator status="{{ $content->content_status }}" />
                    </x-table.td>
                    <x-table.td>
                        <x-feedback-status.status-indicator status="{{ $content->approval_status }}" />
                    </x-table.td>
                    <x-table.td>{{ $content->updated_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') }}</x-table.td>
                    <x-table.td>
                        <div class="flex items-center space-x-2">
                            <x-button href="{{ route('content.edit', $content->id) }}"
                                variant="table-action-edit" size="sm"
                                class="tooltip" data-tip="Edit">
                                <i class='bx bx-edit'></i>
                            </x-button>

                            <x-button variant="table-action-view" size="sm"
                                class="tooltip" data-tip="Archive"
                                onclick="document.getElementById('archive-modal-{{ $content->id }}').showModal(); return false;">
                                <i class='bx bx-archive'></i>
                            </x-button>

                            @if($content->approval_status === 'pending' && $content->user && $content->user->hasRole('Program Coordinator'))
                                <form action="{{ route('content.approve', $content->id) }}" method="POST" class="inline">
                                    @csrf
                                    <x-button type="submit" variant="table-action-manage" size="sm" class="tooltip" data-tip="Approve">
                                        <i class='bx bx-check'></i>
                                    </x-button>
                                </form>
                            @endif

                            {{-- <form action="{{ route('content.destroy', $content->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <x-button type="submit" variant="danger" size="sm"
                                    onclick="return confirm('Are you sure you want to delete this content?')" class="tooltip"
                                    data-tip="Delete">
                                    <i class='bx bx-trash'></i>
                                </x-button>
                            </form> --}}
                        </div>
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.tbody>
    </x-table.table>

        @foreach($contents as $content)
            @include('content.modals.archiveContentModal', ['content' => $content])
        @endforeach

    <div class="mt-6">
        {{ $contents->links() }}
    </div>

@endsection
