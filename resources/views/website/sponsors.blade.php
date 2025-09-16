@extends('layouts.navbar')

@section('content')
    <section class="relative w-full min-h-screen flex items-center">
        <!-- Background image -->
        <img src="{{ asset('assets/images/bg/sponsors-bg.jpg') }}" alt="Join Youmanitarian International"
            class="absolute inset-0 w-full h-full object-cover">

        <!-- Gradient overlay (dark left -> transparent right) -->
        <div class="absolute inset-0 bg-[#1a2235] bg-opacity-70 backdrop-blur-sm"></div>

        <!-- Content -->
        <div class="relative z-10 max-w-3xl px-6 md:px-12 lg:px-24 text-white">
            <p class="text-base md:text-lg lg:text-xl font-semibold tracking-wider uppercase text-white/90 mb-2">
                Who Supports Us?
            </p>

            <h2 class="text-3xl md:text-5xl lg:text-6xl font-bold leading-snug">
                Sponsor and <span class="text-[#FFB51B]">Partnerships</span>
            </h2>
            <p class="mt-4 text-base md:text-lg lg:text-xl font-medium">
                Make connections, take action and move forward with a community
                built on dedication and mutual growth. Collaborate with us to amplify our impact. Whether you’re an
                individual, organization, or corporate partner,
                your support helps us reach more communities and deliver essential programs effectively.
            </p>

        </div>
    </section>



<section class="w-full bg-white px-6 md:px-16 lg:px-32 py-20">
    <div class="max-w-[1920px] mx-auto flex flex-col lg:flex-row gap-16">

        <!-- Left Text Column -->
        <div class="flex flex-col gap-4 lg:w-1/3">
            <span class="inline-block px-4 py-1.5 bg-sky-950 rounded-full text-white font-semibold text-lg tracking-wide">
                Why Partner With Us
            </span>
            <h2 class="text-4xl md:text-5xl font-bold leading-tight text-zinc-900">
                Benefits for <span class="text-[#FFB51B]">Our Partners</span>
            </h2>
            <p class="text-lg md:text-xl text-zinc-900 leading-relaxed">
                Join a network of like-minded organizations and individuals. Collaborate with us to make a meaningful impact, grow your brand visibility, and contribute to lasting change in the community.
            </p>
        </div>

        <!-- Right Cards Column -->
        <div class="flex flex-1 flex-col md:flex-row gap-6">

            <!-- Card 1 -->
            <div class="flex-1 bg-gradient-to-br from-amber-100 to-amber-300 rounded-3xl p-8 flex flex-col gap-4 shadow-lg hover:scale-105 transition-transform duration-300">
                <i class='bx bx-donate-heart text-5xl text-amber-700'></i>
                <h3 class="text-xl md:text-2xl font-bold text-zinc-900">Amplify Your Impact</h3>
                <p class="text-base md:text-lg text-zinc-800 leading-relaxed">
                    Partnering with us allows your organization to reach communities in need and make a real difference.
                </p>
            </div>

            <!-- Card 2 -->
            <div class="flex-1 bg-gradient-to-br from-sky-100 to-sky-300 rounded-3xl p-8 flex flex-col gap-4 shadow-lg hover:scale-105 transition-transform duration-300">
                <i class='bx bxs-network-chart text-5xl text-sky-700'></i>
                <h3 class="text-xl md:text-2xl font-bold text-zinc-900">Grow Your Network</h3>
                <p class="text-base md:text-lg text-zinc-800 leading-relaxed">
                    Connect with other organizations, thought leaders, and community members who share your vision for positive change.
                </p>
            </div>

            <!-- Card 3 -->
            <div class="flex-1 bg-gradient-to-br from-emerald-100 to-emerald-300 rounded-3xl p-8 flex flex-col gap-4 shadow-lg hover:scale-105 transition-transform duration-300">
                <i class='bx bx-trending-up text-5xl text-emerald-700'></i>
                <h3 class="text-xl md:text-2xl font-bold text-zinc-900">Brand Visibility</h3>
                <p class="text-base md:text-lg text-zinc-800 leading-relaxed">
                    Gain recognition and highlight your support across our events, campaigns, and online platforms.
                </p>
            </div>

        </div>
    </div>
