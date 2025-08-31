@extends('layouts.navbar')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen bg-gray-100 gap-6 px-4">
    <h1 class="text-5xl font-extrabold text-gray-800">Donate</h1>
    <p class="text-gray-600 text-center max-w-2xl">
        Your support helps us continue our programs. Make a secure donation below.
    </p>

    <x-button type="button" variant="primary" class="px-6"
        onclick="document.getElementById('addDonationModal-website').showModal()">
        <i class='bx bx-heart'></i> Make a Donation
    </x-button>
</div>

@include('finance.modals.addDonationModal', [
    'modalId' => 'addDonationModal-website',
])

@endsection
