@extends('layouts.sidebar_final')

@section('content')
    <x-page-header icon="bx-bulb" title="Program Requests"
        desc="Review, manage, and respond to submitted program ideas from the community.">

        {{-- <x-button href="{{ route('website.programs') }}#request-form" variant="primary">
            <i class='bx bx-plus text-lg'></i> Submit New Request
        </x-button> --}}

    </x-page-header>

    <div class="px-4 sm:px-6 lg:px-8 py-6">
        @if($requests->isEmpty())
            <x-empty-state
                icon="bx bx-folder-open"
                title="No Program Requests"
                description="Be the first to submit a program idea and help shape our offerings." />
        @else
            <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($requests as $req)
                    <x-overview.card
                        title="{{ \Illuminate\Support\Str::limit($req->title, 30) }}"
                        icon="bx-bulb"
                        variant="midnight-header"
                        class="group hover:shadow-lg hover:-translate-y-0.5 transition-all duration-300">

                        <div class="space-y-3">
                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="bx bx-user-pin text-[#ffb51b]"></i>
                                <span class="font-medium">{{ $req->name }}</span>
                            </div>

                            <div class="flex items-center gap-2 text-sm text-gray-600">
                                <i class="bx bx-time-five text-[#ffb51b]"></i>
                                <span>{{ $req->created_at->diffForHumans() }}</span>
                            </div>

                            @if($req->target_audience)
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <i class="bx bx-group text-[#ffb51b]"></i>
                                    <span class="truncate">{{ $req->target_audience }}</span>
                                </div>
                            @endif

                            <div class="pt-3 border-t border-gray-200">
                                <x-button
                                    variant="table-action-view"
                                    onclick="document.getElementById('programRequest-{{ $req->id }}').showModal()">
                                    <i class="bx bx-show"></i>
                                    View Details
                                </x-button>
                            </div>
                        </div>
                    </x-overview.card>

                    @include('program_requests.modals.programRequestDetails', [
                        'req' => $req,
                        'modalId' => 'programRequest-' . $req->id,
                    ])
                @endforeach
            </div>

            <div class="mt-12 flex justify-center">
                {{ $requests->links() }}
            </div>
        @endif
    </div>
@endsection
