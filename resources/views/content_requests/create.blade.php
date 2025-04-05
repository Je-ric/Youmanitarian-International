{{-- @extends('layouts.sidebar')

@section('content')
<div class="container">
    <h1>Create Content Request</h1>
    
    <form action="{{ route('content_requests.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="mb-3">
            <label for="title" class="form-label">Title</label>
            <input type="text" name="title" id="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label for="notes" class="form-label">Notes</label>
            <textarea name="notes" id="notes" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label for="images" class="form-label">Upload Images</label>
            <input type="file" name="images[]" id="images" class="form-control" accept="image/*" multiple>
        </div>

        <button type="submit" class="btn btn-success">Submit Request</button>
    </form>
</div>
@endsection --}}

@extends('layouts.sidebar')  
@section('content') 
<div class="container mx-auto p-6">
    <div class="w-full bg-white rounded-lg">
        <!-- Header with Button -->
        <div class="flex justify-between items-center border-b border-gray-200 pb-6 mb-6">
            <h1 class="text-xl font-semibold text-[#1a2235]">Create Content Request</h1>
            <button type="submit" form="contentRequestForm" class="btn text-white bg-[#ffb51b] hover:bg-[#e6a017] focus:ring-2 focus:ring-[#ffb51b] focus:ring-offset-2 flex items-center">
                <i class='bx bx-send mr-2'></i> <!-- Boxicon for the button -->
                Submit Request
            </button>
        </div>

        <!-- Form -->
        <form id="contentRequestForm" action="{{ route('content_requests.store') }}" method="POST" enctype="multipart/form-data" class="w-full">
            @csrf

            <!-- Grid Layout -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Left Column -->
                <div class="space-y-6">
                    <!-- Title -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-[#1a2235]">Title</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="title" id="title" 
                                class="input input-bordered w-full bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] pl-10" 
                                placeholder="Enter request title" required>
                            <i class='bx bx-text absolute left-3 top-3 text-gray-400'></i> <!-- Boxicon for title -->
                        </div>
                    </div>

                    <!-- Description -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-[#1a2235]">Description</span>
                        </label>
                        <div class="relative">
                            <textarea name="description" id="description" 
                                class="textarea textarea-bordered w-full h-48 bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] pl-10" 
                                placeholder="Detailed content description" required></textarea>
                            <i class='bx bx-edit absolute left-3 top-3 text-gray-400'></i> <!-- Boxicon for description -->
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="space-y-6">
                    <!-- Notes -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-[#1a2235]">Additional Notes</span>
                        </label>
                        <div class="relative">
                            <textarea name="notes" id="notes" 
                                class="textarea textarea-bordered w-full h-32 bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] pl-10" 
                                placeholder="Optional special instructions or comments"></textarea>
                            <i class='bx bx-note absolute left-3 top-3 text-gray-400'></i> <!-- Boxicon for notes -->
                        </div>
                    </div>

                    <!-- Upload Images -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-[#1a2235]">Attach Images</span>
                        </label>
                        <div class="relative">
                            <input type="file" name="images[]" id="images" 
                                class="file-input file-input-bordered w-full bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] pl-10" 
                                accept="image/*" multiple>
                            <i class='bx bx-image-add absolute left-3 top-3 text-gray-400'></i> <!-- Boxicon for file upload -->
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

<!-- Include Boxicons -->
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
@endsection