<div class="flex flex-col">

    @php
        use Illuminate\Support\Facades\Auth;
        $viewer = Auth::user();
        $isManager = $viewer && $viewer->hasRole('Content Manager');
        $isOwner = isset($content) && $viewer && $viewer->id === $content->created_by;
        $showActionBar = isset($reviewMode, $content) && $reviewMode && $isManager && !$isOwner;
        $approval = $content->approval_status ?? null;
        $cStatus = $content->content_status ?? null;
    @endphp

    @if($showActionBar)
        <div class="sticky top-0 z-30 bg-white/90 backdrop-blur border-b border-gray-200 px-6 sm:px-8 py-4 mb-4 flex flex-wrap items-center gap-3">
            <div class="flex items-center gap-2 text-sm">
                <span class="px-2 py-1 rounded bg-gray-100 text-gray-700 font-medium">
                    Status: {{ ucfirst($cStatus) }}
                </span>
                <span class="px-2 py-1 rounded bg-gray-100 text-gray-700 font-medium">
                    Approval: {{ str_replace('_',' ', ucfirst($approval)) }}
                </span>
            </div>

            <div class="flex items-center gap-2 ml-auto flex-wrap">
                @if(in_array($approval, ['pending','submitted']))
                    <form action="{{ route('content.approve', $content->id) }}" method="POST"
                          onsubmit="return confirm('Approve and publish this content?')">
                        @csrf
                        <x-button type="submit" variant="approve">
                            <i class="bx bx-check-circle text-lg"></i> Approve
                        </x-button>
                    </form>

                    <form action="{{ route('content.needs_revision', $content->id) }}" method="POST"
                          onsubmit="return confirm('Mark as needs revision?')">
                        @csrf
                        <x-button type="submit" variant="warning">
                            <i class="bx bx-edit text-lg"></i> Needs Revision
                        </x-button>
                    </form>

                    {{-- <form action="{{ route('content.reject', $content->id) }}" method="POST"
                          onsubmit="return confirm('Reject this content?')">
                        @csrf
                        <x-button type="submit" variant="danger">
                            <i class="bx bx-x-circle text-lg"></i> Reject
                        </x-button>
                    </form> --}}
                @elseif($approval === 'needs_revision')
                    <form action="{{ route('content.approve', $content->id) }}" method="POST"
                          onsubmit="return confirm('Approve now and publish?')">
                        @csrf
                        <x-button type="submit" variant="approve">
                            <i class="bx bx-check-circle text-lg"></i> Approve
                        </x-button>
                    </form>
                    <form action="{{ route('content.reject', $content->id) }}" method="POST"
                          onsubmit="return confirm('Reject this content?')">
                        @csrf
                        <x-button type="submit" variant="danger">
                            <i class="bx bx-block text-lg"></i> Reject
                        </x-button>
                    </form>
                @elseif($cStatus === 'published' && $approval === 'approved')
                    <form action="{{ route('content.archive', $content->id) }}" method="POST"
                          onsubmit="return confirm('Archive this published content?')">
                        @csrf
                        <x-button type="submit" variant="table-action-archive">
                            <i class="bx bx-archive text-lg"></i> Archive
                        </x-button>
                    </form>
                @elseif($cStatus === 'archived')
                    <span class="text-sm text-gray-500 italic">Archived (no actions)</span>
                @endif
            </div>
        </div>
    @endif

    {{-- px-20 == 80px and since may tabs-modern (24px) - 80-24 = 56 --}}
    {{-- Kinomment ko lang, kase nakakaproud HAHAHAHAHA --}}
    <div class="px-[56px] py-2">
        <div class="pt-16 px-4 sm:px-7">
            <div class="flex flex-col gap-4">

                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-[#1a2235] leading-tight">
                    @if(isset($title) && $title)
                        {{ $title }}
                    @else
                        <div class="h-8 bg-gray-200 rounded animate-pulse"></div>
                    @endif
                </h1>

                <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4 text-sm text-gray-600">
                    <div class="flex items-center gap-2">
                        <i class='bx bx-calendar text-[#ffb51b]'></i>
                        <span>{{ now()->format('F j, Y') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <i class='bx bx-show text-[#ffb51b]'></i>
                        <span>0 views</span>
                    </div>
                </div>

                <div class="flex flex-wrap items-center gap-3">
                    @if(isset($content_type) && $content_type)
                        <span class="inline-flex items-center px-3 py-1 bg-[#ffb51b] text-white text-sm font-semibold">
                            {{ ucfirst($content_type) }}
                        </span>
                    @else
                        <div class="h-6 w-16 bg-gray-200 rounded animate-pulse"></div>
                    @endif

                    @if(isset($is_featured) && $is_featured)
                        <span class="inline-flex items-center px-3 py-1 bg-gradient-to-r from-red-500 to-red-600 text-white text-sm font-semibold">
                            <i class='bx bx-star mr-1'></i> Featured
                        </span>
                    @endif
                </div>

                @if(isset($image_content) && $image_content)
                    <div class="relative">
                        <img src="{{ asset('storage/' . $image_content) }}"
                             alt="Content Image"
                             class="w-full h-48 sm:h-64 lg:h-80 xl:h-96 object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                    </div>
                @else
                    <div class="relative w-full h-48 sm:h-64 lg:h-80 xl:h-96 bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent"></div>
                        <div class="text-center z-10">
                            <i class='bx bx-image text-6xl text-gray-400 mb-2'></i>
                            <p class="text-gray-500 text-sm font-medium">No featured image selected</p>
                            <p class="text-gray-400 text-xs">Upload an image in the Edit tab</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="flex flex-col xl:flex-row gap-6 lg:gap-8 bg-white px-10">
        <article class="xl:w-2/3">
            <div class="overflow-hidden">
                <!-- Article Content -->
                <div class="sm:px-8 lg:px-16 pt-10 pb-6 sm:pb-8">
                    <div class="prose prose-lg max-w-none text-gray-800 leading-relaxed">
                        @if(isset($body) && $body)
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

                <div class="px-6 sm:px-8 lg:px-10 pb-6 sm:pb-8">
                    <div class="border-t border-gray-200 pt-6 sm:pt-8">
                        <h3 class="text-xl sm:text-2xl font-semibold text-[#1a2235] mb-6 flex items-center gap-2">
                            <i class='bx bx-image text-[#ffb51b]'></i>
                            Gallery
                        </h3>
                        @if(isset($gallery_images) && count($gallery_images) > 0)
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                                @foreach($gallery_images as $image)
                                    <div class="group relative overflow-hidden cursor-pointer transform hover:scale-105 transition-all duration-300">
                                        <img src="{{ asset('storage/' . $image) }}"
                                             class="w-full h-24 sm:h-32 lg:h-40 object-cover"
                                             alt="Gallery Image {{ $loop->iteration }}">
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                            <i class='bx bx-expand text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300'></i>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3 sm:gap-4">
                                @for($i = 0; $i < 4; $i++)
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

                @if((isset($enable_likes) && $enable_likes) || (isset($enable_comments) && $enable_comments) || (isset($enable_bookmark) && $enable_bookmark))
                    <div class="px-6 sm:px-8 lg:px-10 py-6 border-t border-gray-200 bg-gray-50">
                        <div class="flex flex-wrap items-center justify-between gap-4">
                            <div class="flex items-center gap-6">
                                @if(isset($enable_likes) && $enable_likes)
                                    <button class="flex items-center gap-2 text-gray-600 hover:text-red-500 transition-colors duration-200 group">
                                        <i class='bx bx-heart text-xl group-hover:text-red-500'></i>
                                        <span class="font-medium">0</span>
                                    </button>
                                @endif

                                @if(isset($enable_comments) && $enable_comments)
                                    <div class="flex items-center gap-2 text-gray-600">
                                        <i class='bx bx-comment text-xl'></i>
                                        <span class="font-medium">0</span>
                                        <span class="text-sm">Comments</span>
                                    </div>
                                @endif
                            </div>

                            @if(isset($enable_bookmark) && $enable_bookmark)
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

                        @for($i = 0; $i < 3; $i++)
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
</div>
