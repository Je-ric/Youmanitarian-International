@extends('layouts.content_create')

@section('content')
<style>
    .note-editable h1 { font-size: 2em; margin: 0.67em 0; }
    .note-editable h2 { font-size: 1.5em; margin: 0.75em 0; }
    .note-editable h3 { font-size: 1.17em; margin: 0.83em 0; }
    .note-editable ul,
    .note-editable ol { margin-left: 2em; }
    .note-editable li { list-style-type: inherit; }
    .note-editable img { max-width: 100%; height: auto; cursor: move; }
    </style>

    <x-page-header
        icon="bx-file"
        title="{{ isset($content) ? 'Edit Content' : 'Create New Content' }}"
        desc="Fill out the form to create or edit content.">

        <!-- Header Actions -->
        <div class="flex flex-col sm:flex-row gap-3">
            <x-button href="{{ route('content.index') }}" variant="cancel">
                <i class='bx bx-arrow-back mr-2'></i>
                Back to Content
            </x-button>

            <button type="button"
                    data-drawer-target="drawer-right-example"
                    data-drawer-show="drawer-right-example"
                    data-drawer-placement="right"
                    aria-controls="drawer-right-example"
                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                <i class='bx bx-cog mr-2'></i>
                Settings Panel
            </button>

            <x-button variant="add-create" type="submit" form="contentForm">
                <i class='bx {{ isset($content) ? 'bx-edit' : 'bx-save' }} mr-2'></i>
                {{ isset($content) ? 'Update Content' : 'Save Content' }}
            </x-button>
        </div>
    </x-page-header>

    @php
        $reviewMode = $reviewMode ?? false;
    @endphp

    <x-navigation-layout.tabs-modern
        :tabs="$reviewMode
            ? [['id' => 'preview', 'label' => 'Preview', 'icon' => 'bx-show']]
            : [
                ['id' => 'edit', 'label' => 'Edit', 'icon' => 'bx-edit'],
                ['id' => 'preview', 'label' => 'Preview', 'icon' => 'bx-show']
            ]"
        defaultTab="preview"
        :preserveState="false"
        class="mb-6">

        <x-slot name="slot_edit">
            @if(!$reviewMode)
                <div class="relative">

                    <form id="contentForm"
                        action="{{ isset($content) ? route('content.update', $content->id) : route('content.store') }}"
                        method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @if(isset($content)) @method('PUT') @endif

                        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
                            <div class="xl:col-span-3 space-y-6">
                                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                                    <div class="flex items-center gap-3 mb-6 justify-between">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                                <i class='bx bx-edit text-blue-600 text-xl'></i>
                                            </div>
                                            <div>
                                                <h3 class="text-lg font-semibold text-[#1a2235]">Basic Information</h3>
                                                <p class="text-sm text-gray-600">Essential content details</p>
                                            </div>
                                        </div>
                                        @if(isset($content))
                                            <x-feedback-status.status-indicator status="{{ $content->approval_status }}" />
                                        @endif
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                        <div class="md:col-span-2">
                                            <x-form.label for="title">Content Title *</x-form.label>
                                            <x-form.input
                                                type="text"
                                                name="title"
                                                id="title"
                                                placeholder="Enter your content title..."
                                                class="w-full"
                                                value="{{ old('title', $content->title ?? '') }}"
                                                required />
                                        </div>

                                        <div>
                                            <x-form.label for="slug">URL Slug *</x-form.label>
                                            <x-form.input
                                                type="text"
                                                name="slug"
                                                id="slug"
                                                placeholder="auto-generated-from-title"
                                                class="w-full"
                                                value="{{ old('slug', $content->slug ?? '') }}"
                                                required />
                                            <p class="text-xs text-gray-500 mt-1">Auto-generated from title, but you can customize it</p>
                                        </div>

                                        <div>
                                            <x-form.label for="content_type">Content Type *</x-form.label>
                                            <select name="content_type" id="content_type"
                                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b]"
                                                    required>
                                                <option value="">Select content type</option>
                                                @foreach(['news' => 'News', 'program' => 'Program', 'announcement' => 'Announcement', 'event' => 'Event', 'article' => 'Article', 'blog' => 'Blog'] as $value => $label)
                                                    <option value="{{ $value }}" {{ old('content_type', $content->content_type ?? '') == $value ? 'selected' : '' }}>
                                                        {{ $label }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Editor -->
                                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                                    <div class="flex items-center gap-3 mb-6">
                                        <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                                            <i class='bx bx-text text-green-600 text-xl'></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-[#1a2235]">Content Body</h3>
                                            <p class="text-sm text-gray-600">Write your main content here</p>
                                        </div>
                                    </div>

                                    <div>
                                        <x-form.label for="editor">Content Body *</x-form.label>
                                        <textarea id="editor"
                                            class="w-full h-96 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b]"
                                            name="body"
                                            placeholder="Start writing your content...">{{ old('body', $content->body ?? '') }}</textarea>
                                    </div>
                                </div>

                                <!-- Media Gallery -->
                                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                                    <div class="flex items-center gap-3 mb-6">
                                        <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center">
                                            <i class='bx bx-images text-purple-600 text-xl'></i>
                                        </div>
                                        <div>
                                            <h3 class="text-lg font-semibold text-[#1a2235]">Media Gallery</h3>
                                            <p class="text-sm text-gray-600">Upload images for your content</p>
                                        </div>
                                    </div>

                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                                        <div>
                                            <x-form.label for="image">Featured Image</x-form.label>
                                            @if(isset($content) && $content->image_content)
                                                <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                                                    <img src="{{ asset('storage/' . $content->image_content) }}"
                                                         alt="Current Image"
                                                         class="w-full h-32 object-cover rounded-lg border mb-2">
                                                    <a href="{{ asset('storage/' . $content->image_content) }}"
                                                       target="_blank"
                                                       class="inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 text-sm">
                                                        <i class='bx bx-external-link'></i>
                                                        View Full Size
                                                    </a>
                                                </div>
                                            @endif
                                            <x-form.input-upload
                                                name="image"
                                                id="image"
                                                accept="image/png,image/jpeg">
                                                <div class="text-center">
                                                    <i class='bx bx-cloud-upload text-3xl text-gray-400 mb-2'></i>
                                                    <p class="text-sm text-gray-600">PNG, JPG up to 10MB</p>
                                                    @if(isset($content) && $content->image_content)
                                                        <p class="text-xs text-gray-500 mt-1">Upload new image to replace current</p>
                                                    @endif
                                                </div>
                                            </x-form.input-upload>
                                        </div>

                                        <div>
                                            <x-form.label for="gallery_images">Additional Images</x-form.label>
                                            @if(isset($content) && $content->images && $content->images->count() > 0)
                                                <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                                                    <p class="text-sm text-gray-600 mb-3">Current gallery ({{ $content->images->count() }} images):</p>
                                                    <div class="grid grid-cols-3 gap-2">
                                                        @foreach($content->images->take(6) as $image)
                                                            <div class="relative group">
                                                                <img src="{{ asset('storage/' . $image->image_path) }}"
                                                                     alt="Gallery Image"
                                                                     class="w-full h-16 object-cover rounded border">
                                                                <button type="button"
                                                                        onclick="deleteGalleryImage({{ $image->id }})"
                                                                        class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white rounded-full text-xs opacity-0 group-hover:opacity-100 transition-opacity">
                                                                    ×
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                    @if($content->images->count() > 6)
                                                        <p class="text-xs text-gray-500 mt-2">+{{ $content->images->count() - 6 }} more images</p>
                                                    @endif
                                                </div>
                                            @endif
                                            <x-form.input-upload
                                                name="gallery_images[]"
                                                id="gallery_images"
                                                accept="image/png,image/jpeg"
                                                multiple>
                                                <div class="text-center">
                                                    <i class='bx bx-images text-3xl text-gray-400 mb-2'></i>
                                                    <p class="text-sm text-gray-600">Upload multiple images</p>
                                                    <p class="text-xs text-gray-500">PNG, JPG up to 10MB each</p>
                                                </div>
                                            </x-form.input-upload>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="xl:col-span-1 space-y-6">

                                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center">
                                            <i class='bx bx-send text-orange-600'></i>
                                        </div>
                                        <h3 class="font-semibold text-[#1a2235]">Publishing</h3>
                                    </div>

                                    @php
                                        $user = Auth::user();
                                        $isProgramCoordinator = $user->hasRole('Program Coordinator');
                                        $isContentManager = $user->hasRole('Content Manager');
                                        $hasBothRoles = $isProgramCoordinator && $isContentManager;
                                    @endphp

                                    <div class="space-y-3">
                                        <label class="flex items-center">
                                            <input type="radio" name="publishing_action" value="draft"
                                                {{ old('publishing_action', 'draft') == 'draft' ? 'checked' : '' }}
                                                class="text-[#ffb51b] focus:ring-[#ffb51b]">
                                            <span class="ml-2 text-sm">Save as Draft</span>
                                        </label>

                                        @if($isProgramCoordinator || $hasBothRoles)
                                        <label class="flex items-center">
                                            <input type="radio" name="publishing_action" value="submitted"
                                                {{ old('publishing_action') == 'submitted' ? 'checked' : '' }}
                                                class="text-[#ffb51b] focus:ring-[#ffb51b]">
                                            <span class="ml-2 text-sm">Submit for Approval</span>
                                        </label>
                                        @endif

                                        @if($isContentManager || $hasBothRoles)
                                        <label class="flex items-center">
                                            <input type="radio" name="publishing_action" value="published"
                                                {{ old('publishing_action') == 'published' ? 'checked' : '' }}
                                                class="text-[#ffb51b] focus:ring-[#ffb51b]">
                                            <span class="ml-2 text-sm">Publish Directly</span>
                                        </label>
                                        @endif
                                    </div>

                                    <button type="button"
                                        onclick="document.getElementById('statusGuideModal').showModal();"
                                        class="mt-3 w-full px-3 py-2 text-xs bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors">
                                        <i class="bx bx-info-circle mr-1"></i>
                                        View Status Guide
                                    </button>
                                </div>

                                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center">
                                            <i class='bx bx-toggle-left text-green-600'></i>
                                        </div>
                                        <h3 class="font-semibold text-[#1a2235]">Features</h3>
                                    </div>

                                    <div class="space-y-3">
                                        <x-form.toggle
                                            name="enable_likes"
                                            :checked="old('enable_likes', $content->enable_likes ?? true)"
                                            label="Heart Reactions" />

                                        <x-form.toggle
                                            name="enable_comments"
                                            :checked="old('enable_comments', $content->enable_comments ?? true)"
                                            label="Comments" />

                                        <x-form.toggle
                                            name="enable_bookmark"
                                            :checked="old('enable_bookmark', $content->enable_bookmark ?? true)"
                                            label="Bookmarks" />

                                        <x-form.toggle
                                            name="is_featured"
                                            :checked="old('is_featured', $content->is_featured ?? false)"
                                            label="Featured Content" />
                                    </div>
                                </div>

                                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
                                    <div class="flex items-center gap-3 mb-4">
                                        <div class="w-8 h-8 bg-indigo-100 rounded-lg flex items-center justify-center">
                                            <i class='bx bx-calendar text-indigo-600'></i>
                                        </div>
                                        <h3 class="font-semibold text-[#1a2235]">Schedule & SEO</h3>
                                    </div>

                                    <div class="space-y-4">
                                        <div>
                                            <x-form.label for="published_at" class="text-sm">Publish Date</x-form.label>
                                            <x-form.input
                                                type="date"
                                                name="published_at"
                                                id="published_at"
                                                class="w-full"
                                                value="{{ old('published_at', isset($content->published_at) ? \Illuminate\Support\Carbon::parse($content->published_at)->format('Y-m-d') : '') }}" />
                                        </div>

                                        <div>
                                            <x-form.label for="meta_title" class="text-sm">Meta Title</x-form.label>
                                            <x-form.input
                                                type="text"
                                                name="meta_title"
                                                id="meta_title"
                                                class="w-full"
                                                placeholder="SEO title..."
                                                value="{{ old('meta_title', $content->meta_title ?? '') }}" />
                                        </div>

                                        <div>
                                            <x-form.label for="meta_description" class="text-sm">Meta Description</x-form.label>
                                            <textarea
                                                name="meta_description"
                                                id="meta_description"
                                                rows="3"
                                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b]"
                                                placeholder="SEO description...">{{ old('meta_description', $content->meta_description ?? '') }}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <div>
                                    <h4 class="font-medium text-[#1a2235] mb-3">Content Stats</h4>
                                    <div class="space-y-2 text-sm">
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Word Count:</span>
                                            <span id="wordCount" class="font-medium">0</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Character Count:</span>
                                            <span id="charCount" class="font-medium">0</span>
                                        </div>
                                        <div class="flex justify-between">
                                            <span class="text-gray-600">Reading Time:</span>
                                            <span id="readingTime" class="font-medium">0 min</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    @include('content.partials.contentReviewComments')
                </div>
            @endif
        </x-slot>

        <x-slot name="slot_preview">
            @include('content.partials.preview', [
                'title' => old('title', $content->title ?? ''),
                'body' => old('body', $content->body ?? ''),
                'content_type' => old('content_type', $content->content_type ?? ''),
                'image_content' => isset($content) && $content->image_content ? $content->image_content : null,
                'is_featured' => old('is_featured', $content->is_featured ?? false),
                'enable_likes' => old('enable_likes', $content->enable_likes ?? true),
                'enable_comments' => old('enable_comments', $content->enable_comments ?? true),
                'enable_bookmark' => old('enable_bookmark', $content->enable_bookmark ?? true),
                'gallery_images' => isset($content) && $content->images ? $content->images->pluck('image_path')->toArray() : []
            ])

            @include('content.partials.contentReviewComments')
        </x-slot>
    </x-navigation-layout.tabs-modern>

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>

    <script>
        $(document).ready(function () {
            // Enhanced Summernote Configuration
            $('#editor').summernote({
                minHeight: 200, // Set your minimum height here (e.g., 200px)
                height: 400,
                placeholder: 'Start writing your amazing content here...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph', 'height']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video', 'hr']],
                    ['view', ['fullscreen', 'codeview']],
                    ['misc', ['undo', 'redo']],
                    ['custom', ['wordcount', 'readingtime']]
                ],
                buttons: {
                    wordcount: function(context) {
                        var ui = $.summernote.ui;
                        return ui.button({
                            contents: '<i class="bx bx-text"></i>',
                            tooltip: 'Word Count',
                            click: function() {
                                updateContentStats();
                            }
                        }).render();
                    },
                    readingtime: function(context) {
                        var ui = $.summernote.ui;
                        return ui.button({
                            contents: '<i class="bx bx-time"></i>',
                            tooltip: 'Reading Time',
                            click: function() {
                                updateContentStats();
                            }
                        }).render();
                    }
                },
                styleTags: [
                    'p',
                    { title: 'Blockquote', tag: 'blockquote', className: 'blockquote border-l-4 border-gray-300 pl-4 italic', value: 'blockquote' },
                    'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
                ],
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Verdana'],
                fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '36', '48'],
                inheritPlaceholder: true,
                dialogsInBody: true,
                dialogsFade: true,
                disableDragAndDrop: false,
                shortcuts: true,
                tabDisable: false,
                codeviewFilter: true,
                codeviewIframeFilter: true,
                spellCheck: true,
                disableGrammar: false,
                callbacks: {
                    onChange: function(contents, $editable) {
                        $('#editor').val(contents);
                        updateContentStats();
                        autoResizeEditor();
                    },
                    onInit: function() {
                        console.log('Enhanced Summernote Editor Initialized');
                        updateContentStats();
                        autoResizeEditor();
                    }
                    // ,
                    // onImageUpload: function(files) {
                    //     // Handle image upload
                    //     for (let i = 0; i < files.length; i++) {
                    //         uploadImage(files[i]);
                    //     }
                    // }
                }
            });

            // Auto-generate slug from title
            $('#title').on('input', function() {
                var title = $(this).val();
                var slug = title.toLowerCase()
                    .replace(/[^a-z0-9 -]/g, '')
                    .replace(/\s+/g, '-')
                    .replace(/-+/g, '-')
                    .replace(/^-+|-+$/g, '');
                $('#slug').val(slug);
            });

            // Auto-save functionality
            let autoSaveTimer;
            $('#editor, #title, #slug').on('input', function() {
                clearTimeout(autoSaveTimer);
                autoSaveTimer = setTimeout(function() {
                    // Auto-save logic here
                    console.log('Auto-saving...');
                }, 30000); // Auto-save every 30 seconds
            });
        });

        // Content Statistics
        function updateContentStats() {
            const content = $('#editor').summernote('code');
            const textContent = $(content).text();
            const wordCount = textContent.trim().split(/\s+/).length;
            const charCount = textContent.length;
            const readingTime = Math.ceil(wordCount / 200); // Average reading speed

            $('#wordCount').text(wordCount);
            $('#charCount').text(charCount);
            $('#readingTime').text(readingTime + ' min');
        }

        // function toggleFullscreen() {
        //     $('#editor').summernote('fullscreen.toggle');
        //     toggleOffcanvas();
        // }

        // Gallery image deletion
        function deleteGalleryImage(imageId) {
            if (confirm('Are you sure you want to delete this image?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/content/images/${imageId}`;

                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);

                document.body.appendChild(form);
                form.submit();
            }
        }

        // Image upload handler
        function uploadImage(file) {
            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', '{{ csrf_token() }}');

            // You can implement AJAX upload here
            console.log('Uploading image:', file.name);
        }

        // Keyboard shortcuts
        document.addEventListener('keydown', function(e) {
            if (e.ctrlKey || e.metaKey) {
                switch(e.key) {
                    case 's':
                        e.preventDefault();
                        saveDraft();
                        break;
                    case 'p':
                        e.preventDefault();
                        previewContent();
                        break;
                }
            }
        });

        function autoResizeEditor() {
            var $editable = $('.note-editable');
            $editable.css('height', 'auto'); // Reset height
            var scrollHeight = $editable[0].scrollHeight;
            var minHeight = 200; // Match your minHeight
            $editable.css('height', Math.max(scrollHeight, minHeight) + 'px');
        }

        // Call on change and init
        $('#editor').on('summernote.change summernote.init', function() {
            autoResizeEditor();
        });
    </script>

    @include('content.modals.statusGuideModal')
@endsection
