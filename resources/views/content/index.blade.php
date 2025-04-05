@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto p-6">

    @if(session('success'))
    <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

    <a href="{{ route('content.create') }}" 
    class="flex items-center gap-3 px-4 py-2 rounded-lg bg-[#ffb51b] text-[#1a2235] hover:bg-[#e6a017] transition-colors">
     <i class='bx bx-plus text-xl'></i>
     <span>Create Content</span>
 </a>
    <!-- Content -->
    <div>
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-[#1a2235]">Content</h2>
        </div>
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
                            <a href="{{ route('content.edit', $content->id) }}" 
                               class="px-3 py-1.5 text-sm bg-[#ffb51b] text-white rounded hover:bg-[#e6a017] transition-colors flex items-center">
                                <i class='bx bx-edit mr-2'></i> Edit
                            </a>
                            <a href="{{ route('content.archive', $content->id) }}" 
                               class="px-3 py-1.5 text-sm bg-gray-600 text-white rounded hover:bg-gray-700 transition-colors flex items-center">
                                <i class='bx bx-archive mr-2'></i> Archive
                            </a>
                            <form action="{{ route('content.destroy', $content->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" 
                                        class="px-3 py-1.5 text-sm bg-red-600 text-white rounded hover:bg-red-700 transition-colors flex items-center" 
                                        onclick="return confirm('Are you sure?')">
                                    <i class='bx bx-trash mr-2'></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>




{{-- <script>
    function openModal(modalId) {
        document.getElementById(modalId).showModal();
    }
    </script> --}}
    

<!-- Include Boxicons & DaisyUI -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/daisyui@2.51.5"></script>
@endsection