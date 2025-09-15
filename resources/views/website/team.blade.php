@extends('layouts.navbar')

@section('content')
    <div class="min-h-full bg-gray-50">

        <div class="relative bg-cover bg-center py-16"
            style="background-image: url('{{ asset('assets/images/bg/team-bg.jpg') }}');">
            <!-- Overlay for better text readability -->
            <div class="absolute inset-0 bg-[#1a2235] bg-opacity-60 backdrop-blur-sm"></div>

            <!-- Content -->
            <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <x-section-title first="Meet" second="Our Team" firstColor="#FFFFFF" />
                <p class="text-xl text-gray-300 max-w-3xl mx-auto">
                    Dedicated professionals working together to make a meaningful impact in our community
                </p>
            </div>
        </div>




         <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Founder Section -->
            <section class="py-16 bg-white">
                <div class="max-w-4xl mx-auto text-center">
                    <div class="inline-flex items-center justify-center w-2 h-2 bg-[#FFB51B] rounded-full mb-4"></div>
                    <h2 class="text-3xl font-bold text-[#1a2235] mb-2">Leadership</h2>
                    <div class="w-24 h-1 bg-gradient-to-r from-[#FFB51B] to-[#e6a318] mx-auto mb-12"></div>

                    <div class="bg-white rounded-2xl outline outline-2 outline-gray-200 p-8 hover:outline-[#FFB51B] transition-all duration-300">
                        @if ($founder->photo_url)
                            <img class="w-32 h-32 mx-auto rounded-full object-cover border-4 border-[#FFB51B]"
                                src="{{ asset('storage/' . $founder->photo_url) }}" alt="{{ $founder->name }}">
                        @else
                            <div class="w-32 h-32 mx-auto rounded-full bg-gradient-to-br from-[#1a2235] to-[#2a3447] flex items-center justify-center border-4 border-[#FFB51B]">
                                <span class="text-3xl font-bold text-white">
                                    {{ strtoupper(substr($founder->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif

                        <div class="mt-6">
                            <h3 class="text-2xl font-bold text-[#1a2235]">{{ $founder->name }}</h3>
                            <div class="inline-block bg-[#FFB51B] text-[#1a2235] px-4 py-1 rounded-full text-sm font-semibold mt-2 mb-4">
                                {{ $founder->position }}
                            </div>
                        </div>

                        @if ($founder->bio)
                            <p class="text-gray-700 text-base leading-relaxed max-w-2xl mx-auto mb-6">{{ $founder->bio }}</p>
                        @endif

                        <div class="flex justify-center space-x-4">
                            @if ($founder->facebook_url)
                                <a href="{{ $founder->facebook_url }}" target="_blank" rel="noopener"
                                   aria-label="Facebook Profile"
                                   class="w-12 h-12 bg-blue-600 text-white rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors duration-200">
                                    <i class='bx bxl-facebook text-xl'></i>
                                </a>
                            @endif
                            @if ($founder->linkedin_url)
                                <a href="{{ $founder->linkedin_url }}" target="_blank" rel="noopener"
                                   aria-label="LinkedIn Profile"
                                   class="w-12 h-12 bg-blue-700 text-white rounded-lg flex items-center justify-center hover:bg-blue-800 transition-colors duration-200">
                                    <i class='bx bxl-linkedin text-xl'></i>
                                </a>
                            @endif
                            @if ($founder->twitter_url)
                                <a href="{{ $founder->twitter_url }}" target="_blank" rel="noopener"
                                   aria-label="Twitter Profile"
                                   class="w-12 h-12 bg-gray-800 text-white rounded-lg flex items-center justify-center hover:bg-gray-900 transition-colors duration-200">
                                    <i class='bx bxl-twitter text-xl'></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            </section>

            <!-- Executives Section -->
            @if ($executives->isNotEmpty())
                <section class="py-16 bg-gradient-to-br from-gray-50 to-gray-100">
                    <div class="text-center mb-12">
                        <div class="inline-flex items-center justify-center w-2 h-2 bg-[#FFB51B] rounded-full mb-4"></div>
                        <h2 class="text-3xl font-bold text-[#1a2235] mb-2">Executive Team</h2>
                        <div class="w-24 h-1 bg-gradient-to-r from-[#FFB51B] to-[#e6a318] mx-auto mb-4"></div>
                        <p class="text-gray-600 max-w-2xl mx-auto">Strategic leaders driving our organization's vision and growth</p>
                    </div>

                    <!-- Updated executives to use outline borders instead of shadows -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($executives as $executive)
                            <div class="bg-white rounded-2xl outline outline-2 outline-gray-200 p-6 text-center hover:outline-[#FFB51B] transition-all duration-300">
                                @if ($executive->photo_url)
                                    <img class="w-24 h-24 mx-auto rounded-full object-cover border-2 border-[#FFB51B] mb-4"
                                        src="{{ asset('storage/' . $executive->photo_url) }}" alt="{{ $executive->name }}">
                                @else
                                    <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-[#1a2235] to-[#2a3447] flex items-center justify-center border-2 border-[#FFB51B] mb-4">
                                        <span class="text-xl font-semibold text-white">
                                            {{ strtoupper(substr($executive->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif

                                <h3 class="text-lg font-bold text-[#1a2235] mb-1">{{ $executive->name }}</h3>
                                <p class="text-sm font-semibold text-[#FFB51B] mb-3">{{ $executive->position }}</p>

                                @if ($executive->bio)
                                    <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">{{ $executive->bio }}</p>
                                @endif

                                <div class="flex justify-center space-x-3">
                                    @if ($executive->facebook_url)
                                        <a href="{{ $executive->facebook_url }}" target="_blank" rel="noopener"
                                           aria-label="Facebook Profile"
                                           class="w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors duration-200">
                                            <i class='bx bxl-facebook text-sm'></i>
                                        </a>
                                    @endif
                                    @if ($executive->linkedin_url)
                                        <a href="{{ $executive->linkedin_url }}" target="_blank" rel="noopener"
                                           aria-label="LinkedIn Profile"
                                           class="w-8 h-8 bg-blue-700 text-white rounded-lg flex items-center justify-center hover:bg-blue-800 transition-colors duration-200">
                                            <i class='bx bxl-linkedin text-sm'></i>
                                        </a>
                                    @endif
                                    @if ($executive->twitter_url)
                                        <a href="{{ $executive->twitter_url }}" target="_blank" rel="noopener"
                                           aria-label="Twitter Profile"
                                           class="w-8 h-8 bg-gray-800 text-white rounded-lg flex items-center justify-center hover:bg-gray-900 transition-colors duration-200">
                                            <i class='bx bxl-twitter text-sm'></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Members Section -->
            @if ($members->isNotEmpty())
                <section class="py-16 bg-white">
                    <div class="text-center mb-12">
                        <div class="inline-flex items-center justify-center w-2 h-2 bg-[#FFB51B] rounded-full mb-4"></div>
                        <h2 class="text-3xl font-bold text-[#1a2235] mb-2">Team Members</h2>
                        <div class="w-24 h-1 bg-gradient-to-r from-[#FFB51B] to-[#e6a318] mx-auto mb-4"></div>
                        <p class="text-gray-600 max-w-2xl mx-auto">Dedicated professionals committed to our mission and values</p>
                    </div>

                   <!-- Updated to 3-column grid layout -->
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 max-w-7xl mx-auto">
    @foreach ($members as $member)
        <div class="bg-white rounded-2xl outline outline-2 outline-gray-200 p-6 flex flex-col items-center hover:outline-[#FFB51B] transition-all duration-300">
            <!-- Image Section -->
            <div class="flex-shrink-0">
                @if ($member->photo_url)
                    <img class="w-48 h-48 rounded-2xl object-cover border-2 border-[#FFB51B]"
                        src="{{ asset('storage/' . $member->photo_url) }}" alt="{{ $member->name }}">
                @else
                    <div class="w-48 h-48 rounded-2xl bg-gradient-to-br from-[#1a2235] to-[#2a3447] flex items-center justify-center border-2 border-[#FFB51B]">
                        <span class="text-5xl font-bold text-white">
                            {{ strtoupper(substr($member->name, 0, 1)) }}
                        </span>
                    </div>
                @endif
            </div>

            <!-- Content Section -->
            <div class="flex-1 flex flex-col justify-center gap-4 text-center mt-6">
                <div class="space-y-1">
                    <h3 class="text-xl font-bold text-[#1a2235]">{{ $member->name }}</h3>
                    <p class="text-base font-medium text-[#FFB51B]">{{ $member->position }}</p>
                </div>

                @if ($member->bio)
                    <p class="text-gray-600 text-sm leading-relaxed line-clamp-3">{{ $member->bio }}</p>
                @endif

                <!-- Social Links -->
                <div class="flex justify-center gap-4 mt-4">
                    @if ($member->facebook_url)
                        <a href="{{ $member->facebook_url }}" target="_blank" rel="noopener"
                           aria-label="Facebook Profile"
                           class="w-9 h-9 bg-blue-600 text-white rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors duration-200">
                            <i class="bx bxl-facebook text-base"></i>
                        </a>
                    @endif
                    @if ($member->linkedin_url)
                        <a href="{{ $member->linkedin_url }}" target="_blank" rel="noopener"
                           aria-label="LinkedIn Profile"
                           class="w-9 h-9 bg-blue-700 text-white rounded-lg flex items-center justify-center hover:bg-blue-800 transition-colors duration-200">
                            <i class="bx bxl-linkedin text-base"></i>
                        </a>
                    @endif
                    @if ($member->twitter_url)
                        <a href="{{ $member->twitter_url }}" target="_blank" rel="noopener"
                           aria-label="Twitter Profile"
                           class="w-9 h-9 bg-gray-800 text-white rounded-lg flex items-center justify-center hover:bg-gray-900 transition-colors duration-200">
                            <i class="bx bxl-twitter text-base"></i>
                        </a>
                    @endif
                </div>
            </div>
        </div>
    @endforeach
</div>

                </section>
            @endif

            <!-- Developers Section -->
            @if ($developers->isNotEmpty())
                <section class="py-16 bg-gradient-to-br from-[#1a2235] to-[#2a3447]">
                    <div class="text-center mb-12">
                        <div class="inline-flex items-center justify-center w-2 h-2 bg-[#FFB51B] rounded-full mb-4"></div>
                        <h2 class="text-3xl font-bold text-white mb-2">Development Team</h2>
                        <div class="w-24 h-1 bg-gradient-to-r from-[#FFB51B] to-[#e6a318] mx-auto mb-4"></div>
                        <p class="text-gray-300 max-w-2xl mx-auto">Technical experts building and maintaining our digital infrastructure</p>
                    </div>

                    <!-- Updated developers to use outline borders instead of shadows -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach ($developers as $dev)
                            <div class="bg-white rounded-2xl outline outline-2 outline-gray-200 p-6 text-center hover:outline-[#FFB51B] transition-all duration-300">
                                @if ($dev->photo_url)
                                    <img class="w-24 h-24 mx-auto rounded-full object-cover border-2 border-[#FFB51B] mb-4"
                                        src="{{ asset('storage/' . $dev->photo_url) }}" alt="{{ $dev->name }}">
                                @else
                                    <div class="w-24 h-24 mx-auto rounded-full bg-gradient-to-br from-[#1a2235] to-[#2a3447] flex items-center justify-center border-2 border-[#FFB51B] mb-4">
                                        <span class="text-xl font-semibold text-white">
                                            {{ strtoupper(substr($dev->name, 0, 1)) }}
                                        </span>
                                    </div>
                                @endif

                                <h3 class="text-lg font-bold text-[#1a2235] mb-1">{{ $dev->name }}</h3>
                                <p class="text-sm font-semibold text-[#FFB51B] mb-3">{{ $dev->position }}</p>

                                @if ($dev->bio)
                                    <p class="text-gray-600 text-sm leading-relaxed mb-4 line-clamp-3">{{ $dev->bio }}</p>
                                @endif

                                <div class="flex justify-center space-x-3">
                                    @if ($dev->facebook_url)
                                        <a href="{{ $dev->facebook_url }}" target="_blank" rel="noopener"
                                           aria-label="Facebook Profile"
                                           class="w-8 h-8 bg-blue-600 text-white rounded-lg flex items-center justify-center hover:bg-blue-700 transition-colors duration-200">
                                            <i class="bx bxl-facebook text-sm"></i>
                                        </a>
                                    @endif
                                    @if ($dev->linkedin_url)
                                        <a href="{{ $dev->linkedin_url }}" target="_blank" rel="noopener"
                                           aria-label="LinkedIn Profile"
                                           class="w-8 h-8 bg-blue-700 text-white rounded-lg flex items-center justify-center hover:bg-blue-800 transition-colors duration-200">
                                            <i class="bx bxl-linkedin text-sm"></i>
                                        </a>
                                    @endif
                                    @if ($dev->twitter_url)
                                        <a href="{{ $dev->twitter_url }}" target="_blank" rel="noopener"
                                           aria-label="Twitter Profile"
                                           class="w-8 h-8 bg-gray-800 text-white rounded-lg flex items-center justify-center hover:bg-gray-900 transition-colors duration-200">
                                            <i class="bx bxl-twitter text-sm"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @endif

            <!-- Call to Action Section -->
            <section class="py-16 bg-gradient-to-r from-[#FFB51B] to-[#e6a318]">
                <div class="text-center">
                    <h2 class="text-3xl font-bold text-[#1a2235] mb-4">Join Our Team</h2>
                    <p class="text-[#1a2235] text-lg mb-8 max-w-2xl mx-auto">
                        Are you passionate about making a difference? We're always looking for dedicated individuals to join
                        our mission.
                    </p>
                    <a href="#contact"
                        class="inline-flex items-center px-8 py-3 bg-[#1a2235] text-white font-semibold rounded-full hover:bg-[#2a3447] transition-colors duration-200">
                        Get In Touch
                        <i class="bx bx-right-arrow-alt ml-2 text-xl"></i>
                    </a>
                </div>
            </section>
        </div>
    </div>








    <div class="min-h-full bg-gray-50 py-5">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-10">
               <x-section-title first="Meet the" second="Team" />
                <p class="mt-2 text-gray-600">The people behind our mission</p>
            </div>

            <section class="bg-gray-50 py-16">
                <div class="max-w-3xl mx-auto text-center px-6">

                    @if ($founder->photo_url)
                        <img class="w-40 h-40 mx-auto rounded-full object-cover shadow-lg"
                            src="{{ asset('storage/' . $founder->photo_url) }}" alt="{{ $founder->name }}">
                    @else
                        <div class="w-40 h-40 mx-auto rounded-full bg-gray-200 flex items-center justify-center shadow-lg">
                            <span class="text-4xl font-bold text-[#1a2235]">
                                {{ strtoupper(substr($founder->name, 0, 1)) }}
                            </span>
                        </div>
                    @endif

                    <h2 class="mt-6 text-3xl font-extrabold text-[#1a2235]">{{ $founder->name }}</h2>
                    <p class="text-indigo-600 text-lg font-medium">{{ $founder->position }}</p>

                    @if ($founder->bio)
                        <p class="mt-4 text-[#e6a318] text-base leading-relaxed">{{ $founder->bio }}</p>
                    @endif

                    <div class="mt-6 flex justify-center space-x-5 text-2xl text-gray-500">
                        @if ($founder->facebook_url)
                            <a href="{{ $founder->facebook_url }}" target="_blank" rel="noopener" aria-label="Facebook"
                                class="hover:text-blue-600">
                                <i class='bx bxl-facebook-circle'></i>
                            </a>
                        @endif
                        @if ($founder->linkedin_url)
                            <a href="{{ $founder->linkedin_url }}" target="_blank" rel="noopener" aria-label="LinkedIn"
                                class="hover:text-blue-700">
                                <i class='bx bxl-linkedin-square'></i>
                            </a>
                        @endif
                        @if ($founder->twitter_url)
                            <a href="{{ $founder->twitter_url }}" target="_blank" rel="noopener" aria-label="Twitter/X"
                                class="hover:text-gray-700">
                                <i class='bx bxl-twitter'></i>
                            </a>
                        @endif
                    </div>
                </div>
            </section>

            <section>

            </section>


            <x-section-title first="The" second="Executives" />
           @if ($executives->isEmpty())
    <p class="text-center text-gray-500">No team members to display.</p>
@else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        @foreach ($executives as $executive)
            <div class="bg-white rounded-lg shadow p-3 flex items-center gap-6">

                {{-- Photo --}}
                @if ($executive->photo_url)
                    <img class="w-32 h-32 object-cover flex-shrink-0 rounded-lg"
                         src="{{ asset('storage/' . $executive->photo_url) }}" alt="{{ $executive->name }}">
                @else
                    <div class="w-32 h-32 bg-gray-200 flex items-center justify-center flex-shrink-0 rounded-lg">
                        <span class="text-2xl font-semibold text-gray-500">
                            {{ strtoupper(substr($executive->name, 0, 1)) }}
                        </span>
                    </div>
                @endif

                {{-- Info --}}
                <div class="flex-1 text-left">
                    <h3 class="text-md font-semibold text-[#1a2235]">{{ $executive->name }}</h3>
                    <p class="text-xs text-[#e6a318]">{{ $executive->position }}</p>

                    @if ($executive->bio)
                        <p class="mt-2 text-gray-600 text-sm leading-relaxed">{{ $executive->bio }}</p>
                    @endif

                    {{-- Social Icons --}}
                    <div class="mt-3 flex space-x-4 text-gray-400 text-xl">
                        @if ($executive->facebook_url)
                            <a href="{{ $executive->facebook_url }}" target="_blank" rel="noopener"
                               aria-label="Facebook"
                               class="hover:text-blue-600 transition-colors duration-200">
                                <i class='bx bxl-facebook-circle'></i>
                            </a>
                        @endif
                        @if ($executive->linkedin_url)
                            <a href="{{ $executive->linkedin_url }}" target="_blank" rel="noopener"
                               aria-label="LinkedIn"
                               class="hover:text-blue-700 transition-colors duration-200">
                                <i class='bx bxl-linkedin-square'></i>
                            </a>
                        @endif
                        @if ($executive->twitter_url)
                            <a href="{{ $executive->twitter_url }}" target="_blank" rel="noopener"
                               aria-label="Twitter/X"
                               class="hover:text-sky-500 transition-colors duration-200">
                                <i class='bx bxl-twitter'></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif



            {{-- Members Section --}}
            @if ($members->isNotEmpty())
                <x-section-title first="Our" second="Members" />
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-10">
                    @foreach ($members as $member)
                        <div
                            class="bg-white rounded-2xl shadow-md p-6 text-center border border-gray-100 hover:shadow-lg transition">
                            {{-- Photo --}}
                            @if ($member->photo_url)
                                <img class="w-28 h-28 mx-auto rounded-full object-cover shadow mb-4"
                                    src="{{ asset('storage/' . $member->photo_url) }}" alt="{{ $member->name }}">
                            @else
                                <div
                                    class="w-28 h-28 mx-auto rounded-full bg-gray-200 flex items-center justify-center shadow mb-4">
                                    <span class="text-2xl font-semibold text-gray-500">
                                        {{ strtoupper(substr($member->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif

                            {{-- Info --}}
                            <h3 class="text-lg font-semibold text-[#1a2235]">{{ $member->name }}</h3>
                            <p class="text-sm text-[#e6a318]">{{ $member->position }}</p>

                            @if ($member->bio)
                                <p class="mt-2 text-gray-600 text-sm">{{ $member->bio }}</p>
                            @endif

                            {{-- Social --}}
                            <div class="mt-4 flex justify-center space-x-4 text-gray-500 text-xl">
                                @if ($member->facebook_url)
                                    <a href="{{ $member->facebook_url }}" target="_blank" class="hover:text-blue-600">
                                        <i class="bx bxl-facebook-circle"></i>
                                    </a>
                                @endif
                                @if ($member->linkedin_url)
                                    <a href="{{ $member->linkedin_url }}" target="_blank" class="hover:text-blue-700">
                                        <i class="bx bxl-linkedin-square"></i>
                                    </a>
                                @endif
                                @if ($member->twitter_url)
                                    <a href="{{ $member->twitter_url }}" target="_blank" class="hover:text-gray-700">
                                        <i class="bx bxl-twitter"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- Developers Section --}}
            @if ($developers->isNotEmpty())
                <x-section-title first="Our" second="Developers" />x-
                <div class="space-y-8">
                    @foreach ($developers as $dev)
                        <div class="bg-white rounded-xl shadow p-6 flex items-center space-x-6 hover:shadow-lg transition">
                            {{-- Photo --}}
                            @if ($dev->photo_url)
                                <img class="w-24 h-24 object-cover rounded-lg shadow-md"
                                    src="{{ asset('storage/' . $dev->photo_url) }}" alt="{{ $dev->name }}">
                            @else
                                <div class="w-24 h-24 bg-gray-200 flex items-center justify-center rounded-lg shadow-md">
                                    <span class="text-xl font-semibold text-gray-500">
                                        {{ strtoupper(substr($dev->name, 0, 1)) }}
                                    </span>
                                </div>
                            @endif

                            {{-- Info --}}
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-[#1a2235]">{{ $dev->name }}</h3>
                                <p class="text-sm text-[#e6a318]">{{ $dev->position }}</p>
                                @if ($dev->bio)
                                    <p class="mt-2 text-gray-600 text-sm">{{ $dev->bio }}</p>
                                @endif

                                {{-- Social --}}
                                <div class="mt-3 flex space-x-4 text-gray-500 text-xl">
                                    @if ($dev->facebook_url)
                                        <a href="{{ $dev->facebook_url }}" target="_blank" class="hover:text-blue-600">
                                            <i class="bx bxl-facebook-circle"></i>
                                        </a>
                                    @endif
                                    @if ($dev->linkedin_url)
                                        <a href="{{ $dev->linkedin_url }}" target="_blank" class="hover:text-blue-700">
                                            <i class="bx bxl-linkedin-square"></i>
                                        </a>
                                    @endif
                                    @if ($dev->twitter_url)
                                        <a href="{{ $dev->twitter_url }}" target="_blank" class="hover:text-gray-700">
                                            <i class="bx bxl-twitter"></i>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>
    </div>

@endsection
