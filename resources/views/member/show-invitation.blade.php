@extends('layouts.sidebar_final')

@section('content')
    <div class="min-h-screen bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl mx-auto">

            <!-- Main Invitation Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

                <!-- Organization Header -->
                <div class="bg-[#1a2235] px-8 py-8">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-white rounded-xl p-2 flex-shrink-0">
                            <img src="{{ asset('assets/images/logo/YI_Logo.png') }}" alt="Youmanitarian International Logo"
                                class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-white">Youmanitarian International</h1>
                            <p class="text-gray-300 text-sm">Membership Invitation</p>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-8">

                    <!-- Invitation Message -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-[#1a2235] mb-3">You're Invited</h2>
                        <p class="text-gray-600 mb-6">You have been invited to join our humanitarian mission.</p>

                        @if($invitationMessage)
                            <div class="bg-[#ffb51b]/5 border-l-4 border-[#ffb51b] rounded-r-lg p-4">
                                <p class="text-gray-700 italic">"{{ $invitationMessage }}"</p>
                            </div>
                        @endif
                    </div>

                    <!-- Membership Details -->
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <!-- Membership Type -->
                        <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <i class='bx bx-id-card text-blue-600'></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-[#1a2235]">Membership Type</h4>
                                    <p class="text-sm text-gray-600">Your designated role</p>
                                </div>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <p class="text-xl font-bold text-[#ffb51b]">
                                    {{ ucwords(str_replace('_', ' ', $member->membership_type)) }} Member
                                </p>
                            </div>
                        </div>
                        <!-- Benefits -->
                        <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-xl p-6 border border-emerald-200">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center">
                                    <i class='bx bx-gift text-emerald-600'></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-[#1a2235]">Member Benefits</h4>
                                    <p class="text-sm text-gray-600">What you'll receive</p>
                                </div>
                            </div>
                            <ul class="space-y-2 text-sm text-gray-700">
                                <li class="flex items-center gap-2">
                                    <i class='bx bx-check text-emerald-600'></i>
                                    Access to exclusive programs
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class='bx bx-check text-emerald-600'></i>
                                    Community networking opportunities
                                </li>
                                <li class="flex items-center gap-2">
                                    <i class='bx bx-check text-emerald-600'></i>
                                    Impact reporting and updates
                                </li>
                            </ul>
                        </div>
                    </div>


                </div>

                <!-- Terms & Conditions -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-8">
                    <div class="flex items-start gap-3">
                        <i class='bx bx-info-circle text-blue-600 text-lg flex-shrink-0 mt-0.5'></i>
                        <div>
                            <p class="text-blue-800 font-medium text-sm mb-1">Terms & Conditions</p>
                            <p class="text-blue-700 text-xs leading-relaxed">
                                By accepting this invitation, you agree to our
                                <a href="#" class="underline hover:no-underline font-medium">Terms of Service</a> and
                                <a href="#" class="underline hover:no-underline font-medium">Privacy Policy</a>.
                                Your membership will be activated upon acceptance.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-3">
                    <a href="{{ $acceptUrl }}"
                        class="flex-1 bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-3 px-6 rounded-lg transition-colors duration-200 text-center">
                        Accept Invitation
                    </a>
                    <a href="{{ $declineUrl }}"
                        class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-lg transition-colors duration-200 text-center">
                        Decline
                    </a>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-500">
                Need help?
                <a href="mailto:support@youmanitarian.org" class="text-[#ffb51b] hover:underline">
                    Contact Support
                </a>
            </p>
        </div>
    </div>

    <style>
        /* Responsive adjustments for sidebar layout */
        @media (min-width: 1024px) {
            .max-w-2xl {
                max-width: calc(100vw - 22rem);
                /* Account for sidebar width */
            }
        }

        /* Mobile optimizations */
        @media (max-width: 640px) {
            .p-8 {
                padding: 1.5rem;
            }

            .px-8 {
                padding-left: 1.5rem;
                padding-right: 1.5rem;
            }

            .py-8 {
                padding-top: 1.5rem;
                padding-bottom: 1.5rem;
            }
        }

        /* Focus states for accessibility */
        a:focus {
            outline: 2px solid #ffb51b;
            outline-offset: 2px;
        }
    </style>
@endsection