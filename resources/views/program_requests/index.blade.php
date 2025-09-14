@extends('layouts.sidebar_final')

@section('content')
<div class="px-4 sm:px-6 lg:px-8 py-6">

    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="text-xl font-semibold text-[#1a2235]">Program Requests</h1>
            <p class="text-sm text-gray-500 mt-1">All submitted program ideas.</p>
        </div>
        <a href="{{ route('website.programs') }}#request-form"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-[#ffb51b] text-[#1a2235] text-sm font-medium hover:bg-[#e6a319] transition">
            <i class='bx bx-plus'></i> Submit New
        </a>
    </div>

    <!-- Empty State -->
    @if($requests->isEmpty())
        <x-empty-state
            icon="bx bx-folder-open"
            title="No Program Requests"
            description="Be the first to submit a program idea." />
    @else
        <!-- Responsive Grid -->
        <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
            @foreach($requests as $req)
                @php
                    $short = \Illuminate\Support\Str::limit($req->description, 120);
                @endphp

                <x-overview.card 
                    :title="$req->title"
                    icon="bx-bulb"
                    variant="default"
                >
                    <div class="space-y-3 text-sm">
                        <!-- Meta info -->
                        <div class="flex items-center justify-between text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="bx bx-user-pin text-[#ffb51b] text-sm"></i>
                                <span class="font-medium">{{ $req->name }}</span>
                            </span>
                            <span>
                                {{ $req->proposed_date ? \Carbon\Carbon::parse($req->proposed_date)->format('M j, Y') : 'TBD' }}
                            </span>
                        </div>

                        <!-- Short description -->
                        <p class="text-gray-600 leading-relaxed line-clamp-3">
                            {{ $short }}
                        </p>

                        <!-- Tags -->
                        <div class="flex flex-wrap gap-2 text-xs">
                            @if($req->target_audience)
                                <span class="px-2 py-0.5 rounded bg-gray-100 text-gray-600">
                                    {{ $req->target_audience }}
                                </span>
                            @endif
                            @if($req->location)
                                <span class="px-2 py-0.5 rounded bg-[#ffb51b]/10 text-[#b37f13]">
                                    {{ $req->location }}
                                </span>
                            @endif
                        </div>

                        <!-- Footer -->
                        <div class="pt-2 flex items-center justify-between text-xs text-gray-500">
                            <span class="flex items-center gap-1">
                                <i class="bx bx-time-five text-[#ffb51b]"></i>
                                {{ $req->created_at->diffForHumans() }}
                            </span>
                            <button type="button"
                                class="inline-flex items-center gap-1 px-2 py-1 rounded-md bg-[#1a2235]/10 text-[#1a2235] text-xs font-medium hover:bg-[#1a2235]/20 transition"
                                onclick="document.getElementById('programRequest-{{ $req->id }}').showModal()">
                                <i class="bx bx-show"></i> View
                            </button>
                        </div>
                    </div>
                </x-overview.card>

                @include('program_requests.modals.programRequestDetails', [
                    'req' => $req,
                    'modalId' => 'programRequest-'.$req->id
                ])
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $requests->links() }}
        </div>
    @endif

</div>
@endsection