</section>


    <hr class="bg-[#1a2235] h-8 w-full my-8"></hr>

    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 lg:px-24 space-y-16">

            <!-- Our Farm Members -->
            <div class="space-y-8">

                <x-section-title first="Our" second="Farm Members" mb="false"/>
                <p class="text-center text-base md:text-lg text-zinc-600 max-w-4xl mx-auto">
                    Meet our dedicated farm members who help make our agricultural programs a success.
                </p>

               <div class="grid grid-cols-[repeat(auto-fit,minmax(150px,1fr))] gap-12 justify-items-center">
                    <!-- Repeat this card for each member -->
                    <div class="flex flex-col items-center gap-4">
                        <img src="{{ asset('assets/images/bg/fm-bebens.jpg') }}" alt="Member Logo"
                            class="w-32 h-32 object-contain rounded-full border border-gray-200 p-2 bg-white">
                        <div class="text-center">
                            <p class="font-semibold text-zinc-900 text-lg md:text-xl">Beben's Integrated Farm</p>
                            <p class="text-sm text-zinc-500">Casiguran, Aurora</p> <!-- Optional location -->
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-4">
                        <img src="{{ asset('assets/images/bg/fm-ironfarm.jpg') }}" alt="Member Logo"
                            class="w-32 h-32 object-contain rounded-full border border-gray-200 p-2 bg-white">
                        <div class="text-center">
                            <p class="font-semibold text-zinc-900 text-lg md:text-xl">Ironfarm Agri-Tourism and Training
                                Center</p>
                            <p class="text-sm text-zinc-500">Hermosa, Bataan</p>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-4">
                        <img src="{{ asset('assets/images/bg/fm-mit.jpg') }}" alt="Member Logo"
                            class="w-32 h-32 object-contain rounded-full border border-gray-200 p-2 bg-white">
                        <div class="text-center">
                            <p class="font-semibold text-zinc-900 text-lg md:text-xl">Mallonga Institute of Technology</p>
                            <p class="text-sm text-zinc-500">Limay, Bataan</p>
                        </div>
                    </div>

                    <div class="flex flex-col items-center gap-4">
                        <img src="{{ asset('assets/images/bg/fm-tyif.jpg') }}" alt="Member Logo"
                            class="w-32 h-32 object-contain rounded-full border border-gray-200 p-2 bg-white">
                        <div class="text-center">
                            <s- class="font-semibold text-zinc-900 text-lg md:text-xl">Tes-Yoy's Integrated Farm</s->
                            <p class="text-sm text-zinc-500">San Antionio, Nueva Ecija</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Our Partners -->
            <div class="space-y-8">
                <x-section-title first="Our" second="Partners" mb="false" />
                <p class="text-center text-base md:text-lg text-zinc-600 max-w-4xl mx-auto">
                    We collaborate with organizations who share our vision and support our mission.
                </p>

                <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-12 justify-center">
                    <div class="flex flex-col items-center gap-4">
                        <img src="{{ asset('assets/images/bg/sp-clsu.png') }}" alt="Partner Logo"
                            class="w-32 h-32 object-contain rounded-full border border-gray-200 p-2 bg-white">

                    </div>

                    <div class="flex flex-col items-center gap-4">
                        <img src="{{ asset('assets/images/bg/sp-iccem.png') }}" alt="Partner Logo"
                            class="w-32 h-32 object-contain rounded-full border border-gray-200 p-2 bg-white">

                    </div>

                    <div class="flex flex-col items-center gap-4">
                        <img src="{{ asset('assets/images/bg/sp-efarma.png') }}" alt="Partner Logo"
                            class="w-32 h-32 object-contain rounded-full border border-gray-200 p-2 bg-white">

                    </div>

                    <div class="flex flex-col items-center gap-4">
                        <img src="{{ asset('assets/images/bg/sp-geocycle.png') }}" alt="Partner Logo"
                            class="w-32 h-32 object-contain rounded-full border border-gray-200 p-2 bg-white">

                    </div>

                    <div class="flex flex-col items-center gap-4">
                        <img src="{{ asset('assets/images/bg/sp-feu.png') }}" alt="Partner Logo"
                            class="w-32 h-32 object-contain rounded-full border border-gray-200 p-2 bg-white">

                    </div>
                    <div class="flex flex-col items-center gap-4">
                        <img src="{{ asset('assets/images/bg/sp-rmcares.jpg') }}" alt="Partner Logo"
                            class="w-32 h-32 object-contain rounded-full border border-gray-200 p-2 bg-white">

                    </div>
                </div>
            </div>

        </div>
    </section>

@endsection
