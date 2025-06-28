@extends('layouts.sidebar_final')

@section('content')

<h1 class="text-3xl font-bold text-[#1a2235] mb-6">Contents</h1>

<div class="container mx-auto p-6">

    <x-button href="{{ route('content.create') }}" variant="add-create" class="mb-6">
        <i class='bx bx-plus-circle mr-2'></i> Add Content
    </x-button>
    
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
                                variant="primary" size="sm" class="tooltip" data-tip="Edit">
                            <i class='bx bx-edit'></i>
                        </x-button>
                    
                        <x-button href="{{ route('content.archive', $content->id) }}" 
                                variant="secondary" size="sm" class="tooltip" data-tip="Archive"
                                onclick="return confirm('Are you sure you want to archive this content?')">
                            <i class='bx bx-archive'></i>
                        </x-button>
                    
                        <form action="{{ route('content.destroy', $content->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <x-button type="submit" variant="danger" size="sm" 
                                    onclick="return confirm('Are you sure you want to delete this content?')"
                                    class="tooltip" data-tip="Delete">
                                <i class='bx bx-trash'></i> 
                            </x-button>
                        </form>
                    </div>
                </x-table.td>                        
            </x-table.tr>
            @endforeach
        </x-table.tbody>
    </x-table.table>

    <div class="mt-6">
        {{ $contents->links() }}
    </div>
</div>

@endsection