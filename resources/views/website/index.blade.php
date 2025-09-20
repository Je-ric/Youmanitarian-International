@extends('layouts.navbar')

@section('content')
    <section class="bg-[#1a2235] h-screen flex flex-col items-center justify-center text-center px-6">
        <x-section-title first="Our" second="Purpose" mb="false" firstColor="#FFFFFF" />
        <p class="mt-4 text-white text-lg max-w-2xl">Get the latest updates and deeper connection with us!</p>


        @if (is_object($featuredPost))
            <a href="{{ route('website.view-content', $featuredPost->slug) }}"
                class="container mx-auto px-4 py-8 flex justify-center">
                <div class="w-full md:w-10/12 lg:w-8/12">
                    @if ($featuredPost->image_content)
                        <img src="{{ \App\Http\Controllers\WebsiteController::getImageUrl($featuredPost->image_content) }}"
                            alt="Featured Content Image"
                            class="w-full h-96 object-cover rounded-2xl shadow-2xl hover:scale-105 transition-transform duration-500">
                    @endif
                    <div class="pt-6 pl-2 text-left">
                        <h2 class="text-3xl font-bold text-[#FFB51B]">{{ $featuredPost->title }}</h2>
                        <p class="text-sm text-white mt-2">Published on:
                            {{ $featuredPost->created_at->format('F j, Y') }}</p>

                        <div class="mt-4 flex flex-wrap items-center gap-2">
                            <x-feedback-status.status-indicator :status="$featuredPost->content_type"
                                :label="ucfirst($featuredPost->content_type)" />
                        </div>
                    </div>
                </div>
            </a>
    </section>

    <div class="container mx-auto px-4 py-6 bg-white flex justify-center">
        <div class="w-9/12">

            @forelse ($latestPosts as $post)
                <div class="py-4"> {{-- gives spacing inside --}}
                    <a href="{{ route('website.view-content', $post->slug) }}" class="block w-11/12 mx-auto no-underline">
                        <div
                            class="bg-white flex flex-col mx-3 md:flex-row items-center w-full hover:bg-gray-200 transition duration-200">
                            @if ($post->image_content)
                                <img src="{{ \App\Http\Controllers\WebsiteController::getImageUrl($post->image_content) }}"
                                    alt="Content Image" class="md:w-1/4 w-full h-40 object-cover">
                            @endif
                            <div class="p-4 flex flex-col justify-center md:w-3/4">
                                <h2 class="text-lg font-bold text-gray-800">{{ $post->title }}</h2>
                                <p class="text-xs text-gray-500 mt-1">Published on:
                                    {{ $post->created_at->format('F j, Y') }}</p>

                                <p class="mt-2">
                                    <x-feedback-status.status-indicator :status="$post->content_type"
                                        :label="ucfirst($post->content_type)" />
                                </p>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- divider (only between items, not after the last one) --}}
                @if (!$loop->last)
                    <hr class="border-gray-300 my-4 w-11/12 mx-auto">
                @endif

            @empty
                {{-- already handled --}}
            @endforelse

        </div>
    </div>
@else
    <div class="text-center py-16">
        <p class="text-gray-500 text-xl">No news or updates have been posted yet. Please check back later!</p>
    </div>
    @endif



{{-- ===================================================================================== --}}
    <section class="relative w-full min-h-screen flex items-center">

        <img src="{{ asset('assets/images/bg/index.jpg') }}" alt="Join Youmanitarian International"
            class="absolute inset-0 w-full h-full object-cover">

        <div class="absolute inset-0 bg-gradient-to-r from-[#1a2235]/80 via-[#1a2235]/50 to-transparent"></div>

        <div class="relative z-10 max-w-3xl px-6 md:px-12 lg:px-24 text-white">
            <div class="max-w-5xl">
                <p class="text-2xl md:text-3xl lg:text-4xl font-normal mb-4">Be one of us!</p>
                <h2 class="text-3xl md:text-5xl lg:text-6xl font-bold inline">
                    In <span class="text-[#FFB51B]">Youmanitarian International</span>
                </h2>
                <p class="mt-6 text-lg md:text-xl lg:text-2xl font-normal leading-relaxed">
                    We believe that every helping hand can change a life.<br />
                    Whether you have time, skills, or simply the will to help, there’s a place for you here.
                </p>
            </div>

            <div class="mt-8">
                <x-button href="{{ route('login') }}" variant="primary-outline">
                    Become a Volunteer
                    <span class="w-8 h-8 bg-gray-100/20 rounded-full flex items-center justify-center">
                        <i class="bx bx-right-arrow-alt text-white text-lg md:text-xl"></i>
                    </span>
                </x-button>
            </div>
        </div>
    </section>

@endsection
