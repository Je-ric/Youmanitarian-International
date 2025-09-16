@php
    use Illuminate\Support\Facades\Auth;
    $viewer = Auth::user();
    $isManager = $viewer && $viewer->hasRole('Content Manager');
    $isOwner = isset($content) && $viewer && $viewer->id === $content->created_by;
    $approval = $content->approval_status ?? null;
    $cStatus = $content->content_status ?? null;
@endphp

<div class="flex flex-col">
    <div class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-gray-200 px-6 sm:px-8 py-4 flex flex-wrap items-center gap-3">
        <div class="flex items-center gap-2 text-sm">
            @if ($cStatus)
                <x-feedback-status.status-indicator status="{{ $cStatus }}"
                    label="Status: {{ ucfirst(str_replace('_', ' ', $cStatus)) }}" />
            @endif
            @if ($approval)
                <x-feedback-status.status-indicator status="{{ $approval }}"
                    label="Approval: {{ ucfirst(str_replace('_', ' ', $approval)) }}" />
            @endif
        </div>

        <div class="flex items-center gap-2 ml-auto flex-wrap">
            @if ($cStatus === 'archived')

                <x-feedback-status.alert variant="flexible"
                        icon="bx bx-info-circle"
                        message="This content is archived. Unarchive to Draft before editing."
                        bgColor="bg-amber-50"
                        textColor="text-amber-700"
                        borderColor="border-amber-200"
                        iconColor="text-amber-600" />

                <x-button variant="table-action-manage" size="sm" class="tooltip" data-tip="Unarchive"
                    onclick="document.getElementById('unarchive-modal-{{ $content->id }}').showModal(); return false;">
                    <i class='bx bx-archive-out'></i> Unarchive
                </x-button>
                @include('content.modals.unarchiveContentModal', ['content' => $content])

            @elseif (in_array($approval, ['pending', 'submitted']))

                <x-button variant="success" size="sm" class="tooltip" data-tip="Approve & Publish"
                    onclick="document.getElementById('approve-modal-{{ $content->id }}').showModal(); return false;">
                    <i class='bx bx-check-circle'></i> Approve & Publish
                </x-button>

                <x-button variant="warning" size="sm" class="tooltip" data-tip="Needs Revision"
                    onclick="document.getElementById('needs-revision-modal-{{ $content->id }}').showModal(); return false;">
                    <i class='bx bx-edit-alt'></i> Needs Revision
                </x-button>

                @include('content.modals.approveContentModal', ['content' => $content])
                @include('content.modals.needsRevisionModal', ['content' => $content])

            @elseif ($cStatus === 'published' && $approval === 'approved')

                <x-button variant="table-action-view" size="sm" class="tooltip" data-tip="Archive"
                    onclick="document.getElementById('archive-modal-{{ $content->id }}').showModal(); return false;">
                    <i class='bx bx-archive'></i> Archive
                </x-button>
                @include('content.modals.archiveContentModal', ['content' => $content])

            @endif
        </div>
    </div>


    {{-- Main Preview (mirrors website.view-content structure) --}}
    @php
        $hasImage = isset($image_content) && $image_content;
        $displayTitle = isset($title) && $title ? $title : null;
        $displayDate = now()->format('F j, Y');
        $authorName = optional($viewer)->name ?? 'Preview User';
        $isFeatured = isset($is_featured) && $is_featured;
        $contentType = isset($content_type) ? $content_type : null;
    @endphp


    {{-- px-20 == 80px and since may tabs-modern (24px) - 80-24 = 56 --}}
    {{-- Kinomment ko lang, kase nakakaproud HAHAHAHAHA --}}
    @if ($hasImage)
        <div class="relative w-full h-[80vh] sm:h-[90vh] lg:h-[100vh] flex items-center justify-center overflow-hidden">
            <div class="absolute inset-0 w-full h-full overflow-hidden">
                <img src="{{ asset('storage/' . $image_content) }}" alt="Content Image" class="w-full h-full object-cover filter blur-sm">
            </div>

            <div class="absolute inset-0 bg-[#1a2235] bg-opacity-80 backdrop-blur-sm"></div>

            <div class="relative z-10 text-center px-6 sm:px-12">
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-[#ffb51b] leading-tight">
                    {{ $displayTitle ?? 'Untitled Content' }}
                </h1>
                <div class="mt-2 text-white text-sm sm:text-base">
                    <i class='bx bx-calendar mr-1'></i> {{ $displayDate }}
                </div>
            </div>

            <div class="absolute bottom-6 left-6 flex flex-col gap-2 text-white text-sm sm:text-base">
                <div class="flex items-center gap-2">
                    <i class='bx bx-user'></i>
                    <span>By {{ $authorName }}</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class='bx bx-show'></i>
                    <span>0 views</span>
                </div>
            </div>

            <div class="absolute bottom-6 right-6 flex flex-wrap justify-end items-center gap-3">
                @if ($contentType)
                    <x-feedback-status.status-indicator :status="$contentType" :label="ucfirst($contentType)" />
                @endif
                @if ($isFeatured)
                    <x-feedback-status.status-indicator status="info" icon="bx bx-star" label="Featured" />
                @endif
            </div>
        </div>
    @endif

    <div class="flex flex-col xl:flex-row gap-6 lg:gap-8 bg-white px-10 py-4">
        <article class="xl:w-2/3">
            <div class="overflow-hidden">
                <div class="sm:px-8 lg:px-16 pt-10 pb-6 sm:pb-8">
                    <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed">
                        @if (isset($body) && $body)
                            {!! $body !!}
                        @else
                            <div class="space-y-4">
                                <div class="h-4 bg-gray-200 rounded animate-pulse"></div>
                                <div class="h-4 bg-gray-200 rounded animate-pulse w-3/4"></div>
                                <div class="h-4 bg-gray-200 rounded animate-pulse w-1/2"></div>
                                <div class="h-4 bg-gray-200 rounded animate-pulse w-5/6"></div>
                                <div class="h-4 bg-gray-200 rounded animate-pulse w-2/3"></div>
                            </div>
                        @endif
                    </div>
                </div>

                @if ($hasImage)
                    <div class="px-6 sm:px-8 lg:px-10 pb-6 sm:pb-8">
                        <img src="{{ asset('storage/' . $image_content) }}" alt="Featured Image" class="w-full h-auto max-h-[80vh] object-contain rounded-md shadow-lg">
                    </div>
                @endif

                <div class="px-6 sm:px-8 lg:px-10 pb-6 sm:pb-8">
                    <div class="border-t border-gray-200 pt-6 sm:pt-8">
                        <h3 class="text-xl sm:text-2xl font-semibold text-[#1a2235] mb-6 flex items-center gap-2">
                            <i class='bx bx-image text-[#ffb51b]'></i>
                            Gallery
                        </h3>
                        @if (isset($gallery_images) && count($gallery_images) > 0)
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                                @foreach ($gallery_images as $image)
                                    <div class="group relative overflow-hidden cursor-pointer transform hover:scale-105 transition-all duration-300" onclick="openImageModal({{ $loop->index }})">
                                        <img src="{{ asset('storage/' . $image) }}" class="w-full h-24 sm:h-32 lg:h-40 object-cover" alt="Gallery Image {{ $loop->iteration }}">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                            <i class='bx bx-expand text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300'></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                                @for ($i = 0; $i < 4; $i++)
                                    <div class="w-full h-24 sm:h-32 lg:h-40 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center border-2 border-dashed border-gray-300">
                                        <div class="text-center">
                                            <i class='bx bx-image text-2xl text-gray-400 mb-1'></i>
                                            <p class="text-gray-400 text-xs">Gallery Image</p>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        @endif
                    </div>
                </div>

                @if ((isset($enable_likes) && $enable_likes) || (isset($enable_comments) && $enable_comments) || (isset($enable_bookmark) && $enable_bookmark))
                    <div class="px-6 sm:px-8 lg:px-10 py-6 border-t border-gray-200 bg-gray-50">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center gap-6">
                                @if (isset($enable_likes) && $enable_likes)
                                    <button class="flex items-center gap-2 text-gray-600 hover:text-red-500 transition-colors duration-200 group">
                                        <i class='bx bx-heart text-xl group-hover:text-red-500'></i>
                                        <span class="font-medium">0</span>
                                    </button>
                                @endif
                                @if (isset($enable_comments) && $enable_comments)
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <i class='bx bx-comment text-xl'></i>
                                        <span class="font-medium">0</span>
                                        <span class="text-sm">Comments</span>
                                    </div>
                                @endif
                            </div>
                            @if (isset($enable_bookmark) && $enable_bookmark)
                                <button class="flex items-center gap-2 text-gray-600 hover:text-[#ffb51b] transition-colors duration-200">
                                    <i class='bx bx-bookmark text-xl'></i>
                                    <span class="font-medium text-sm">Bookmark</span>
                                </button>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </article>

        <aside class="xl:w-1/3">
            <div class="bg-white border border-gray-200 sticky top-6 max-h-[calc(100vh-3rem)] overflow-hidden">
                <div class="p-6 border-b border-gray-200">
                    <h2 class="text-xl font-semibold text-[#1a2235] flex items-center gap-2">
                        <i class='bx bx-collection text-[#ffb51b]'></i>
                        Related Content
                    </h2>
                </div>
                <div class="overflow-y-auto max-h-[calc(100vh-12rem)]">
                    <div class="p-6 space-y-4">
                        @for ($i = 0; $i < 3; $i++)
                            <div class="p-4 border border-gray-200">
                                <div class="flex gap-4">
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 flex-shrink-0 bg-gray-100 flex items-center justify-center">
                                        <i class='bx bx-image text-xl text-gray-400'></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="h-4 bg-gray-200 rounded animate-pulse mb-2"></div>
                                        <div class="h-3 bg-gray-200 rounded animate-pulse w-1/2"></div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
        </aside>
    </div>

    <!-- Image Preview Modal -->
    <div id="imageModal" class="fixed inset-0 items-center justify-center bg-black bg-opacity-90 hidden z-50 p-4">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white text-2xl sm:text-3xl hover:text-[#ffb51b] transition-colors z-10 w-10 h-10 flex items-center justify-center bg-black bg-opacity-50">
            <i class='bx bx-x'></i>
        </button>
        <button onclick="prevImage()" class="absolute left-4 top-1/2 transform -translate-y-1/2 text-white text-2xl sm:text-3xl hover:text-[#ffb51b] transition-colors z-10 w-10 h-10 flex items-center justify-center bg-black bg-opacity-50">
            <i class='bx bx-chevron-left'></i>
        </button>
        <img id="modalImage" class="w-full h-full max-w-full max-h-full object-contain" src="/placeholder.svg" alt="Preview">
        <button onclick="nextImage()" class="absolute right-4 top-1/2 transform -translate-y-1/2 text-white text-2xl sm:text-3xl hover:text-[#ffb51b] transition-colors z-10 w-10 h-10 flex items-center justify-center bg-black bg-opacity-50">
            <i class='bx bx-chevron-right'></i>
        </button>
    </div>

    <script>
        let galleryImages = [
            @if (isset($gallery_images) && count($gallery_images) > 0)
                @foreach ($gallery_images as $image)
                    "{{ asset('storage/' . $image) }}",
                @endforeach
            @endif
        ];
        let currentIndex = 0;

        function openImageModal(index) {
            currentIndex = index;
            const modal = document.getElementById('imageModal');
            document.getElementById('modalImage').src = galleryImages[currentIndex] || '';
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        function closeImageModal() {
            document.getElementById('imageModal').classList.add('hidden');
            document.body.style.overflow = 'auto';
        }

        function prevImage() {
            if (!galleryImages.length) return;
            currentIndex = (currentIndex > 0) ? currentIndex - 1 : galleryImages.length - 1;
            document.getElementById('modalImage').src = galleryImages[currentIndex];
        }

        function nextImage() {
            if (!galleryImages.length) return;
            currentIndex = (currentIndex < galleryImages.length - 1) ? currentIndex + 1 : 0;
            document.getElementById('modalImage').src = galleryImages[currentIndex];
        }

        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeImageModal();
            }
        });
    </script>
</div>
