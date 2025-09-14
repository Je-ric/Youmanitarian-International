@extends('layouts.sidebar_final')

@section('content')
    <div class="min-h-screen bg-gray-50 py-8 px-4 sm:py-12 sm:px-6 lg:px-8">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">

                <div class="bg-[#1a2235] px-6 py-8 sm:px-8">
                    <div class="flex items-center gap-4">
                        <div class="w-16 h-16 bg-white rounded-xl p-2 flex-shrink-0">
                            <img src="{{ asset('assets/images/logo/YI.jpg') }}" alt="Youmanitarian International Logo"
                                class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-white">Youmanitarian International</h1>
                            <p class="text-gray-300 text-sm">Membership Invitation</p>
                        </div>
                    </div>
                </div>

                <div class="p-6 sm:p-8">
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold text-[#1a2235] mb-4">You're Invited</h2>
                        <p class="text-gray-600 leading-relaxed mb-6">
                            You have been invited to join our humanitarian mission — not only as a volunteer, but as a
                            valued <span class="font-semibold text-[#1a2235]">member</span> who helps shape the vision,
                            plans, and impact of our organization. Your commitment ensures that together, we can sustain
                            meaningful change in the communities we serve.
                        </p>

                        @if ($invitationMessage)
                            <div class="bg-[#ffb51b]/10 border-l-4 border-[#ffb51b] rounded-r-xl p-4">
                                <p class="text-gray-700 italic">"{{ $invitationMessage }}"</p>
                            </div>
                        @endif
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
                        <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-6 border border-gray-200">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <i class='bx bx-id-card text-blue-600 text-xl'></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-[#1a2235]">Membership Type</h4>
                                    <p class="text-sm text-gray-600">Your designated role</p>
                                </div>
                            </div>
                            <div class="bg-white rounded-xl p-4 border border-gray-200">
                                <p class="text-xl font-bold text-[#ffb51b]">
                                    {{ ucwords(str_replace('_', ' ', $member->membership_type)) }} Member
                                </p>
                            </div>
                        </div>

                        <div class="bg-gradient-to-br from-emerald-50 to-green-50 rounded-xl p-6 border border-emerald-200">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center">
                                    <i class='bx bx-gift text-emerald-600 text-xl'></i>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-[#1a2235]">Member Benefits</h4>
                                    <p class="text-sm text-gray-600">What you'll receive</p>
                                </div>
                            </div>
                            <ul class="space-y-3 text-sm text-gray-700">
                                <li class="flex items-start gap-3">
                                    <i class='bx bx-calendar text-indigo-600 mt-0.5 text-base'></i>
                                    <span>Membership contributions can be made <span class="font-semibold">quarterly</span>,
                                        making it flexible and sustainable for you.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class='bx bx-bulb text-indigo-600 mt-0.5 text-base'></i>
                                    <span>As a member, you'll take part in <span class="font-semibold">planning and
                                            decision-making</span> for upcoming programs and initiatives.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class='bx bx-group text-indigo-600 mt-0.5 text-base'></i>
                                    <span>You're not just a volunteer — you'll be recognized as a <span
                                            class="font-semibold">partner in the organization's mission</span>.</span>
                                </li>
                                <li class="flex items-start gap-3">
                                    <i class='bx bx-line-chart text-indigo-600 mt-0.5 text-base'></i>
                                    <span>Gain access to <span class="font-semibold">strategic updates</span> and help shape
                                        the impact of our community efforts.</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="bg-blue-50 border border-blue-200 rounded-xl p-4 mb-8">
                        <div class="flex items-start gap-3">
                            <i class='bx bx-info-circle text-blue-600 text-lg flex-shrink-0 mt-0.5'></i>
                            <div>
                                <p class="text-blue-800 font-medium text-sm mb-1">Terms & Conditions</p>
                                <p class="text-blue-700 text-xs leading-relaxed">
                                    By accepting this invitation, you agree to our
                                    <a href="#" class="underline hover:no-underline font-medium">Terms of Service</a>
                                    and
                                    <a href="#" class="underline hover:no-underline font-medium">Privacy Policy</a>.
                                    Your membership will be activated upon acceptance.
                                </p>
                            </div>
                        </div>
                    </div>

                    @if (!in_array($member->membership_status, ['active']) && $member->invitation_status !== 'accepted')
                        <div class="flex flex-col sm:flex-row gap-3">
                            <form action="{{ route('member.invitation.accept', $member) }}" method="POST" class="flex-1">
                                @csrf
                                <button type="submit"
                                    class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-medium py-3 px-6 rounded-xl transition-all duration-200 hover:shadow-lg">
                                    Accept Invitation
                                </button>
                            </form>
                            {{--
                        <form action="{{ route('member.invitation.decline', $member) }}" method="POST" class="flex-1">
                            @csrf
                            <button type="submit" class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 font-medium py-3 px-6 rounded-xl transition-all duration-200">
                                Decline
                            </button>
                        </form>
                        --}}
                        </div>
                    @else
                        <x-feedback-status.alert type="success" message="Membership already accepted." />
                    @endif
                </div>
            </div>
        </div>

        {{-- <div class="mt-6 text-center">
        <p class="text-sm text-gray-500">
            Need help?
            <a href="mailto:support@youmanitarian.org" class="text-[#ffb51b] hover:underline">
                Contact Support
            </a>
        </p>
    </div> --}}
    </div>

    <style>
        @media (min-width: 1024px) {
            .max-w-3xl {
                max-width: calc(100vw - 22rem);
            }
        }

        @media (max-width: 640px) {
            .p-6 {
                padding: 1.25rem;
            }

            .px-6 {
                padding-left: 1.25rem;
                padding-right: 1.25rem;
            }
        }

        a:focus {
            outline: 2px solid #ffb51b;
            outline-offset: 2px;
        }
    </style>
@endsection
