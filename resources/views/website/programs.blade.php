{{-- filepath: resources/views/website/programs.blade.php --}}

@extends('layouts.navbar')

@section('content')
<div class="min-h-screen bg-gray-100 py-12 px-4">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-4xl sm:text-5xl font-extrabold text-gray-800 mb-8 text-center">Programs</h1>

        @forelse($programs as $program)
            {{-- Program Card --}}
            <div class="bg-white rounded-2xl shadow-lg p-8 mb-8 flex flex-col sm:flex-row items-center gap-8">
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-[#1a2235] mb-2">{{ $program->title }}</h2>
                    <div class="text-gray-500 mb-2">
                        {{ \Carbon\Carbon::parse($program->date)->format('F d, Y') }}
                        &middot;
                        {{ \Carbon\Carbon::parse($program->start_time)->format('g:i A') }}
                        @if($program->end_time)
                            - {{ \Carbon\Carbon::parse($program->end_time)->format('g:i A') }}
                        @endif
                    </div>
                    <div class="text-gray-700 mb-4">{{ $program->description }}</div>
                    <div class="flex items-center gap-2 text-sm text-gray-400 mb-4">
                        <i class='bx bx-map'></i>
                        <span>{{ $program->location }}</span>
                    </div>
                    <a href="#feedback-form-{{ $program->id }}" class="inline-block px-5 py-2 rounded-lg bg-[#1a2235] text-white font-semibold shadow hover:bg-[#232b47] transition">View & Submit Feedback</a>
                </div>
                <div class="flex-shrink-0">
                    <img src="{{ $program->image_url ?? 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80' }}" alt="Program" class="rounded-xl w-48 h-32 object-cover shadow">
                </div>
            </div>

            {{-- Feedback Form --}}
            <div id="feedback-form-{{ $program->id }}" class="bg-white rounded-2xl shadow-lg p-8 max-w-2xl mx-auto mb-12">
                <h3 class="text-xl font-bold text-[#1a2235] mb-4">Submit Your Feedback for "{{ $program->title }}"</h3>
                <form method="POST" action="{{ route('programs.feedback.guest.submit', $program->id) }}">
                    @csrf
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Name</label>
                        <input type="text" name="guest_name" required class="input input-bordered w-full rounded-lg px-4 py-2 border border-gray-200 focus:border-[#1a2235] focus:ring-2 focus:ring-[#1a2235] transition" placeholder="Your name">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Email <span class="text-gray-400 text-xs">(optional)</span></label>
                        <input type="email" name="guest_email" class="input input-bordered w-full rounded-lg px-4 py-2 border border-gray-200 focus:border-[#1a2235] focus:ring-2 focus:ring-[#1a2235] transition" placeholder="you@email.com">
                    </div>
                    <div class="mb-4">
                        <label class="block text-gray-700 font-medium mb-1">Rating</label>
                        <select name="rating" required class="select select-bordered w-full rounded-lg px-4 py-2 border border-gray-200 focus:border-[#1a2235] focus:ring-2 focus:ring-[#1a2235] transition">
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Good</option>
                            <option value="3">3 - Fair</option>
                            <option value="2">2 - Poor</option>
                            <option value="1">1 - Terrible</option>
                        </select>
                    </div>
                    <div class="mb-6">
                        <label class="block text-gray-700 font-medium mb-1">Feedback</label>
                        <textarea name="feedback" class="textarea textarea-bordered w-full rounded-lg px-4 py-2 border border-gray-200 focus:border-[#1a2235] focus:ring-2 focus:ring-[#1a2235] transition" rows="4" placeholder="Share your experience..."></textarea>
                    </div>
                    <button type="submit" class="w-full py-2 px-4 rounded-lg bg-[#1a2235] text-white font-semibold shadow hover:bg-[#232b47] transition">Submit Feedback</button>
                </form>
            </div>
        @empty
            <div class="text-center text-gray-500">No programs available at the moment.</div>
        @endforelse
    </div>
</div>
@endsection