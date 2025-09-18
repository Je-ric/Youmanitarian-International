@extends('layouts.sidebar_final')

@section('content')
    <x-page-header
        icon="bx-time-five"
        title="Consultation Hours"
        desc="Browse active consultation hours and find a specialization.">
    </x-page-header>

    <div class="py-10 px-6 space-y-6">
        <!-- Search Form -->
        <x-search-form
            :search="request('search', $q)"
            :showSortOptions="false"
            searchPlaceholder="Search by specialization"
            searchLabel="Specialization"
            searchLabelVariant="task"
        />

        @if ($hours->isEmpty())
            <x-empty-state
                icon="bx bx-time-five"
                title="No Active Consultation Hours"
                description="Try a different specialization or check back later." />
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                @foreach ($hours as $h)
                    <x-overview.card
                        title="{{ $h->specialization }}"
                        icon="bx-time-five"
                        variant="bordered"
                    >
                        <div class="text-xs text-gray-700 space-y-1">
                            <div>
                                <span class="block text-gray-500">Professional</span>
                                <span class="font-medium">{{ $h->professional->name }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Day</span>
                                <span class="font-medium">{{ $h->day }}</span>
                            </div>

                            <div class="flex justify-between">
                                <span class="text-gray-500">Time</span>
                                <span class="font-medium">
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $h->start_time)->format('g:i A') }} -
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $h->end_time)->format('g:i A') }}
                                </span>
                            </div>
                        </div>

                        <div class="mt-3 flex justify-end">
                            <a href="{{ route('consultation-chats.thread.start', $h->professional->id) }}"
                               class="inline-flex items-center gap-1 px-2.5 py-1 text-xs font-medium rounded-md bg-primary text-white hover:opacity-90">
                                <i class='bx bx-chat text-sm'></i>
                                Chat
                            </a>
                        </div>
                    </x-overview.card>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $hours->links() }}
            </div>
        @endif
    </div>
@endsection
