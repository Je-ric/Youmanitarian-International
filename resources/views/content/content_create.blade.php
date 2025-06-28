@extends('layouts.sidebar_final')

@section('content')
    <div class="w-full bg-white p-8 rounded-lg">

        <div class="flex justify-between items-center border-b border-gray-200 pb-6 mb-6">
            <h2 class="text-2xl font-bold text-[#1a2235]">
                {{ isset($content) ? 'Edit Content' : 'Create New Content' }}
            </h2>

            <div class="flex gap-2">
                <button type="submit" form="contentForm"
                    class="btn text-white bg-[#ffb51b] hover:bg-[#e6a017] focus:ring-2 focus:ring-[#ffb51b] focus:ring-offset-2 flex items-center">
                    <i class='bx {{ isset($content) ? 'bx-edit' : 'bx-save' }} mr-2'></i>
                    {{ isset($content) ? 'Update Content' : 'Save Content' }}
                </button>
            </div>
        </div>

        <!-- Summernote CSS/JS -->
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

        <form id="contentForm"
            action="{{ isset($content) ? route('content.update', $content->id) : route('content.store') }}" method="POST"
            enctype="multipart/form-data">

            @csrf
            @if(isset($content)) @method('PUT') @endif

            <!-- Main Grid Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Left Column - Form Fields -->
                <div class="lg:col-span-1 space-y-6">
                    
                    <!-- Title -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-[#1a2235]">Title</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="title" id="title"
                                class="input input-bordered w-full bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] pl-10"
                                value="{{ old('title', $content->title ?? '') }}" required>
                            <i class='bx bx-text absolute left-3 top-3 text-gray-400'></i>
                        </div>
                    </div>

                    <!-- Slug -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-[#1a2235]">URL Slug</span>
                        </label>
                        <div class="relative">
                            <input type="text" name="slug" id="slug"
                                class="input input-bordered w-full bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] pl-10"
                                value="{{ old('slug', $content->slug ?? '') }}" required>
                            <i class='bx bx-link absolute left-3 top-3 text-gray-400'></i>
                        </div>
                        <label class="label">
                            <span class="label-text-alt text-gray-500">This will be used in the URL (e.g., /news/your-slug-here)</span>
                        </label>
                    </div>

                    <!-- Category and Status -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold text-[#1a2235]">Category</span>
                            </label>
                            <div class="relative">
                                <select name="content_type"
                                    class="select select-bordered w-full bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] pl-10">
                                    <option value="news" {{ old('content_type', $content->content_type ?? '') == 'news' ? 'selected' : '' }}>News</option>
                                    <option value="program" {{ old('content_type', $content->content_type ?? '') == 'program' ? 'selected' : '' }}>Program</option>
                                    <option value="announcement" {{ old('content_type', $content->content_type ?? '') == 'announcement' ? 'selected' : '' }}>Announcement</option>
                                    <option value="event" {{ old('content_type', $content->content_type ?? '') == 'event' ? 'selected' : '' }}>Event</option>
                                    <option value="article" {{ old('content_type', $content->content_type ?? '') == 'article' ? 'selected' : '' }}>Article</option>
                                    <option value="blog" {{ old('content_type', $content->content_type ?? '') == 'blog' ? 'selected' : '' }}>Blog</option>
                                </select>
                                <i class='bx bx-category absolute left-3 top-3 text-gray-400'></i>
                            </div>
                        </div>

                        <div class="form-control">
                            <label class="label">
                                <span class="label-text font-semibold text-[#1a2235]">Status</span>
                            </label>
                            <div class="relative">
                                <select name="content_status"
                                    class="select select-bordered w-full bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] pl-10">
                                    <option value="draft" {{ old('content_status', $content->content_status ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('content_status', $content->content_status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
                                    <option value="archived" {{ old('content_status', $content->content_status ?? '') == 'archived' ? 'selected' : '' }}>Archived</option>
                                </select>
                                <i class='bx bx-flag absolute left-3 top-3 text-gray-400'></i>
                            </div>
                        </div>
                    </div>

                    <!-- Cover Image -->
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
                            <img src="{{ asset('storage/' . $content->image_content) }}" alt="Current Image" class="mt-2"
                                style="max-width: 200px;">
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
                            <div class="mt-4 grid grid-cols-2 gap-2">
                                @foreach($content->images as $image)
                                    <div class="relative border p-2">
                                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery Image"
                                            class="w-full h-20 object-cover">
                                        <form action="{{ route('content_images.destroy', $image->id) }}" method="POST" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="px-2 py-1 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition-colors flex items-center mt-1"
                                                onclick="return confirm('Are you sure?')">
                                                <i class='bx bx-trash mr-1'></i> Delete
                                            </button>
                                        </form>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                    <!-- Checkboxes -->
                    <div class="form-control space-y-3">
                        <label class="cursor-pointer flex items-center gap-2">
                            <input type="checkbox" name="enable_likes" value="1" {{ old('enable_likes', $content->enable_likes ?? true) ? 'checked' : '' }}>
                            <span>Enable Likes</span>
                        </label>
                        <label class="cursor-pointer flex items-center gap-2">
                            <input type="checkbox" name="enable_comments" value="1" {{ old('enable_comments', $content->enable_comments ?? true) ? 'checked' : '' }}>
                            <span>Enable Comments</span>
                        </label>
                        <label class="cursor-pointer flex items-center gap-2">
                            <input type="checkbox" name="enable_bookmark" value="1" {{ old('enable_bookmark', $content->enable_bookmark ?? true) ? 'checked' : '' }}>
                            <span>Enable Bookmark</span>
                        </label>
                        <label class="cursor-pointer flex items-center gap-2">
                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $content->is_featured ?? false) ? 'checked' : '' }}>
                            <span>Featured</span>
                        </label>
                    </div>

                    <!-- Publish Date -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-[#1a2235]">Publish Date</span>
                        </label>
                        @php
                            $publishedAt = old('published_at', $content->published_at ?? '');
                            if ($publishedAt && $publishedAt instanceof \Carbon\Carbon) {
                                $publishedAt = $publishedAt->format('Y-m-d');
                            }
                        @endphp
                        <input type="date" name="published_at" class="input input-bordered w-full"
                            value="{{ $publishedAt }}">
                    </div>

                    <!-- Meta Title -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-[#1a2235]">Meta Title</span>
                        </label>
                        <input type="text" name="meta_title" class="input input-bordered w-full"
                            value="{{ old('meta_title', $content->meta_title ?? '') }}">
                    </div>

                    <!-- Meta Description -->
                    <div class="form-control">
                        <label class="label">
                            <span class="label-text font-semibold text-[#1a2235]">Meta Description</span>
                        </label>
                        <input type="text" name="meta_description" class="input input-bordered w-full"
                            value="{{ old('meta_description', $content->meta_description ?? '') }}">
                    </div>

                </div>

                <!-- Right Column - Body Editor -->
                <div class="lg:col-span-2">
                    <div class="form-control h-full">
                        <label class="label">
                            <span class="label-text font-semibold text-[#1a2235]">Content Body</span>
                        </label>
                        <div class="h-full">
                            <textarea id="editor"
                                class="textarea textarea-bordered w-full h-[600px] bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b] pl-10">{{ old('body', $content->body ?? '') }}</textarea>
                            <input type="hidden" name="body" id="body" value="{{ old('body', $content->body ?? '') }}">
                        </div>
                    </div>
                </div>

            </div>

            <script>
                $(document).ready(function () {
                    $('#editor').summernote({
                        height: 600,
                        placeholder: 'Write your content here...',
                        callbacks: {
                            onChange: function (contents, $editable) {
                                $('#body').val(contents);
                            }
                        }
                    });
                    // Set initial value
                    $('#body').val($('#editor').summernote('code'));

                    // Auto-generate slug from title
                    $('#title').on('input', function() {
                        var title = $(this).val();
                        var slug = title.toLowerCase()
                            .replace(/[^a-z0-9 -]/g, '') // Remove special characters
                            .replace(/\s+/g, '-') // Replace spaces with hyphens
                            .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
                            .trim('-'); // Remove leading/trailing hyphens
                        $('#slug').val(slug);
                    });
                });
            </script>
        </form>
    </div>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script type="module" src="{{ asset('js/app.js') }}"></script>

@endsection