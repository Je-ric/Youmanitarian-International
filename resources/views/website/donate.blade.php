@extends('layouts.navbar')

@section('content')
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
        <div class="bg-white rounded-2xl border border-gray-200 p-6">
            <h2 class="text-2xl font-bold text-gray-800 mb-6">Frequently Asked Questions</h2>
            <div class="space-y-4">
                <div>
                    <h3 class="font-semibold text-gray-700">Will I get a receipt for my donation?</h3>
                    <p class="text-gray-600 text-sm">Yes, receipts can be provided upon request. Please contact our treasurer for details.</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700">Can I donate in-kind (clothes, food, supplies)?</h3>
                    <p class="text-gray-600 text-sm">Yes, we welcome in-kind donations. Please coordinate with our contact person for drop-off arrangements.</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700">Do you accept international donations?</h3>
                    <p class="text-gray-600 text-sm">Yes, international donations are possible through bank transfer and certain e-wallets. Please reach out to confirm details.</p>
                </div>
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
