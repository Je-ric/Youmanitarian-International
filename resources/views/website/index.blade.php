@extends('layouts.navbar')

@section('content')
    <section class="h-screen flex flex-col items-center justify-center text-center px-6 mt-20">
        <x-section-title first="Our" second="Purpose" />
        <p class="mt-4 text-gray-600 text-lg max-w-2xl">Get the latest updates and deeper connection with us!</p>


        @if ($featuredPost)
            <a href="{{ route('website.view-content', $featuredPost->slug) }}"
                class="container mx-auto px-4 py-8 flex justify-center">
                <div class="w-full md:w-10/12 lg:w-8/12">
                    @if ($featuredPost->image_content)
                        <img src="{{ \App\Http\Controllers\WebsiteController::getImageUrl($featuredPost->image_content) }}"
                            alt="Featured Content Image" class="w-full h-96 object-cover rounded-2xl">
                    @endif
                    <div class="pt-6 pl-2 text-left">
                        <h2 class="text-3xl font-bold text-gray-800">{{ $featuredPost->title }}</h2>
                        <p class="text-sm text-gray-500 mt-2">Published on:
                            {{ $featuredPost->created_at->format('F j, Y') }}</p>
                    </div>
                </div>
            </a>
    </section>

    <div class="container mx-auto px-4 py-6 bg-white flex justify-center">
        <div class="w-9/12">
            @forelse ($latestPosts as $post)
                <hr class="border-gray-300">
                <a href="{{ route('website.view-content', $post->slug) }}" class="block w-11/12 mx-auto no-underline">
                    <div
                        class="bg-white flex flex-col md:flex-row items-center w-full hover:bg-gray-200 transition duration-200">
                        @if ($post->image_content)
                            <img src="{{ \App\Http\Controllers\WebsiteController::getImageUrl($post->image_content) }}"
                                alt="Content Image" class="md:w-1/4 w-full h-40 object-cover">
                        @endif
                        <div class="p-4 flex flex-col justify-center md:w-3/4">
                            <h2 class="text-lg font-bold text-gray-800">{{ $post->title }}</h2>
                            <p class="text-xs text-gray-500 mt-1">Published on: {{ $post->created_at->format('F j, Y') }}
                            </p>
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

    <div class="bg-[#1A2235] py-4">
        <ul class="flex flex-row items-center justify-evenly">
            <li class="flex flex-col items-center justify-center px-6 text-white font-bold text-2xl leading-tight">
                <span>Quick</span>
                <span>Links</span>
            </li>
            <span class="w-px h-12 bg-gray-500"></span>

            <li class="flex items-center justify-center px-6">
                <a href="#" class="text-gray-300 hover:text-white transition">Programs</a>
            </li>

            <span class="w-px h-12 bg-gray-500"></span>

            <li class="flex items-center justify-center px-6">
                <a href="#" class="text-gray-300 hover:text-white transition">About Us</a>
            </li>

            <span class="w-px h-12 bg-gray-500"></span>

            <li class="flex items-center justify-center px-6">
                <a href="#" class="text-gray-300 hover:text-white transition">Meet the Team</a>
            </li>
        </ul>
    </div>

    <section
        class="w-full min-h-[700px] px-6 md:px-16 lg:px-40 pt-12 md:pt-16 lg:pt-20 pb-4 bg-[url('/assets/images/bg/BG-1.png')] bg-auto relative">
        {{-- <div class="absolute inset-0 bg-gray-800/40"></div> --}}

        <div class="relative flex flex-col justify-center items-start h-full w-full text-left gap-6">
            <div class="max-w-5xl">
                <p class="text-black text-2xl md:text-3xl lg:text-4xl font-normal mb-4">Be one of us!</p>
                <h2 class="text-3xl md:text-5xl lg:text-6xl font-bold text-black inline">
                    In <span class="text-amber-400">Youmanitarian International</span>
                </h2>
                <p class="mt-6 text-black text-lg md:text-xl lg:text-2xl font-normal leading-relaxed">
                    We believe that every helping hand can change a life.<br />
                    Whether you have time, skills, or simply the will to help, there’s a place for you here.
                </p>
            </div>

            <button
                class="px-4 md:px-5 py-2 md:py-3 bg-sky-950 rounded-full inline-flex items-center gap-4 hover:bg-sky-900 transition">
                <span class="text-white text-base md:text-lg font-bold leading-tight">
                    Become a Volunteer
                </span>
                <span class="w-8 h-8 bg-gray-100/20 rounded-full flex items-center justify-center">
                    <i class="bx bx-right-arrow-alt text-white text-lg md:text-xl"></i>
                </span>
            </button>

        </div>
    </section>





@endsection
