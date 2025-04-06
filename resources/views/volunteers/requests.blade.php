@extends('layouts.sidebar')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold text-[#1a2235] mb-6">Volunteer Applications</h1>

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
                    {{-- <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Action</th> --}}
                </tr>
            </thead>
            <tbody>
                @foreach($volunteers as $volunteer)
                    <tr class="border-t">
                        <td class="p-3">{{ $volunteer->user->name }}</td>
                        <td class="p-3">{{ $volunteer->user->email }}</td>
                        <td class="p-3"></td>
                        {{-- <td>
                            <x-status-indicator status="{{ $volunteer->status }}" variant="outline" />
                        </td>
                        <td class="p-3">
                            @if($volunteer->status === 'pending')
                                <form action="{{ route('volunteers.approve', $volunteer->user) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-green-500 text-white rounded hover:bg-green-600">
                                        Approve
                                    </button>
                                </form>

                                <form action="{{ route('volunteers.remove', $volunteer->user) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                                        Reject
                                    </button>
                                </form>
                            @elseif($volunteer->status === 'approved' || $volunteer->status === 'denied')
                                <form action="{{ route('volunteers.restore', $volunteer->user) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                                        Restore Status
                                    </button>
                                </form>
                            @else
                                <span class="text-gray-500">No actions available</span>
                            @endif
                        </td> --}}
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
