@extends('layouts.sidebar_final')

@section('content')
    <x-page-header icon="bx-donate-heart"
                    title="Donations Management"
                    desc="View and manage donations, track financial statistics, and monitor payment activities.">

        <x-button variant="primary" onclick="document.getElementById('addDonationModal').showModal()">
            <i class='bx bx-plus mr-1'></i>
            Add Donation
        </x-button>
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
                                    <x-button variant="table-action-view"
                                        onclick="document.getElementById('viewDonationModal-{{ $donation->id }}').showModal()">
                                        <i class='bx bx-dots-horizontal-rounded'></i>
                                    </x-button>
                                    @if($donation->status === 'Pending')
                                        <form action="{{ route('finance.donations.status', $donation) }}" method="POST"
                                            class="inline">
                                            @csrf
                                            @method('PATCH')
                                            <x-button type="submit" variant="table-action-manage">Confirm</x-button>
                                        </form>
                                    @endif
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
    @endforeach
@endsection
