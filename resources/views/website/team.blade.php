@extends('layouts.navbar')

@section('content')
<div class="min-h-screen bg-gray-50 py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-gray-800">Meet the Team</h1>
            <p class="mt-2 text-gray-600">The people behind our mission</p>
        </div>

        @if($teamMembers->isEmpty())
            <p class="text-center text-gray-500">No team members to display.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
                @foreach($teamMembers as $member)
                    <div class="bg-white rounded-lg shadow p-6 text-center">
                        @if($member->photo_url)
                            <img
                                class="w-32 h-32 mx-auto rounded-full object-cover mb-4"
                                src="{{ asset('storage/' . $member->photo_url) }}"
                                alt="{{ $member->name }}"
                            >
                        @else
                            <div class="w-32 h-32 mx-auto rounded-full bg-gray-200 flex items-center justify-center mb-4">
                                <span class="text-3xl font-semibold text-gray-500">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                            </div>
                        @endif

                        <h3 class="text-xl font-semibold text-gray-800">{{ $member->name }}</h3>
                        <p class="text-indigo-600">{{ $member->position }}</p>

                        @if($member->bio)
                            <p class="mt-3 text-gray-600 text-sm">{{ $member->bio }}</p>
                        @endif

                        <div class="mt-4 flex items-center justify-center space-x-4 text-gray-500">
                            @if($member->facebook_url)
                                <a href="{{ $member->facebook_url }}" target="_blank" rel="noopener" aria-label="Facebook" class="hover:text-gray-700">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12.06C22 6.48 17.52 2 11.94 2S2 6.48 2 12.06c0 5 3.66 9.15 8.44 9.94v-7.03H7.9v-2.91h2.54V9.41c0-2.5 1.49-3.88 3.76-3.88 1.09 0 2.23.2 2.23.2v2.45h-1.26c-1.24 0-1.63.77-1.63 1.56v1.87h2.78l-.44 2.91h-2.34V22c4.78-.79 8.44-4.93 8.44-9.94z"/></svg>
                                </a>
                            @endif
                            @if($member->linkedin_url)
                                <a href="{{ $member->linkedin_url }}" target="_blank" rel="noopener" aria-label="LinkedIn" class="hover:text-gray-700">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M6.94 6.5A2.44 2.44 0 1 1 4.5 4.06 2.44 2.44 0 0 1 6.94 6.5zM7.94 8.75H4V20h3.94zM20 20h-3.94v-5.53c0-1.32-.02-3.01-1.84-3.01-1.84 0-2.12 1.43-2.12 2.92V20H8.16V8.75h3.78v1.54h.05a4.14 4.14 0 0 1 3.73-2.05C19.1 8.24 20 10.31 20 13.36z"/></svg>
                                </a>
                            @endif
                            @if($member->twitter_url)
                                <a href="{{ $member->twitter_url }}" target="_blank" rel="noopener" aria-label="Twitter/X" class="hover:text-gray-700">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2H21l-6.5 7.43L22 22h-6.828l-5.34-6.45L3.6 22H1l7.023-8.023L2 2h6.915l4.82 5.878L18.244 2zm-2.39 18h2.2L8.24 4H5.9l9.954 16z"/></svg>
                                </a>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
@endsection
