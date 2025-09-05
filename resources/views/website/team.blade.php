@extends('layouts.navbar')

@section('content')
<div class="min-h-full bg-gray-50 py-5">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h2 class="text-4xl lg:text-5xl font-bold text-center text-balance mb-16">
                <span class="text-primary-custom">Meet the</span>
                <span class="text-accent-custom">Team</span>
            </h2>
            <p class="mt-2 text-gray-600">The people behind our mission</p>
        </div>

        <section class="bg-gray-50 py-16">
    <div class="max-w-3xl mx-auto text-center px-6">
        {{-- Profile Image (Circle) --}}
        @if($founder->photo_url)
            <img
                class="w-40 h-40 mx-auto rounded-full object-cover shadow-lg"
                src="{{ asset('storage/' . $founder->photo_url) }}"
                alt="{{ $founder->name }}"
            >
        @else
            <div class="w-40 h-40 mx-auto rounded-full bg-gray-200 flex items-center justify-center shadow-lg">
                <span class="text-4xl font-bold text-[#1a2235]">
                    {{ strtoupper(substr($founder->name, 0, 1)) }}
                </span>
            </div>
        @endif

        {{-- Info --}}
        <h2 class="mt-6 text-3xl font-extrabold text-[#1a2235]">{{ $founder->name }}</h2>
        <p class="text-indigo-600 text-lg font-medium">{{ $founder->position }}</p>

        @if($founder->bio)
            <p class="mt-4 text-[#e6a318] text-base leading-relaxed">{{ $founder->bio }}</p>
        @endif

        {{-- Social Icons (Boxicons) --}}
        <div class="mt-6 flex justify-center space-x-5 text-2xl text-gray-500">
            @if($founder->facebook_url)
                <a href="{{ $founder->facebook_url }}" target="_blank" rel="noopener" aria-label="Facebook" class="hover:text-blue-600">
                    <i class='bx bxl-facebook-circle'></i>
                </a>
            @endif
            @if($founder->linkedin_url)
                <a href="{{ $founder->linkedin_url }}" target="_blank" rel="noopener" aria-label="LinkedIn" class="hover:text-blue-700">
                    <i class='bx bxl-linkedin-square'></i>
                </a>
            @endif
            @if($founder->twitter_url)
                <a href="{{ $founder->twitter_url }}" target="_blank" rel="noopener" aria-label="Twitter/X" class="hover:text-gray-700">
                    <i class='bx bxl-twitter'></i>
                </a>
            @endif
        </div>
    </div>
</section>

<section>

</section>


        <h2 class="text-4xl lg:text-5xl font-bold text-center text-balance mb-16">
                <span class="text-primary-custom">Youmanitarian</span>
                <span class="text-accent-custom">Members</span>
            </h2>
        @if($teamMembers->isEmpty())
            <p class="text-center text-gray-500">No team members to display.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($teamMembers as $member)
                    <div class="bg-white rounded-lg shadow p-3 flex items-center space-x-6">
                        {{-- Profile Image (Square) --}}
                        @if($member->photo_url)
                            <img
                                class="w-32 h-32 object-cover flex-shrink-0 rounded-lg"
                                src="{{ asset('storage/' . $member->photo_url) }}"
                                alt="{{ $member->name }}"
                            >
                        @else
                            <div class="w-32 h-32 bg-gray-200 flex items-center justify-center flex-shrink-0 rounded-lg">
                                <span class="text-2xl font-semibold text-gray-500">
                                    {{ strtoupper(substr($member->name, 0, 1)) }}
                                </span>
                            </div>
                        @endif

                        {{-- Info --}}
                        <div class="flex-1 text-left">
                            <h3 class="text-md font-semibold text-[#1a2235]">{{ $member->name }}</h3>
                            <p class="text-xs text-[#e6a318]">{{ $member->position }}</p>

                            @if($member->bio)
                                <p class="mt-2 text-gray-600 text-sm">{{ $member->bio }}</p>
                            @endif

                            {{-- Social Icons (Boxicons) --}}
                            <div class="mt-3 flex space-x-3 text-gray-500 text-xl">
                                @if($member->facebook_url)
                                    <a href="{{ $member->facebook_url }}" target="_blank" rel="noopener" aria-label="Facebook" class="hover:text-blue-600">
                                        <i class='bx bxl-facebook-circle'></i>
                                    </a>
                                @endif
                                @if($member->linkedin_url)
                                    <a href="{{ $member->linkedin_url }}" target="_blank" rel="noopener" aria-label="LinkedIn" class="hover:text-blue-700">
                                        <i class='bx bxl-linkedin-square'></i>
                                    </a>
                                @endif
                                @if($member->twitter_url)
                                    <a href="{{ $member->twitter_url }}" target="_blank" rel="noopener" aria-label="Twitter/X" class="hover:text-gray-700">
                                        <i class='bx bxl-twitter'></i>
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
