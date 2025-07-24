{{-- @extends('layouts.sidebar_final') --}}
@extends('layouts.content_create')

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

    <x-navigation-layout.tabs-modern
        :tabs="[
            ['id' => 'edit', 'label' => 'Edit', 'icon' => 'bx-edit'],
            ['id' => 'preview', 'label' => 'Preview', 'icon' => 'bx-show']
        ]"
        defaultTab="edit"
        :preserveState="false"
        class="mb-6">

        <x-slot name="slot_edit">
            <!-- Form  -->
    <div class="w-full rounded-lg">
        <form id="contentForm"
            action="{{ isset($content) ? route('content.update', $content->id) : route('content.store') }}" method="POST"
            enctype="multipart/form-data">
            @csrf
            @if(isset($content)) @method('PUT') @endif
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left -->
                <div class="lg:col-span-1 space-y-6">
                    <x-button href="{{ route('content.index') }}"
                                variant="cancel">
                        BACKKKKKKKKKKKKKKKKKKKKKKKKK!!!!!!!!!
                    </x-button>
<div class="text-center">
    <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" type="button" data-drawer-target="drawer-right-example" data-drawer-show="drawer-right-example" data-drawer-placement="right" aria-controls="drawer-right-example">
    Show right drawer
    </button>
 </div>
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
                    @php
                        $user = Auth::user();
                        $canChoosePublish = $user->hasRole('Content Manager') && $user->hasRole('Program Coordinator') && !isset($content);
                    @endphp
                    @if($canChoosePublish)
                        <div>
                            <x-form.label>Publishing Option</x-form.label>
                            <div class="flex flex-col gap-2 mt-2">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="publish_option" value="publish" {{ old('publish_option', 'publish') == 'publish' ? 'checked' : '' }}>
                                    <span class="ml-2">Publish directly</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="publish_option" value="approval" {{ old('publish_option') == 'approval' ? 'checked' : '' }}>
                                    <span class="ml-2">Submit for approval</span>
                                </label>
                            </div>
                        </div>
                    @endif
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
                                            <button type="button"
                                                    class="px-3 py-1.5 text-sm bg-red-600 text-white rounded hover:bg-red-700 transition-colors flex items-center mt-1"
                                                onclick="deleteGalleryImage({{ $image->id }})">
                                                    <i class='bx bx-trash mr-2'></i> Delete
                                                </button>
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
                <!-- Right  -->
                <div class="lg:col-span-2 flex flex-col h-full">
                    <div class="flex-1">
                        <x-form.label>Body</x-form.label>
                        <textarea id="editor"
                            class="textarea textarea-bordered w-full h-96 bg-gray-50 border border-gray-200 focus:border-[#ffb51b] focus:ring-2 focus:ring-[#ffb51b]"
                            name="body">{{ old('body', $content->body ?? '') }}</textarea>
                    </div>
                </div>
            </div>

            @include('content.partials.contentReviewComments')

            <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
            <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
            <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
            
            {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
            <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script> --}}

            <script>
                $(document).ready(function () {
                    $('#editor').summernote({
                        height: 300,
                        placeholder: 'Write your content here...',
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'italic', 'underline', 'strikethrough', 'superscript', 'subscript', 'clear']],
                            ['fontname', ['fontname']],
                            ['fontsize', ['fontsize']],
                            ['fontsizeunit', ['fontsizeunit']],
                            ['color', ['color', 'forecolor', 'backcolor']],
                            ['para', ['ul', 'ol', 'paragraph', 'height']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture', 'video', 'hr']],
                            ['view', ['fullscreen', 'codeview', 'help']],
                            ['misc', ['undo', 'redo']],
                            // Example custom button group
                            ['mybutton', ['hello']]
                        ],
                        buttons: {
                            // Example custom button: inserts 'hello' at cursor
                            hello: function (context) {
                                var ui = $.summernote.ui;
                                var button = ui.button({
                                    contents: '<i class="fa fa-child"></i> Hello',
                                    tooltip: 'Insert Hello',
                                    click: function () {
                                        context.invoke('editor.insertText', 'hello');
                                    }
                                });
                                return button.render();
                            }
                        },
                        popover: {
                            image: [
                                ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                                ['remove', ['removeMedia']]
                            ],
                            link: [
                                ['link', ['linkDialogShow', 'unlink']]
                            ],
                            table: [
                                ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                                ['delete', ['deleteRow', 'deleteCol', 'deleteTable']]
                            ],
                            air: [
                                ['color', ['color']],
                                ['font', ['bold', 'underline', 'clear']],
                                ['para', ['ul', 'paragraph']],
                                ['table', ['table']],
                                ['insert', ['link', 'picture']]
                            ]
                        },
                        blockquoteBreakingLevel: 2,
                        styleTags: [
                            'p',
                            { title: 'Blockquote', tag: 'blockquote', className: 'blockquote', value: 'blockquote' },
                            'pre', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'
                        ],
                        fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Merriweather'],
                        fontNamesIgnoreCheck: ['Merriweather'],
                        addDefaultFonts: true,
                        fontSizeUnits: ['px', 'pt', 'em', 'rem'],
                        lineHeights: ['0.5', '0.8', '1.0', '1.2', '1.4', '1.5', '2.0', '3.0'],
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
                            onChange: function (contents, $editable) {
                                $('#editor').val(contents);
                            },
                            // Example advanced callbacks (can be customized or removed)
                            onInit: function() {
                                console.log('Summernote is launched');
                                // Example: show notification in status area
                                $('.note-status-output').html('<div class="alert alert-info">Editor initialized</div>');
                            },
                            onEnter: function() {
                                console.log('Enter/Return key pressed');
                            },
                            onFocus: function() {
                                console.log('Editable area is focused');
                            },
                            onBlur: function() {
                                console.log('Editable area loses focus');
                            },
                            onBlurCodeview: function() {
                                console.log('Codeview area loses focus');
                            },
                            onKeyup: function(e) {
                                console.log('Key is released:', e.keyCode);
                            },
                            onKeydown: function(e) {
                                console.log('Key is downed:', e.keyCode);
                            },
                            onPaste: function(e) {
                                console.log('Called event paste');
                            },
                            onImageLinkInsert: function(url) {
                                var $img = $('<img>').attr({ src: url });
                                $('#editor').summernote('insertNode', $img[0]);
                            }
                        }
                    });

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
        </x-slot>
    </x-navigation-layout.tabs-modern>

    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script type="module" src="{{ asset('js/app.js') }}"></script>

    <!-- Gallery Image Delete Function -->
    <script>
        function deleteGalleryImage(imageId) {
            if (confirm('Are you sure you want to delete this image?')) {
                // Create a temporary form to submit the delete request
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/content/images/${imageId}`;

                // Add CSRF token
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                form.appendChild(csrfToken);

                // Add method override
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                form.appendChild(methodField);

                // Submit the form
                document.body.appendChild(form);
                form.submit();
            }
        }
    </script>
@endsection
