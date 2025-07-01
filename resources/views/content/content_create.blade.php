@extends('layouts.sidebar_final')

@section('content')
    <x-page-header 
        icon="bx-file" 
        title="{{ isset($content) ? 'Edit Content' : 'Create New Content' }}"
        desc="Fill out the form to create or edit content.">

        <x-button variant="add-create" type="submit" form="contentForm">
            <i class='bx {{ isset($content) ? 'bx-edit' : 'bx-save' }} mr-2'></i>
            {{ isset($content) ? 'Update Content' : 'Save Content' }}
        </x-button>

    </x-page-header>

    <div class="w-full bg-white p-8 rounded-lg">

        <form id="contentForm"
            action="{{ isset($content) ? route('content.update', $content->id) : route('content.store') }}" method="POST"
            enctype="multipart/form-data">

            @csrf
            @if(isset($content)) @method('PUT') @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Column -->
                <div class="lg:col-span-1 space-y-6">
                    <div>
                        <x-form.label>Content Title</x-form.label>
                        <x-form.input type="text" name="title" placeholder="What's the title???"
                            class="w-full bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b]"
                            value="{{ old('title', $content->title ?? '') }}" required />
                    </div>
                    <div>
                        <x-form.label>Slug</x-form.label>
                        <x-form.input type="text" name="slug" placeholder="what's-the-title???"
                            class="w-full bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b]"
                            value="{{ old('slug', $content->slug ?? '') }}" required />
                    </div>
                    <div>
                        <x-form.label>Featured Image</x-form.label>
                        @if(isset($content) && $content->image_content)
                            <div class="mb-4">
                                <img src="{{ asset('storage/' . $content->image_content) }}" alt="Current Image"
                                    class="mt-2 max-w-32 h-24 object-cover rounded-lg border">
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $content->image_content) }}" target="_blank"
                                        class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-medium text-sm transition-colors duration-200">
                                        <i class='bx bx-external-link'></i>
                                        View Full Size
                                    </a>
                                </div>
                            </div>
                        @endif
                        <x-form.input-upload name="image" id="image" accept="image/png,image/jpeg" class="mb-2">
                            Supported formats: JPEG, PNG
                            @if(isset($content) && $content->image_content)
                                <span class="block text-sm text-gray-500 mt-1">Upload a new image to replace the current one</span>
                            @endif
                        </x-form.input-upload>
                    </div>
                    <div class="flex items-center gap-8">
                        <x-form.radio-group name="content_type" label="Content Type" :options="['news' => 'News', 'program' => 'Program', 'announcement' => 'Announcement', 'event' => 'Event', 'article' => 'Article', 'blog' => 'Blog']" :selected="old('content_type', $content->content_type ?? '')" />
                    </div>
                    <div>
                        <x-form.label>Content Status</x-form.label>
                        <select name="content_status" class="input input-bordered w-full bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b]" required>
                            <option value="">Select Status</option>
                            <option value="draft" {{ old('content_status', $content->content_status ?? '') == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="published" {{ old('content_status', $content->content_status ?? '') == 'published' ? 'selected' : '' }}>Published</option>
                            <option value="archived" {{ old('content_status', $content->content_status ?? '') == 'archived' ? 'selected' : '' }}>Archived</option>
                        </select>
                    </div>
                    <div>
                        <x-form.label>Allow what applies:</x-form.label>
                        <div class="flex flex-col gap-2 mt-2">
                            <x-form.toggle name="enable_likes" :checked="old('enable_likes', $content->enable_likes ?? true)" label="Enable heart reacts" />
                            <x-form.toggle name="enable_comments" :checked="old('enable_comments', $content->enable_comments ?? true)" label="Enable Comments" />
                            <x-form.toggle name="enable_bookmark" :checked="old('enable_bookmark', $content->enable_bookmark ?? true)" label="Enable bookmarks" />
                            <x-form.toggle name="is_featured" :checked="old('is_featured', $content->is_featured ?? false)"
                                label="Featured" />
                        </div>
                    </div>
                    <div>
                        <x-form.label>Upload multiple additional images</x-form.label>
                        @if(isset($content) && $content->images && $content->images->count() > 0)
                            <div class="mb-4">
                                <p class="text-sm text-gray-600 mb-2">Current gallery images:</p>
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach($content->images as $image)
                                        <div class="relative border p-2">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery Image"
                                                class="w-full h-24 object-cover rounded-lg">
                                            <form action="{{ route('content_images.destroy', $image->id) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="px-3 py-1.5 text-sm bg-red-600 text-white rounded hover:bg-red-700 transition-colors flex items-center mt-1"
                                                    onclick="return confirm('Are you sure?')">
                                                    <i class='bx bx-trash mr-2'></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                        <x-form.input-upload 
                            name="gallery_images[]" 
                            id="gallery_images" 
                            accept="image/png,image/jpeg" 
                            multiple
                        >
                            @if(isset($content) && $content->images && $content->images->count() > 0)
                                <span class="text-green-600">You can upload more images. Current images are shown above.</span>
                            @else
                                PNG, JPG up to 10MB
                            @endif
                        </x-form.input-upload>
                    </div>
                    <div>
                        <x-form.label>Publish Date</x-form.label>
                        <x-form.input type="date" name="published_at" class="w-full"
                            value="{{ old('published_at', isset($content->published_at) ? \Illuminate\Support\Carbon::parse($content->published_at)->format('Y-m-d') : '') }}" />
                    </div>
                    <div>
                        <x-form.label>Meta Title</x-form.label>
                        <x-form.input type="text" name="meta_title" class="w-full"
                            value="{{ old('meta_title', $content->meta_title ?? '') }}" />
                    </div>
                    <div>
                        <x-form.label>Meta Description</x-form.label>
                        <x-form.input type="text" name="meta_description" class="w-full"
                            value="{{ old('meta_description', $content->meta_description ?? '') }}" />
                    </div>
                </div>
                <!-- Right Column (Body/Editor) -->
                <div class="lg:col-span-2 flex flex-col h-full">
                    <div class="flex-1">
                        <x-form.label>Body</x-form.label>
                        <textarea id="editor"
                            class="textarea textarea-bordered w-full h-96 bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b]"
                            name="body">{{ old('body', $content->body ?? '') }}</textarea>
                        <input type="hidden" name="body" id="body" value="{{ old('body', $content->body ?? '') }}">
                    </div>
                </div>
            </div>

            <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
            <script>
                $(document).ready(function () {
                    $('#editor').summernote({
                        height: 300,
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
                    $('input[name="title"]').on('input', function() {
                        var title = $(this).val();
                        var slug = title.toLowerCase()
                            .replace(/[^a-z0-9 -]/g, '') // Remove special characters
                            .replace(/\s+/g, '-') // Replace spaces with hyphens
                            .replace(/-+/g, '-') // Replace multiple hyphens with single hyphen
                            .replace(/^-+|-+$/g, ''); // Remove leading/trailing hyphens
                        $('input[name="slug"]').val(slug);
                    });
                });
            </script>
        </form>
    </div>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script type="module" src="{{ asset('js/app.js') }}"></script>

@endsection