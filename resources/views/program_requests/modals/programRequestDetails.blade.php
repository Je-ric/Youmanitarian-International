<x-modal.dialog :id="'programRequest-' . $req->id" maxWidth="lg:max-w-2xl w-full">
    <x-modal.header>
        <div class="flex items-start gap-3">
            <div class="shrink-0 w-10 h-10 flex items-center justify-center rounded-lg bg-[#ffb51b]/10">
                <i class='bx bx-bulb text-[#ffb51b] text-2xl'></i>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-[#1a2235] leading-tight">
                    {{ $req->title }}
                </h2>
                <p class="text-xs text-gray-500">
                    Submitted {{ $req->created_at->diffForHumans() }}
                </p>
            </div>
        </div>
    </x-modal.header>

    <x-modal.body>
        <div class="space-y-6 text-sm">

            <!-- Info Grid -->
            <div class="grid sm:grid-cols-2 gap-6">
                <div>
                    <p class="text-[11px] uppercase text-gray-500 tracking-wide">Submitted By</p>
                    <p class="mt-1 font-medium text-[#1a2235]">{{ $req->name }}</p>
                </div>
                <div>
                    <p class="text-[11px] uppercase text-gray-500 tracking-wide">Target Audience</p>
                    <p class="mt-1 text-gray-700">{{ $req->target_audience ?: '—' }}</p>
                </div>
                <div>
                    <p class="text-[11px] uppercase text-gray-500 tracking-wide">Location</p>
                    <p class="mt-1 text-gray-700">{{ $req->location ?: '—' }}</p>
                </div>
                <div>
                    <p class="text-[11px] uppercase text-gray-500 tracking-wide">Proposed Date</p>
                    <p class="mt-1">
                        <span class="inline-flex px-2 py-0.5 rounded bg-[#1a2235]/10 text-[#1a2235] font-medium">
                            {{ $req->proposed_date ? \Carbon\Carbon::parse($req->proposed_date)->format('M j, Y') : 'TBD' }}
                        </span>
                    </p>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-gray-200"></div>

            <!-- Description -->
            <div>
                <p class="text-[11px] uppercase text-gray-500 tracking-wide mb-2">Description</p>
                <div class="text-gray-700 leading-relaxed whitespace-pre-line text-sm">
                    {!! nl2br(e($req->description)) !!}
                </div>
            </div>

        </div>
    </x-modal.body>

    <x-modal.footer>
        <div class="flex flex-col sm:flex-row justify-end gap-2 w-full">
            <x-modal.close-button :modalId="'programRequest-' . $req->id" text="Close" />
            <form action="{{ route('program_requests.destroy', $req) }}" method="POST"
                  onsubmit="return confirm('Delete this request?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-1 px-3 py-2 rounded-lg bg-red-50 text-red-600 text-xs font-medium hover:bg-red-100 transition">
                    <i class='bx bx-trash text-sm'></i> Delete
                </button>
            </form>
        </div>
    </x-modal.footer>
</x-modal.dialog>
