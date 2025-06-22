@extends('layouts.sidebar_final')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-gray-50 to-slate-100 flex items-center justify-center py-8 px-4">
    <div class="w-full max-w-5xl mx-auto">
        <!-- Main Invitation Card -->
        <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-gray-100">
            <div class="flex flex-col lg:flex-row">
                
                <!-- Left Panel - Brand Section -->
                <div class="w-full lg:w-2/5 bg-gradient-to-br from-[#1a2235] via-[#2a3441] to-[#1a2235] relative overflow-hidden">
                    <!-- Decorative Elements -->
                    <div class="absolute inset-0 bg-gradient-to-br from-[#ffb51b]/10 to-transparent"></div>
                    <div class="absolute top-0 right-0 w-32 h-32 bg-[#ffb51b]/20 rounded-full -translate-y-16 translate-x-16"></div>
                    <div class="absolute bottom-0 left-0 w-24 h-24 bg-[#ffb51b]/15 rounded-full translate-y-12 -translate-x-12"></div>
                    
                    <div class="relative z-10 p-8 lg:p-12 flex flex-col justify-center items-center text-center min-h-[300px] lg:min-h-[600px]">
                        <!-- Logo Section -->
                        <div class="mb-8">
                            <div class="w-20 h-20 lg:w-24 lg:h-24 bg-white rounded-2xl p-3 shadow-lg mb-6 mx-auto">
                                <img src="{{ asset('assets/images/logo/YI_Logo.png') }}" 
                                     alt="Youmanitarian International Logo" 
                                     class="w-full h-full object-contain">
                            </div>
                            <div class="space-y-2">
                                <h1 class="text-white font-bold text-2xl lg:text-3xl tracking-tight">Youmanitarian</h1>
                                <h1 class="text-white font-bold text-2xl lg:text-3xl tracking-tight">International</h1>
                            </div>
                        </div>
                        
                        <!-- Mission Statement -->
                        <div class="space-y-4 max-w-sm">
                            <div class="w-16 h-0.5 bg-[#ffb51b] mx-auto"></div>
                            <p class="text-slate-300 text-sm lg:text-base leading-relaxed">
                                Empowering communities through humanitarian action and sustainable development initiatives worldwide.
                            </p>
                            <div class="flex items-center justify-center gap-2 text-[#ffb51b] text-xs font-medium">
                                <i class='bx bx-shield-check'></i>
                                <span>Trusted • Global • Impact</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Panel - Invitation Content -->
                <div class="w-full lg:w-3/5 p-8 lg:p-12">
                    <!-- Header Section -->
                    <div class="mb-8">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-[#ffb51b] to-[#ff9500] rounded-xl flex items-center justify-center">
                                <i class='bx bx-envelope text-white text-xl'></i>
                            </div>
                            <div>
                                <h2 class="text-2xl lg:text-3xl font-bold text-[#1a2235] tracking-tight">Membership Invitation</h2>
                                <p class="text-gray-600 text-sm lg:text-base">Join our global humanitarian network</p>
                            </div>
                        </div>
                        
                        <div class="w-full h-px bg-gradient-to-r from-[#ffb51b] via-[#ffb51b]/50 to-transparent"></div>
                    </div>

                    <!-- Invitation Message -->
                    @if($invitationMessage)
                        <div class="mb-8 p-6 bg-gradient-to-r from-[#ffb51b]/5 to-transparent border-l-4 border-[#ffb51b] rounded-r-xl">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 bg-[#ffb51b]/20 rounded-lg flex items-center justify-center flex-shrink-0 mt-1">
                                    <i class='bx bx-message-dots text-[#ffb51b] text-sm'></i>
                                </div>
                                <div>
                                    <p class="text-[#1a2235] font-semibold text-sm mb-2">Personal Message from Your Inviter:</p>
                                    <blockquote class="text-gray-700 italic text-sm lg:text-base leading-relaxed">
                                        "{{ $invitationMessage }}"
                                    </blockquote>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Membership Details -->
                    <div class="mb-8">
                        <h3 class="text-lg font-semibold text-[#1a2235] mb-4 flex items-center gap-2">
                            <i class='bx bx-id-card text-[#ffb51b]'></i>
                            Membership Details
                        </h3>
                        
                        <div class="bg-gradient-to-br from-slate-50 to-gray-50 border border-gray-200 rounded-xl p-6">
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600 font-medium mb-1">Membership Type</p>
                                    <p class="text-lg font-bold text-[#1a2235] flex items-center gap-2">
                                        <span class="w-2 h-2 bg-[#ffb51b] rounded-full"></span>
                                        {{ ucwords(str_replace('_', ' ', $member->membership_type)) }} Member
                                    </p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600 font-medium mb-1">Status</p>
                                    <p class="text-lg font-bold text-emerald-600 flex items-center gap-2">
                                        <i class='bx bx-check-circle text-sm'></i>
                                        Pending Acceptance
                                    </p>
                                </div>
                            </div>
                            
                            <!-- Benefits Preview -->
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <p class="text-sm font-semibold text-[#1a2235] mb-3">Membership Benefits Include:</p>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <i class='bx bx-check text-emerald-500 text-xs'></i>
                                        <span>Access to exclusive programs</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class='bx bx-check text-emerald-500 text-xs'></i>
                                        <span>Global network connection</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class='bx bx-check text-emerald-500 text-xs'></i>
                                        <span>Impact reporting & updates</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class='bx bx-check text-emerald-500 text-xs'></i>
                                        <span>Volunteer opportunities</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Terms and Actions -->
                    <div class="space-y-6">
                        <!-- Terms Notice -->
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

                        <!-- Action Buttons -->
                        <div class="flex flex-col sm:flex-row gap-4">
                            <a href="{{ $acceptUrl }}" 
                               class="flex-1 group relative overflow-hidden bg-gradient-to-r from-emerald-600 to-emerald-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 text-center">
                                <div class="absolute inset-0 bg-gradient-to-r from-emerald-700 to-emerald-800 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
                                <div class="relative flex items-center justify-center gap-2">
                                    <i class='bx bx-check-circle text-lg'></i>
                                    <span>Accept Invitation</span>
                                </div>
                            </a>
                            
                            <a href="{{ $declineUrl }}" 
                               class="flex-1 group bg-white border-2 border-gray-300 text-gray-700 font-semibold py-4 px-6 rounded-xl hover:border-gray-400 hover:bg-gray-50 transition-all duration-200 text-center">
                                <div class="flex items-center justify-center gap-2">
                                    <i class='bx bx-x-circle text-lg'></i>
                                    <span>Decline Politely</span>
                                </div>
                            </a>
                        </div>

                        <!-- Contact Information -->
                        <div class="pt-6 border-t border-gray-200">
                            <p class="text-xs text-gray-500 text-center mb-3">
                                Questions about this invitation? Contact our membership team
                            </p>
                            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 text-xs text-gray-600">
                                <a href="mailto:membership@youmanitarian.org" class="flex items-center gap-1 hover:text-[#ffb51b] transition-colors">
                                    <i class='bx bx-envelope'></i>
                                    <span>membership@youmanitarian.org</span>
                                </a>
                                <div class="hidden sm:block w-px h-4 bg-gray-300"></div>
                                <a href="tel:+1234567890" class="flex items-center gap-1 hover:text-[#ffb51b] transition-colors">
                                    <i class='bx bx-phone'></i>
                                    <span>+1 (234) 567-8900</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="mt-8 text-center">
            <p class="text-xs text-gray-500">
                This invitation is confidential and intended solely for the named recipient. 
                Please do not forward or share this invitation link.
            </p>
        </div>
    </div>
</div>

<style>
/* Custom responsive utilities */
@media (max-width: 640px) {
    .min-h-screen {
        min-height: 100vh;
    }
}

@media (min-width: 641px) and (max-width: 1023px) {
    .lg\:min-h-\[600px\] {
        min-height: 400px;
    }
}

/* Enhanced focus states for accessibility */
a:focus-visible {
    outline: 2px solid #ffb51b;
    outline-offset: 2px;
}

/* Smooth animations */
.group:hover .group-hover\:opacity-100 {
    transition: opacity 0.2s ease-in-out;
}

/* Custom gradient borders */
.border-gradient {
    background: linear-gradient(white, white) padding-box,
                linear-gradient(45deg, #ffb51b, #ff9500) border-box;
    border: 2px solid transparent;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add loading states to buttons
    const buttons = document.querySelectorAll('a[href*="accept"], a[href*="decline"]');
    
    buttons.forEach(button => {
        button.addEventListener('click', function(e) {
            const originalText = this.innerHTML;
            const isAccept = this.href.includes('accept');
            
            // Add loading state
            this.innerHTML = `
                <div class="flex items-center justify-center gap-2">
                    <div class="w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></div>
                    <span>${isAccept ? 'Processing...' : 'Declining...'}</span>
                </div>
            `;
            
            this.style.pointerEvents = 'none';
            this.style.opacity = '0.8';
        });
    });
    
    // Add subtle animations on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    });
    
    // Observe elements for animation
    document.querySelectorAll('.bg-white').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(20px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});
</script>
@endsection
