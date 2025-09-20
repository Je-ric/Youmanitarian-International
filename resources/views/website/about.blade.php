@extends('layouts.navbar')

@section('content')
    <div class="relative w-full bg-cover bg-center py-16"
        style="background-image: url('{{ asset('assets/images/bg/team-bg.jpg') }}');">
        <div class="absolute inset-0 bg-[#1a2235] bg-opacity-60 backdrop-blur-sm"></div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-left">
            <p class="text-lg font-medium uppercase tracking-wide text-white">Who we are?</p>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-bold text-[#FFB51B] tracking-tight">
                Youmanitarian International
            </h1>
            <p class="mt-4 text-base sm:text-lg lg:text-xl text-white">
                A non-stock, non-profit organization composed of passionate, goal-driven, and responsive <br> individuals
                who
                exist to empower communities and transform the lives of marginalized people.
            </p>
            <button aria-label="Contact Us"
                class="mt-6 inline-flex items-center gap-2 rounded-full bg-gray-900 px-7 py-3 font-medium text-white shadow
                     hover:bg-gray-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gray-800">
                Contact&nbsp;Us
                <i class='bx bx-mail-send'></i>
            </button>
        </div>
    </div>

    {{-- ===================================================================================== --}}
    <section class="py-14 md:py-20 bg-gray-50">
        <div class="mx-auto max-w-6xl px-6 lg:px-8">

            <x-section-title textAlign="left" first="About" second="Us" />

            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div class="flex flex-col justify-center space-y-6 text-black leading-relaxed text-justify">
                    <p>
                        <strong class="text-[#FFB51B]">Youmanitarian Service Organization Internation, Inc.</strong> or
                        simply <strong class="text-[#FFB51B]">Youmanitarian International</strong>
                        is a non-partisan, non-sectarian and non-government organization composed of passionate,
                        goal-driven and responsive individuals from the Philippines and abroad.
                    </p>
                    <p>
                        Humanitarian is defined: as someone who is concerned with or seeking to promote human welfare.
                        We used the word <strong class="text-[#FFB51B]">"YOU"</strong> instead of <strong
                            class="text-[#FFB51B]">"HU"</strong> to emphasize that it's
                        <strong class="text-[#FFB51B]">"You is concerned with or seeking to promote human welfare."</strong>
                    </p>
                    <p>
                        <strong class="text-[#FFB51B]">Legality:</strong> Youmanitarian International is a duly registered
                        non-stock and non-profit corporation
                        with the Securities and Exchange Commission (SEC) of the Philippines on September 21, 2020, with
                        company registration number CN202007651.
                    </p>
                </div>

                <div class="flex justify-center md:justify-end">
                    <img src="{{ asset('assets/images/logo/YI.jpg') }}" alt="Youmanitarian Logo"
                        class="w-64 md:w-80 lg:w-[25rem] h-auto rounded-full object-cover border-4 border-[var(--accent-color)]" />
                </div>
            </div>
        </div>
    </section>

    {{-- ===================================================================================== --}}
    <section class="py-16 md:py-20 bg-[#1a2235]">
        <div class="mx-auto max-w-6xl px-6 lg:px-8">

            <x-section-title first="Who" second="We Are" firstColor="#FFFFFF" />

            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">

                <div class="flex flex-col">
                    <img src="{{ asset('assets/images/bg/mission.jpg') }}" alt="Mission of Youmanitarian International"
                        class="w-full max-w-160 h-72 md:h-80 lg:h-88 object-cover mb-6 rounded-lg" />

                    <h2 class="flex items-center gap-2 text-2xl font-bold text-[#FFB51B] mb-4">
                        <i class='bx bx-target-lock text-3xl'></i>
                        Mission
                    </h2>
                    <p class="text-white leading-relaxed">
                        Transform the lives of marginalized and underprivileged people, and youth sector through education,
                        inclusive development and exchange, civic and social endeavours in the spirit of volunteerism and
                        goodwill,
                        encourage peace and promote understanding to make a substantial change through sustainable
                        development programs.
                    </p>
                </div>

                <div class="flex flex-col">
                    <img src="{{ asset('assets/images/bg/vision.jpg') }}" alt="Vision of Youmanitarian International"
                        class="w-full max-w-160 h-72 md:h-80 lg:h-88 object-cover mb-6 rounded-lg" />

                    <h2 class="flex items-center gap-2 text-2xl font-bold text-[#FFB51B] mb-4">
                        <i class='bx bx-show text-3xl'></i>
                        Vision
                    </h2>
                    <p class="text-white leading-relaxed">
                        Youmanitarian International as one of the progressive organizations working through harmony
                        with other stakeholders in creating more sustainable communities by tapping the resources within.
                    </p>
                </div>
            </div>
        </div>
    </section>


    {{-- ===================================================================================== --}}
    <section class="py-16 bg-white">
        <div class="mx-auto max-w-6xl px-6 lg:px-8">

            <x-section-title first="Our" second="Purpose" />

            <div class="mt-8 flex items-start gap-4">
                <i class='bx bx-info-circle text-3xl text-[var(--accent-color)] mt-1'></i>
                <p class="text-gray-800 leading-relaxed">
                    <strong>GENERAL:</strong> The prime purpose of our existence is to <strong>ESTABLISH</strong> harmonious
                    relationships; collaboration and mutual aid among
                    our peers and stakeholders in pursuit of a common good and engagements to empower communities.
                </p>
            </div>

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

    {{-- ===================================================================================== --}}
    <section class="py-20 bg-[#1a2235]">
        <div class="mx-auto max-w-6xl px-6 lg:px-10">
            <div class="grid lg:grid-cols-2 gap-x-20 gap-y-20 items-center">

                <div class="flex flex-col items-center lg:order-2 space-y-4">

                    <x-section-title first="The" second="Logo" firstColor="#FFFFFF" />
                    <img src="{{ asset('assets/images/logo/YI.jpg') }}" alt="Youmanitarian Logo"
                        class="w-80 h-80 md:w-[30rem] md:h-[30rem] rounded-full ring ring-gray-300 object-cover translate-y-6 motion-safe:animate-fadeIn motion-safe:delay-100 shadow-2xl" />
                </div>

                <div class="space-y-10 text-gray-100">

                    <div class="flex flex-col justify-center space-y-6 motion-safe:animate-fadeIn motion-safe:delay-200">
                        <div class="flex items-start gap-4">
                            <i class="bx bx-star text-3xl text-[var(--accent-color)]"></i>
                            <p class="leading-relaxed">
                                <span class="font-semibold text-white">3 Stars</span><br>
                                Symbolize the three main islands of the country.
                            </p>
                        </div>
                        <div class="flex items-start gap-4">
                            <i class="bx bx-font text-3xl text-[var(--accent-color)]"></i>
                            <p class="leading-relaxed">
                                <span class="font-semibold text-white">Letter Y</span><br>
                                the initial of <span class="font-semibold text-[var(--accent-color)]">Youmanitarian</span>.
                            </p>
                        </div>
                        <div class="flex items-start gap-4">
                            <i class="bx bx-leaf text-3xl text-[var(--accent-color)]"></i>
                            <p class="leading-relaxed">
                                <span class="font-semibold text-white">Laurel</span><br>
                                Symbolizes <em>nobility</em> and <em>victory</em>.
                            </p>
                        </div>
                    </div>

                    <div class="w-full h-px bg-gray-600"></div>

                    <div class="space-y-6 translate-x-4 motion-safe:animate-fadeIn motion-safe:delay-[300ms]">
                        <div class="flex items-start gap-4">
                            <i class="bx bx-infinite text-3xl text-[var(--accent-color)]"></i>
                            <p class="leading-relaxed">
                                <span class="font-semibold text-white">8 Rings in Lotus Form</span>
                                – Youmanitarian International is just like Lotus flower that grows from the mud (humble
                                beginning) and blooming towards the sky (aiming high).
                            </p>
                        </div>

                        <div>
                            <p class="mb-3 font-semibold text-white">
                                The 8 rings symbolize the <span class="text-[var(--accent-color)]">8 Noble Fold Path</span>:
                            </p>
                            <ul
                                class="grid grid-cols-2 sm:grid-cols-4 gap-x-6 gap-y-2 text-sm pl-6 list-disc marker:text-[var(--accent-color)]">
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

            <x-section-title first="Our" second="Services" />

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-12">

                <div
                    class="flex flex-col items-center text-center p-8 rounded-xl border border-gray-200 hover:border-[var(--accent-color)] transition-all duration-300">
                    <i class='bx bx-news text-5xl text-[var(--primary-color)] mb-4'></i>
                    <h3 class="text-xl font-semibold mb-2">Content Management</h3>
                    <p class="text-gray-600 text-sm">
                        Easily create, update, and publish news, blogs, and impact stories with a structured CMS
                        that ensures collaboration and accurate content delivery.
                    </p>
                </div>

                <div
                    class="flex flex-col items-center text-center p-8 rounded-xl border border-gray-200 hover:border-[var(--accent-color)] transition-all duration-300">
                    <i class='bx bx-group text-5xl text-[var(--primary-color)] mb-4'></i>
                    <h3 class="text-xl font-semibold mb-2">Volunteer Management</h3>
                    <p class="text-gray-600 text-sm">
                        Streamline volunteer registration, task assignments, and attendance logs with personal dashboards
                        for tracking contributions and activities.
                    </p>
                </div>

                <div
                    class="flex flex-col items-center text-center p-8 rounded-xl border border-gray-200 hover:border-[var(--accent-color)] transition-all duration-300">
                    <i class='bx bx-credit-card text-5xl text-[var(--primary-color)] mb-4'></i>
                    <h3 class="text-xl font-semibold mb-2">Membership & Payments</h3>
                    <p class="text-gray-600 text-sm">
                        Securely track membership fees and donations with QR-based payment displays and automated
                        email confirmations for transparency and accountability.
                    </p>
                </div>

                <div
                    class="flex flex-col items-center text-center p-8 rounded-xl border border-gray-200 hover:border-[var(--accent-color)] transition-all duration-300">
                    <i class='bx bx-bell text-5xl text-[var(--primary-color)] mb-4'></i>
                    <h3 class="text-xl font-semibold mb-2">User Notifications</h3>
                    <p class="text-gray-600 text-sm">
                        Keep users updated with real-time dashboard alerts and email notifications for approvals,
                        payments, new events, and organizational announcements.
                    </p>
                </div>

                <div
                    class="flex flex-col items-center text-center p-8 rounded-xl border border-gray-200 hover:border-[var(--accent-color)] transition-all duration-300">
                    <i class='bx bx-shield text-5xl text-[var(--primary-color)] mb-4'></i>
                    <h3 class="text-xl font-semibold mb-2">Role-Based Access</h3>
                    <p class="text-gray-600 text-sm">
                        Ensure security and efficiency with role-specific access for administrators, coordinators,
                        content managers, members, and volunteers.
                    </p>
                </div>

                <div
                    class="flex flex-col items-center text-center p-8 rounded-xl border border-gray-200 hover:border-[var(--accent-color)] transition-all duration-300">
                    <i class='bx bx-analyse text-5xl text-[var(--primary-color)] mb-4'></i>
                    <h3 class="text-xl font-semibold mb-2">Analytics & Reports</h3>
                    <p class="text-gray-600 text-sm">
                        Generate real-time reports on content, volunteer engagement, and financial records to
                        measure social impact and improve decision-making.
                    </p>
                </div>

            </div>
        </div>
    </section>
@endsection
