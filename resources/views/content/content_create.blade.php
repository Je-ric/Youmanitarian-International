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
                        <input type="text" name="title" placeholder="What's the title???"
                            class="input input-bordered w-full bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b]"
                            value="{{ old('title', $content->title ?? '') }}" required>
                    </div>
                    <div>
                        <x-form.label>Slug</x-form.label>
                        <input type="text" name="slug" placeholder="what's-the-title???"
                            class="input input-bordered w-full bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b]"
                            value="{{ old('slug', $content->slug ?? '') }}" required>
                    </div>
                    <div>
                        <x-form.label>Featured Image</x-form.label>
                        <x-form.input-upload name="image" id="image" accept="image/png,image/jpeg" class="mb-2">
                            Supported formats: JPEG, PNG
                        </x-form.input-upload>
                        @if(isset($content) && $content->image_content)
                            <img src="{{ asset('storage/' . $content->image_content) }}" alt="Current Image" class="mt-2 max-w-xs rounded-lg">
                        @endif
                    </div>
                    <div class="flex items-center gap-8">
                        <x-form.radio-group name="content_type" label="Content Type" :options="['news' => 'News', 'program' => 'Program', 'announcement' => 'Announcement', 'event' => 'Event', 'article' => 'Article', 'blog' => 'Blog']" :selected="old('content_type', $content->content_type ?? '')" />
                    </div>
                    <div>
                        <x-form.label>Allow what applies:</x-form.label>
                        <div class="flex flex-col gap-2 mt-2">
                            <x-form.toggle name="enable_likes" :checked="old('enable_likes', $content->enable_likes ?? true)" label="Enable heart reacts" />
                            <x-form.toggle name="enable_comments" :checked="old('enable_comments', $content->enable_comments ?? true)" label="Enable Comments" />
                            <x-form.toggle name="enable_bookmark" :checked="old('enable_bookmark', $content->enable_bookmark ?? true)" label="Enable bookmarks" />
                            <x-form.toggle name="is_featured" :checked="old('is_featured', $content->is_featured ?? false)" label="Featured" />
                        </div>
                    </div>
                    <div>
                        <x-form.label>Upload multiple additional images</x-form.label>
                        <x-form.input-upload name="gallery_images[]" id="gallery_images" accept="image/png,image/jpeg" multiple>
                            Supported formats: JPEG, PNG
                        </x-form.input-upload>
                    </div>
                    @if(isset($content) && $content->images)
                        <div class="mt-4 grid grid-cols-2 md:grid-cols-4 gap-4">
                            @foreach($content->images as $image)
                                <div class="relative border p-2">
                                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="Gallery Image"
                                                class="w-full h-32 object-cover rounded-lg">
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
                    @endif
                    <div>
                        <x-form.label>Publish Date</x-form.label>
                        <input type="date" name="published_at"
                            class="input input-bordered w-full"
                            value="{{ old('published_at', isset($content->published_at) ? \Illuminate\Support\Carbon::parse($content->published_at)->format('Y-m-d') : '') }}">
                    </div>
                    <div>
                        <x-form.label>Meta Title</x-form.label>
                        <input type="text" name="meta_title"
                            class="input input-bordered w-full"
                            value="{{ old('meta_title', $content->meta_title ?? '') }}">
                    </div>
                    <div>
                        <x-form.label>Meta Description</x-form.label>
                        <input type="text" name="meta_description"
                            class="input input-bordered w-full"
                            value="{{ old('meta_description', $content->meta_description ?? '') }}">
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
                });
            </script>
    </form>
</div>

<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<script type="module" src="{{ asset('js/app.js') }}"></script>

@endsection