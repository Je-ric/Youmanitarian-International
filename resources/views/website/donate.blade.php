@extends('layouts.navbar')

@section('content')
<section class="relative w-full min-h-screen flex items-center">
    <!-- Background image -->
    <img src="{{ asset('assets/images/bg/donate-bg.jpg') }}"
         alt="Support Youmanitarian International"
         class="absolute inset-0 w-full h-full object-cover">

    <!-- Gradient overlay (dark top -> transparent bottom) -->
    <div class="absolute inset-0 bg-gradient-to-b from-[#1a2235]/90 via-[#1a2235]/70 to-transparent"></div>

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


<div class="min-h-screen bg-gray-50 py-12 px-6">
    <div class="max-w-5xl mx-auto flex flex-col gap-16">

        <!-- Page Header -->
        <div class="text-center">
            <h1 class="text-5xl font-extrabold text-gray-800 mb-4">Donate</h1>
            <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                Your support helps us continue our programs. Choose a method below and make a secure donation.
            </p>

            <!-- Disclaimer Note -->
            <div class="mt-6 bg-yellow-50 border-l-4 border-yellow-400 text-yellow-800 p-4 rounded-lg text-sm max-w-2xl mx-auto">
                <p>
                    <strong>Note:</strong> This website does not process donations directly.
                    Please use the details provided below to send your donation.
                    After donating, you may fill out our donation form.
                    A treasurer or authorized staff will then confirm your donation as received.
                </p>
            </div>
        </div>

        <!-- 1. Why Donate -->
        <div class="text-center">
            <h2 class="text-3xl font-bold text-gray-800 mb-4">Why Donate?</h2>
            <p class="text-gray-600 max-w-3xl mx-auto">
                Every contribution you make allows us to sustain our programs and reach more communities in need.
                Whether it’s supporting children’s education, providing relief during disasters, or empowering local volunteers—your help makes it possible.
            </p>
        </div>

        <!-- 2. Transparency -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Transparency & Assurance</h2>
            <p class="text-gray-600 mb-3">
                We are committed to using your donations responsibly. 100% of your support goes directly to our programs and beneficiaries.
            </p>
            <p class="text-gray-600">
                Administrative costs are covered separately, ensuring your contribution creates the maximum impact.
                <a href="#" class="text-indigo-600 hover:underline">View our financial reports</a> (if available).
            </p>
        </div>

        <!-- Donation Methods -->
        <div>
            <h2 class="text-3xl font-bold text-gray-800 text-center mb-8">Ways to Donate</h2>
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Bank Transfer -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 flex flex-col items-center text-center">
                    <i class='bx bx-bank text-indigo-600 text-5xl mb-3'></i>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Bank Transfer</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Send your donations directly to our bank account.
                    </p>
                    <div class="bg-gray-50 rounded-lg p-3 text-sm w-full">
                        <p><strong>Bank:</strong> ABC Bank</p>
                        <p><strong>Account:</strong> 1234-5678-90</p>
                        <p><strong>Name:</strong> Youmanitarian Intl.</p>
                    </div>
                </div>

                <!-- E-Wallet -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 flex flex-col items-center text-center">
                    <i class='bx bx-wallet text-green-600 text-5xl mb-3'></i>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">E-Wallet (GCash/PayMaya)</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Scan the QR code below to donate via GCash or PayMaya.
                    </p>
                    <img src="{{ asset('images/qr-gcash.png') }}" alt="GCash QR" class="w-32 h-32 object-contain mb-2">
                    <img src="{{ asset('images/qr-paymaya.png') }}" alt="PayMaya QR" class="w-32 h-32 object-contain">
                </div>

                <!-- Credit/Debit Card -->
                <div class="bg-white rounded-2xl border border-gray-200 p-6 flex flex-col items-center text-center">
                    <i class='bx bx-credit-card text-purple-600 text-5xl mb-3'></i>
                    <h3 class="text-xl font-semibold text-gray-800 mb-2">Credit / Debit Card</h3>
                    <p class="text-gray-600 text-sm mb-4">
                        Donate using Visa, MasterCard, or other major cards.
                    </p>
                    <x-button type="button" variant="primary" class="w-full mt-auto"
                        onclick="document.getElementById('addDonationModal-website').showModal()">
                        <i class='bx bx-heart'></i> Fill Out Donation Form
                    </x-button>
                </div>
            </div>
        </div>

        <!-- 3. Offline Donations -->
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Offline Donations</h2>
            <p class="text-gray-600 mb-3">
                You may also bring donations directly to our office or partner locations.
            </p>
            <p class="text-gray-600"><strong>Address:</strong> 123 Main Street, City, Province</p>
            <p class="text-gray-600"><strong>Contact Person:</strong> Juan Dela Cruz – 0917 123 4567</p>
        </div>

     <!-- 4. FAQ -->

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
    
<div class="bg-white rounded-2xl border border-gray-200 p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Frequently Asked Questions</h2>

    <div class="space-y-4">
        <x-accordion-daisy title="Will I get a receipt for my donation?">
            <p class="text-gray-600 text-sm">
                Yes, receipts can be provided upon request. Please contact our treasurer for details.
            </p>
        </x-accordion-daisy>

        <x-accordion-daisy title="Can I donate in-kind (clothes, food, supplies)?">
            <p class="text-gray-600 text-sm">
                Yes, we welcome in-kind donations. Please coordinate with our contact person for drop-off arrangements.
            </p>
        </x-accordion-daisy>

        <x-accordion-daisy title="Do you accept international donations?">
            <p class="text-gray-600 text-sm">
                Yes, international donations are possible through bank transfer and certain e-wallets.
                Please reach out to confirm details.
            </p>
        </x-accordion-daisy>
    </div>
</div>


    </div>

    <h1 class="text-xl font-bold mt-16">We need to know the different donation method na meron sila</h1>
    <p>If may bank (for each bank), we need the account details (bank name, account name, account number, etc.).</p>
    <p>E-wallets (GCash, PayMaya, etc.) - we need the account details (account name, account number, QR's).</p>
    <p>Location for offline donations (if applicable) - we need the address and contact person details.</p>
</div>

@include('finance.modals.addDonationModal', [
    'modalId' => 'addDonationModal-website',
    'action'  => route('website.donations.store'),
])
@endsection
