@extends('layouts.content_create')

@section('content')
    <style>
        .note-editable h1 {
            font-size: 2em;
            margin: 0.67em 0;
        }

        .note-editable h2 {
            font-size: 1.5em;
            margin: 0.75em 0;
        }

        .note-editable h3 {
            font-size: 1.17em;
            margin: 0.83em 0;
        }

        .note-editable ul,
        .note-editable ol {
            margin-left: 2em;
        }

        .note-editable li {
            list-style-type: inherit;
        }

        .note-editable img {
            max-width: 100%;
            height: auto;
            cursor: move;
        }
    </style>

    <x-page-header icon="bx-file"
                    title="{{ isset($content) ? 'Edit Content' : 'Create New Content' }}"
                    desc="Fill out the form to create or edit content.">

        <div class="flex flex-col sm:flex-row gap-3">
            <x-button href="{{ route('content.index') }}" variant="cancel">
                <i class='bx bx-arrow-back mr-2'></i>
                Back to Content
            </x-button>

            <x-button type="button" variant="info"
                data-drawer-target="drawer-right-example"
                data-drawer-show="drawer-right-example"
                data-drawer-placement="right"
                aria-controls="drawer-right-example">
                <i class='bx bx-search-alt mr-2'></i>
                Review
            </x-button>

            @php
                $authUser = Auth::user();

                // Roles
                $isAdmin = $authUser->hasRole('Admin');
                $isContentManager = $authUser->hasRole('Content Manager');
                $isProgramCoordinator = $authUser->hasRole('Program Coordinator');

                // Content-context
                $owner = isset($content) && $authUser->id === ($content->created_by ?? null);
                $isArchived = isset($content) && $content->content_status === 'archived';
                $isPublished = isset($content) && $content->content_status === 'published';

                // Lock rule
                $lockedPublished = $owner && $isPublished && $isProgramCoordinator && !$isContentManager && !$isAdmin;

                // Review mode
                $reviewMode = $reviewMode ?? false;
                if (isset($content) && (!$owner || $lockedPublished || $isArchived)) {
                    $reviewMode = true;
                }
            @endphp

            {{-- If review mode and user is owner --}}
            @if (($reviewMode ?? false) && isset($content) && $owner && !$lockedPublished)
                @if (!($isArchived ?? false))
                    <x-button variant="primary" href="{{ route('content.edit', $content->id) }}?mode=edit">
                        <i class='bx bx-edit mr-2'></i>
                        Edit This Content
                    </x-button>
                {{-- @else
                    <x-feedback-status.alert variant="flexible" icon="bx bx-info-circle"
                        message="This content is archived. Unarchive to Draft before editing." bgColor="bg-amber-50"
                        textColor="text-amber-700" borderColor="border-amber-200" iconColor="text-amber-600" />
                    <x-button variant="table-action-manage"
                        onclick="document.getElementById('unarchive-modal-{{ $content->id }}').showModal();">
                        <i class='bx bx-archive-out mr-1'></i> Unarchive
                    </x-button>

                    @include('content.modals.unarchiveContentModal', ['content' => $content]) --}}
                @endif
            @endif

            {{-- Show only when creating/editing (not in preview) --}}
            @unless ($reviewMode ?? false)
                <x-button variant="add-create" type="submit" form="contentForm">
                    <i class='bx {{ isset($content) ? 'bx-edit' : 'bx-save' }} mr-2'></i>
                    {{ isset($content) ? 'Update Content' : 'Save Content' }}
                </x-button>
            @endunless
        </div>

    </x-page-header>


    <x-navigation-layout.tabs-modern :tabs="$reviewMode
        ? [['id' => 'preview', 'label' => 'Preview', 'icon' => 'bx-show']]
        : [
            ['id' => 'edit', 'label' => 'Edit', 'icon' => 'bx-edit'],
            ['id' => 'preview', 'label' => 'Preview', 'icon' => 'bx-show'],
        ]" default-tab="{{ $reviewMode ? 'preview' : 'edit' }}"
        :preserve-state="true" class="mb-6">

        <x-slot name="slot_edit">
            @if (!$reviewMode)
                <div class="relative">

                    <form id="contentForm"
                        action="{{ isset($content) ? route('content.update', $content->id) : route('content.store') }}"
                        method="POST" enctype="multipart/form-data">
                        @csrf
                        @if (isset($content))
                            @method('PUT')
                        @endif

                        <div class="grid grid-cols-1 xl:grid-cols-4 gap-6">
                            <div class="xl:col-span-3 space-y-6">
                                <x-overview.card title="Basic Information" icon="bx-edit" variant="elevated">
                                    <x-slot name="slot">
                                        @if (isset($content))
                                            <div class="mb-4 -mt-2">
                                                <x-feedback-status.status-indicator status="{{ $content->approval_status }}" />
                                            </div>
                                        @endif
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div class="md:col-span-2">
                                                <x-form.label for="title">Content Title *</x-form.label>
                                                <x-form.input type="text" name="title" id="title"
                                                    placeholder="Enter your content title..." class="w-full"
                                                    value="{{ old('title', $content->title ?? '') }}" required />
                                            </div>

                                            <div>
                                                <x-form.label for="slug">URL Slug *</x-form.label>
                                                <x-form.input type="text" name="slug" id="slug"
                                                    placeholder="auto-generated-from-title" class="w-full"
                                                    value="{{ old('slug', $content->slug ?? '') }}" required />
                                                <p class="text-xs text-gray-500 mt-1">Auto-generated from title, but you can
                                                    customize it</p>
                                            </div>

                                            <div>
                                                <x-form.label for="content_type">Content Type *</x-form.label>
                                                <select name="content_type" id="content_type"
                                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b]"
                                                    required>
                                                    <option value="">Select content type</option>
                                                    @foreach (['news' => 'News', 'program' => 'Program', 'announcement' => 'Announcement', 'event' => 'Event', 'article' => 'Article', 'blog' => 'Blog'] as $value => $label)
                                                        <option value="{{ $value }}"
                                                            {{ old('content_type', $content->content_type ?? '') == $value ? 'selected' : '' }}>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </x-slot>
                                </x-overview.card>

                                <!-- Editor -->
                                <x-overview.card title="Content Body" icon="bx-text" variant="midnight-header">
                                    <x-slot name="slot">
                                        <div>
                                            <x-form.label for="editor">Content Body *</x-form.label>
                                            <textarea id="editor"
                                                class="w-full h-96 border border-gray-300 rounded-lg focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b]"
                                                name="body" placeholder="Start writing your content...">{{ old('body', $content->body ?? '') }}</textarea>
                                        </div>
                                    </x-slot>
                                </x-overview.card>

                                <!-- Media Gallery -->
                                <x-overview.card title="Media Gallery" icon="bx-images" variant="bordered">
                                    <x-slot name="slot">
                                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                            <div>
                                                <x-form.label for="image">Featured Image</x-form.label>
                                                @if (isset($content) && $content->image_content)
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
                                                <x-form.input-upload name="image" id="image"
                                                    accept="image/png,image/jpeg">
                                                    <div class="text-center">
                                                        <i class='bx bx-cloud-upload text-3xl text-gray-400 mb-2'></i>
                                                        <p class="text-sm text-gray-600">PNG, JPG up to 10MB</p>
                                                        @if (isset($content) && $content->image_content)
                                                            <p class="text-xs text-gray-500 mt-1">Upload new image to replace
                                                                current</p>
                                                        @endif
                                                    </div>
                                                </x-form.input-upload>
                                            </div>

                                            <div>
                                                <x-form.label for="gallery_images">Additional Images</x-form.label>
                                                @if (isset($content) && $content->images && $content->images->count() > 0)
                                                    <div class="mb-4 p-3 bg-gray-50 rounded-lg">
                                                        <p class="text-sm text-gray-600 mb-3">Current gallery
                                                            ({{ $content->images->count() }} images):</p>
                                                        <div class="grid grid-cols-3 gap-2">
                                                            @foreach ($content->images->take(6) as $image)
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
                                                        @if ($content->images->count() > 6)
                                                            <p class="text-xs text-gray-500 mt-2">
                                                                +{{ $content->images->count() - 6 }} more images</p>
                                                        @endif
                                                    </div>
                                                @endif
                                                <x-form.input-upload name="gallery_images[]" id="gallery_images"
                                                    accept="image/png,image/jpeg" multiple>
                                                    <div class="text-center">
                                                        <i class='bx bx-images text-3xl text-gray-400 mb-2'></i>
                                                        <p class="text-sm text-gray-600">Upload multiple images</p>
                                                        <p class="text-xs text-gray-500">PNG, JPG up to 10MB each</p>
                                                    </div>
                                                </x-form.input-upload>
                                            </div>
                                        </div>
                                    </x-slot>
                                </x-overview.card>
                            </div>

                            <div class="xl:col-span-1 space-y-6">
                                <x-overview.card
                                title="Publishing"
                                icon="bx-send"
                                variant="bordered">
                                    <x-slot name="slot">
                                        @php
                                            // Selected (null when archived so nothing is checked)
                                            $oldOrDefault = $isArchived ? null : old('publishing_action', $defaultPublishingAction ?? 'draft');

                                            // options by role
                                            $publishingOptions = ['draft' => 'Save as Draft'];
                                            if ($isProgramCoordinator && !$isAdmin && !$isContentManager) {
                                                $publishingOptions['submitted'] = 'Submit for Approval';
                                            }
                                            if ($isContentManager || $isAdmin) {
                                                $publishingOptions['published'] = 'Publish Directly';
                                            }
                                        @endphp

                                        <x-form.radio-group
                                            name="publishing_action"
                                            :options="$publishingOptions"
                                            :selected="$oldOrDefault"
                                            :inline="false"
                                            :disabled="$isArchived" />

                                        @if ($isArchived)
                                            <p class="text-xs text-gray-500 mt-2">
                                                This content is archived. Unarchive to change publishing options.
                                            </p>
                                        @endif

                                        <button type="button"
                                            onclick="document.getElementById('statusGuideModal').showModal();"
                                            class="mt-3 w-full px-3 py-2 text-xs bg-blue-50 text-blue-700 rounded-lg hover:bg-blue-100 transition-colors">
                                            <i class="bx bx-info-circle mr-1"></i>
                                            View Status Guide
                                        </button>
                                    </x-slot>
                                </x-overview.card>

                                <x-overview.card
                                title="Publishing"
                                icon="bx-send"
                                variant="bordered">
                                    <x-slot name="slot">
                                        <div class="space-y-3">
                                            <x-form.toggle name="enable_likes" :checked="old('enable_likes', $content->enable_likes ?? true)" label="Heart Reactions" />
                                            <x-form.toggle name="enable_comments" :checked="old('enable_comments', $content->enable_comments ?? true)" label="Comments" />
                                            <x-form.toggle name="enable_bookmark" :checked="old('enable_bookmark', $content->enable_bookmark ?? true)" label="Bookmarks" />
                                            <x-form.toggle name="is_featured" :checked="old('is_featured', $content->is_featured ?? false)" label="Featured Content" />
                                        </div>
                                    </x-slot>
                                </x-overview.card>

                                <x-overview.card
                                title="Publishing"
                                icon="bx-send"
                                variant="bordered">
                                    <x-slot name="slot">
                                        <div class="space-y-4">
                                            <x-feedback-status.alert variant="flexible" type="info"
                                                message="Publish date is set automatically when content is published directly or approved."
                                                bgColor="bg-blue-50" textColor="text-blue-700" borderColor="border-blue-200"
                                                icon="bx bx-time-five" />

                                            <div>
                                                <x-form.label for="meta_title" class="text-sm">Meta Title</x-form.label>
                                                <x-form.input type="text" name="meta_title" id="meta_title"
                                                    class="w-full" placeholder="SEO title..."
                                                    value="{{ old('meta_title', $content->meta_title ?? '') }}" />
                                            </div>

                                            <div>
                                                <x-form.label for="meta_description" class="text-sm">Meta Description</x-form.label>
                                                <textarea name="meta_description" id="meta_description" rows="3"
                                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-[#ffb51b] focus:border-[#ffb51b]"
                                                    placeholder="SEO description...">{{ old('meta_description', $content->meta_description ?? '') }}</textarea>
                                            </div>
                                        </div>
                                    </x-slot>
                                </x-overview.card>

                                <x-overview.card
                                title="Publishing"
                                icon="bx-send"
                                variant="bordered">
                                    <x-slot name="slot">
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
                                    </x-slot>
                                </x-overview.card>
                            </div>
                        </div>
                    </form>

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
                'gallery_images' =>
                    isset($content) && $content->images ? $content->images->pluck('image_path')->toArray() : [],
                'content' => $content ?? null,
                'reviewMode' => $reviewMode,
            ])

            {{-- @include('content.partials.contentReviewComments') --}}
        </x-slot>
    </x-navigation-layout.tabs-modern>

    {{-- global for DOM --}}
    @include('content.partials.contentReviewComments')
    @include('content.modals.statusGuideModal')

    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote-lite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.1/dist/flowbite.min.js"></script>
    @vite('resources/js/summernote.js')


@endsection
