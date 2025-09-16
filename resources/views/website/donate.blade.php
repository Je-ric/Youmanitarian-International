@extends('layouts.navbar')

@section('content')
    <section class="relative w-full min-h-screen flex items-center">
        <!-- Background image -->
        <img src="{{ asset('assets/images/bg/donate-bg.jpg') }}" alt="Support Youmanitarian International"
            class="absolute inset-0 w-full h-full object-cover">

        <!-- Gradient overlay (dark top -> transparent bottom) -->
        <div class="absolute inset-0 bg-[#1a2235] bg-opacity-60 backdrop-blur-sm"></div>

        <!-- Content -->
        <div class="relative z-10 max-w-3xl px-6 md:px-12 lg:px-24 text-white">
            <p class="text-base md:text-lg lg:text-xl font-normal tracking-wide uppercase">
                Give Hope, Change Lives
            </p>
            <h2 class="text-3xl md:text-5xl lg:text-6xl font-bold leading-snug">
                Your <span class="text-[#FFB51B]">Donation</span> Builds a Brighter Tomorrow
            </h2>
            <p class="mt-4 text-base md:text-lg lg:text-xl font-medium">
                Every contribution, big or small, helps us reach more communities,
                provide essential aid, and empower lives. Together, we can
                transform hope into action.
            </p>

            <button
                class="mt-6 inline-flex items-center gap-2 px-6 py-3 bg-[#FFB51B] text-[#1A2235] rounded-full font-semibold shadow hover:bg-[#e6a318] transition">
                DONATE NOW
                <i class="bx bx-heart text-lg"></i>
            </button>
        </div>
    </section>


<section class="py-16 px-6 md:px-16 lg:px-32 space-y-12">

        <!-- Page Header -->
        <div class="text-center">
            <h1 class="text-5xl font-extrabold text-gray-800 mb-4">Donate</h1>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Your support helps us continue our programs. Choose a method below and make a secure donation.
            </p>

            <!-- Disclaimer Note -->

        </div>

        <!-- 1. Why Donate -->
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Why Donate?</h2>
            <p class="text-gray-600 max-w-3xl mx-auto">
                Every contribution you make allows us to sustain our programs and reach more communities in need.
                Whether it’s supporting children’s education, providing relief during disasters, or empowering local
                volunteers—your help makes it possible.
            </p>
        </div>

        <!-- 2. Transparency -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Transparency & Assurance</h2>
            <p class="text-gray-600 mb-3">
                We are committed to using your donations responsibly. 100% of your support goes directly to our programs
                and beneficiaries. Administrative costs are covered separately, ensuring your contribution creates the maximum
                impact.
            </p>
        </div>
