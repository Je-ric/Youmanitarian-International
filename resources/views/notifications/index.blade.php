@extends('layouts.sidebar_final')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Notifications</h1>
            <p class="text-gray-600 mt-1">View and manage your recent notifications.</p>
        </div>
        @if(Auth::user()->unreadNotifications->isNotEmpty())
            <form action="{{ route('notifications.readAll') }}" method="POST">
                @csrf
                <x-button type="submit" variant="primary">
                    <i class='bx bx-check-double mr-2'></i>
                    Mark All as Read
                </x-button>
            </form>
        @endif
    </div>

    @if (session('success'))
        <x-alert type="success" message="{{ session('success') }}" />
    @endif

    <div class="bg-white rounded-lg shadow-md overflow-hidden">
        <div class="divide-y divide-gray-200">
            @forelse ($notifications as $notification)
                <a href="{{ route('notifications.read', $notification->id) }}"
                   class="block p-6 hover:bg-gray-50/50 transition-colors duration-150 {{ is_null($notification->read_at) ? 'bg-indigo-50' : '' }}">
                    <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="w-full">
                        @csrf
                        <button type="submit" class="w-full text-left">
                            <div class="flex justify-between items-start">
                                <div class="flex items-start gap-4">
                                    @if(is_null($notification->read_at))
                                        <span class="w-3 h-3 bg-indigo-500 rounded-full mt-1.5 flex-shrink-0" title="Unread"></span>
                                    @else
                                        <span class="w-3 h-3 bg-gray-300 rounded-full mt-1.5 flex-shrink-0" title="Read"></span>
                                    @endif
                                    <div>
                                        <div class="text-lg font-semibold text-gray-800">
                                            {{ $notification->data['title'] ?? 'Notification' }}
                                        </div>
                                        <p class="text-gray-600 mt-1">
                                            {{ $notification->data['message'] ?? 'You have a new notification.' }}
                                        </p>
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500 whitespace-nowrap">
                                    {{ $notification->created_at->diffForHumans() }}
                                </div>
                            </div>
                        </button>
                    </form>
                </a>
            @empty
                <div class="p-6 text-center text-gray-500">
                    <i class='bx bx-bell-off text-4xl mb-2'></i>
                    <p>You have no notifications at the moment.</p>
                </div>
            @endforelse
        </div>

        @if($notifications->hasPages())
            <div class="p-4 bg-gray-50 border-t">
                {{ $notifications->links() }}
            </div>
        @endif
    </div>
</div>
@endsection 