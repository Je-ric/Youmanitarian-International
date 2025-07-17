@extends('layouts.sidebar_final')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6">
    
    <!-- Header Section -->
    <header class="mb-8">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-gradient-to-br from-[#1a2235] to-[#2a3441] rounded-xl flex items-center justify-center">
                    <i class='bx bx-bell text-white text-xl'></i>
                </div>
                <div>
                    <h1 class="text-2xl font-bold text-[#1a2235] tracking-tight">Notifications</h1>
                    <p class="text-gray-600 mt-1 flex items-center gap-2">
                        <span>Stay updated with your latest activities</span>
                        @if(Auth::user()->unreadNotifications->count() > 0)
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-[#ffb51b] text-[#1a2235]">
                                {{ Auth::user()->unreadNotifications->count() }} new
                            </span>
                        @endif
                    </p>
                </div>
            </div>
            
            <div class="flex items-center gap-3">
                @if(Auth::user()->unreadNotifications->isNotEmpty())
                    <form action="{{ route('notifications.readAll') }}" method="POST">
                        @csrf
                        <button type="submit" class="inline-flex items-center px-4 py-2 border border-[#1a2235] text-[#1a2235] bg-white rounded-lg hover:bg-[#1a2235] hover:text-white transition-all duration-200 text-sm font-medium">
                            <i class='bx bx-check-double mr-2'></i>
                            Mark all as read
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </header>
    <!-- Notifications Container -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        @forelse ($notifications as $notification)
            @php
                $isUnread = is_null($notification->read_at);
                $notificationType = $notification->data['type'] ?? 'general';
                $iconConfig = match($notificationType) {
                    'task_assigned'               => ['bx-clipboard', 'bg-blue-100', 'text-blue-700'],
                    'program_volunteer_attendance'=> ['bx-user-check', 'bg-indigo-100', 'text-indigo-700'],
                    'program_update'              => ['bx-refresh', 'bg-purple-100', 'text-purple-700'],
                    'volunteer_joined'            => ['bx-group', 'bg-green-100', 'text-green-700'],
                    'volunteer_application'       => ['bx-file-find', 'bg-teal-100', 'text-teal-700'],
                    'role_update'                 => ['bx-shield-quarter', 'bg-orange-100', 'text-orange-700'],
                    'payment_reminder'            => ['bx-alarm', 'bg-yellow-100', 'text-yellow-700'],
                    'member_invitation'           => ['bx-mail-send', 'bg-cyan-100', 'text-cyan-700'],
                    default                       => ['bx-info-circle', 'bg-gray-200', 'text-gray-700'],
                };

                // Determine the correct action URL for each notification type
                $actionUrl = '#';
                if ($notificationType === 'payment_reminder') {
                    $actionUrl = route('notifications.show_payment_reminder', ['notification' => $notification->id]);
                } elseif ($notificationType === 'task_assigned' || $notificationType === 'program_volunteer_attendance') {
                    $programId = $notification->data['program_id'] ?? ($notification->data['program']['id'] ?? null);
                    if ($programId) {
                        $actionUrl = route('programs.view', $programId);
                    }
                } elseif ($notificationType === 'program_update') {
                    $programId = $notification->data['program_id'] ?? null;
                    if ($programId) {
                        $actionUrl = route('programs.index', [], false) . '?modal=' . $programId;
                    } else {
                        $actionUrl = route('programs.index');
                    }
                } elseif ($notificationType === 'member_invitation') {
                    $memberId = $notification->data['member_id'] ?? null;
                    if ($memberId) {
                        $actionUrl = route('member.invitation.show', ['member' => $memberId]);
                    }
                } elseif (!empty($notification->data['action_url'])) {
                    $actionUrl = $notification->data['action_url'];
                }
            @endphp
            <div class="relative border-b border-gray-100 last:border-b-0 transition-all duration-200 hover:bg-gray-50 {{ $isUnread ? 'bg-gradient-to-r from-[#ffb51b]/5 to-transparent' : '' }}">
                @if($isUnread)
                    <div class="absolute left-0 top-0 bottom-0 w-1 bg-gradient-to-b from-[#ffb51b] to-[#ff9500]"></div>
                @endif
                <form action="{{ route('notifications.read', $notification->id) }}" method="POST" class="w-full">
                    @csrf
                    <button type="submit" class="w-full text-left p-0 group focus:outline-none focus:bg-gray-50">
                        <a href="{{ $actionUrl }}" class="block p-6 w-full h-full no-underline text-inherit">
                            <div class="flex items-start gap-4">
                                <div class="flex-shrink-0 w-12 h-12 {{ $iconConfig[1] }} rounded-xl flex items-center justify-center">
                                    <i class='bx {{ $iconConfig[0] }} {{ $iconConfig[2] }} text-xl'></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between gap-4">
                                        <h3 class="font-semibold text-gray-900 text-base leading-tight {{ $isUnread ? 'text-[#1a2235]' : '' }}">
                                            {{ $notification->data['title'] ?? 'Notification' }}
                                            @if($isUnread)
                                                <span class="inline-block w-2 h-2 bg-[#ffb51b] rounded-full ml-2"></span>
                                            @endif
                                        </h3>
                                        <div class="flex-shrink-0 text-right">
                                            <div class="text-xs text-gray-500 font-medium">
                                                {{ $notification->created_at->diffForHumans() }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="text-gray-600 text-sm mt-2 leading-relaxed">
                                        {!! $notification->data['message'] ?? 'You have a new notification.' !!}
                                    </div>
                                    <div class="mt-4 flex items-center justify-between">
                                        <div class="flex items-center gap-4">
                                            <span class="inline-flex items-center text-[#1a2235] text-sm font-medium group-hover:text-[#ffb51b] transition-colors">
                                                View details
                                                <i class='bx bx-right-arrow-alt ml-1'></i>
                                            </span>
                                            @if(isset($notification->data['priority']) && $notification->data['priority'] === 'high')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    <i class='bx bx-error-circle mr-1'></i>
                                                    High Priority
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            @if($isUnread)
                                                <div class="flex items-center text-xs text-blue-600 font-medium">
                                                    <i class='bx bx-mouse mr-1'></i>
                                                    Click to mark as read
                                                </div>
                                            @else
                                                <div class="flex items-center text-xs text-gray-400">
                                                    <i class='bx bx-check mr-1'></i>
                                                    Read
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </button>
                </form>
            </div>
        @empty
            <!-- Empty State -->
            <div class="p-16 text-center">
                <div class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-2xl flex items-center justify-center mx-auto mb-6">
                    <i class='bx bx-bell-off text-3xl text-gray-400'></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-2">All caught up!</h3>
                <p class="text-gray-500 text-base max-w-md mx-auto leading-relaxed">
                    You don't have any notifications right now. We'll let you know when something important happens.
                </p>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($notifications->hasPages())
        <div class="mt-8 bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center justify-between">
                <div class="text-sm text-gray-600">
                    Showing {{ $notifications->firstItem() }} to {{ $notifications->lastItem() }} of {{ $notifications->total() }} notifications
                </div>
                <div class="flex items-center gap-2">
                    {{ $notifications->links('pagination::tailwind') }}
                </div>
            </div>
        </div>
    @endif
    
    <!-- Quick Stats -->
    <div class="mt-8 grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-[#ffb51b]/10 rounded-lg flex items-center justify-center">
                    <i class='bx bx-bell text-[#ffb51b] text-lg'></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-[#1a2235]">{{ Auth::user()->unreadNotifications->count() }}</div>
                    <div class="text-sm text-gray-600">Unread</div>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-check text-green-600 text-lg'></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-[#1a2235]">{{ Auth::user()->readNotifications->count() }}</div>
                    <div class="text-sm text-gray-600">Read</div>
                </div>
            </div>
        </div>
        
        <div class="bg-white rounded-lg border border-gray-200 p-4">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class='bx bx-time text-blue-600 text-lg'></i>
                </div>
                <div>
                    <div class="text-2xl font-bold text-[#1a2235]">{{ Auth::user()->notifications->where('created_at', '>=', now()->subDay())->count() }}</div>
                    <div class="text-sm text-gray-600">Today</div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