</section class="py-16 px-6 md:px-16 lg:px-32 space-y-12">





    <section class="relative w-full flex items-center py-16">
        <!-- Background image -->
        <img src="{{ asset('assets/images/bg/donate-bg.jpg') }}" alt="Support Youmanitarian International"
            class="absolute inset-0 w-full h-full object-cover">

        <!-- Gradient overlay (dark top -> transparent bottom) -->
        <div class="absolute inset-0 bg-[#1a2235] bg-opacity-70 backdrop-blur-sm"></div>

        <!-- Content -->
        <div class="relative z-10 max-w-6xl mx-auto px-6 md:px-12 lg:px-24 text-white">

            <x-section-title first="How Can" second="You Help?" firstColor="#FFFFFF" />

            <div class="grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
                <!-- Make a Donation -->
                <div class="flex flex-col items-center justify-between h-full">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 rounded-full bg-[#FFB51B]/20 flex items-center justify-center mb-4">
                            <i class='bx bx-heart text-3xl text-[#FFB51B]'></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Make A Donation</h3>
                        <p class="text-sm">
                            Support our mission by contributing to our programs and initiatives. Every donation, big or
                            small, helps
                            provide essential resources, fund community projects, and empower individuals in need.
                        </p>
                    </div>
                </div>

                <!-- Become A Volunteer -->
                <div class="flex flex-col items-center justify-between h-full">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 rounded-full bg-[#FFB51B]/20 flex items-center justify-center mb-4">
                            <i class='bx bx-group text-3xl text-[#FFB51B]'></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Become A Volunteer</h3>
                        <p class="text-sm">
                            Join our team and help us make a difference in the community. Volunteers gain meaningful
                            experience,
                            connect with like-minded individuals, and play an active role in creating positive social
                            impact.
                        </p>
                    </div>
                </div>

                <!-- Partner With Us -->
                <div class="flex flex-col items-center justify-between h-full">
                    <div class="flex flex-col items-center">
                        <div class="w-20 h-20 rounded-full bg-[#FFB51B]/20 flex items-center justify-center mb-4">
                            <i class='bx bx-conversation text-3xl text-[#FFB51B]'></i>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Partner With Us</h3>
                        <p class="text-sm">
                            Collaborate with us to amplify impact and support more communities. Partnerships allow
                            organizations
                            and businesses to contribute resources, share expertise, and join forces to address social
                            challenges
                            effectively.
                        </p>
                    </div>
                </div>
            </div>


        </div>
    </section>



    <!-- Donation Methods -->
    <div class="py-16 px-6 md:px-16 lg:px-32">
            <x-section-title first="Ways to" second="Donate" firstColor="#FFFFFF" />

        <!-- Banks Section -->
        <div class="mb-12">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6 text-center">Bank Transfers</h3>
            <div class="flex flex-col md:flex-row justify-center items-start gap-8">
                <!-- BDO -->
                <div class="flex flex-col items-center text-center md:text-left gap-2">
                    <img src="{{ asset('assets/images/bg/donate-bdo.png') }}" alt="BDO Logo"
                        class="w-24 h-24 object-contain mb-2">
                    <div class="text-gray-700 space-y-1">
                        <p><strong>Account Name:</strong> Youmanitarian International</p>
                        <p><strong>Account Number:</strong> 0917-000-0000</p>
                        <p><strong>Branch:</strong> Main Branch</p>
                    </div>
                </div>

                <!-- BPI -->
                <div class="flex flex-col items-center text-center md:text-left gap-2">
                    <img src="{{ asset('assets/images/bg/donate-bpi.png') }}" alt="BPI Logo"
                        class="w-24 h-24 object-contain mb-2">
                    <div class="text-gray-700 space-y-1">
                        <p><strong>Account Name:</strong> Youmanitarian International</p>
                        <p><strong>Account Number:</strong> 0917-000-1111</p>
                        <p><strong>Branch:</strong> Main Branch</p>
                    </div>
                </div>

                <!-- Metrobank -->
                <div class="flex flex-col items-center text-center md:text-left gap-2">
                    <img src="{{ asset('assets/images/bg/donate-metrobank.png') }}" alt="Metrobank Logo"
                        class="w-24 h-24 object-contain mb-2">
                    <div class="text-gray-700 space-y-1">
                        <p><strong>Account Name:</strong> Youmanitarian International</p>
                        <p><strong>Account Number:</strong> 0917-000-2222</p>
                        <p><strong>Branch:</strong> Main Branch</p>
                    </div>
                </div>
            </div>
        </div>


        <!-- E-Wallet Section -->
        <div class="mb-12 text-center">
            <h3 class="text-2xl font-semibold text-gray-800 mb-6">E-Wallets</h3>
            <div class="flex flex-col md:flex-row justify-center items-center gap-12">
                <!-- GCash -->
                <div class="flex flex-col items-center">
                    <img src="{{ asset('assets/images/bg/donate-gcash.png') }}" alt="GCash Logo"
                        class="w-24 h-24 object-contain mb-2">
                    <p class="text-gray-700 mb-2">Scan the QR code below to donate instantly:</p>
                    <img src="{{ asset('assets/images/bg/QR-1.png') }}" alt="GCash QR" class="w-32 h-32 object-contain">
                </div>

                <!-- PayPal / PayMaya -->
                <div class="flex flex-col items-center">
                    <img src="{{ asset('assets/images/bg/donate-paypal.png') }}" alt="PayPal Logo"
                        class="w-24 h-24 object-contain mb-2">
                    <p class="text-gray-700 mb-2">Scan the QR code below to donate instantly:</p>
                    <img src="{{ asset('assets/images/bg/QR-2.png') }}" alt="PayPal QR" class="w-32 h-32 object-contain">
                </div>
            </div>
        </div>

        <!-- Instruction & Button -->
        <div class="text-center space-y-4">
            <p class="text-gray-700 text-lg">
                After making your donation, please fill out the form below to help us track your contribution.
                This ensures your donation is properly acknowledged and processed.
            </p>
            <x-button type="button" variant="primary"
                class="mt-2 inline-flex items-center justify-center px-8 py-3 text-lg"
                onclick="document.getElementById('addDonationModal-website').showModal()">
                <i class='bx bx-heart mr-2'></i> Fill Out Donation Form
            </x-button>
        </div>

        <!-- Disclaimer / Note -->
        <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-6 rounded-lg text-sm shadow-sm">
            <p class="mb-2">
                <strong>Note:</strong> This website does not process donations directly.
                Please use the details provided above to send your donation. After donating, kindly fill out our donation
                form.
            </p>
            <p class="mb-0">
                A treasurer or authorized staff will confirm receipt of your donation and provide acknowledgment if needed.
            </p>
        </div>

        <!-- Offline/Onsite Donations -->
        <div
            class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm flex flex-col md:flex-row items-start md:items-center gap-6">
            <div class="flex-shrink-0">
                <i class='bx bx-map text-4xl text-[#FFB51B]'></i>
            </div>
            <div class="text-gray-700 space-y-2">
                <h2 class="text-2xl font-bold text-gray-800">Offline / Onsite Donations</h2>
                <p>
                    You may also bring donations directly to our office or partner locations.
                    We welcome both monetary and in-kind contributions to support our programs.
                </p>
                <p><strong>Address:</strong> 123 Main Street, City, Province</p>
                <p><strong>Contact Person:</strong> Juan Dela Cruz – 0917 123 4567</p>
                <p class="text-sm text-gray-500">
                    Office hours: Mon-Fri, 8:00 AM – 5:00 PM. Please call ahead to coordinate large donations.
                </p>
            </div>
        </div>

    </div>


    <!-- 4. FAQ -->
    <section class="py-16 bg-[#1A2235]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <x-section-title first="Frequently" second="Asked Questions" mb="false" firstColor="#FFFFFF" />
            <p class="text-center text-gray-400 mb-10">
                Find answers to the most common questions about donating to Youmanitarian International.
            </p>

            <div class="space-y-4">
                <x-accordion-daisy title="How can I make a donation?" variant="dark">
                    <p>
                        You can make a donation via bank transfer, e-wallets like GCash or PayMaya, or credit/debit card.
                        Please refer to the donation methods provided above for detailed instructions.
                    </p>
                </x-accordion-daisy>

                <x-accordion-daisy title="Is my donation secure?" variant="dark">
                    <p>
                        Yes, your donations are secure. We do not process payments directly on this website,
                        but we provide verified bank and e-wallet account details to ensure your contribution reaches us
                        safely.
                    </p>
                </x-accordion-daisy>

                <x-accordion-daisy title="Can I donate offline?" variant="dark">
                    <p>
                        Yes, offline donations are welcome. You may bring donations directly to our office or partner
                        locations.
                        Please refer to the contact information and address provided in the offline donations section.
                    </p>
                </x-accordion-daisy>

                <x-accordion-daisy title="How will my donation be used?" variant="dark">
                    <p>
                        100% of your donation goes directly to our programs and beneficiaries.
                        Administrative costs are covered separately, ensuring maximum impact of your contribution.
                    </p>
                </x-accordion-daisy>

                <x-accordion-daisy title="Do I get a receipt for my donation?" variant="dark">
                    <p>
                        Yes. After making a donation, you can fill out our donation form.
                        A treasurer or authorized staff will then confirm your donation and provide a receipt if needed.
                    </p>
                </x-accordion-daisy>

                <x-accordion-daisy title="Can I set up a recurring donation?" variant="dark">
                    <p>
                        Currently, we accept one-time donations only. If you would like to support us regularly,
                        please contact us directly to discuss a recurring donation arrangement.
                    </p>
                </x-accordion-daisy>

                <x-accordion-daisy title="Who can I contact for donation inquiries?" variant="dark">
                    <p>
                        For any questions regarding donations, please contact our team via the contact details listed in the
                        offline donation section.
                    </p>
                </x-accordion-daisy>
            </div>
        </div>
    </section>


    @include('finance.modals.addDonationModal', [
        'modalId' => 'addDonationModal-website',
        'action' => route('website.donations.store'),
    ])
@endsection
