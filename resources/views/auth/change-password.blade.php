@extends('layouts.navbar')

@section('content')
<!-- Updated background with navy gradient and improved spacing -->
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Enhanced card design with border instead of shadow -->
        <div class="bg-white rounded-2xl border-2 border-slate-200 p-8 space-y-6">
            <div class="text-center">
                <!-- Added icon and improved typography -->
                <div class="mx-auto h-16 w-16 bg-gradient-to-r from-amber-500 to-amber-600 rounded-full flex items-center justify-center mb-4">
                    <i class='bx bx-key text-2xl text-white'></i>
                </div>
                <h2 class="text-2xl font-bold text-slate-800 mb-2">
                    Change your password
                </h2>
                <p class="text-slate-600 text-sm leading-relaxed">
                    Enter your current password and choose a new one.
                </p>
            </div>

            <form class="space-y-4" method="POST" action="{{ url('/change-password') }}">
                @csrf

                <!-- Improved input styling with better spacing and icons -->
                <div>
                    <label for="current_password" class="block text-sm font-medium text-slate-700 mb-2">Current Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class='bx bx-lock text-slate-400'></i>
                        </div>
                        <input id="current_password" name="current_password" type="password" required
                               class="block w-full pl-10 pr-3 py-3 border-2 border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200"
                               placeholder="Enter current password">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700 mb-2">New Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class='bx bx-lock-alt text-slate-400'></i>
                        </div>
                        <input id="password" name="password" type="password" required
                               class="block w-full pl-10 pr-3 py-3 border-2 border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200"
                               placeholder="Enter new password">
                    </div>
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2">Confirm New Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class='bx bx-check-shield text-slate-400'></i>
                        </div>
                        <input id="password_confirmation" name="password_confirmation" type="password" required
                               class="block w-full pl-10 pr-3 py-3 border-2 border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-colors duration-200"
                               placeholder="Confirm new password">
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

                <!-- Updated button styling with gradient and better spacing -->
                <div class="pt-2">
                    <x-button variant="warning" type="submit" class="w-full flex justify-center items-center py-3 px-4 rounded-xl text-white">
                        <i class='bx bx-save mr-2'></i>
                        Change Password
                    </x-button>
                </div>

                <!-- Enhanced back link styling -->
                <div class="text-center pt-4 border-t border-slate-200">
                    <a href="{{ route('dashboard') }}" class="inline-flex items-center font-medium text-amber-600 hover:text-amber-700 transition-colors duration-200">
                        <i class='bx bx-arrow-back mr-1'></i>
                        Back to Dashboard
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
