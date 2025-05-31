@extends('layouts.sidebar_final')

@section('content')

<h1 class="text-3xl font-bold text-[#1a2235] mb-6">Contents</h1>

@if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="container mx-auto p-6">

    <x-button href="{{ route('content.create') }}" variant="add-create" class="mb-6">
        <i class='bx bx-plus-circle mr-2'></i> Add Content
    </x-button>
    <div>
        <div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-[#1a2235]">Title</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-[#1a2235]">Type</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-[#1a2235]">Status</th> 
                        <th class="py-3 px-4 text-left text-sm font-semibold text-[#1a2235]">Last Updated</th>
                        <th class="py-3 px-4 text-left text-sm font-semibold text-[#1a2235]">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contents as $content)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                        <td class="py-3 px-4 text-sm text-[#1a2235]">{{ $content->title }}</td>
                        <td>
                            <x-status-indicator status="{{ $content->type }}" variant="outline" />
                        </td>
                        <td>
                            <x-status-indicator status="{{ $content->status }}" variant="outline" />
                        </td>
                        <td class="py-3 px-4 text-sm text-[#1a2235]">{{ $content->updated_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') }}</td>
                        <td class="py-3 px-4 flex items-center space-x-2">
                            <x-button href="{{ route('content.edit', $content->id) }}" 
                                    variant="primary" class="tooltip" data-tip="Edit">
                                <i class='bx bx-edit'></i>
                            </x-button>
                        
                            <x-button href="{{ route('content.archive', $content->id) }}" 
                                    variant="secondary" class="tooltip" data-tip="Archive">
                                <i class='bx bx-archive'></i>
                            </x-button>
                        
                            <form action="{{ route('content.destroy', $content->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <x-button type="submit" variant="danger" onclick="return confirm('Are you sure?')"
                                        class="tooltip" data-tip="Delete">
                                    <i class='bx bx-trash'></i> 
                                </x-button>
                            </form>
                        </td>                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        

        <div class="mt-6">
            {{ $contents->links() }}
        </div>
    </div>
</div>


@endsection