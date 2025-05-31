@extends('layouts.sidebar_final')

@section('content')
<div class="w-full bg-white p-8 rounded-lg">

    <div class="flex justify-between items-center border-b border-gray-200 pb-6 mb-6">
        <h2 class="text-2xl font-bold text-[#1a2235]">
            {{ isset($content) ? 'Edit Content' : 'Create New Content' }}
        </h2>
        
    <div class="flex gap-2">
            @if(isset($contentRequest))
                <button class="btn" onclick="my_modal_1.showModal()"><i class='bx bx-show-alt'></i>View Request</button>

    <dialog id="my_modal_1" class="modal">
            <div class="modal-box w-11/12 max-w-5xl p-0 overflow-hidden bg-gradient-to-br from-[#f8fafc] to-[#f1f5f9]">
            <!-- Header with divider -->
            <div class="px-6 py-4 border-b border-[#e2e8f0]">
                <h3 class="text-xl font-bold text-[#1a2235] flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#3b82f6]" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z" clip-rule="evenodd" />
                </svg>
                Request Details
                </h3>
            </div>
        
            <div class="max-h-[70vh] overflow-y-auto p-6">
                <div class="bg-white rounded-xl shadow-sm p-5 mb-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div>
                        <p class="text-sm font-medium text-[#64748b]">Title</p>
                        <p class="text-[#1a2235] font-semibold text-lg">{{ $contentRequest->title }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-[#64748b]">Requested By</p>
                        <p class="text-[#1a2235]">{{ $contentRequest->user->name ?? 'N/A' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-[#64748b]">Requested Date</p>
                        <p class="text-[#1a2235] font-semibold text-lg">{{ $contentRequest->created_at }}</p>
                    </div>
                    </div>
                
                    <div class="mb-4">
                    <p class="text-sm font-medium text-[#64748b] mb-1">Description</p>
                    <div class="text-[#1a2235] whitespace-pre-line bg-[#f8fafc] p-3 rounded-lg border border-[#e2e8f0] max-h-[200px] overflow-y-auto">
                        {{ $contentRequest->description }}
                    </div>
                    </div>
                
                    <div>
                    <p class="text-sm font-medium text-[#64748b] mb-1">Additional Notes</p>
                    <div class="text-[#1a2235] whitespace-pre-line bg-[#f8fafc] p-3 rounded-lg border border-[#e2e8f0] max-h-[200px] overflow-y-auto">
                        {{ $contentRequest->notes ?? 'No notes provided' }}
                    </div>
                    </div>
                </div>
        
                <!-- Images section -->
                @if($contentRequest->images->isNotEmpty())
                <div class="bg-white rounded-xl shadow-sm p-5">
                <h3 class="text-lg font-semibold text-[#1a2235] flex items-center gap-2 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#3b82f6]" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd" />
                    </svg>
                    Attached Images
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4">
                    @foreach($contentRequest->images as $image)
                        <div class="group relative rounded-md overflow-hidden shadow-sm hover:shadow-md transition-shadow">
                        <div class="relative">
                            <img src="{{ asset('storage/' . $image->image_url) }}" 
                                alt="Request Image" 
                                class="w-full h-32 object-cover transition-transform group-hover:scale-105">
                            
                            <div class="absolute inset-0 flex items-end justify-center p-2 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                            <a href="{{ asset('storage/' . $image->image_url) }}" download 
                                class="btn btn-sm bg-[#3b82f6] text-white hover:bg-[#2563eb] border-none shadow-md transform translate-y-2 group-hover:translate-y-0 transition-transform">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download HD
                            </a>
                            </div>
                        </div>
                        </div>
                        @endforeach
                </div>
                </div>
                @endif
            </div>
      
          <!-- Footer with divider and action -->
          <div class="px-6 py-4 border-t border-[#e2e8f0] flex justify-end">
            <form method="dialog">
              <button class="btn bg-[#3b82f6] text-white hover:bg-[#2563eb] focus:outline-none focus:ring-2 focus:ring-[#3b82f6] focus:ring-opacity-50 transition-colors">
                Close
              </button>
            </form>
          </div>
        </div>
        
        <!-- Click outside to close -->
        <form method="dialog" class="modal-backdrop">
          <button>close</button>
        </form>
      </dialog> 


            @endif
                <button type="submit" form="contentForm" class="btn text-white bg-[#ffb51b] hover:bg-[#e6a017] focus:ring-2 focus:ring-[#ffb51b] focus:ring-offset-2 flex items-center">
                    <i class='bx {{ isset($content) ? 'bx-edit' : 'bx-save' }} mr-2'></i> 
                    {{ isset($content) ? 'Update Content' : 'Save Content' }}
                </button>
    </div>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="bg-green-200 text-green-700 p-3 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-200 text-red-700 p-3 rounded mb-6">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

  

{{--       
<dialog id="my_modal_1" class="modal">
  <div class="modal-box w-11/12 max-w-5xl">
    <h3 class="text-lg font-semibold text-[#1a2235]">Request Details!</h3>

    <div class="p-4 rounded-lg mb-6">
        <p class="mb-2"><strong>Title:</strong> {{ $contentRequest->title }}</p>
        <p class="mb-2"><strong>Requested By:</strong> {{ $contentRequest->user->name ?? 'N/A' }}</p>
        <p class="mb-2"><strong>Description:</strong> {{ $contentRequest->description }}</p>
        <p class="mb-4"><strong>Additional Notes:</strong> {{ $contentRequest->notes ?? 'No notes provided' }}</p>
        <p class="mb-4"><strong>Additional Notes:</strong> {{ $contentRequest->notes ?? 'No notes provided' }}</p>

        @if($contentRequest->images->isNotEmpty())
        <h3 class="mt-3 text-lg font-semibold text-[#1a2235]">Images:</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mt-2">
            @foreach($contentRequest->images as $image)
                <img src="{{ asset('storage/' . $image->image_url) }}" 
                    alt="Request Image" 
                    class="w-full max-w-xs h-28 sm:h-32 md:h-36 object-cover rounded-md shadow">
                @endforeach
            </div>
        @endif
    
    </div>

    <div class="modal-action">
      <form method="dialog">
        <button class="btn">Close</button>
      </form>
    </div>
  </div>
</dialog> --}}

    <!-- Form -->
    <form id="contentForm" action="{{ isset($content) ? route('content.update', $content->id) : route('content.store') }}" 
          method="POST" enctype="multipart/form-data">
          
        @csrf
        @if(isset($content)) @method('PUT') @endif
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="form-control md:col-span-1">
                <label class="label">
                    <span class="label-text font-semibold text-[#1a2235]">Title</span>
                </label>
                <div class="relative">
                    <input type="text" name="title"
                           class="input input-bordered w-full bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] pl-10"
                           value="{{ old('title', $content->title ?? '') }}" required>
                    <i class='bx bx-text absolute left-3 top-3 text-gray-400'></i>
                </div>
            </div>
        
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-[#1a2235]">Category</span>
                    </label>
                    <div class="relative">
                        <select name="type" class="select select-bordered w-full bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] pl-10">
                            <option value="news" {{ old('type', $content->type ?? '') == 'news' ? 'selected' : '' }}>News</option>
                            <option value="program" {{ old('type', $content->type ?? '') == 'program' ? 'selected' : '' }}>Program</option>
                        </select>
                        
                        <i class='bx bx-category absolute left-3 top-3 text-gray-400'></i> 
                    </div>
                </div>
                
                <div class="form-control">
                    <label class="label">
                        <span class="label-text font-semibold text-[#1a2235]">Status</span>
                    </label>
                    <div class="relative">
                        <select name="status"
                                class="select select-bordered w-full bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] pl-10">
                            <option value="draft" {{ old('status', $content->status ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('status', $content->status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
                        </select>
                        <i class='bx bx-flag absolute left-3 top-3 text-gray-400'></i> <!-- Boxicon for status -->
                    </div>
                </div>
            </div>
        </div>
        
        {{-- CKEDITOR di na gumagana, kapangit mo kabonding --}}

        {{-- <div class="form-control mb-6">
            <label class="label">
                <span class="label-text font-semibold text-[#1a2235]">Body</span>
            </label>
            <div class="">

                <textarea id="body" name="body"
                        class="textarea textarea-bordered w-full h-64 bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] pl-10"
                        required>{{ old('body', $content->body ?? '') }}
                </textarea>
            </div>
        </div> --}}

    
        <link rel="stylesheet" href="{{ asset('css/editor.css') }}">
        <script type="module" src="{{ asset('js/editor.js') }}"></script>


        <div class="form-control mb-6">
            <label class="label">
                <span class="label-text font-semibold text-[#1a2235]">Body</span>
            </label>
            <div>
                <textarea id="body" name="body" 
                    class="textarea textarea-bordered w-full h-64 bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] pl-10"
                    required>{{ old('body', $content->body ?? '') }}
                </textarea>
            </div>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold text-[#1a2235]">Upload Cover Image</span>
                </label>
                <div class="relative">
                    <input type="file" name="image" 
                           class="file-input file-input-bordered w-full bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] pl-10">
                    <i class='bx bx-image-add absolute left-3 top-3 text-gray-400'></i>
                </div>
                @if(isset($content) && $content->image_content)
                    <img src="{{ asset('storage/' . $content->image_content) }}" alt="Current Image" class="mt-2" style="max-width: 200px;">
                @endif
            </div>

            <!-- Gallery Images -->
            <div class="form-control">
                <label class="label">
                    <span class="label-text font-semibold text-[#1a2235]">Upload Gallery Images</span>
                </label>
                <div class="relative">
                    <input type="file" name="gallery_images[]" multiple 
                           class="file-input file-input-bordered w-full bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] pl-10">
                    <i class='bx bx-images absolute left-3 top-3 text-gray-400'></i> 
                </div>
                @if(isset($content) && $content->images)
                    <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                        @foreach($content->images as $image)
                            <div class="relative border p-2">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery Image" class="w-full h-32 object-cover">
                                
                                <form action="{{ route('content_images.destroy', $image->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="px-3 py-1.5 text-sm bg-red-600 text-white rounded hover:bg-red-700 transition-colors flex items-center" 
                                            onclick="return confirm('Are you sure?')">
                                        <i class='bx bx-trash mr-2'></i> Delete
                                    </button>
                                </form>
                                
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </form>
</div>

<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
{{-- <script src="https://cdn.tiny.cloud/1/zctnfzjfl8blcadzgdm4gwxy3986m39amafpx9zq9xbe5dk8/tinymce/5/tinymce.min.js"></script> --}}
{{-- <script src="https://cdn.tiny.cloud/1/vuvcfajzp5h0glvobgw3o47ynzsgadyfyccgj2jtjbz69s7i/tinymce/5/tinymce.min.js"></script>
    <script>
    tinymce.init({
        selector: '#body',
        plugins: 'advlist autolink lists link image charmap print preview anchor autoresize',
        toolbar: 'undo redo | formatselect | bold italic | alignleft aligncenter alignright | outdent indent | link image',
        menubar: false,
        autoresize_bottom_margin: 20, 
        autoresize_min_height: 300,   
        autoresize_max_height: 800,   
        setup: function (editor) {
            editor.on('change', function () {
                tinymce.triggerSave();
            });
        }
    });
</script> --}}
@endsection