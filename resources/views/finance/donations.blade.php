@extends('layouts.sidebar_final')

@section('content')
    <x-page-header icon="bx-donate-heart"
                    title="Donations Management"
                    desc="View and manage donations, track financial statistics, and monitor payment activities.">

        <div class="flex items-center gap-2">
            <x-button variant="secondary" onclick="document.getElementById('downloadOptionsModal').showModal()">
                <i class='bx bx-download mr-1'></i>
                Download All
            </x-button>
            <x-button variant="primary" onclick="document.getElementById('addDonationModal').showModal()">
                <i class='bx bx-plus mr-1'></i>
                Add Donation
            </x-button>
        </div>
    </x-page-header>

    @php
        $tabs = [
            ['id' => 'overview', 'label' => 'Overview', 'icon' => 'bx-line-chart'],
            ['id' => 'donations', 'label' => 'Donations', 'icon' => 'bx-heart']
        ];
    @endphp

    <x-navigation-layout.tabs-modern :tabs="$tabs" default-tab="overview">
        <x-slot:slot_overview>
            @include('finance.partials.donationOverview')
            </x-slot>

            <x-slot:slot_donations>

                <x-table.table containerClass="overflow-x-auto" tableClass="min-w-full">
                    <x-table.thead>
                        <x-table.tr :hover="false">
                            <x-table.th>Donor</x-table.th>
                            <x-table.th>Amount</x-table.th>
                            <x-table.th>Date</x-table.th>
                            <x-table.th>Payment Method</x-table.th>
                            <x-table.th>Status</x-table.th>
                            <x-table.th>Actions</x-table.th>
                        </x-table.tr>
                    </x-table.thead>
                    <x-table.tbody>
                        @forelse($donations as $donation)
                            <x-table.tr>
                                <x-table.td>
                                    <div class="text-sm font-medium text-gray-900">{{ $donation->donor_name }}</div>
                                    <div class="text-sm text-gray-500">{{ $donation->donor_email }}</div>
                                </x-table.td>
                                <x-table.td>
                                    <div class="text-sm text-gray-900">₱{{ number_format($donation->amount, 2) }}</div>
                                </x-table.td>
                                <x-table.td>
                                    <div class="text-sm text-gray-900">{{ $donation->donation_date->format('M d, Y') }}</div>
                                </x-table.td>
                                <x-table.td>
                                    <div class="text-sm text-gray-900">{{ $donation->payment_method }}</div>
                                </x-table.td>
                                <x-table.td>
                                    <span
                                        class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                                        {{ $donation->status === 'Confirmed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $donation->status }}
                                    </span>
                                </x-table.td>
                                <x-table.td>
                                    <div class="flex items-center gap-2">
                                        <x-button variant="table-action-view"
                                            onclick="document.getElementById('viewDonationModal-{{ $donation->id }}').showModal()">
                                            <i class='bx bx-dots-horizontal-rounded'></i>
                                        </x-button>
                                        <div class="flex space-x-2">
                                            <a href="{{ route('finance.donations.download', ['donation' => $donation->id, 'format' => 'pdf']) }}"
                                               class="inline-flex items-center px-2 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-md hover:bg-blue-200 transition-colors duration-200"
                                               title="Download Donation as PDF">
                                                <i class='bx bx-d   ownload mr-1'></i>
                                                PDF
                                            </a>

                                            <!-- CSV Download -->
                                            <a href="{{ route('finance.donations.download', ['donation' => $donation->id, 'format' => 'csv']) }}"
                                               class="inline-flex items-center px-2 py-1 text-xs font-medium text-green-600 bg-green-100 rounded-md hover:bg-green-200 transition-colors duration-200"
                                               title="Download Donation as CSV">
                                                <i class='bx bx-download mr-1'></i>
                                                CSV
                                            </a>
                                        </div>

                                        @if($donation->status === 'Pending')
                                            <x-button
                                                variant="table-action-manage"
                                                onclick="document.getElementById('confirmDonationModal-{{ $donation->id }}').showModal()">
                                                Confirm
                                            </x-button>
                                        @endif
                                    </div>
                                </x-table.td>
                            </x-table.tr>
                        @empty
                            <x-table.tr>
                                <x-table.td colspan="6">
                                    <x-empty-state
                                        icon="bx bx-donate-heart"
                                        title="No Donations Found"
                                        description="There are no donations to display in this category."
                                    />
                                </x-table.td>
                            </x-table.tr>
                        @endforelse
                    </x-table.tbody>
                </x-table.table>

                <div class="px-6 py-4 border-t border-gray-200">
                    {{-- {{ $donations->links() }} --}}
                    {{ $donations->appends(['tab' => 'donations'])->links() }}
                </div>
                </x-slot>
    </x-navigation-layout.tabs-modern>

    @include('finance.modals.addDonationModal', [
        'donation' => null,
        'modalId' => 'addDonationModal'
        ])

    @foreach($donations as $donation)
        @include('finance.modals.addDonationModal', [
            'modalId' => 'viewDonationModal-' . $donation->id,
            'donation' => $donation
        ])
        @if($donation->status === 'Pending')
            @include('finance.modals.confirmDonationModal', [
                'donation' => $donation
            ])
        @endif
    @endforeach

    {{-- Download Options Modal --}}
    <x-modal.dialog id="downloadOptionsModal" maxWidth="max-w-md" width="w-11/12">
        <x-modal.header>
            <div>
                <h3 class="text-xl font-bold text-[#1a2235]">
                    Download All Donations
                </h3>
                <p class="text-gray-500 text-sm mt-1">
                    Choose your preferred format for downloading all donation records.
                </p>
            </div>
        </x-modal.header>

        <x-modal.body>
            <div class="space-y-4">
                <div class="text-center">
                    <p class="text-gray-600 mb-4">Select the format you'd like to download:</p>
                </div>

                <div class="grid grid-cols-1 gap-3">
                    <a href="{{ route('finance.donations.download.all', ['format' => 'csv']) }}"
                       class="flex items-center justify-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        <i class='bx bx-table text-2xl text-green-600'></i>
                        <div class="text-left">
                            <div class="font-semibold text-gray-900">CSV Format</div>
                            <div class="text-sm text-gray-500">Spreadsheet format for data analysis</div>
                        </div>
                    </a>

                    <a href="{{ route('finance.donations.download.all', ['format' => 'pdf']) }}"
                       class="flex items-center justify-center gap-3 p-4 border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors duration-200">
                        <i class='bx bx-file-pdf text-2xl text-red-600'></i>
                        <div class="text-left">
                            <div class="font-semibold text-gray-900">PDF Format</div>
                            <div class="text-sm text-gray-500">Professional report format for printing</div>
                        </div>
                    </a>
                </div>
            </div>
        </x-modal.body>

        <x-modal.footer>
            <x-modal.close-button modalId="downloadOptionsModal" text="Cancel" variant="cancel" />
        </x-modal.footer>
    </x-modal.dialog>
@endsection
