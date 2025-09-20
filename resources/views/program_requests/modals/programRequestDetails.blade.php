@php
    $modalId = 'programRequest-' . $req->id;
@endphp

<x-modal.dialog
    :id="$modalId"
    maxWidth="2xl:max-w-4xl xl:max-w-3xl lg:max-w-2xl md:max-w-xl sm:max-w-lg max-w-md"
    width="w-full"
    maxHeight="max-h-[90vh]">

    <x-modal.header>
        <h2 class="text-lg sm:text-xl font-bold text-[#1a2235] flex items-center gap-2">
            <i class='bx bx-bulb text-[#ffb51b] text-2xl'></i>
            <span class="leading-tight">{{ $req->title }}</span>
        </h2>
    </x-modal.header>

    <x-modal.body>
        <div class="space-y-6">

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-form.label variant="user" class="text-[11px] tracking-wide">Submitted By</x-form.label>
                    <x-form.readonly class="text-sm font-semibold text-[#1a2235] bg-gray-100">
                        {{ $req->name }}
                    </x-form.readonly>
                </div>

                <div>
                    <x-form.label variant="date" class="text-[11px] tracking-wide">Submitted</x-form.label>
                    <x-form.readonly class="text-sm font-medium text-[#1a2235] bg-gray-100">
                        {{ $req->created_at->diffForHumans() }}
                    </x-form.readonly>
                </div>

                @if($req->email)
                    <div>
                        <x-form.label variant="email" class="text-[11px] tracking-wide">Email</x-form.label>
                        <x-form.readonly class="text-sm text-[#1a2235] bg-gray-100">
                            {{ $req->email }}
                        </x-form.readonly>
                    </div>
                @endif

                @if($req->contact_number)
                    <div>
                        <x-form.label variant="phone" class="text-[11px] tracking-wide">Contact Number</x-form.label>
                        <x-form.readonly class="text-sm text-[#1a2235] bg-gray-100">
                            {{ $req->contact_number }}
                        </x-form.readonly>
                    </div>
                @endif

                <div>
                    <x-form.label variant="user" class="text-[11px] tracking-wide">Target Audience</x-form.label>
                    <x-form.readonly class="text-sm text-[#1a2235] bg-gray-100">
                        {{ $req->target_audience ?: 'Not specified' }}
                    </x-form.readonly>
                </div>

                <div>
                    <x-form.label variant="location" class="text-[11px] tracking-wide">Proposed Location</x-form.label>
                    <x-form.readonly class="text-sm text-[#1a2235] bg-gray-100">
                        {{ $req->location ?: 'Not specified' }}
                    </x-form.readonly>
                </div>
            </div>

            <div class="border-t border-gray-200"></div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <x-form.label variant="date" class="text-[11px] tracking-wide">Proposed Date</x-form.label>
                    <x-form.readonly class="text-sm font-medium text-[#1a2235] bg-gray-100">
                        {{ $req->proposed_date ? \Carbon\Carbon::parse($req->proposed_date)->format('M j, Y') : 'To Be Determined' }}
                    </x-form.readonly>
                </div>
            </div>

            <div class="border-t border-gray-200"></div>

            <div>
                <x-form.label variant="description" class="text-[11px] tracking-wide mb-1">
                    Description
                </x-form.label>
                <div class="rounded-lg border border-gray-200 bg-white p-4">
                    <div class="text-sm leading-relaxed text-gray-700 whitespace-pre-line">
                        {!! nl2br(e($req->description)) !!}
                    </div>
                </div>
            </div>

        </div>
    </x-modal.body>

    <x-modal.footer>
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4 w-full">
            <div class="flex items-center gap-2">
                <span class="text-sm text-gray-600">Status:</span>
                <x-feedback-status.status-indicator
                    :status="$req->status"
                    :label="ucfirst($req->status)" />
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-3">
                @if($req->status === 'pending')
                    @if($req->email)
                        <form action="{{ route('program_requests.update', $req) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <x-button type="submit" variant="success"
                                onclick="return confirm('Are you sure you want to approve this request? An email will be sent to the requester.');">
                                <i class='bx bx-check'></i> Approve
                            </x-button>
                        </form>

                        <form action="{{ route('program_requests.update', $req) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <x-button type="submit" variant="danger"
                                onclick="return confirm('Are you sure you want to reject this request?');">
                                <i class='bx bx-x'></i> Reject
                            </x-button>
                        </form>
                    @else
                        <form action="{{ route('program_requests.update', $req) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="approved">
                            <x-button type="submit" variant="success"
                                onclick="return confirm('Are you sure you want to approve this request?');">
                                <i class='bx bx-check'></i> Approve
                            </x-button>
                        </form>

                        <form action="{{ route('program_requests.update', $req) }}" method="POST" class="inline">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="status" value="rejected">
                            <x-button type="submit" variant="danger"
                                onclick="return confirm('Are you sure you want to reject this request?');">
                                <i class='bx bx-x'></i> Reject
                            </x-button>
                        </form>
                    @endif
                @endif

                <form action="{{ route('program_requests.destroy', $req) }}" method="POST" class="inline"
                        onsubmit="return confirm('Are you sure you want to delete this request? This action cannot be undone.');">
                    @csrf
                    @method('DELETE')
                    <x-button type="submit" variant="delete">
                        <i class='bx bx-trash'></i> Delete
                    </x-button>
                </form>

                <x-modal.close-button :modalId="'programRequest-' . $req->id" text="Close" />
            </div>
        </div>
    </x-modal.footer>
</x-modal.dialog>
