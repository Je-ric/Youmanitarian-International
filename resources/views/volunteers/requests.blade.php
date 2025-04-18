@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-[#1a2235] mb-6">Volunteers Lists</h1>

    @if (session('toast'))
        <x-toast :message="session('toast')['message']" :type="session('toast')['type']" />
    @endif
    
    @if($volunteers->isEmpty())
        <p class="text-gray-600">No volunteer applications found.</p>
    @else
        <table class="w-full bg-white shadow-lg rounded-lg">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Email</th>
                    <th class="p-3 text-left">View Contributions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($volunteers as $volunteer)
                    <tr class="border-t">
                        <td class="p-3">{{ $volunteer->user->name }}</td>
                        <td class="p-3">{{ $volunteer->user->email }}</td>
                        <td class="p-3">
                            <x-button href="{{ route('volunteers.details', $volunteer->id) }}"
                                variant="info" class="tooltip" data-tip="View Details">
                                <i class='bx bx-show'></i> View
                            </x-button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
