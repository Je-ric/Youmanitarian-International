@extends('layouts.navbar')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-[#1A2235]/5 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <!-- Header Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl md:text-5xl font-bold text-[#1A2235] mb-4">
                Get in <span class="text-[#FFB51B]">Touch</span>
            </h1>
            <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                Have questions about our programs? Want to partner with us?
                We'd love to hear from you. Send us a message and we'll respond as soon as possible.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">

            <!-- Contact Form -->
            <div class="bg-white rounded-2xl shadow-lg p-8">
                <h2 class="text-2xl font-bold text-[#1A2235] mb-6">Send us a Message</h2>

                <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class='bx bx-user mr-1'></i>Full Name *
                            </label>
                            <input type="text" name="name" id="name" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#FFB51B] focus:border-[#FFB51B] transition-colors duration-200"
                                   placeholder="Your full name" value="{{ old('name') }}">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class='bx bx-envelope mr-1'></i>Email Address *
                            </label>
                            <input type="email" name="email" id="email" required
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#FFB51B] focus:border-[#FFB51B] transition-colors duration-200"
                                   placeholder="your.email@example.com" value="{{ old('email') }}">
                            @error('email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class='bx bx-phone mr-1'></i>Phone Number
                            </label>
                            <input type="tel" name="phone" id="phone"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#FFB51B] focus:border-[#FFB51B] transition-colors duration-200"
                                   placeholder="+63 912 345 6789" value="{{ old('phone') }}">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="subject" class="block text-sm font-medium text-gray-700 mb-2">
                                <i class='bx bx-message-square-dots mr-1'></i>Subject
                            </label>
                            <input type="text" name="subject" id="subject"
                                   class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#FFB51B] focus:border-[#FFB51B] transition-colors duration-200"
                                   placeholder="What's this about?" value="{{ old('subject') }}">
                            @error('subject')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="message" class="block text-sm font-medium text-gray-700 mb-2">
                            <i class='bx bx-edit mr-1'></i>Message *
                        </label>
                        <textarea name="message" id="message" rows="6" required
                                  class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl focus:ring-2 focus:ring-[#FFB51B] focus:border-[#FFB51B] transition-colors duration-200"
                                  placeholder="Tell us how we can help you...">{{ old('message') }}</textarea>
                        @error('message')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit"
                            class="w-full bg-[#1A2235] hover:bg-[#1A2235]/90 text-white font-semibold py-4 px-6 rounded-xl flex items-center justify-center transition-colors duration-200">
                        <i class='bx bx-send mr-2'></i>
                        Send Message
                    </button>
                </form>
            </div>

            <!-- Contact Information -->
            <div class="space-y-8">

                <!-- Contact Details -->
                <div class="bg-white rounded-2xl shadow-lg p-8">
                    <h2 class="text-2xl font-bold text-[#1A2235] mb-6">Contact Information</h2>

                    <div class="space-y-6">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-[#FFB51B] rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-envelope text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Email</h3>
                                <p class="text-gray-600">info@youmanitarian.org</p>
                                <p class="text-gray-600">support@youmanitarian.org</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-[#FFB51B] rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-phone text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Phone</h3>
                                <p class="text-gray-600">+63 912 345 6789</p>
                                <p class="text-gray-600">+63 2 1234 5678</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-[#FFB51B] rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-map text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Address</h3>
                                <p class="text-gray-600">123 Community Street</p>
                                <p class="text-gray-600">Nueva Ecija, Philippines 3100</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-[#FFB51B] rounded-xl flex items-center justify-center flex-shrink-0">
                                <i class='bx bx-time text-white text-xl'></i>
                            </div>
                            <div>
                                <h3 class="font-semibold text-gray-900">Office Hours</h3>
                                <p class="text-gray-600">Monday - Friday: 9:00 AM - 5:00 PM</p>
                                <p class="text-gray-600">Saturday: 9:00 AM - 12:00 PM</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="bg-gradient-to-br from-[#1A2235] to-[#1A2235]/90 rounded-2xl shadow-lg p-8 text-white">
                    <h2 class="text-2xl font-bold mb-6">Quick Links</h2>

                    <div class="space-y-4">
                        <a href="{{ route('website.programs') }}"
                           class="flex items-center space-x-3 p-3 rounded-xl bg-white/10 hover:bg-white/20 transition-colors duration-200">
                            <i class='bx bx-calendar-event text-[#FFB51B] text-xl'></i>
                            <span>View Our Programs</span>
                        </a>

                        <a href="{{ route('website.about') }}"
                           class="flex items-center space-x-3 p-3 rounded-xl bg-white/10 hover:bg-white/20 transition-colors duration-200">
                            <i class='bx bx-info-circle text-[#FFB51B] text-xl'></i>
                            <span>About Us</span>
                        </a>

                        <a href="{{ route('website.donate') }}"
                           class="flex items-center space-x-3 p-3 rounded-xl bg-white/10 hover:bg-white/20 transition-colors duration-200">
                            <i class='bx bx-heart text-[#FFB51B] text-xl'></i>
                            <span>Donate Today</span>
                        </a>

                        <a href="{{ route('website.team') }}"
                           class="flex items-center space-x-3 p-3 rounded-xl bg-white/10 hover:bg-white/20 transition-colors duration-200">
                            <i class='bx bx-group text-[#FFB51B] text-xl'></i>
                            <span>Meet the Team</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
