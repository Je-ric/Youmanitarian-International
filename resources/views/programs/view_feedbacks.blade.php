@extends('layouts.sidebar_final')

@section('content')
    <div class="max-w-4xl mx-auto mt-8 px-4 sm:px-6 lg:px-8">
        <h1 class="text-2xl sm:text-3xl font-bold mb-4 sm:text-left">
            Feedback for "{{ $program->title }}"
        </h1>

        @if($feedbacks->isEmpty())
            <p class="text-gray-500 text-center sm:text-left">No feedback submitted for this program yet.</p>
        @else
            <div class="space-y-4">
                @foreach($feedbacks as $feedback)
                    <div class="p-4 border rounded-md shadow-sm bg-white">
                        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-2">
                            <div class="mb-2 sm:mb-0">
                                <p class="font-semibold text-gray-800">
                                    {{ $feedback->volunteer->user->name ?? 'Anonymous Volunteer' }}
                                </p>
                                <p class="text-sm text-gray-500">
                                    Submitted on {{ \Carbon\Carbon::parse($feedback->submitted_at)->format('F j, Y g:i A') }}
                                </p>
                            </div>
                            <div class="text-yellow-500 font-bold text-lg sm:text-xl">
                                ⭐ {{ $feedback->rating }}/5
                            </div>
                        </div>
                        <p class="text-gray-700 whitespace-pre-line">{{ $feedback->feedback ?? 'No written feedback.' }}</p>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
