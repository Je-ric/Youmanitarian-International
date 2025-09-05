@extends('layouts.navbar')

@section('content')
    <!-- HERO -->
    <header class="relative isolate h-[90vh] flex items-center">
        <img src="https://images.unsplash.com/photo-1506765515384-028b60a970df?auto=format&fit=crop&w=1400&q=80"
            alt="Empowering community"
            class="absolute inset-0 w-full h-full object-cover object-center opacity-70 sm:opacity-80" />
        <div class="absolute inset-0 bg-white/40 backdrop-blur-md"></div>
        <div class="relative z-10 mx-auto w-full max-w-6xl px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-lg font-medium uppercase tracking-wide text-gray-800/80">Who we are?</p>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-semibold tracking-tight">
                    Youmanitarian International
                </h1>
                <p class="mt-4 text-base sm:text-lg lg:text-xl">
                    A non-stock, non-profit organization composed of passionate, goal-driven, and responsive individuals who
                    exist
                    to empower communities and transform the lives of marginalized people.
                </p>
                <button aria-label="Contact Us"
                    class="mt-6 inline-flex items-center gap-2 rounded-full bg-gray-900 px-7 py-3 font-medium text-white shadow
                     hover:bg-gray-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-800">
                    Contact&nbsp;Us
                    <i class='bx bx-mail-send'></i>
                </button>
            </div>
        </div>
    </header>

    {{-- ===================================================================================== --}}
    <!-- ABOUT US -->
    <section class="py-16 md:py-20 bg-white">
        <div class="mx-auto max-w-6xl px-6 lg:px-8">
            <!-- About Us Header -->
            <h2 class="text-4xl lg:text-5xl font-bold text-balance mb-12">
                <span class="text-primary-custom">About</span>
                <span class="text-accent-custom">Us</span>
            </h2>

            <!-- About Us Content -->
            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <!-- Text -->
                <div class="flex flex-col justify-center space-y-6 text-gray-800 leading-relaxed">
                    <p>
                        Youmanitarian Service Organization Internation, Inc. or simply Youmanitarian International
                        is a non-partisan, non-sectarian and non-government organization composed of passionate,
                        goal-driven and responsive individuals from the Philippines and abroad.
                    </p>
                    <p>
                        Humanitarian is defined: as someone who is concerned with or seeking to promote human welfare.
                        We used the word "<strong>YOU</strong>" instead of "HU" to emphasize that it's
                        "You is concerned with or seeking to promote human welfare."
                    </p>
                    <p>
                        Legality: Youmanitarian International is a duly registered non-stock and non-profit corporation
                        with the Securities and Exchange Commission (SEC) of the Philippines on September 21, 2020, with
                        company registration number CN202007651.
                    </p>
                </div>

                <!-- Image -->
                <div class="flex justify-center md:justify-end">
                    <img src="{{ asset('assets/images/logo/YI.jpg') }}" alt="Youmanitarian Logo"
                        class="w-64 md:w-80 lg:w-[25rem] h-auto rounded-full object-cover border-4 border-[var(--accent-color)]" />
                </div>
            </div>
        </div>
    </section>

    <!-- Vision and Mission -->
    <section class="py-16 bg-gray-50">
        <div class="mx-auto max-w-6xl px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <!-- Vision -->
                <div class="flex flex-col space-y-4 p-6 md:p-10 bg-[var(--primary-color)] text-white rounded-lg">
                    <div class="flex items-center gap-3">
                        <i class='bx bx-show text-3xl text-[var(--accent-color)]'></i>
                        <h3 class="text-2xl font-semibold">Our&nbsp;Vision</h3>
                    </div>
                    <p>
                        Youmanitarian International as one of the progressive organizations working through harmony
                        with other stakeholders in creating more sustainable communities by tapping the resources within.
                    </p>
                </div>

                <!-- Mission -->
                <div class="flex flex-col space-y-4 p-6 md:p-10 bg-[var(--primary-color)] text-white rounded-lg">
                    <div class="flex items-center gap-3">
                        <i class='bx bx-target-lock text-3xl text-[var(--accent-color)]'></i>
                        <h3 class="text-2xl font-semibold">Our&nbsp;Mission</h3>
                    </div>
                    <p>
                        Transform the lives of marginalized and underprivileged people, and youth sector through education,
                        inclusive development
                        and exchange, civic and social endeavours in the spirit of volunteerism and goodwill encourage peace
                        and promote understanding
                        to make a substantial change through sustainable development programs.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Purpose -->
    <section class="py-16 bg-white">
        <div class="mx-auto max-w-6xl px-6 lg:px-8">
            <h2 class="text-4xl lg:text-5xl font-bold text-center text-balance mb-16">
                <span class="text-primary-custom">Our</span>
                <span class="text-accent-custom">Purpose</span>
            </h2>

            <!-- General Purpose -->
            <div class="mt-8 flex items-start gap-4">
                <i class='bx bx-info-circle text-3xl text-[var(--accent-color)] mt-1'></i>
                <p class="text-gray-800 leading-relaxed">
                    <strong>GENERAL:</strong> The prime purpose of our existence is to <strong>ESTABLISH</strong> harmonious
                    relationships; collaboration and mutual aid among
                    our peers and stakeholders in pursuit of a common good and engagements to empower communities.
                </p>
            </div>

            <!-- Specific Purposes -->
            <div class="mt-8 space-y-6">
                <p class="text-gray-800 font-semibold">SPECIFIC:</p>
                <ul class="list-decimal pl-6 space-y-3 text-gray-800 leading-relaxed">
                    <li>To <strong>RENDER</strong> our expertise in local communities by finding opportunities to
                        collaborate with existing programs of the government through concerned agencies and with different
                        institutions to achieve our common goals;</li>
                    <li>To <strong>ACT</strong> as a catalyst to bridge the gaps in the implementation of social policies
                        and programs and respond to the needs of marginalized sectors for a more equitable, inclusive, and
                        progressive society;</li>
                    <li>To <strong>CAPACITATE</strong> the vulnerable and marginalized sectors with practical skills and
                        life-long learning strategies to realize their full potentials as proactive members of the community
                        in partnership with government agencies, local government units, private institutions, and duly
                        recognized community-based organizations;</li>
                    <li>To <strong>CHARTER</strong> a local network of Youmanitarians in every city and municipality or
                        community;</li>
                    <li>To <strong>CHARTER</strong> a youth implementation arm to be called "Youth for Youmanity (YfY) in
                        every community and schools;</li>
                    <li>To <strong>INSTILL</strong> socio-civic awareness, sense of responsibility and voluntarism through
                        active participation;</li>
                    <li>To <strong>ENCOURAGE</strong> more people to be a volunteer and empower them to serve their
                        communities.</li>
                </ul>
            </div>
        </div>
    </section>



    <section class="py-20 bg-gray-50">
        <div class="mx-auto max-w-6xl px-6 lg:px-10">
            <div class="grid lg:grid-cols-2 gap-x-20 gap-y-20 items-center">
                <!-- IMAGE -->

                <div class="flex flex-col items-center lg:order-2 space-y-4">
                    <h2 class="text-4xl lg:text-5xl font-bold mb-8">
                        <span class="text-primary-custom">The</span>
                        <span class="text-accent-custom">Logo</span>
                    </h2>
                    <img src="{{ asset('assets/images/logo/YI.jpg') }}" alt="Youmanitarian Logo"
                        class="w-80 h-80 md:w-[30rem] md:h-[30rem] rounded-full ring ring-gray-200 object-cover translate-y-6 motion-safe:animate-fadeIn motion-safe:delay-100" />
                </div>


                <!-- TEXT BLOCK -->
                <div class="space-y-10 text-gray-800">

                    <!-- LEFT -->
                    <div class="flex flex-col justify-center space-y-6 motion-safe:animate-fadeIn motion-safe:delay-200">
                        <div class="flex items-start gap-4">
                            <i class="bx bx-star text-3xl text-[var(--primary-color)]"></i>
                            <p class="leading-relaxed">
                                <span class="font-semibold text-[var(--primary-color)]">3 Stars</span><br>
                                Symbolize the three main islands of the country.
                            </p>
                        </div>
                        <div class="flex items-start gap-4">
                            <i class="bx bx-font text-3xl text-[var(--primary-color)]"></i>
                            <p class="leading-relaxed">
                                <span class="font-semibold text-[var(--primary-color)]">Letter Y</span><br>
                                the initial of <span class="font-semibold text-[var(--accent-color)]">Youmanitarian</span>.
                            </p>
                        </div>
                        <div class="flex items-start gap-4">
                            <i class="bx bx-leaf text-3xl text-[var(--primary-color)]"></i>
                            <p class="leading-relaxed">
                                <span class="font-semibold text-[var(--primary-color)]">Laurel</span><br>
                                Symbolizes <em>nobility</em> and <em>victory</em>.
                            </p>
                        </div>
                    </div>


                    <div class="w-full h-px bg-gray-200"></div>

                    <!-- RIGHT  -->
                    <div class="space-y-6 translate-x-4 motion-safe:animate-fadeIn motion-safe:delay-[300ms]">
                        <div class="flex items-start gap-4">
                            <i class="bx bx-infinite text-3xl text-[var(--primary-color)]"></i>
                            <p class="leading-relaxed">
                                <span class="font-semibold text-[var(--primary-color)]">8 Rings in Lotus Form</span>
                                – Youmanitarian International is just like Lotus flower that grows from the mud (humble
                                beginning) and blooming towards the sky (aiming high).
                            </p>
                        </div>

                        <div>
                            <p class="mb-3 font-semibold text-[var(--primary-color)]">The 8 rings symbolizes the
                                <span class="text-[var(--accent-color)]">8 Noble Fold Path</span>:
                            </p>
                            <ul class="grid grid-cols-2 sm:grid-cols-4 gap-x-6 gap-y-2 text-sm pl-6 list-disc">
                                <li>Right View</li>
                                <li>Right Intention</li>
                                <li>Right Speech</li>
                                <li>Right Action</li>
                                <li>Right Livelihood</li>
                                <li>Right Effort</li>
                                <li>Right Mindfulness</li>
                                <li>Right Concentration</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-white">
        <div class="mx-auto max-w-6xl px-6 lg:px-8">
            <!-- Section Header -->
            <h2 class="text-4xl lg:text-5xl font-bold text-center mb-16">
                <span class="text-primary-custom">Our</span>
                <span class="text-accent-custom">Services</span>
            </h2>

            <!-- Services Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">
                <!-- Service Card -->
                <div
                    class="flex flex-col items-center text-center p-8 rounded-xl border border-gray-200 hover:border-[var(--accent-color)] transition-all duration-300">
                    <i class='bx bx-cog text-5xl text-[var(--primary-color)] mb-4'></i>
                    <h3 class="text-xl font-semibold mb-2">Service Title 1</h3>
                    <p class="text-gray-600 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod
                        tempor.</p>
                </div>

                <div
                    class="flex flex-col items-center text-center p-8 rounded-xl border border-gray-200 hover:border-[var(--accent-color)] transition-all duration-300">
                    <i class='bx bx-layer text-5xl text-[var(--primary-color)] mb-4'></i>
                    <h3 class="text-xl font-semibold mb-2">Service Title 2</h3>
                    <p class="text-gray-600 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod
                        tempor.</p>
                </div>

                <div
                    class="flex flex-col items-center text-center p-8 rounded-xl border border-gray-200 hover:border-[var(--accent-color)] transition-all duration-300">
                    <i class='bx bx-rocket text-5xl text-[var(--primary-color)] mb-4'></i>
                    <h3 class="text-xl font-semibold mb-2">Service Title 3</h3>
                    <p class="text-gray-600 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod
                        tempor.</p>
                </div>

                <div
                    class="flex flex-col items-center text-center p-8 rounded-xl border border-gray-200 hover:border-[var(--accent-color)] transition-all duration-300">
                    <i class='bx bx-world text-5xl text-[var(--primary-color)] mb-4'></i>
                    <h3 class="text-xl font-semibold mb-2">Service Title 4</h3>
                    <p class="text-gray-600 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do
                        eiusmod tempor.</p>
                </div>

                <div
                    class="flex flex-col items-center text-center p-8 rounded-xl border border-gray-200 hover:border-[var(--accent-color)] transition-all duration-300">
                    <i class='bx bx-briefcase text-5xl text-[var(--primary-color)] mb-4'></i>
                    <h3 class="text-xl font-semibold mb-2">Service Title 5</h3>
                    <p class="text-gray-600 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do
                        eiusmod tempor.</p>
                </div>

                <div
                    class="flex flex-col items-center text-center p-8 rounded-xl border border-gray-200 hover:border-[var(--accent-color)] transition-all duration-300">
                    <i class='bx bx-help-circle text-5xl text-[var(--primary-color)] mb-4'></i>
                    <h3 class="text-xl font-semibold mb-2">Service Title 6</h3>
                    <p class="text-gray-600 text-sm">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do
                        eiusmod tempor.</p>
                </div>
            </div>
        </div>
    </section>
@endsection
