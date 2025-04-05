@extends('layouts.sidebar')

@section('content')
<a href="{{ route('content_requests.create') }}" 
                   class="flex items-center gap-3 px-4 py-2 rounded-lg hover:bg-[#ffb51b] hover:text-[#1a2235] transition-colors">
                    <i class='bx bx-edit text-xl'></i>
                    <span>Create Request</span>
                </a>
                
<div class="mb-12">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-[#1a2235]">Content Requests</h2>
    </div>
    <div class="overflow-x-auto bg-white rounded-lg border border-gray-200">
        <table class="min-w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-[#1a2235]">Title</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-[#1a2235]">Requested By</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-[#1a2235]">Status</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-[#1a2235]">Requested Date</th>
                    <th class="py-3 px-4 text-left text-sm font-semibold text-[#1a2235]">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contentRequests as $request)
                <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                    <td class="py-3 px-4 text-sm text-[#1a2235]">{{ $request->title }}</td>
                    <td class="py-3 px-4 text-sm text-[#1a2235]">{{ $request->user->name ?? 'N/A' }}</td>
                    <td>
                        <x-status-indicator status="{{ $request->status  }}" variant="outline" />
                    </td>
                    <td class="py-3 px-4 text-sm text-[#1a2235]">{{ $request->created_at->setTimezone('Asia/Manila')->format('M d, Y h:i A') }}</td>
                    
                    <td class="py-3 px-4"> 
                        <button onclick="document.getElementById('modal-{{ $request->id }}').showModal()" 
                            class="px-3 py-1.5 text-sm bg-[#ffb51b] text-white rounded hover:bg-[#e6a017] transition-colors">
                        View
                        </button>
        
                        
                        <!-- Modal -->
                        <dialog id="modal-{{ $request->id }}" class="modal">
                            <div class="modal-box w-11/12 max-w-7xl p-8 bg-white rounded-lg">
                                <div class="border-b border-gray-200 pb-4 mb-6">
                                    <h2 class="text-2xl font-bold text-[#1a2235]">{{ $request->title }}</h2>
                                    <p class="text-sm text-gray-500 mt-1">Requested by: {{ $request->user->name ?? 'N/A' }}</p>
                                </div>
                        
                                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                                    <div class="lg:col-span-2">
                                        <div class="mb-6">
                                            <h3 class="text-lg font-semibold text-[#1a2235] mb-2">Description</h3>
                                            <p class="text-gray-700">{{ $request->description }}</p>
                                        </div>
                        
                                        <div class="border-t border-gray-200 mb-6"></div>
                        
                                        <div>
                                            <h3 class="text-lg font-semibold text-[#1a2235] mb-2">Additional Notes</h3>
                                            <p class="text-gray-700">{{ $request->notes ?? 'No additional notes provided.' }}</p>
                                        </div>
                                    </div>
                        
                                    <div class="space-y-6">
                                        <div>
                                            <h3 class="text-lg font-semibold text-[#1a2235] mb-4">Image Gallery</h3>
                                            @if($request->images->isNotEmpty())
                                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                                    @foreach($request->images as $image)
                                                        <img src="{{ asset('storage/' . $image->image_url) }}" 
                                                             alt="Content Request Image" 
                                                             class="w-full h-32 object-cover rounded-md shadow-sm hover:shadow-md transition-shadow">
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-gray-500">No images available</p>
                                            @endif
                                        </div>
                        
                                        @if($request->status === 'pending')
                                            <form method="POST" action="{{ route('content.updateStatus') }}" class="mt-4">
                                                @csrf
                                                <input type="hidden" name="id" value="{{ $request->id }}">
                                                <input type="hidden" name="status" value="in_progress">
                                                <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition-colors">
                                                    Mark as In Progress
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                        
                                <div class="border-t border-gray-200 my-6"></div>
                        
                                <div class="modal-action">
                                    <form method="dialog">
                                        <button class="px-4 py-2 bg-[#ffb51b] text-white rounded hover:bg-[#e6a017] transition-colors">
                                            Close
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </dialog>

                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection