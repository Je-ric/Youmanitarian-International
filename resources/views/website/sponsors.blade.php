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



<section class="w-full bg-white px-6 md:px-16 lg:px-32 py-16">
    <div class="max-w-[1920px] mx-auto flex flex-col lg:flex-row gap-16">

        <!-- Left Text Column -->
        <div class="flex flex-col gap-4 lg:w-1/3">
            <span class="inline-block px-4 py-1.5 bg-sky-950 rounded-full text-white font-semibold text-lg tracking-wide">
                Beneficial
            </span>
            <h2 class="text-4xl md:text-5xl font-bold leading-tight text-zinc-900">
                Beneficial Elements
            </h2>
            <p class="text-lg md:text-xl text-zinc-900 leading-relaxed">
                Powerful tools for your business to increase revenue and productivity.
            </p>
        </div>

        <!-- Right Cards Column -->
        <div class="flex flex-1 flex-col md:flex-row gap-4 md:gap-6">

            <!-- Card 1 -->
            <div class="flex-1 bg-gray-100 rounded-3xl p-6 md:p-8 flex flex-col gap-4">
                <i class='bx bxs-smile text-5xl text-amber-400'></i>
                <h3 class="text-xl md:text-2xl font-bold text-zinc-900">Happy Customers</h3>
                <p class="text-base md:text-lg text-neutral-700 leading-relaxed">
                    Productive agents are happy agents. Provide all the tools and info they need to best serve your customers.
                </p>
            </div>

            <!-- Card 2 -->
            <div class="flex-1 bg-gray-100 rounded-3xl p-6 md:p-8 flex flex-col gap-4">
                <i class='bx bxs-cog text-5xl text-amber-400'></i>
                <h3 class="text-xl md:text-2xl font-bold text-zinc-900">Best Integrations</h3>
                <p class="text-base md:text-lg text-neutral-700 leading-relaxed">
                    Our software handles complex businesses, yet scales effortlessly as you grow.
                </p>
            </div>

            <!-- Card 3 -->
            <div class="flex-1 bg-gray-100 rounded-3xl p-6 md:p-8 flex flex-col gap-4">
                <i class='bx bx-trending-up text-5xl text-amber-400'></i>
                <h3 class="text-xl md:text-2xl font-bold text-zinc-900">Grow Without Problems</h3>
                <p class="text-base md:text-lg text-neutral-700 leading-relaxed">
                    By analyzing diverse datasets and adopting fast technology, we bridge companies with their customers seamlessly.
                </p>
            </div>

        </div>
    </div>
</section>



  <div class="w-full max-w-[1920px] h-auto md:max-h-[700px] px-6 md:px-12 bg-white flex flex-col lg:flex-row justify-start items-center gap-8 md:gap-16 overflow-hidden">

    <!-- Left Image Section -->
    <div class="w-full md:w-[700px] relative flex-shrink-0">
        <img class="w-full h-auto md:h-[700px] object-cover rounded-tr-3xl rounded-br-3xl"
            src="https://placehold.co/839x933" alt="Bridge Illustration" />

        <!-- Overlay Circle Card -->
        <div class="absolute md:left-[500px] md:top-[450px] px-8 py-6 bg-sky-950 rounded-full shadow-lg outline outline-4 outline-white flex flex-col items-center gap-4">

            <!-- Top Icon/Graphic -->
            <div class="p-2 bg-gray-100/20 rounded-full flex justify-center items-center">
                <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center">
                    <!-- Replace with actual icon or SVG -->
                </div>
            </div>

            <!-- Text Content -->
            <div class="text-center">
                <div class="text-white text-4xl md:text-5xl font-bold leading-tight">YOU</div>
                <div class="text-white text-base md:text-lg font-bold leading-loose">Lorem Ipsum</div>
            </div>

        </div>
    </div>

    <!-- Right Text Section -->
    <div class="flex-1 flex flex-col justify-center items-start gap-4 md:gap-6">

        <!-- Heading -->
        <h2 class="text-zinc-900 text-3xl md:text-5xl font-bold leading-snug">
            Building bridges between <span class="text-slate-400">organization and stakeholders</span>
        </h2>

        <!-- Description -->
        <p class="text-zinc-900 text-base md:text-lg font-normal leading-relaxed md:leading-8">
            By evaluating diverse datasets and adopting technology quickly, we bridge the gap between companies and their stakeholders efficiently.
        </p>

        <!-- Call-to-Action Card -->
        <div class="flex items-center gap-4 md:gap-6 px-4 md:px-6 py-2 md:py-3 bg-sky-950 rounded-[60px]">

            <!-- Text inside CTA -->
            <div class="text-white text-base md:text-lg font-bold leading-7">Lorem Ipsum</div>

            <!-- Icon or small graphic -->
            <div class="p-1.5 bg-gray-100/20 rounded-full flex items-center justify-center">
                <div class="w-5 h-5 bg-white rounded-full"></div>
            </div>

        </div>

    </div>
</div>




    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6 md:px-12 lg:px-24 space-y-16">

            <!-- Our Farm Members -->
            <div class="space-y-8">

                <x-section-title first="Our" second="Farm Members" />
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
                <x-section-title first="Our" second="Partners" />
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
