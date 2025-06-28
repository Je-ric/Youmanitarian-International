@extends('layouts.sidebar_final')  

@section('content') 
<div class="container mx-auto p-6">
    <div class="w-full bg-white rounded-lg">
        <div class="flex justify-between items-center border-b border-gray-200 pb-6 mb-6">
            <h1 class="text-xl font-semibold text-[#1a2235]">Create Content Request</h1>
            <button type="submit" form="contentRequestForm" class="btn text-white bg-[#ffb51b] hover:bg-[#e6a017] focus:ring-2 focus:ring-[#ffb51b] focus:ring-offset-2 flex items-center">
                <i class='bx bx-send mr-2'></i> 
                Submit Request
            </button>
        </div>

        <form id="contentRequestForm" action="{{ route('content_requests.store') }}" method="POST" enctype="multipart/form-data" class="w-full">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="space-y-6">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-[#1a2235]">Title</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="title" id="title" 
                                class="input input-bordered w-full bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] pl-10" 
                                placeholder="Enter request title" required>
                            <i class='bx bx-text absolute left-3 top-3 text-gray-400'></i> 
                        </div>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-[#1a2235]">Description</span>
                        </label>
                        <div class="relative">
                            <textarea name="description" id="description" 
                                class="textarea textarea-bordered w-full h-48 bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] pl-10" 
                                placeholder="Detailed content description" required></textarea>
                            <i class='bx bx-edit absolute left-3 top-3 text-gray-400'></i> 
                        </div>
                    </div>
                </div>

                <div class="space-y-6">
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-[#1a2235]">Additional Notes</span>
                        </label>
                        <div class="relative">
                            <textarea name="notes" id="notes" 
                                class="textarea textarea-bordered w-full h-32 bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] pl-10" 
                                placeholder="Optional special instructions or comments"></textarea>
                            <i class='bx bx-note absolute left-3 top-3 text-gray-400'></i> 
                        </div>
                    </div>

                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-[#1a2235]">Attach Images</span>
                        </label>
                        <div class="relative">
                            <input type="file" name="images[]" id="images" 
                                class="file-input file-input-bordered w-full bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] pl-10" 
                                accept="image/*" multiple>
                            <i class='bx bx-image-add absolute left-3 top-3 text-gray-400'></i> 
                        </div>
                        <div class="label">
                            <span class="label-text-alt text-gray-500">Maximum 10 files (JPEG, PNG, GIF)</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection