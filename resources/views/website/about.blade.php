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
    <section class="py-16 md:py-20">
        <div class="mx-auto max-w-6xl px-6 lg:px-8">
            <h2 class="text-3xl sm:text-4xl font-semibold tracking-tight text-center">
                About&nbsp;Us
            </h2>
            <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="flex items-center">
                    <p class="bg-white rounded-lg shadow-lg p-8 md:p-12 text-lg leading-relaxed">
                        During recent years, GCECC has made joint ventures to expand its areas of expertise and has become
                        one of the most established construction companies in Somalia. Growth is driven by an expanded
                        management team and increasing annual turnover.
                    </p>
                </div>
                <div>
                    <img src="https://images.unsplash.com/photo-1503389152951-9f71e620c44e?auto=format&fit=crop&w=800&q=80"
                        alt="Construction Site" class="w-full h-auto rounded-lg shadow-lg object-cover" />
                </div>
            </div>
        </div>
    </section>
    <section class="py-16 bg-gray-100">
        <div class="mx-auto max-w-6xl px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-10">
                <div class="bg-gray-900 text-white rounded-lg p-10 shadow-lg">
                    <h3 class="text-2xl font-semibold mb-4 tracking-tight">Our&nbsp;Vision</h3>
                    <p>
                        To be the most respected and successfully operated company in our industry—creating value for all
                        stakeholders.
                    </p>
                </div>
                <div class="bg-gray-900 text-white rounded-lg p-10 shadow-lg">
                    <h3 class="text-2xl font-semibold mb-4 tracking-tight">Our&nbsp;Mission</h3>
                    <p>
                        To provide foundations for post-conflict Somalia’s future.
                    </p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-16">
        <div class="mx-auto max-w-5xl px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 items-center gap-8">
                <!-- LEFT LIST -->
                <div class="space-y-3 md:text-right">
                    <p><strong>3 Stars</strong> – Symbolize the three main islands of the country.</p>
                    <p><strong>Letter Y</strong> – Represents “Youmanitarian”.</p>
                    <p><strong>Laurel</strong> – Signifies nobility and victory.</p>
                    <p><strong>8 Lotus Rings</strong> – From mud to sky, representing the Eightfold Path.</p>
                </div>
                <!-- CENTER IMAGE -->
                <div class="flex justify-center">
                    <img src="https://images.unsplash.com/photo-1505238680356-667803448bb6?auto=format&fit=crop&w=400&q=80"
                        alt="Youmanitarian Logo" class="w-60 h-60 md:w-72 md:h-72 object-cover rounded-full shadow-xl" />
                </div>
                <!-- RIGHT LIST -->
                <div class="space-y-3 md:text-left">
                    <p><strong>3 Stars</strong> – Symbolize the three main islands of the country.</p>
                    <p><strong>Letter Y</strong> – Represents “Youmanitarian”.</p>
                    <p><strong>Laurel</strong> – Signifies nobility and victory.</p>
                    <p><strong>8 Lotus Rings</strong> – From mud to sky, representing the Eightfold Path.</p>
                </div>
            </div>
        </div>
    </section>
    <section class="py-16 bg-gray-100">
        <div class="mx-auto max-w-6xl px-6 lg:px-8">
            <h2 class="text-3xl sm:text-4xl font-semibold tracking-tight text-center">
                Our&nbsp;Services
            </h2>
            <div class="mt-12 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-10">
                <!-- Card -->
                <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                    <i class='bx bx-water text-yellow-500 text-3xl mb-4'></i>
                    <h3 class="text-xl font-medium mb-2">Water & Wastewater Solutions</h3>
                    <p class="text-sm leading-relaxed">
                        Electro-mechanical contracting, commissioning, and O&M of water & wastewater treatment plants.
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                    <i class='bx bx-buildings text-yellow-500 text-3xl mb-4'></i>
                    <h3 class="text-xl font-medium mb-2">Metafabrication Works</h3>
                    <p class="text-sm leading-relaxed">
                        From small equipment to large-scale structures—fabricated by experienced welders and designers.
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                    <i class='bx bx-chip text-yellow-500 text-3xl mb-4'></i>
                    <h3 class="text-xl font-medium mb-2">Electro-Mechanical</h3>
                    <p class="text-sm leading-relaxed">
                        Comprehensive repair & maintenance of office automation equipment by skilled engineers &
                        technicians.
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                    <i class='bx bx-package text-yellow-500 text-3xl mb-4'></i>
                    <h3 class="text-xl font-medium mb-2">Food & Non-Food Supply</h3>
                    <p class="text-sm leading-relaxed">
                        Supplying essential items that enhance well-being and resilience during rebuilding phases.
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                    <i class='bx bx-truck text-yellow-500 text-3xl mb-4'></i>
                    <h3 class="text-xl font-medium mb-2">Logistics & Distribution</h3>
                    <p class="text-sm leading-relaxed">
                        Efficient, reliable movement of goods across challenging terrains to reach communities in need.
                    </p>
                </div>
                <div class="bg-white rounded-lg shadow-lg p-8 text-center">
                    <i class='bx bx-plus-medical text-yellow-500 text-3xl mb-4'></i>
                    <h3 class="text-xl font-medium mb-2">Emergency Relief</h3>
                    <p class="text-sm leading-relaxed">
                        Rapid deployment of resources and expertise for disaster response and humanitarian aid.
                    </p>
                </div>
            </div>
        </div>
    </section>
@endsection