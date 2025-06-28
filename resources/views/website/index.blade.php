@extends('layouts.navbar')

@section('content')
<section class="h-screen flex flex-col items-center justify-center text-center px-6 mt-20">
    <h2 class="text-5xl font-extrabold text-gray-800 pt-6">Our Purpose</h2>
    <p class="mt-4 text-gray-600 text-lg max-w-2xl">Get the latest updates and deeper connection with us!</p>
    
    
    @if ($featuredPost)
    <a href="{{ route('website.view-content', $featuredPost->slug) }}" class="container mx-auto px-4 py-8 flex justify-center">
        <div class="w-full md:w-10/12 lg:w-8/12">
            @if ($featuredPost->image_content)
            <img src="{{ \App\Http\Controllers\WebsiteController::getImageUrl($featuredPost->image_content) }}" alt="Featured Content Image" class="w-full h-96 object-cover rounded-2xl">
            @endif
            <div class="pt-6 pl-2 text-left">
                <h2 class="text-3xl font-bold text-gray-800">{{ $featuredPost->title }}</h2>
                <p class="text-sm text-gray-500 mt-2">Published on: {{ $featuredPost->created_at->format('F j, Y') }}</p>
            </div>
        </div>
    </a>
</section>

<div class="container mx-auto px-4 py-6 bg-white flex justify-center">
    <div class="w-9/12">
        @forelse ($latestPosts as $post)
        <hr class="border-gray-300">
        <a href="{{ route('website.view-content', $post->slug) }}" class="block w-11/12 mx-auto no-underline">
            <div class="bg-white flex flex-col md:flex-row items-center w-full hover:bg-gray-200 transition duration-200">
                @if ($post->image_content)
                <img src="{{ \App\Http\Controllers\WebsiteController::getImageUrl($post->image_content) }}" alt="Content Image" class="md:w-1/4 w-full h-40 object-cover">
                @endif
                <div class="p-4 flex flex-col justify-center md:w-3/4">
                    <h2 class="text-lg font-bold text-gray-800">{{ $post->title }}</h2>
                    <p class="text-xs text-gray-500 mt-1">Published on: {{ $post->created_at->format('F j, Y') }}</p>
                </div>
            </div>
        </a>
        @empty
        {{-- This part is already handled by the message below since if latestPosts is empty, featuredPost must also be null --}}
        @endforelse
    </div>
</div>

@else
<div class="text-center py-16">
    <p class="text-gray-500 text-xl">No news or updates have been posted yet. Please check back later!</p>
</div>
@endif

@endsection