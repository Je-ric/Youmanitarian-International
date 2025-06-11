{{-- filepath: resources/views/volunteers/volunteers.blade.php --}}

@extends('layouts.sidebar_final')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-6">
        <h1 class="text-2xl font-bold mb-6 text-[#1a2235]">Approved Volunteers</h1>

        @if($volunteers->isEmpty())
            <div class="text-gray-500">No approved volunteers found.</div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white rounded-lg shadow">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left">Name</th>
                            <th class="px-4 py-2 text-left">Email</th>
                            <th class="px-4 py-2 text-left">Joined At</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($volunteers as $volunteer)
                            <tr class="border-b">
                                <td class="px-4 py-2">{{ $volunteer->user->name ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $volunteer->user->email ?? 'N/A' }}</td>
                                <td class="px-4 py-2">{{ $volunteer->created_at->format('M d, Y') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection