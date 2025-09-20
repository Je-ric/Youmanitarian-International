@extends('layouts.navbar')

@section('content')
    <section class="relative w-full min-h-screen flex items-center">
        <!-- Background image -->
        <img src="{{ asset('assets/images/bg/program-bg.jpg') }}" alt="Join Youmanitarian International"
            class="absolute inset-0 w-full h-full object-cover">

        <!-- Gradient overlay (dark left -> transparent right) -->
        <div class="absolute inset-0 bg-gradient-to-r from-[#1a2235]/80 via-[#1a2235]/50 to-transparent"></div>

        <!-- Content -->
        <div class="relative z-10 max-w-3xl px-6 md:px-12 lg:px-24 text-white">
            <p class="text-base md:text-lg lg:text-xl font-normal tracking-wide uppercase">
                Grow Without Limits
            </p>
            <h2 class="text-3xl md:text-5xl lg:text-6xl font-bold leading-snug">
                Join <span class="text-[#FFB51B]">Youmanitarian International</span> and be one of us!
            </h2>
            <p class="mt-4 text-base md:text-lg lg:text-xl font-medium">
                Make connections, take action and move forward with a community
                built on dedication and mutual growth.
            </p>

            <button
                class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-[#FFB51B] text-[#1A2235] rounded-full font-semibold shadow hover:bg-[#e6a318] transition">
                JOIN NOW!
                <i class="bx bx-right-arrow-alt text-lg"></i>
            </button>
        </div>
    </section>



    <section class="max-w-7xl w-full mx-auto bg-[#1A2235] rounded-2xl py-4 my-3 px-6">
        <div class="container mx-auto grid grid-cols-2 sm:grid-cols-4 gap-6 text-center">
            <div>
                <div class="text-2xl sm:text-3xl font-bold text-white">{{ $volunteersCount }}</div>
                <div class="text-sm sm:text-base font-bold text-[#FFB51B]">Volunteers</div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-bold text-white">{{ $membersCount }}</div>
                <div class="text-sm sm:text-base font-bold text-[#FFB51B]">Members</div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-bold text-white">{{ $programsCount }}</div>
                <div class="text-sm sm:text-base font-bold text-[#FFB51B]">Programs</div>
            </div>
            <div>
                <div class="text-2xl sm:text-3xl font-bold text-white">--</div>
                <div class="text-sm sm:text-base font-bold text-[#FFB51B]">Activities</div>
            </div>
        </div>
    </section>



    <section class="relative max-w-5xl mx-auto py-8 sm:py-10">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8">

            <x-section-title first="Program" second="Highlights" />

            <div class="space-y-6">
                <article class="p-5 sm:p-6 rounded-xl border border-slate-200 shadow-sm bg-white">

                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg sm:text-xl font-semibold text-black">
                            Community Empowerment
                        </h3>
                        <span
                            class="w-10 h-10 flex items-center justify-center bg-primary-custom text-white rounded-full shadow-md">
                            <i class='bx bx-group text-xl'></i>
                        </span>
                    </div>

                    <!-- w-1/2 -->
                    <p class="text-sm sm:text-base text-gray-700 leading-relaxed w-[70%] text-justify">
                        Our programs strengthen rural communities by supporting farmers, women, and youth.
                        Through hands-on workshops, skills training, and strategic partnerships, beneficiaries
                        gain long-term knowledge and sustainable opportunities. By empowering local leaders and
                        providing access to resources, we help communities thrive socially and economically.
                    </p>
                </article>

                <article class="p-5 sm:p-6 rounded-xl border border-slate-200 shadow-sm bg-white">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg sm:text-xl font-semibold text-black">
                            Volunteer Engagement
                        </h3>
                        <span
                            class="w-10 h-10 flex items-center justify-center bg-accent-custom text-white rounded-full shadow-md">
                            <i class='bx bx-heart text-xl'></i>
                        </span>
                    </div>
                    <p class="text-sm sm:text-base text-gray-700 leading-relaxed w-[70%] text-justify">
                        Volunteers are at the heart of our mission. We provide structured opportunities for
                        individuals to contribute their expertise, track their volunteer hours, and participate
                        in initiatives ranging from disaster relief to educational outreach. By fostering
                        engagement, we build a community of active citizens who drive meaningful change.
                    </p>
                </article>

                <article class="p-5 sm:p-6 rounded-xl border border-slate-200 shadow-sm bg-white">
                    <div class="flex justify-between items-center mb-3">
                        <h3 class="text-lg sm:text-xl font-semibold text-black">
                            Impact Stories
                        </h3>
                        <span
                            class="w-10 h-10 flex items-center justify-center bg-slate-900 text-white rounded-full shadow-md">
                            <i class='bx bx-book-open text-xl'></i>
                        </span>
                    </div>
                    <p class="text-sm sm:text-base text-gray-700 leading-relaxed w-[70%] text-justify">
                        We believe in transparency and inspiration. Our platform highlights real-life stories
                        of transformation, showing how farmers, volunteers, and community members have
                        benefited from our programs. These narratives showcase success, resilience, and the
                        positive ripple effects of collective effort on society.
                    </p>
                </article>
            </div>
        </div>
    </section>



    <section class="py-16 bg-[#1A2235] my-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">

            <x-section-title first="Program" second="Feedback" firstColor="#FFFFFF" mb="false" />
            <p class="text-white mb-10">
                Here’s the peoples feedback about our programs and events and how they transformed their lives
            </p>

            <div class="relative w-full overflow-hidden rounded-2xl shadow-lg bg-white">

                <div id="feedbackSlides"
                    class="flex w-full transition-transform duration-500 ease-in-out overflow-x-auto scroll-smooth scrollbar-hide max-h-[400px]">

                    <div class="slide flex-shrink-0 w-full p-10 text-center overflow-y-auto">
                        <p class="text-lg md:text-xl text-gray-700 italic max-w-3xl mx-auto">
                            “This program completely changed how I view volunteering. I gained practical skills that I now
                            apply daily. The instructors were very supportive and encouraging. I feel more confident
                            stepping into leadership roles in my community.”
                        </p>
                        <h3 class="mt-6 text-lg font-semibold text-gray-900">— Juan Dela Cruz, Volunteer</h3>
                    </div>

                    <div class="slide flex-shrink-0 w-full p-10 text-center overflow-y-auto">
                        <p class="text-lg md:text-xl text-gray-700 italic max-w-3xl mx-auto">
                            “The workshops were practical and inspiring. I learned skills that I now use every day at work
                            and in life. Highly recommended!”
                        </p>
                        <h3 class="mt-6 text-lg font-semibold text-gray-900">— Jose Dimagiba, Participant</h3>
                    </div>

                    <div class="slide flex-shrink-0 w-full p-10 text-center overflow-y-auto">
                        <p class="text-lg md:text-xl text-gray-700 italic max-w-3xl mx-auto">
                            “Joining this program allowed me to meet amazing people who share my passion. We collaborated on
                            meaningful projects. I left with both new skills and lasting friendships.”
                        </p>
                        <h3 class="mt-6 text-lg font-semibold text-gray-900">— Malupiton, Youth Leader</h3>
                    </div>

                    <div class="slide flex-shrink-0 w-full p-10 text-center overflow-y-auto">
                        <p class="text-lg md:text-xl text-gray-700 italic max-w-3xl mx-auto">
                            “I never expected a program like this to be so enriching. Every session was interactive and
                            insightful. The activities taught me problem-solving and teamwork. I’m looking forward to
                            participating in future programs.”
                        </p>
                        <h3 class="mt-6 text-lg font-semibold text-gray-900">— Hiro Hamada, Volunteer</h3>
                    </div>

                </div>

                <button id="prevSlideBtn"
                    class="btn btn-circle absolute left-3 top-1/2 -translate-y-1/2 bg-[#FFB51B] hover:bg-[#e6a319] text-white shadow-lg">
                    ❮
                </button>
                <button id="nextSlideBtn"
                    class="btn btn-circle absolute right-3 top-1/2 -translate-y-1/2 bg-[#FFB51B] hover:bg-[#e6a319] text-white shadow-lg">
                    ❯
                </button>

            </div>
        </div>
    </section>

    <script>
        const slidesContainer = document.getElementById('feedbackSlides');
        const slides = slidesContainer.querySelectorAll('.slide');
        let activeSlideIndex = 0;

        function goToSlide(index) {
            if (index < 0) index = slides.length - 1;
            if (index >= slides.length) index = 0;
            activeSlideIndex = index;

            slidesContainer.scrollTo({
                left: slides[index].offsetLeft,
                behavior: 'smooth'
            });
        }

        document.getElementById('prevSlideBtn').addEventListener('click', () => goToSlide(activeSlideIndex - 1));
        document.getElementById('nextSlideBtn').addEventListener('click', () => goToSlide(activeSlideIndex + 1));
    </script>

    <style>
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>





    <div class="bg-gradient-to-br from-gray-50 to-gray-100 py-8 px-4">
        <div class="max-w-7xl mx-auto px-0 sm:px-0 lg:px-0">
            <x-section-title first="Our" second="Programs" />

            <!-- Ongoing -->
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-3xl md:text-4xl font-bold text-[#1a2235] flex items-center gap-3">
                    <i class='bx bx-play-circle text-[#FFB51B]'></i> Ongoing Programs
                </h3>
                <div class="text-sm text-gray-500 bg-white px-4 py-2 rounded-full shadow-sm">
                    {{ count($ongoingPrograms) }} Programs Scheduled
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-16">
                @forelse ($ongoingPrograms as $program)
                    <x-overview.card title="{{ $program->title }}" icon="bx-play-circle" variant="minimal">
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


    <section class="py-16 bg-[#1A2235]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <x-section-title first="Frequently" second="Asked Questions" mb="false" firstColor="#FFFFFF" />
            <p class="text-center text-gray-400 mb-10">Find answers to the most common questions about our programs.</p>

            <div class="space-y-4">
                <x-accordion-daisy title="How can I join a program?" variant="dark">
                    <p>
                        You can join by registering through our website’s program page.
                        Each program has a “Register” or “Sign Up” button.
                        Simply fill out the form and wait for confirmation from our team.
                    </p>
                </x-accordion-daisy>

                <x-accordion-daisy title="Are the programs free?" variant="dark">
                    <p>
                        Yes, most of our programs are free of charge.
                        However, some may require minimal contributions or materials depending on the activity.
                        All details are listed in each program description.
                    </p>
                </x-accordion-daisy>

                <x-accordion-daisy title="Who can participate?" variant="dark">
                    <p>
                        Anyone with the passion to serve is welcome to participate!
                        Whether you’re a student, professional, or community member,
                        our programs are open to volunteers, partners, and beneficiaries alike.
                    </p>
                </x-accordion-daisy>

                <x-accordion-daisy title="How are volunteer applications processed?" variant="dark">
                    <p>
                        All volunteer applications are reviewed by Admins or Program Coordinators.
                        They can approve, deny, or restore applications. Once approved, volunteers
                        can join programs and may be invited to become official members.
                    </p>
                </x-accordion-daisy>

                <x-accordion-daisy title="Who can manage programs and volunteers?" variant="dark">
                    <p>
                        Admins and Program Coordinators can create and manage programs.
                        Coordinators can manage volunteers within their programs, assign tasks,
                        approve attendance, and view feedback. Volunteers can only join or leave programs based on rules.
                    </p>
                </x-accordion-daisy>

                <x-accordion-daisy title="How is program feedback collected?" variant="dark">
                    <p>
                        Feedback is collected from volunteers and guests only after a program ends.
                        Coordinators and Admins can view all submitted feedback, which helps improve
                        future programs and ensure better participant experiences.
                    </p>
                </x-accordion-daisy>

                <x-accordion-daisy title="Can volunteers leave a program after joining?" variant="dark">
                    <p>
                        Volunteers can leave a program only if it hasn’t started yet (status: incoming) and
                        they have no assigned tasks. Once a program has started or tasks are assigned, leaving
                        is not allowed to ensure smooth program operations.
                    </p>
                </x-accordion-daisy>

            </div>
        </div>
    </section>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <x-section-title first="Submit" second="Program Request" mb="false" />
            <div class="text-center max-w-5xl mx-auto my-4">
                <x-feedback-status.alert type="info" icon="bx bx-info-circle"
                    message="Have an idea for a program? Submit your request,
                    and our team will carefully review it. <br>
                    If it meets our criteria and aligns with our mission,
                    we’ll proceed with planning and bring it
                    to life for the community." />
            </div>


            <form action="{{ route('program_requests.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <x-form.label for="name" variant="user">Your Name</x-form.label>
                        <x-form.input name="name" id="name" required placeholder="e.g. Juan Dela Cruz" />
                    </div>

                    <div>
                        <x-form.label for="title" variant="title">Program Title</x-form.label>
                        <x-form.input name="title" id="title" required
                            placeholder="e.g. Community Feeding Program" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <x-form.label for="email" variant="email">Email Address</x-form.label>
                        <x-form.input name="email" id="email" type="email" placeholder="your.email@example.com" />
                    </div>

                    <div>
                        <x-form.label for="contact_number" variant="phone">Contact Number</x-form.label>
                        <x-form.input name="contact_number" id="contact_number" placeholder="+63 912 345 6789" />
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
                        <x-form.input name="location" id="location" required
                            placeholder="e.g. Nueva Ecija, Philippines" />
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <x-form.label for="proposed_date" variant="date">Proposed Date</x-form.label>
                        <x-form.date-picker id="proposed_date" name="proposed_date" />
                    </div>
                    <div class="flex items-end">
                        <x-form.label></x-form.label>
                        <x-button type="submit" variant="primary">
                            <i class='bx bx-send mr-1'></i> Submit Request
                        </x-button>
                    </div>
                </div>

            </form>
        </div>
    </div>
@endsection
