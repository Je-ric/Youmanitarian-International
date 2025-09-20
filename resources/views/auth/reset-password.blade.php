@extends('layouts.navbar')

@section('content')
<!-- Updated background with project colors -->
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-gray-50 to-[#1A2235]/5 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Enhanced card design with border instead of shadow -->
        <div class="bg-white rounded-2xl border-2 border-slate-200 p-8 space-y-6">
            <div class="text-center">
                <!-- Added icon and improved typography -->
                <div class="mx-auto h-16 w-16 bg-gradient-to-r from-[#1A2235] to-[#1A2235]/90 rounded-full flex items-center justify-center mb-4">
                    <i class='bx bx-reset text-2xl text-white'></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-800 mb-2">
                    Reset your password
                </h2>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Enter your new password below.
                </p>
            </div>

            <form class="space-y-4" method="POST" action="{{ route('password.update') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- Improved input styling with better spacing and icons -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class='bx bx-envelope text-slate-400'></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required
                               class="block w-full pl-10 pr-3 py-3 border-2 border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#FFB51B] focus:border-[#FFB51B] transition-colors duration-200"
                               placeholder="Enter your email address" value="{{ old('email', $email) }}">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">New Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class='bx bx-lock-alt text-slate-400'></i>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="new-password" required
                               class="block w-full pl-10 pr-3 py-3 border-2 border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#FFB51B] focus:border-[#FFB51B] transition-colors duration-200"
                               placeholder="Enter new password">
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Confirm New Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class='bx bx-check-shield text-slate-400'></i>
                        </div>
                        <input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                               class="block w-full pl-10 pr-3 py-3 border-2 border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#FFB51B] focus:border-[#FFB51B] transition-colors duration-200"
                               placeholder="Confirm new password">
                    </div>
                </div>

                <!-- Enhanced error messages styling -->
                {{-- @if ($errors->any())
                    <div class="rounded-xl bg-red-50 border-2 border-red-200 p-4">
                        <div class="flex items-start">
                            <i class='bx bx-error-circle text-red-600 mr-2 mt-0.5'></i>
                            <div class="text-sm text-red-700">
                                <ul class="list-disc list-inside space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif --}}

                <!-- Enhanced success message styling -->
                @if (session('status'))
                    <div class="rounded-xl bg-green-50 border-2 border-green-200 p-4">
                        <div class="flex items-center">
                            <i class='bx bx-check-circle text-green-600 mr-2'></i>
                            <div class="text-sm text-green-700 font-medium">
                                {{ session('status') }}
                            </div>
                        </div>
                    </div>
                @endif

                 <!-- Updated button styling with project colors -->
                 <div class="pt-2">
                     <button type="submit" class="w-full bg-[#1A2235] hover:bg-[#1A2235]/90 text-white font-semibold py-3 px-4 rounded-xl flex justify-center items-center transition-colors duration-200">
                         <i class='bx bx-check mr-2'></i>
                         Reset Password
                     </button>
                 </div>

                <!-- Enhanced back link styling -->
                <div class="text-center pt-4 border-t border-slate-200">
                    <a href="{{ route('login') }}" class="inline-flex items-center font-medium text-[#FFB51B] hover:text-[#FFB51B]/80 transition-colors duration-200">
                        <i class='bx bx-arrow-back mr-1'></i>
                        Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
