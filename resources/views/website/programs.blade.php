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


   <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4">
    <div class="max-w-7xl mx-auto">
        <!-- Enhanced header with better typography and spacing -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-[#1a2235] mb-4">Our Programs</h1>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">Discover our upcoming events and share your feedback on completed programs</p>
        </div>

        <!-- Calendar-like grid layout for upcoming programs -->
        <div class="mb-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-[#1a2235] flex items-center gap-3">
                    <i class='bx bx-calendar text-[#FFB51B]'></i>
                    Upcoming Programs
                </h2>
                <div class="text-sm text-gray-500 bg-white px-4 py-2 rounded-full shadow-sm">
                    {{ count($incomingPrograms) }} Events Scheduled
                </div>
            </div>

            <!-- Responsive grid layout that looks more calendar-like -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($incomingPrograms as $program)
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <!-- Image with hover effect -->
                        <div class="relative overflow-hidden h-48">
                            <img src="{{ $program->image_url ?? 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80' }}"
                                alt="{{ $program->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            <div class="absolute top-4 right-4 bg-[#FFB51B] text-[#1a2235] px-3 py-1 rounded-full text-sm font-semibold">
                                {{ \Carbon\Carbon::parse($program->date)->format('M d') }}
                            </div>
                        </div>

                        <!-- Better organized content with consistent spacing -->
                        <div class="p-6">
                            <h3 class="text-xl font-bold text-[#1a2235] mb-3 line-clamp-2">{{ $program->title }}</h3>

                            <!-- Time and location info with icons -->
                            <div class="space-y-2 mb-4">
                                <div class="flex items-center gap-2 text-gray-600 text-sm">
                                    <i class='bx bx-time text-[#FFB51B]'></i>
                                    <span>{{ \Carbon\Carbon::parse($program->start_time)->format('g:i A') }}
                                    @if ($program->end_time)
                                        - {{ \Carbon\Carbon::parse($program->end_time)->format('g:i A') }}
                                    @endif</span>
                                </div>
                                <div class="flex items-center gap-2 text-gray-600 text-sm">
                                    <i class='bx bx-map text-[#FFB51B]'></i>
                                    <span>{{ $program->location }}</span>
                                </div>
                            </div>

                            <p class="text-gray-700 text-sm mb-6 line-clamp-3">{{ $program->description }}</p>

                            <!-- Action buttons for upcoming programs -->
                            <div class="flex gap-3">
                                <button type="button"
                                    class="flex-1 px-4 py-2 bg-[#1a2235] text-white rounded-lg hover:bg-[#232b47] transition-colors duration-200 flex items-center justify-center gap-2 text-sm font-medium"
                                    onclick="document.getElementById('modal_{{ $program->id }}').showModal()">
                                    <i class='bx bx-show'></i> View Details
                                </button>
                                <button class="px-4 py-2 border-2 border-[#FFB51B] text-[#FFB51B] rounded-lg hover:bg-[#FFB51B] hover:text-[#1a2235] transition-colors duration-200 flex items-center gap-2 text-sm font-medium">
                                    <i class='bx bx-bookmark'></i> Save
                                </button>
                            </div>
                        </div>
                    </div>
                    @include('programs.modals.program-modal', ['program' => $program])
                @empty
                    <div class="col-span-full text-center py-16">
                        <i class='bx bx-calendar-x text-6xl text-gray-300 mb-4'></i>
                        <p class="text-xl text-gray-500">No upcoming programs scheduled</p>
                        <p class="text-gray-400 mt-2">Check back soon for new events!</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Enhanced completed programs section -->
        <div class="mb-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-[#1a2235] flex items-center gap-3">
                    <i class='bx bx-check-circle text-[#FFB51B]'></i>
                    Recently Completed Programs
                </h2>
                <div class="text-sm text-gray-500 bg-white px-4 py-2 rounded-full shadow-sm">
                    {{ count($donePrograms) }} Programs Completed
                </div>
            </div>

            <!-- Grid layout for completed programs with feedback focus -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @forelse($donePrograms as $program)
                    <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300 overflow-hidden group">
                        <div class="flex flex-col sm:flex-row">
                            <!-- Image section with completed badge -->
                            <div class="relative sm:w-1/3 h-48 sm:h-auto overflow-hidden">
                                <img src="{{ $program->image_url ?? 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80' }}"
                                    alt="{{ $program->title }}"
                                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute top-4 left-4 bg-green-500 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    Completed
                                </div>
                            </div>

                            <!-- Content section with feedback emphasis -->
                            <div class="flex-1 p-6">
                                <h3 class="text-lg font-bold text-[#1a2235] mb-2">{{ $program->title }}</h3>

                                <div class="flex items-center gap-2 text-gray-500 text-sm mb-3">
                                    <i class='bx bx-calendar'></i>
                                    <span>{{ \Carbon\Carbon::parse($program->date)->format('F d, Y') }}</span>
                                </div>

                                <p class="text-gray-700 text-sm mb-4 line-clamp-2">{{ $program->description }}</p>

                                <!-- Feedback-focused action buttons -->
                                <div class="space-y-3">
                                    <button type="button"
                                        class="w-full px-4 py-3 bg-[#FFB51B] text-[#1a2235] rounded-lg hover:bg-[#e6a319] transition-colors duration-200 flex items-center justify-center gap-2 font-semibold"
                                        onclick="document.getElementById('guestFeedbackModal_{{ $program->id }}').showModal()">
                                        <i class='bx bx-message-dots'></i> Share Your Feedback
                                    </button>
                                    <button type="button"
                                        class="w-full px-4 py-2 border border-[#1a2235] text-[#1a2235] rounded-lg hover:bg-[#1a2235] hover:text-white transition-colors duration-200 flex items-center justify-center gap-2 text-sm"
                                        onclick="document.getElementById('modal_{{ $program->id }}').showModal()">
                                        <i class='bx bx-show'></i> View Program Details
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @include('programs.modals.program-modal', ['program' => $program])
                    @include('website.modals.guestFeedbackModal', ['program' => $program])
                @empty
                    <div class="col-span-full text-center py-16">
                        <i class='bx bx-history text-6xl text-gray-300 mb-4'></i>
                        <p class="text-xl text-gray-500">No completed programs yet</p>
                        <p class="text-gray-400 mt-2">Completed programs will appear here</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- All Programs section with enhanced layout -->
        @if(isset($programs) && count($programs) > 0)
        <div>
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-2xl md:text-3xl font-bold text-[#1a2235] flex items-center gap-3">
                    <i class='bx bx-list-ul text-[#FFB51B]'></i>
                    All Programs
                </h2>
            </div>

            <!-- Improved grid layout for all programs -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($programs as $program)
                    <div class="bg-white rounded-xl shadow-md hover:shadow-lg transition-all duration-300 p-5 group">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h4 class="font-semibold text-[#1a2235] mb-1 line-clamp-2 group-hover:text-[#FFB51B] transition-colors">
                                    {{ $program->title }}
                                </h4>
                                <div class="text-sm text-gray-500 flex items-center gap-1">
                                    <i class='bx bx-calendar-alt text-xs'></i>
                                    {{ \Carbon\Carbon::parse($program->date)->format('M d, Y') }}
                                </div>
                            </div>
                        </div>

                        <div class="flex gap-2">
                            <button type="button"
                                class="flex-1 px-3 py-2 bg-[#1a2235] text-white rounded-lg hover:bg-[#232b47] transition-colors duration-200 flex items-center justify-center gap-1 text-xs font-medium"
                                onclick="document.getElementById('modal_{{ $program->id }}').showModal()">
                                <i class='bx bx-show text-sm'></i> View
                            </button>
                            <button type="button"
                                class="flex-1 px-3 py-2 bg-[#FFB51B] text-[#1a2235] rounded-lg hover:bg-[#e6a319] transition-colors duration-200 flex items-center justify-center gap-1 text-xs font-medium"
                                onclick="document.getElementById('guestFeedbackModal_{{ $program->id }}').showModal()">
                                <i class='bx bx-message-dots text-sm'></i> Feedback
                            </button>
                        </div>
                    </div>
                    @include('programs.modals.program-modal', ['program' => $program])
                    @include('website.modals.guestFeedbackModal', ['program' => $program])
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>


@endsection
