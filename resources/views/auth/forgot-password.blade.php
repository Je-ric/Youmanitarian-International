@extends('layouts.navbar')

@section('content')
<!-- Updated background with navy gradient and improved spacing -->
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Enhanced card design with border instead of shadow -->
        <div class="bg-white rounded-2xl border-2 border-slate-200 p-8 space-y-6">
            <div class="text-center">
                <!-- Added icon and improved typography -->
                <div class="mx-auto h-16 w-16 bg-gradient-to-r from-blue-600 to-blue-700 rounded-full flex items-center justify-center mb-4">
                    <i class='bx bx-lock-alt text-2xl text-white'></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-800 mb-2">
                    Forgot your password?
                </h2>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Enter your email address and we'll send you a password reset link.
                </p>
            </div>

            <form class="space-y-4" method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Improved input styling with better spacing -->
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email address</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class='bx bx-envelope text-slate-400'></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required
                               class="block w-full pl-10 pr-3 py-3 border-2 border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                               placeholder="Enter your email address" value="{{ old('email') }}">
                    </div>
                </div>

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

                <!-- Enhanced error message styling -->
                @error('email')
                    <div class="rounded-xl bg-red-50 border-2 border-red-200 p-4">
                        <div class="flex items-center">
                            <i class='bx bx-error-circle text-red-600 mr-2'></i>
                            <div class="text-sm text-red-700 font-medium">
                                {{ $message }}
                            </div>
                        </div>
                    </div>
                @enderror

                <!-- Updated button styling with gradient and better spacing -->
                <div class="pt-2">
                    <x-button variant="info" type="submit" class="w-full flex justify-center items-center py-3 px-4 rounded-xl text-white">
                        <i class='bx bx-send mr-2'></i>
                        Send Password Reset Link
                    </x-button>
                </div>

                <!-- Enhanced back link styling -->
                <div class="text-center pt-4 border-t border-slate-200">
                    <a href="{{ route('login') }}" class="inline-flex items-center font-medium text-blue-600 hover:text-blue-700 transition-colors duration-200">
                        <i class='bx bx-arrow-back mr-1'></i>
                        Back to Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
