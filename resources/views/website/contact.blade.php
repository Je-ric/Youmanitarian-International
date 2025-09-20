@extends('layouts.navbar')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-[#1A2235]/5 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center mb-8">
                <x-section-title first="Get in" second="Touch" />
                <p class="text-lg text-gray-600 max-w-3xl mx-auto">
                    Have questions about our programs? Want to partner with us?
                    We'd love to hear from you. Send us a message and we'll respond as soon as possible.
                </p>
            </div>

            <div class="flex justify-center">
                <div class="p-8 w-full max-w-3xl">

                    <div class="space-y-2 text-left mb-8">
                        <p class="flex items-center justify-start gap-2 text-gray-700">
                            <i class='bx bx-envelope text-[#FFB51B] text-xl'></i>
                            youmanitarian@email.org
                        </p>

                        <p class="flex items-center justify-start gap-2 text-gray-700">
                            <i class='bx bx-phone text-[#FFB51B] text-xl'></i>
                            0917-000-1111
                        </p>
                    </div>

                    <h2 class="text-2xl font-bold text-[#1A2235] mb-6">Send us a Message</h2>

                    <form action="{{ route('contact.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <x-form.label for="name" variant="user" class="text-sm font-medium text-gray-700 mb-2">
                                    Full Name *
                                </x-form.label>
                                <x-form.input type="text" name="name" id="name" required
                                    placeholder="Your full name" value="{{ old('name') }}" class="w-full" />
                                @error('name')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-form.label for="email" variant="email" class="text-sm font-medium text-gray-700 mb-2">
                                    Email Address *
                                </x-form.label>
                                <x-form.input type="email" name="email" id="email" required
                                    placeholder="your.email@example.com" value="{{ old('email') }}" class="w-full" />
                                @error('email')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div>
                                <x-form.label for="phone" variant="user" class="text-sm font-medium text-gray-700 mb-2">
                                    Phone Number
                                </x-form.label>
                                <x-form.input type="tel" name="phone" id="phone" placeholder="+63 912 345 6789"
                                    value="{{ old('phone') }}" class="w-full" />
                                @error('phone')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <x-form.label for="subject" variant="description"
                                    class="text-sm font-medium text-gray-700 mb-2">
                                    Subject
                                </x-form.label>
                                <x-form.input type="text" name="subject" id="subject" placeholder="What's this about?"
                                    value="{{ old('subject') }}" class="w-full" />
                                @error('subject')
                                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <x-form.label for="message" variant="description"
                                class="text-sm font-medium text-gray-700 mb-2">
                                Message *
                            </x-form.label>
                            <x-form.textarea name="message" id="message" rows="6" required
                                placeholder="Tell us how we can help you..."
                                class="w-full ">{{ old('message') }}</x-form.textarea>
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <x-button type="submit" variant="primary" class="w-full py-4 px-6 text-lg font-semibold">
                            <i class='bx bx-send mr-2'></i>
                            Send Message
                        </x-button>
                    </form>
                </div>


            </div>
        </div>
    </div>
@endsection
