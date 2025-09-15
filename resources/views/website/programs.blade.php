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


    <!-- Stats Section -->
    <section class="w-auto mx-4 bg-[#1A2235] rounded-2xl py-4 px-6">
        <div class="container mx-auto grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
            <div>
                <div class="text-2xl sm:text-3xl font-bold text-white">{{ $volunteersCount }}</div>
                <div class="text-sm sm:text-base text-white">Volunteers</div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-bold text-white">{{ $membersCount }}</div>
                <div class="text-sm sm:text-base text-white">Members</div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-bold text-white">{{ $programsCount }}</div>
                <div class="text-sm sm:text-base text-white">Programs</div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-bold text-white">--</div>
                <div class="text-sm sm:text-base text-white">Activities</div>
            </div>
        </div>
    </section>


    <!-- Program Highlights -->
    <section class="relative max-w-5xl mx-auto bg-white py-8 sm:py-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Title -->
            <x-section-title first="Program" second="Highlights" />

            <div class="space-y-5 sm:space-y-6">
                <!-- Highlight Card -->
                <div
                    class="flex flex-col md:flex-row items-start md:items-center gap-3 sm:gap-5 p-4 sm:p-5 rounded-xl border border-slate-200 shadow-sm">
                    <div class="flex-1 text-lg sm:text-xl font-semibold text-black">
                        Community Empowerment
                    </div>
                    <div class="flex-1 text-sm sm:text-base text-gray-700 leading-relaxed">
                        Our programs strengthen rural communities by supporting farmers, women, and youth.
                        Through workshops, capacity building, and partnerships, we ensure that beneficiaries
                        gain long-term skills and opportunities for sustainable livelihoods.
                    </div>
                    <!-- Icon -->
                    <div
                        class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-primary-custom text-white rounded-full">
                        <i class='bx bx-group text-xl'></i>
                    </div>
                </div>

                <!-- Another Card -->
                <div
                    class="flex flex-col md:flex-row items-start md:items-center gap-3 sm:gap-5 p-4 sm:p-5 rounded-xl border border-slate-200 shadow-sm">
                    <div class="flex-1 text-lg sm:text-xl font-semibold text-black">
                        Volunteer Engagement
                    </div>
                    <div class="flex-1 text-sm sm:text-base text-gray-700 leading-relaxed">
                        Volunteers are at the heart of our mission. We provide structured opportunities
                        for individuals to contribute their skills, log their hours, and participate in
                        initiatives ranging from disaster response to community outreach.
                    </div>
                    <!-- Icon -->
                    <div
                        class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-accent-custom text-white rounded-full">
                        <i class='bx bx-heart text-xl'></i>
                    </div>
                </div>

                <!-- Another Card -->
                <div
                    class="flex flex-col md:flex-row items-start md:items-center gap-3 sm:gap-5 p-4 sm:p-5 rounded-xl border border-slate-200 shadow-sm">
                    <div class="flex-1 text-lg sm:text-xl font-semibold text-black">
                        Impact Stories
                    </div>
                    <div class="flex-1 text-sm sm:text-base text-gray-700 leading-relaxed">
                        We believe in transparency and inspiration. Our platform showcases real stories of
                        transformation from farmers, volunteers, and beneficiaries whose lives have been touched
                        by our work and collective effort.
                    </div>
                    <!-- Icon -->
                    <div
                        class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-slate-900 text-white rounded-full">
                        <i class='bx bx-book-open text-xl'></i>
                    </div>
                </div>
            </div>
        </div>
    </section>







    <!-- Program Feedback Carousel -->
    <section class="py-16 bg-gray-50">
        <div class="mx-auto max-w-5xl px-6 lg:px-8 text-center">

            <x-section-title first="Program" second="Feedback" />

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
                <x-section-title first="Our" second="Programs" />

            <!-- Ongoing -->
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-[#1a2235] flex items-center gap-3">
                    <i class='bx bx-play-circle text-[#FFB51B]'></i> Ongoing Programs
                </h2>
                <div class="text-sm text-gray-500 bg-white px-4 py-2 rounded-full shadow-sm">
                    {{ count($ongoingPrograms) }} Programs Scheduled
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
                @forelse ($ongoingPrograms as $program)
                    <x-overview.card title="{{ $program->title }}" icon="bx-bolt" variant="minimal">
                        <div class="flex items-center justify-between gap-4 text-sm text-gray-600 mb-3">
                            <div class="flex items-center gap-1">
                                <i class='bx bx-calendar text-[#FFB51B]'></i>
                                <span>{{ \Carbon\Carbon::parse($program->date)->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <i class='bx bx-time text-[#FFB51B]'></i>
                                <span>
                                    {{ \Carbon\Carbon::parse($program->start_time)->format('g:i A') }}
                                    @if ($program->end_time)
                                        - {{ \Carbon\Carbon::parse($program->end_time)->format('g:i A') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                            <i class='bx bx-map text-[#FFB51B]'></i>
                            <span>{{ $program->location }}</span>
                        </div>
                        <x-button type="button" variant="secondary" class="w-full text-sm gap-1"
                            onclick="document.getElementById('modal_{{ $program->id }}').showModal()">
                            <i class='bx bx-show'></i>
                            View Details
                        </x-button>
                    </x-overview.card>
                    @include('programs.modals.program-modal', ['program' => $program])
                @empty
                    <x-empty-state icon="bx bx-history" title="No Ongoing Programs"
                        description="Ongoing programs will appear here." size="small" />
                @endforelse
            </div>

            <!-- Upcoming -->
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-[#1a2235] flex items-center gap-3">
                    <i class='bx bx-calendar text-[#FFB51B]'></i> Upcoming Programs
                </h2>
                <div class="text-sm text-gray-500 bg-white px-4 py-2 rounded-full shadow-sm">
                    {{ count($incomingPrograms) }} Programs Scheduled
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
                @forelse($incomingPrograms as $program)
                    <x-overview.card title="{{ $program->title }}" icon="bx-calendar-event" variant="minimal">
                        <div class="flex items-center justify-between gap-4 text-sm text-gray-600 mb-3">
                            <div class="flex items-center gap-1">
                                <i class='bx bx-calendar text-[#FFB51B]'></i>
                                <span>{{ \Carbon\Carbon::parse($program->date)->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <i class='bx bx-time text-[#FFB51B]'></i>
                                <span>
                                    {{ \Carbon\Carbon::parse($program->start_time)->format('g:i A') }}
                                    @if ($program->end_time)
                                        - {{ \Carbon\Carbon::parse($program->end_time)->format('g:i A') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                            <i class='bx bx-map text-[#FFB51B]'></i>
                            <span>{{ $program->location }}</span>
                        </div>
                        <x-button type="button" variant="secondary" class="w-full text-sm gap-1"
                            onclick="document.getElementById('modal_{{ $program->id }}').showModal()">
                            <i class='bx bx-show'></i>
                            View Details
                        </x-button>
                    </x-overview.card>
                    @include('programs.modals.program-modal', ['program' => $program])
                @empty
                    <x-empty-state icon="bx bx-history" title="No Upcoming Programs Scheduled"
                        description="Scheduled programs will appear here." size="small" />
                @endforelse
            </div>

            <!-- Completed -->
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl md:text-4xl font-bold text-[#1a2235] flex items-center gap-3">
                    <i class='bx bx-check-circle text-[#FFB51B]'></i> Recently Completed Programs
                </h2>
                <div class="text-sm text-gray-500 bg-white px-4 py-2 rounded-full shadow-sm">
                    {{ count($donePrograms) }} Programs Completed
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($donePrograms as $program)
                    <x-overview.card title="{{ $program->title }}" icon="bx-check" variant="minimal">
                        <div class="flex items-center justify-between gap-4 text-sm text-gray-600 mb-3">
                            <div class="flex items-center gap-1">
                                <i class='bx bx-calendar text-[#FFB51B]'></i>
                                <span>{{ \Carbon\Carbon::parse($program->date)->format('M d, Y') }}</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <i class='bx bx-time text-[#FFB51B]'></i>
                                <span>
                                    {{ \Carbon\Carbon::parse($program->start_time)->format('g:i A') }}
                                    @if ($program->end_time)
                                        - {{ \Carbon\Carbon::parse($program->end_time)->format('g:i A') }}
                                    @endif
                                </span>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 text-sm text-gray-600 mb-4">
                            <i class='bx bx-map text-[#FFB51B]'></i>
                            <span>{{ $program->location }}</span>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2 w-full">
                            <x-button type="button" variant="primary" class="flex-1 text-sm gap-1"
                                onclick="document.getElementById('guestFeedbackModal_{{ $program->id }}').showModal()">
                                <i class='bx bx-message-dots'></i>
                                Share Feedback
                            </x-button>

                            <x-button type="button" variant="secondary" class="flex-1 text-sm gap-1"
                                onclick="document.getElementById('modal_{{ $program->id }}').showModal()">
                                <i class='bx bx-show'></i>
                                View Details
                            </x-button>
                        </div>

                    </x-overview.card>
                    @include('programs.modals.program-modal', ['program' => $program])
                    @include('website.modals.guestFeedbackModal', ['program' => $program])
                @empty
                    <x-empty-state icon="bx bx-history" title="No Completed Programs"
                        description="Finished programs will appear here." size="small" />
                @endforelse
            </div>
        </div>
    </div>


    <!-- FAQ Section -->
    <section class="py-16 bg-white">
        <div class="mx-auto max-w-4xl px-6 lg:px-8">

            <x-section-title first="Frequently" second="Asked Questions" />

            <div class="space-y-4">
                <x-accordion-daisy title="How can I join a program?">
                    <p>
                        You can join by registering through our website’s program page.
                        Each program has a “Register” or “Sign Up” button.
                        Simply fill out the form and wait for confirmation from our team.
                    </p>
                </x-accordion-daisy>

                <x-accordion-daisy title="Are the programs free?">
                    <p>
                        Yes, most of our programs are free of charge.
                        However, some may require minimal contributions or materials depending on the activity.
                        All details are listed in each program description.
                    </p>
                </x-accordion-daisy>

                <x-accordion-daisy title="Who can participate?">
                    <p>
                        Anyone with the passion to serve is welcome to participate!
                        Whether you’re a student, professional, or community member,
                        our programs are open to volunteers, partners, and beneficiaries alike.
                    </p>
                </x-accordion-daisy>
            </div>
        </div>
    </section>

    <div class="container mx-auto px-4 sm:px-6 lg:px-10 py-10">
        <x-section-title first="Submit" second="Program Request" />

        <form action="{{ route('program_requests.store') }}" method="POST" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <x-form.label for="name" variant="user">Your Name</x-form.label>
                    <x-form.input name="name" id="name" required placeholder="e.g. Juan Dela Cruz" />
                </div>

                <div>
                    <x-form.label for="title" variant="title">Program Title</x-form.label>
                    <x-form.input name="title" id="title" required placeholder="e.g. Community Feeding Program" />
                </div>
            </div>

            <div>
                <x-form.textarea name="description" label="Description" required
                    placeholder="Briefly describe the program objectives and activities..." />
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <x-form.label for="target_audience">Target Audience</x-form.label>
                    <x-form.input name="target_audience" id="target_audience" required
                        placeholder="e.g. Farmers, Women, Youth" />
                </div>

                <div>
                    <x-form.label for="location" variant="location">Location</x-form.label>
                    <x-form.input name="location" id="location" required placeholder="e.g. Nueva Ecija, Philippines" />
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <x-form.label for="proposed_date" variant="date">Proposed Date</x-form.label>
                    <x-form.date-picker id="proposed_date" name="proposed_date" />
                </div>
            </div>

            <div>
                <x-button type="submit" variant="primary">
                    <i class='bx bx-send mr-1'></i> Submit Request
                </x-button>
            </div>
        </form>
    </div>
@endsection
