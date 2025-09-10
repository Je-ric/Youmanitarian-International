@php
    $user = Auth::user();
    $isAdmin = $user->hasRole('Admin');
    $isCoordinator = $user->hasRole('Program Coordinator');
    $isManager = $user->hasRole('Content Manager');
@endphp

@if ($contents->count() > 0)
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
            @foreach ($contents as $content)
                <x-table.tr>
                    <x-table.td>{{ \Illuminate\Support\Str::limit($content->title, 30) }}</x-table.td>
                    <x-table.td>
                        <x-feedback-status.status-indicator status="{{ $content->content_type }}" />
                    </x-table.td>
                    <x-table.td>
                        <x-feedback-status.status-indicator status="{{ $content->content_status }}" />
                    </x-table.td>
                    <x-table.td>
                        @if ($content->approval_status === 'pending' || $content->approval_status === 'submitted')
                            <x-feedback-status.status-indicator status="{{ $content->approval_status }}"
                                label="Awaiting Approval" />
                        @elseif($content->approval_status === 'approved')
                            <x-feedback-status.status-indicator status="approved" label="Approved" />
                        @elseif($content->approval_status === 'needs_revision')
                            <x-feedback-status.status-indicator status="needs_revision" label="Needs Revision" />
                        @elseif($content->approval_status === 'rejected')
                            <x-feedback-status.status-indicator status="rejected" label="Rejected" />
                        @else
                            <x-feedback-status.status-indicator status="{{ $content->approval_status }}"
                                label="{{ ucfirst(str_replace('_', ' ', $content->approval_status)) }}" />
                        @endif
                    </x-table.td>
                    <x-table.td>{{ $content->updated_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') }}</x-table.td>
                    <x-table.td>
                        <div class="flex items-center space-x-2">
                            @auth
                                @php
                                    $isOwner = Auth::id() === $content->created_by;
                                    $lockedPublished =
                                        $isOwner &&
                                        $content->content_status === 'published' &&
                                        $isCoordinator &&
                                        !$isManager &&
                                        !$isAdmin;
                                @endphp

                                @if ($isOwner)
                                    @if ($lockedPublished)
                                        {{-- can see by the owner, pero nakalock when approved and published na --}}
                                        <x-button href="{{ route('content.edit', $content->id) }}"
                                            variant="table-action-view" size="sm" class="tooltip" data-tip="View">
                                            <i class='bx bx-show'></i>
                                        </x-button>
                                    @else
                                        {{-- Editable since hindi pa approved and published at owner siya --}}
                                        <x-button href="{{ route('content.edit', $content->id) }}"
                                            variant="table-action-edit" size="sm" class="tooltip" data-tip="Edit">
                                            <i class='bx bx-edit'></i>
                                        </x-button>
                                    @endif
                                @else
                                    {{-- Not owner: view only --}}
                                    <x-button href="{{ route('content.edit', $content->id) }}" variant="table-action-view"
                                        size="sm" class="tooltip" data-tip="View">
                                        <i class='bx bx-show'></i>
                                    </x-button>
                                @endif
                            @endauth

                            @if ($tab === 'published' && ($isManager || $isAdmin))
                                <x-button variant="table-action-view" size="sm" class="tooltip" data-tip="Archive"
                                    onclick="document.getElementById('archive-modal-{{ $content->id }}').showModal(); return false;">
                                    <i class='bx bx-archive'></i>
                                </x-button>
                            @endif

                            @if ($tab === 'needs_approval' && ($isManager || $isAdmin))
                                <x-button href="{{ route('content.review', $content->id) }}"
                                    variant="table-action-view" size="sm" class="tooltip" data-tip="Review">
                                    <i class='bx bx-search'></i>
                                </x-button>
                            @endif
                        </div>
                    </x-table.td>
                </x-table.tr>
            @endforeach
        </x-table.tbody>
    </x-table.table>

    @foreach ($contents as $content)
        @if ($tab === 'published' && ($isManager || $isAdmin))
            @include('content.modals.archiveContentModal', ['content' => $content])
        @endif
    @endforeach

        {{-- kaya pala separate, para hindi magtumpukan ang modals
            nagfrefreeze yung browser 
            Kapag magkasama sila sa <tr> o <tbody>, nagiging invalid yung HTML structure.  
            hirap ang browser mag-render  --}}
        {{-- Kapag hiwalay, malinaw ang table markup at mas madaling i-render ang bawat modal. --}}


    @if (method_exists($contents, 'links'))
        <div class="mt-6">
            {{ $contents->appends(['tab' => $tab ?? ''])->links() }}
        </div>
    @endif
@else
    <x-empty-state icon="bx bx-file" title="No Content Found"
        description="There is no content to display for this category." />
@endif
