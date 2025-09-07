{{-- filepath: resources/views/website/programs.blade.php --}}

@extends('layouts.navbar')

@section('content')
    <section class="relative w-full min-h-screen bg-gray-200 flex flex-col lg:flex-row">

        <div class="relative z-10 flex flex-col justify-center gap-6 px-6 md:px-12 lg:px-24 py-16 lg:py-20 lg:w-1/2">
            <p class="text-base md:text-lg lg:text-xl font-normal text-[#1A2235] tracking-wide uppercase">
                Grow Without Limits
            </p>
            <h2 class="text-3xl md:text-5xl lg:text-6xl font-bold text-[#1A2235] leading-snug">
                Join <span class="text-[#FFB51B]">Youmanitarian International</span> and be one of us!
            </h2>

            <p class="text-base md:text-lg lg:text-xl font-medium text-[#1A2235]">
                Make connections, take action and move forward with a community
                built on dedication and mutual growth.
            </p>

            <button
                class="inline-flex items-center justify-center gap-2 px-5 py-2 bg-[#1A2235] rounded-full shadow-md text-white text-sm md:text-base font-semibold hover:bg-slate-800 transition w-auto self-start">
                JOIN NOW!
                <i class="bx bx-right-arrow-alt text-lg"></i>
            </button>
        </div>

        <div class="lg:w-1/2 h-64 md:h-96 lg:h-auto">
            <img src="https://placehold.co/1176x921" alt="Join Youmanitarian International"
                class="w-full h-full object-cover rounded-tl-2xl lg:rounded-tl-none lg:rounded-bl-2xl" />
        </div>
    </section>


    <section class="w-auto bg-slate-900 rounded-3xl py-10 px-6">
        <div class="container mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 text-center">

            <div>
                <div class="text-4xl md:text-5xl font-bold text-white">{{ $volunteersCount }}</div>
                <div class="text-lg md:text-2xl font-medium text-white">Volunteers</div>
            </div>

            <div>
                <div class="text-4xl md:text-5xl font-bold text-white">{{ $membersCount }}</div>
                <div class="text-lg md:text-2xl font-medium text-white">Members</div>
            </div>

            <div>
                <div class="text-4xl md:text-5xl font-bold text-white">{{ $programsCount }}</div>
                <div class="text-lg md:text-2xl font-medium text-white">Programs</div>
            </div>

            <div>
                <div class="text-4xl md:text-5xl font-bold text-white"></div>
                <div class="text-lg md:text-2xl font-medium text-white">Activities</div>
            </div>
        </div>
    </section>



    <section class="relative w-full bg-white py-20">
        <div class="container mx-auto px-6 lg:px-12">
            <h2 class="text-center text-4xl md:text-6xl font-bold text-black mb-16">
                PROGRAM HIGHLIGHTS
            </h2>

            <div class="space-y-12">
                <!-- Highlight Card -->
                <div class="flex flex-col lg:flex-row items-start gap-10 p-10 rounded-3xl border border-slate-900">
                    <div class="flex-1 text-2xl md:text-3xl font-bold text-black">
                        Clutch the Future
                    </div>
                    <div class="flex-1 text-lg md:text-2xl font-medium text-black">
                        Clutch the Future is our organization’s signature event solely aimed to grow
                        and sustain a mentoring culture in Frederick County. Named Best Charitable Event
                        in Frederick, this event brings together 400+ women who lift each other up.
                    </div>
                    <div class="flex-shrink-0 w-14 h-14 bg-slate-900 rounded-full"></div>
                </div>

                <!-- Another Card -->
                <div class="flex flex-col lg:flex-row items-start gap-10 p-10 rounded-3xl border border-slate-900">
                    <div class="flex-1 text-2xl md:text-3xl font-bold text-black">
                        The W2WM Pop-Up Shop
                    </div>
                    <div class="flex-1 text-lg md:text-2xl font-medium text-black">
                        The destination for savvy fashionistas to find stylish clothing and accessories
                        at amazing prices. Every purchase of our beautiful new and very gently-worn items
                        directly supports our free programs.
                    </div>
                    <div class="flex-shrink-0 w-14 h-14 bg-slate-900 rounded-full"></div>
                </div>

                <!-- Another Card -->
                <div class="flex flex-col lg:flex-row items-start gap-10 p-10 rounded-3xl border border-slate-900">
                    <div class="flex-1 text-2xl md:text-3xl font-bold text-black">
                        Girls Nite Out
                    </div>
                    <div class="flex-1 text-lg md:text-2xl font-medium text-black">
                        A fun night of socializing, dancing, and shopping with friends! This annual event
                        includes pop-up shops from local vendors, music and dancing, door prizes and more.
                    </div>
                    <div class="flex-shrink-0 w-14 h-14 bg-slate-900 rounded-full"></div>
                </div>
            </div>
        </div>
    </section>


    <!-- FAQ Section -->
    <section class="py-16 bg-white">
        <div class="mx-auto max-w-4xl px-6 lg:px-8">
            <h2 class="text-4xl lg:text-5xl font-bold text-center text-balance mb-12">
                <span class="text-primary-custom">Frequently</span>
                <span class="text-accent-custom">Asked Questions</span>
            </h2>

            <div class="space-y-4">
                <!-- FAQ 1 -->
                <div tabindex="0" class="collapse collapse-plus border border-base-300 bg-base-100 rounded-box">
                    <div class="collapse-title text-lg font-semibold">
                        How can I join a program?
                    </div>
                    <div class="collapse-content text-gray-700 leading-relaxed">
                        <p>
                            You can join by registering through our website’s program page. Each program has a “Register” or
                            “Sign Up” button.
                            Simply fill out the form and wait for confirmation from our team.
                        </p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div tabindex="0" class="collapse collapse-plus border border-base-300 bg-base-100 rounded-box">
                    <div class="collapse-title text-lg font-semibold">
                        Are the programs free?
                    </div>
                    <div class="collapse-content text-gray-700 leading-relaxed">
                        <p>
                            Yes, most of our programs are free of charge. However, some may require minimal contributions or
                            materials depending
                            on the nature of the activity. All details are listed in each program description.
                        </p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div tabindex="0" class="collapse collapse-plus border border-base-300 bg-base-100 rounded-box">
                    <div class="collapse-title text-lg font-semibold">
                        Who can participate?
                    </div>
                    <div class="collapse-content text-gray-700 leading-relaxed">
                        <p>
                            Anyone with the passion to serve is welcome to participate! Whether you’re a student,
                            professional, or community member,
                            our programs are open to volunteers, partners, and beneficiaries alike.
                        </p>
                    </div>
                </div>
                <h1>We need to ask Maam Makee kung ano pa mga FAQs</h1>
            </div>
        </div>
    </section>

    <!-- Program Feedback Carousel -->
    <section class="py-16 bg-gray-50">
        <div class="mx-auto max-w-5xl px-6 lg:px-8 text-center">
            <h2 class="text-4xl lg:text-5xl font-bold text-balance mb-12">
                <span class="text-primary-custom">Program</span>
                <span class="text-accent-custom">Feedback</span>
            </h2>

            <div class="carousel w-full rounded-2xl shadow-lg">
                <!-- Slide 1 -->
                <div id="slide1" class="carousel-item relative w-full flex flex-col items-center p-10 bg-white">
                    <p class="text-lg md:text-xl text-gray-700 leading-relaxed max-w-3xl italic">
                        “This program gave me the confidence to step out of my comfort zone and make a real impact in my
                        community.”
                    </p>
                    <h3 class="mt-6 text-lg font-semibold text-gray-900">— Maria Santos, Volunteer</h3>
                    <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
                        <a href="#slide3" class="btn btn-circle">❮</a>
                        <a href="#slide2" class="btn btn-circle">❯</a>
                    </div>
                </div>

                <!-- Slide 2 -->
                <div id="slide2" class="carousel-item relative w-full flex flex-col items-center p-10 bg-white">
                    <p class="text-lg md:text-xl text-gray-700 leading-relaxed max-w-3xl italic">
                        “The workshops were practical and inspiring. I learned skills that I now use every day at work and
                        in life.”
                    </p>
                    <h3 class="mt-6 text-lg font-semibold text-gray-900">— John Dela Cruz, Participant</h3>
                    <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
                        <a href="#slide1" class="btn btn-circle">❮</a>
                        <a href="#slide3" class="btn btn-circle">❯</a>
                    </div>
                </div>

                <!-- Slide 3 -->
                <div id="slide3" class="carousel-item relative w-full flex flex-col items-center p-10 bg-white">
                    <p class="text-lg md:text-xl text-gray-700 leading-relaxed max-w-3xl italic">
                        “Joining this program helped me connect with like-minded people who share the same passion for
                        community service.”
                    </p>
                    <h3 class="mt-6 text-lg font-semibold text-gray-900">— Angela Reyes, Youth Leader</h3>
                    <div class="absolute left-5 right-5 top-1/2 flex -translate-y-1/2 transform justify-between">
                        <a href="#slide2" class="btn btn-circle">❮</a>
                        <a href="#slide1" class="btn btn-circle">❯</a>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="min-h-screen bg-gray-100 py-12 px-4">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-800 mb-8 text-center">Programs</h1>

            {{-- Incoming Programs --}}
            <h2 class="text-2xl font-bold text-[#1a2235] mb-6">Upcoming Programs</h2>
            @forelse($incomingPrograms as $program)
                <div class="bg-white rounded-2xl shadow-lg p-8 mb-8 flex flex-col sm:flex-row items-center gap-8">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-[#1a2235] mb-2">{{ $program->title }}</h2>
                        <div class="text-gray-500 mb-2">
                            {{ \Carbon\Carbon::parse($program->date)->format('F d, Y') }}
                            &middot;
                            {{ \Carbon\Carbon::parse($program->start_time)->format('g:i A') }}
                            @if ($program->end_time)
                                - {{ \Carbon\Carbon::parse($program->end_time)->format('g:i A') }}
                            @endif
                        </div>
                        <div class="text-gray-700 mb-4">{{ $program->description }}</div>
                        <div class="flex items-center gap-2 text-sm text-gray-400">
                            <i class='bx bx-map'></i>
                            <span>{{ $program->location }}</span>
                        </div>
                    </div>
                    <div class="flex-shrink-0">
                        <img src="{{ $program->image_url ?? 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80' }}"
                            alt="Program" class="rounded-xl w-48 h-32 object-cover shadow">
                    </div>
                </div>
            @empty
                <div class="text-center text-gray-500 mb-12">No upcoming programs.</div>
            @endforelse
            {{-- Done Programs --}}
            <h2 class="text-2xl font-bold text-[#1a2235] mb-6 mt-12">Recently Ended Programs</h2>
            @forelse($donePrograms as $program)
                <div class="bg-white rounded-2xl shadow-lg p-8 mb-8 flex flex-col sm:flex-row items-center gap-8">
                    <div class="flex-1">
                        <h2 class="text-2xl font-bold text-[#1a2235] mb-2">{{ $program->title }}</h2>
                        <div class="text-gray-500 mb-2">
                            {{ \Carbon\Carbon::parse($program->date)->format('F d, Y') }}
                            &middot;
                            {{ \Carbon\Carbon::parse($program->start_time)->format('g:i A') }}
                            @if ($program->end_time)
                                - {{ \Carbon\Carbon::parse($program->end_time)->format('g:i A') }}
                            @endif
                        </div>
                        <div class="text-gray-700 mb-4">{{ $program->description }}</div>
                        <div class="flex items-center gap-2 text-sm text-gray-400 mb-4">
                            <i class='bx bx-map'></i>
                            <span>{{ $program->location }}</span>
                        </div>
                        <a href="#feedback-form-{{ $program->id }}"
                            class="inline-block px-5 py-2 rounded-lg bg-[#1a2235] text-white font-semibold shadow hover:bg-[#232b47] transition">View
                            & Submit Feedback</a>
                    </div>
                </div>

                </div>
            @empty
                <div class="text-center text-gray-500">No programs available at the moment.</div>
            @endforelse
        </div>
    </div>


    @foreach ($programs as $program)
        <div class="p-4 bg-white rounded-lg shadow mb-4">
            <div class="flex items-center justify-between">
                <div>
                    <div class="font-semibold">{{ $program->title }}</div>
                    <div class="text-sm text-slate-600">{{ \Carbon\Carbon::parse($program->date)->format('M d, Y') }}
                    </div>
                </div>
                 <button type="button" class="px-3 py-2 rounded-lg bg-primary-custom text-white flex items-center gap-2"
                    onclick="document.getElementById('modal_{{ $program->id }}').showModal()">
                    <i class='bx bx-show'></i> View
                </button>
                @include('programs.modals.program-modal', ['program' => $program])

                <button type="button" class="px-3 py-2 rounded-lg bg-primary-custom text-white flex items-center gap-2"
                    onclick="document.getElementById('guestFeedbackModal_{{ $program->id }}').showModal()">
                    <i class='bx bx-message-dots'></i> Give Feedback
                </button>
                @include('website.modals.guestFeedbackModal', ['program' => $program])
            </div>
        </div>
    @endforeach
@endsection
