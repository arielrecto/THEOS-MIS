<x-app-layout>
    <div class="container mx-auto p-6">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('home') }}"
               class="btn btn-ghost gap-2">
                <i class="fi fi-rr-arrow-left"></i>
                Back to Dashboard
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-sm">
            <!-- Header -->
            <div class="border-b p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Notifications</h1>
                        <p class="text-gray-600">View and manage your notifications</p>
                    </div>
                    @if($unreadCount > 0)
                        <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-ghost gap-2">
                                <i class="fi fi-rr-check-double"></i>
                                Mark all as read
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Notification Filters -->
            <div class="border-b p-4 bg-gray-50">
                <div class="flex gap-4">
                    <a href="{{ route('notifications.index') }}"
                       class="btn btn-sm {{ !request('filter') ? 'btn-accent' : 'btn-ghost' }}">
                        All
                    </a>
                    <a href="{{ route('notifications.index', ['filter' => 'unread']) }}"
                       class="btn btn-sm {{ request('filter') === 'unread' ? 'btn-accent' : 'btn-ghost' }}">
                        Unread
                    </a>
                    <div class="flex-1"></div>
                    @if($notifications->count() > 0)
                        <form action="{{ route('notifications.clear-all') }}" method="POST"
                              onsubmit="return confirm('Are you sure you want to clear all notifications?')">
                            @csrf
                            <button type="submit" class="btn btn-ghost btn-sm text-error gap-2">
                                <i class="fi fi-rr-trash"></i>
                                Clear All
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Notifications List -->
            <div class="divide-y">
                @forelse($notifications as $notification)
                    <div class="p-4 hover:bg-gray-50 transition-colors {{ !$notification->is_read ? 'bg-accent/5' : '' }}">
                        <div class="flex items-start gap-4">
                            <!-- Notification Icon -->
                            <div class="flex-shrink-0">
                                <div x-data="notificationIcons" class="w-10 h-10 rounded-full bg-accent/10 flex items-center justify-center">
                                    <i :class="`fi ${getNotificationIcon(`{{$notification->type}}`) } text-accent`"></i>
                                </div>
                            </div>

                            <!-- Notification Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-start justify-between gap-4">
                                    <div>
                                        <h3 class="font-medium text-gray-900">
                                            {{ $notification->header }}
                                        </h3>
                                        <p class="text-sm text-gray-600">{{ $notification->message }}</p>
                                        <span class="text-xs text-gray-400">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </span>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('notifications.show', $notification) }}"
                                           class="btn btn-ghost btn-sm">
                                            <i class="fi fi-rr-eye"></i>
                                            View Details
                                        </a>

                                        {{-- @if($notification->url)
                                            <a href="{{ $notification->url }}"
                                               class="btn btn-ghost btn-sm">
                                                View
                                            </a>
                                        @endif --}}

                                        @if(!$notification->is_read)
                                            <form action="{{ route('notifications.mark-as-read', $notification) }}"
                                                  method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-ghost btn-sm">
                                                    <i class="fi fi-rr-check"></i>
                                                </button>
                                            </form>
                                        @endif

                                       <form action="{{ route('notifications.destroy', $notification) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-ghost btn-sm text-error">
                                                <i class="fi fi-rr-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fi fi-rr-bell text-4xl text-gray-400 mb-2"></i>
                            <h3 class="text-lg font-medium text-gray-900">No notifications</h3>
                            <p class="text-gray-500">You're all caught up!</p>
                        </div>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($notifications->hasPages())
                <div class="p-4 border-t">
                    {{ $notifications->links() }}
                </div>
            @endif
        </div>
    </div>

    @push('js')
    <script>
        // Add notification icon mapping

        const notificationIcons = ({
            getNotificationIcon(type) {
            return {
                'info': 'fi-rr-info',
                'success': 'fi-rr-check',
                'warning': 'fi-rr-exclamation',
                'error': 'fi-rr-cross',
                'announcement': 'fi-rr-megaphone',
                'task': 'fi-rr-document',
                'grade': 'fi-rr-graduation-cap',
                'attendance': 'fi-rr-calendar-clock',
            }[type] || 'fi-rr-bell';
        }
        })
    </script>
    @endpush
</x-app-layout>
