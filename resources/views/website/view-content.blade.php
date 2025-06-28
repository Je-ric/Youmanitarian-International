@extends('layouts.navbar')

@section('content')

<div class="container mx-auto px-4 py-8 flex flex-col lg:flex-row gap-8 mt-20">
    <div class="lg:w-2/3 bg-white rounded-xl shadow-lg p-8">
        <!-- Back  -->
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-[#ffb51b] text-white rounded-lg hover:bg-[#e6a017] transition-colors shadow-md">
            <i class='bx bx-left-arrow-alt'></i> Back
        </a>

        <!-- Content Image -->
        @if ($content->image_content)
        <div class="w-full flex justify-center my-8">
            <img src="{{ \App\Http\Controllers\WebsiteController::getImageUrl($content->image_content) }}" 
                 alt="Content Image" 
                 class="rounded-xl max-h-[500px] w-full object-cover shadow-lg">
        </div>
        @endif

        <!-- Title and Metadata -->
        <h1 class="text-4xl font-bold text-[#1a2235] mt-6">{{ $content->title }}</h1>
        <p class="text-gray-500 mt-2">Published on {{ $content->created_at->format('F j, Y') }} • Views: {{ $content->views }}</p>

        
        <hr class="my-6 border-[#ffb51b]">


{{-- ------------------------------------------------------------------------------------------------- --}}
        <div class="prose prose-lg max-w-none text-gray-800">
            {!! $content->body !!}
        </div>

{{-- ------------------------------------------------------------------------------------------------- --}}
        @if ($galleryImages->isNotEmpty())
        <div class="mt-8">
            <h3 class="text-2xl font-semibold text-[#1a2235] mb-6">Gallery</h3>
            <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                @foreach ($galleryImages as $image)
                <div class="relative overflow-hidden rounded-xl cursor-pointer transform hover:scale-105 transition-transform shadow-md"
                     onclick="openImageModal({{ $loop->index }})">
                    <img src="{{ \App\Http\Controllers\WebsiteController::getImageUrl($image->image_path) }}" 
                         class="w-full h-32 object-cover" 
                         alt="Gallery Image">
                    <div class="absolute inset-0 bg-black bg-opacity-0 hover:bg-opacity-20 transition-all"></div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        
{{-- ------------------------------------------------------------------------------------------------- --}}
        {{-- Heart React and Comment Count --}}
        <div class="mt-6 flex items-center gap-8 border-t-2 border-b-2 border-gray-100 px-3 py-3">
            <div class="flex items-center">
                <button id="heartButton-{{ $content->id }}" 
                        class="text-2xl focus:outline-none transition duration-150 ease-in-out"
                        onclick="toggleReact({{ $content->id }}, '{{ csrf_token() }}')" 
                        data-reacted="{{ auth()->user() && $content->heartReacts->contains('user_id', auth()->id()) ? 'true' : 'false' }}">
                        {{-- Wag laging kalimutan yung tokennnnnnn!!!!!! --}}
                        <i id="heartIcon-{{ $content->id }}" 
                    class="bx {{ auth()->user() && $content->heartReacts->contains('user_id', auth()->id()) ? 'bxs-heart text-gray-600' : 'bx-heart text-red-600' }}">
                    </i>
                </button>
                <span id="heartCount-{{ $content->id }}" class="ml-2 text-lg font-semibold">
                    {{ $content->heartReacts->count() }}
                </span>
            </div>

            <div class="flex items-center">
                <i class='bx bx-comment text-2xl text-gray-600'></i>
                <span id="commentCount-{{ $content->id }}" class="ml-2 text-lg font-semibold">
                    {{ $content->comments->count() }}
                </span>
                <p class="ml-1">Comments</p>
            </div>
        </div>

        
{{-- ------------------------------------------------------------------------------------------------- --}}
        <div class="mt-10">
            <h2 class="text-2xl font-semibold text-[#1a2235] mb-6">Comments</h2>

            @auth
            <form id="comment-form" class="mt-4 flex flex-col gap-4" onsubmit="event.preventDefault(); postComment({{ $content->id }});">
                <div class="relative">
                    <textarea id="comment-input" 
                        class="w-full p-3 pr-16 border-b-2 border-b-gray-300 focus:border-[#ffb51b] focus:border-b-4 focus:ring-0 focus:outline-none focus:shadow-none border-t-0 border-l-0 border-r-0 resize-none transition-all duration-200 overflow-hidden"
                        rows="1" placeholder="Write a comment..." required
                        oninput="autoResizeTextarea(this)"></textarea>
        
                    <div class="absolute right-2 bottom-2 flex items-center gap-2">
                        <button type="button" onclick="toggleEmojiPicker()" class="text-gray-500 hover:text-[#ffb51b] transition-colors">
                            <i class='bx bx-smile text-xl'></i>
                        </button>
                        <button type="submit" class="px-4 py-2 bg-[#ffb51b] text-white rounded-lg hover:bg-[#e6a017] transition-colors">Post</button>
                    </div>
        
                    <div id="emoji-picker" class="hidden absolute z-10 bg-white border border-gray-200 rounded-lg shadow-lg p-4 right-0 top-10">
                        <div class="grid grid-cols-8 gap-2">
                            <span onclick="insertEmoji('😀')" class="cursor-pointer hover:scale-110 transition-transform">😀</span>
                            <span onclick="insertEmoji('😍')" class="cursor-pointer hover:scale-110 transition-transform">😍</span>
                            <span onclick="insertEmoji('😂')" class="cursor-pointer hover:scale-110 transition-transform">😂</span>
                            <span onclick="insertEmoji('😎')" class="cursor-pointer hover:scale-110 transition-transform">😎</span>
                            <span onclick="insertEmoji('😡')" class="cursor-pointer hover:scale-110 transition-transform">😡</span>
                            <span onclick="insertEmoji('🤔')" class="cursor-pointer hover:scale-110 transition-transform">🤔</span>
                            <span onclick="insertEmoji('👍')" class="cursor-pointer hover:scale-110 transition-transform">👍</span>
                            <span onclick="insertEmoji('👏')" class="cursor-pointer hover:scale-110 transition-transform">👏</span>
                        </div>
                    </div>
                </div>
            </form>
            @endauth
        
            <!-- Comment List -->
            <div id="comment-list" class="mt-6 space-y-6">
                @foreach ($content->comments as $comment)
                    @include('website.partials.comment', ['comment' => $comment])
                @endforeach
            </div>
            
        </div>

        <!-- Previous/Next Navigation -->
        <div class="flex justify-between mt-8">
            @if ($prevContent)
                <x-link href="{{ route('website.view-content', $prevContent->slug) }}"
                    variant="nextPrevious">
                    <i class='bx bx-chevron-left'></i> Previous
                </x-link>
            @endif
        
            @if ($nextContent)
                <x-link href="{{ route('website.view-content', $nextContent->slug) }}"
                    variant="nextPrevious">
                    <i class='bx bx-chevron-right'></i> Next
                </x-link>
            @endif
        </div>
    </div>

    <!-- Sidebar Section -->
    <div class="lg:w-1/3 h-full">
        <div class="bg-white rounded-xl shadow-lg p-6 sticky top-20 h-[calc(100vh-6rem)] overflow-y-auto">
            <h2 class="text-2xl font-semibold text-[#1a2235] mb-6">Other Content</h2>
            <ul class="space-y-4">
                @foreach ($otherContents as $item)
                <li>
                    <a href="{{ route('website.view-content', $item->slug) }}" 
                       class="block p-6 rounded-xl hover:shadow-lg transition-all transform hover:-translate-y-1"
                       style="background: linear-gradient(135deg, {{ $loop->index % 2 == 0 ? '#ffb51b' : '#1a2235' }}, {{ $loop->index % 2 == 0 ? '#e6a017' : '#0e1425' }});">
                        <div class="flex items-center gap-4">
                            <!-- Thumbnail -->
                            @if ($item->image_content)
                            <div class="w-16 h-16 flex-shrink-0">
                                <img src="{{ \App\Http\Controllers\WebsiteController::getImageUrl($item->image_content) }}" 
                                     alt="Thumbnail" 
                                     class="w-full h-full object-cover rounded-lg">
                            </div>
                            @else
                            <div class="w-16 h-16 flex-shrink-0 bg-gray-200 rounded-lg flex items-center justify-center">
                                <i class='bx bx-image text-2xl text-gray-500'></i>
                            </div>
                            @endif
    
                            <div>
                                <p class="text-white font-semibold">{{ $item->title }}</p>
                                <p class="text-sm text-gray-200 mt-1">{{ $item->created_at->format('F j, Y') }}</p>
                            </div>
                        </div>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
</div>

<!-- Image Preview Modal -->
<div id="imageModal" class="fixed inset-0 bg-black bg-opacity-80 flex items-center justify-center hidden z-[9999]">
    <button onclick="closeImageModal()" class="absolute top-5 right-5 text-white text-3xl hover:text-[#ffb51b] transition-colors">✖</button>
    <button onclick="prevImage()" class="absolute left-5 text-white text-3xl hover:text-[#ffb51b] transition-colors">
        <i class='bx bx-chevron-left'></i>
    </button>
    <img id="modalImage" class="max-w-full max-h-[90vh] rounded-xl shadow-lg" src="" alt="Preview">
    <button onclick="nextImage()" class="absolute right-5 text-white text-3xl hover:text-[#ffb51b] transition-colors">
        <i class='bx bx-chevron-right'></i>
    </button>
</div>

<script>
    let galleryImages = [
        @foreach ($galleryImages as $image)
            "{{ \App\Http\Controllers\WebsiteController::getImageUrl($image->image_path) }}",
        @endforeach
    ];

    let currentIndex = 0;

    function openImageModal(index) {
        currentIndex = index;
        document.getElementById('modalImage').src = galleryImages[currentIndex];
        document.getElementById('imageModal').classList.remove('hidden');
    }

    function closeImageModal() {
        document.getElementById('imageModal').classList.add('hidden');
    }

    function prevImage() {
        currentIndex = (currentIndex > 0) ? currentIndex - 1 : galleryImages.length - 1;
        document.getElementById('modalImage').src = galleryImages[currentIndex];
    }

    function nextImage() {
        currentIndex = (currentIndex < galleryImages.length - 1) ? currentIndex + 1 : 0;
        document.getElementById('modalImage').src = galleryImages[currentIndex];
    }
</script>
@endsection

<script src="{{ asset('js/toggleReact.js') }}"></script>
{{-- 
@vite(['resources/css/app.css', 'resources/js/app.js']) 
<link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>