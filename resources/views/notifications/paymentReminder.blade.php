@extends('layouts.sidebar_final')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-lg">
        <div class="p-6 border-b border-gray-200">
            <h1 class="text-2xl font-bold text-gray-800">Payment Reminder Details</h1>
            <p class="mt-1 text-sm text-gray-600">For membership period: {{ $payment->payment_period }} {{ $payment->payment_year }}</p>
        </div>
        <div class="p-6">
            <div class="mb-6">
                <h2 class="text-lg font-semibold text-gray-700">Reminder Message</h2>
                <div class="mt-2 p-4 bg-gray-50 rounded-md text-gray-800 whitespace-pre-wrap">{{ $notification->data['content'] }}</div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-md font-semibold text-gray-700">Member Details</h3>
                    <p class="text-gray-800">{{ $member->user->name }}</p>
                    <p class="text-gray-600">{{ $member->user->email }}</p>
                </div>
                <div>
                    <h3 class="text-md font-semibold text-gray-700">Payment Status</h3>
                    @php
                        $statusClasses = [
                            'paid' => 'bg-green-100 text-green-800',
                            'pending' => 'bg-yellow-100 text-yellow-800',
                            'overdue' => 'bg-red-100 text-red-800',
                        ];
                    @endphp
                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $statusClasses[$payment->payment_status] ?? '' }}">
                        {{ ucfirst($payment->payment_status) }}
                    </span>
                </div>
            </div>

            <div class="flex justify-end pt-4 border-t border-gray-200">
                {{-- <a href="{{ route('finance.membership.payments') }}" class="px-6 py-2 text-sm font-semibold text-white bg-orange-500 rounded-md hover:bg-orange-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-orange-500">
                    Go to Payments
                </a>
            </div> --}}
        </div>
    </div>
</div>
@endsection 