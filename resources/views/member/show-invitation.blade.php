@extends('layouts.sidebar_final')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-slate-100 py-8 px-4 sm:px-6 lg:px-8">
    <div class="max-w-5xl mx-auto">
        
        <!-- Header Section -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-[#1a2235] to-[#2a3441] rounded-2xl mb-4">
                <i class='bx bx-envelope text-white text-2xl'></i>
            </div>
            <h1 class="text-3xl font-bold text-[#1a2235] tracking-tight">Membership Invitation</h1>
            <p class="text-gray-600 mt-2 max-w-2xl mx-auto">You have received an exclusive invitation to join our humanitarian mission</p>
        </div>

        <!-- Main Invitation Card -->
        <div class="bg-white rounded-2xl shadow-xl border border-gray-200 overflow-hidden">
            
            <!-- Organization Header -->
            <div class="bg-gradient-to-r from-[#1a2235] via-[#2a3441] to-[#1a2235] px-6 sm:px-8 lg:px-12 py-8">
                <div class="flex flex-col lg:flex-row items-center lg:items-start gap-6">
                    <!-- Logo Section -->
                    <div class="flex-shrink-0">
                        <div class="w-20 h-20 bg-white rounded-2xl p-3 shadow-lg">
                            <img src="{{ asset('assets/images/logo/YI_Logo.png') }}" 
                                 alt="Youmanitarian International Logo" 
                                 class="w-full h-full object-contain">
                        </div>
                    </div>
                    
                    <!-- Organization Info -->
                    <div class="text-center lg:text-left flex-1">
                        <h2 class="text-2xl sm:text-3xl font-bold text-white leading-tight">
                            Youmanitarian International
                        </h2>
                        <p class="text-slate-300 mt-2 text-lg">
                            Humanitarian Organization
                        </p>
                        <div class="flex flex-wrap justify-center lg:justify-start gap-4 mt-4">
                            <div class="flex items-center text-slate-300 text-sm">
                                <i class='bx bx-world mr-2'></i>
                                Global Impact
                            </div>
                            <div class="flex items-center text-slate-300 text-sm">
                                <i class='bx bx-heart mr-2'></i>
                                Humanitarian Mission
                            </div>
                            <div class="flex items-center text-slate-300 text-sm">
                                <i class='bx bx-group mr-2'></i>
                                Community Driven
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Invitation Content -->
            <div class="px-6 sm:px-8 lg:px-12 py-8">
                
                <!-- Invitation Title -->
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-12 h-12 bg-[#ffb51b]/10 rounded-xl mb-4">
                        <i class='bx bx-user-plus text-[#ffb51b] text-xl'></i>
                    </div>
                    <h3 class="text-2xl font-bold text-[#1a2235] mb-2">You're Cordially Invited</h3>
                    <p class="text-gray-600 text-lg">To join our mission of making a positive impact worldwide</p>
                </div>

                <!-- Invitation Message -->
                @if($invitationMessage)
                <div class="mb-8">
                    <div class="bg-gradient-to-r from-[#ffb51b]/5 to-transparent border-l-4 border-[#ffb51b] rounded-r-xl p-6">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0 w-10 h-10 bg-[#ffb51b]/10 rounded-lg flex items-center justify-center">
                                <i class='bx bx-message-dots text-[#ffb51b]'></i>
                            </div>
                            <div class="flex-1">
                                <h4 class="font-semibold text-[#1a2235] mb-2">Personal Message</h4>
                                <blockquote class="text-gray-700 italic leading-relaxed">
                                    "{{ $invitationMessage }}"
                                </blockquote>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

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

                <div class="p-4 bg-blue-50 border border-blue-200 rounded-lg">
                    <div class="flex items-start gap-3">
                        <i class='bx bx-info-circle text-blue-600 text-lg flex-shrink-0 mt-0.5'></i>
                        <div>
                            <p class="text-blue-800 font-medium text-sm mb-1">Terms & Conditions</p>
                            <p class="text-blue-700 text-xs leading-relaxed">
                                By accepting this invitation, you acknowledge that you have read and agree to our 
                                <a href="#" class="underline hover:no-underline font-medium">Terms of Service</a> and 
                                <a href="#" class="underline hover:no-underline font-medium">Privacy Policy</a>. 
                                Your membership will be activated upon acceptance.
                            </p>
                        </div>
                    </div>
                </div>
                

                <!-- Terms and Conditions -->
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-6 mb-8">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-amber-100 rounded-lg flex items-center justify-center">
                            <i class='bx bx-info-circle text-amber-600 text-sm'></i>
                        </div>
                        <div class="flex-1">
                            <h4 class="font-semibold text-amber-800 mb-2">Terms & Conditions</h4>
                            <p class="text-amber-700 text-sm leading-relaxed">
                                By accepting this invitation, you acknowledge that you have read and agree to our 
                                <a href="#" class="underline hover:no-underline font-medium">Terms of Service</a> and 
                                <a href="#" class="underline hover:no-underline font-medium">Privacy Policy</a>. 
                                Your membership will be subject to our organizational guidelines and code of conduct.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ $acceptUrl }}" 
                       class="flex-1 group relative overflow-hidden bg-gradient-to-r from-emerald-600 to-green-600 text-white font-semibold py-4 px-8 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-center">
                        <div class="relative z-10 flex items-center justify-center gap-2">
                            <i class='bx bx-check-circle text-xl'></i>
                            <span>Accept Invitation</span>
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-r from-emerald-700 to-green-700 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                    </a>
                    
                    <a href="{{ $declineUrl }}" 
                       class="flex-1 group bg-white border-2 border-gray-300 text-gray-700 font-semibold py-4 px-8 rounded-xl hover:border-gray-400 hover:bg-gray-50 transition-all duration-200 text-center">
                        <div class="flex items-center justify-center gap-2">
                            <i class='bx bx-x-circle text-xl'></i>
                            <span>Decline Politely</span>
                        </div>
                    </a>
                </div>

                <!-- Additional Information -->
                <div class="mt-8 pt-6 border-t border-gray-200">
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mb-2">
                                <i class='bx bx-time text-blue-600'></i>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Quick Setup</p>
                            <p class="text-xs text-gray-600">5 minutes to complete</p>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mb-2">
                                <i class='bx bx-shield-check text-purple-600'></i>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Secure Process</p>
                            <p class="text-xs text-gray-600">Your data is protected</p>
                        </div>
                        <div class="flex flex-col items-center">
                            <div class="w-8 h-8 bg-green-100 rounded-lg flex items-center justify-center mb-2">
                                <i class='bx bx-support text-green-600'></i>
                            </div>
                            <p class="text-sm font-medium text-gray-900">Full Support</p>
                            <p class="text-xs text-gray-600">We're here to help</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Information -->
        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500">
                Need help? Contact us at 
                <a href="mailto:support@youmanitarian.org" class="text-[#ffb51b] hover:underline font-medium">
                    support@youmanitarian.org
                </a>
            </p>
        </div>
    </div>
</div>

<style>
/* Responsive adjustments for sidebar layout */
@media (min-width: 1024px) {
    .max-w-5xl {
        max-width: calc(100vw - 20rem); /* Account for sidebar width */
    }
}

/* Mobile optimizations */
@media (max-width: 640px) {
    .min-h-screen {
        padding: 1rem;
    }
    
    .rounded-2xl {
        border-radius: 1rem;
    }
}

/* Print styles for formal documentation */
@media print {
    .bg-gradient-to-br,
    .bg-gradient-to-r {
        background: white !important;
        color: black !important;
    }
    
    .shadow-xl,
    .shadow-lg {
        box-shadow: none !important;
        border: 1px solid #e5e7eb !important;
    }
}

/* Focus states for accessibility */
a:focus {
    outline: 2px solid #ffb51b;
    outline-offset: 2px;
}

/* Hover animations */
.transform {
    transition: transform 0.2s ease-in-out;
}

.hover\:-translate-y-0\.5:hover {
    transform: translateY(-0.125rem);
}
</style>
@endsection
