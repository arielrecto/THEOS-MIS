<x-app-layout>
    <div class="container mx-auto p-4 sm:p-6">
        <!-- Back Button -->
        <div class="mb-4 sm:mb-6">
            <a href="{{ route('home') }}"
               class="btn btn-ghost gap-2 btn-sm sm:btn-md">
                <i class="fi fi-rr-arrow-left"></i>
                <span class="hidden sm:inline">Back to Dashboard</span>
            </a>
        </div>

        <div class="bg-white rounded-lg shadow-sm">
            <!-- Header -->
            <div class="border-b p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="min-w-0">
                        <h1 class="text-lg sm:text-2xl md:text-3xl font-bold text-gray-800 leading-tight">Notifications</h1>
                        <p class="text-xs sm:text-sm text-gray-600 mt-1">View and manage your notifications</p>
                    </div>

                    <div class="flex items-center gap-2">
                        {{-- full controls on sm+ --}}
                        @if($unreadCount > 0)
                            <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="hidden sm:inline">
                                @csrf
                                <button type="submit" class="btn btn-ghost gap-2 btn-sm sm:btn-md">
                                    <i class="fi fi-rr-check-double"></i>
                                    Mark all as read
                                </button>
                            </form>
                        @endif

                        {{-- compact mobile menu --}}
                        <div class="sm:hidden">
                            <details class="relative">
                                <summary class="btn btn-ghost btn-sm">
                                    <i class="fi fi-rr-menu-burger"></i>
                                </summary>
                                <div class="mt-2 p-2 bg-white shadow rounded-md w-44">
                                    @if($unreadCount > 0)
                                        <form action="{{ route('notifications.mark-all-read') }}" method="POST" class="mb-2">
                                            @csrf
                                            <button type="submit" class="w-full text-left text-sm btn btn-ghost btn-sm">
                                                <i class="fi fi-rr-check-double mr-2"></i> Mark all read
                                            </button>
                                        </form>
                                    @endif

                                    @if($notifications->count() > 0)
                                        <form action="{{ route('notifications.clear-all') }}" method="POST"
                                              onsubmit="return confirm('Are you sure you want to clear all notifications?')">
                                            @csrf
                                            <button type="submit" class="w-full text-left text-sm btn btn-ghost btn-sm text-error">
                                                <i class="fi fi-rr-trash mr-2"></i> Clear all
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </details>
                        </div>

                        {{-- desktop clear button --}}
                        @if($notifications->count() > 0)
                            <form action="{{ route('notifications.clear-all') }}" method="POST"
                                  onsubmit="return confirm('Are you sure you want to clear all notifications?')"
                                  class="hidden sm:inline">
                                @csrf
                                <button type="submit" class="btn btn-ghost btn-sm text-error gap-2">
                                    <i class="fi fi-rr-trash"></i>
                                    Clear All
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Notification Filters -->
            <div class="border-b p-3 sm:p-4 bg-gray-50">
                <div class="flex items-center gap-3">
                    <a href="{{ route('notifications.index') }}"
                       class="btn btn-sm {{ !request('filter') ? 'btn-accent' : 'btn-ghost' }} text-xs sm:text-sm">
                        All
                    </a>
                    <a href="{{ route('notifications.index', ['filter' => 'unread']) }}"
                       class="btn btn-sm {{ request('filter') === 'unread' ? 'btn-accent' : 'btn-ghost' }} text-xs sm:text-sm">
                        Unread
                    </a>
                    <div class="flex-1"></div>
                    <span class="text-xs sm:text-sm text-gray-500">{{ $notifications->total() }} total</span>
                </div>
            </div>

            <!-- Notifications List -->
            <div class="divide-y">
                @forelse($notifications as $notification)
                    <div class="p-3 sm:p-4 hover:bg-gray-50 transition-colors {{ !$notification->is_read ? 'bg-accent/5' : '' }}">
                        <div class="flex flex-col sm:flex-row sm:items-start gap-3">
                            <!-- Notification Icon -->
                            {{-- <div class="flex-shrink-0">
                                <div x-data="notificationIcons" class="w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-accent/10 flex items-center justify-center">
                                    <i :class="`fi ${getNotificationIcon(`{{$notification->type}}`) } text-accent text-lg`"></i>
                                </div>
                            </div> --}}

                            <!-- Notification Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2">
                                    <div class="min-w-0">
                                        <h3 class="font-medium text-sm sm:text-base text-gray-900 truncate">
                                            {{ $notification->header }}
                                        </h3>
                                        <p class="text-xs sm:text-sm text-gray-600 mt-1 line-clamp-3 sm:line-clamp-5">
                                            {{ $notification->message }}
                                        </p>
                                        <span class="text-xs text-gray-400 mt-1 block">{{ $notification->created_at->diffForHumans() }}</span>
                                    </div>

                                    <!-- Action Buttons (desktop) -->
                                    <div class="hidden sm:flex sm:flex-col sm:items-end sm:justify-between sm:ml-4">
                                        <div class="flex items-center gap-2">
                                            <a href="{{ route('notifications.show', $notification) }}"
                                               class="btn btn-ghost btn-sm text-xs sm:text-sm">
                                                <i class="fi fi-rr-eye mr-1"></i>
                                                <span class="hidden md:inline">View Details</span>
                                            </a>

                                            @if(!$notification->is_read)
                                                <form action="{{ route('notifications.mark-as-read', $notification) }}"
                                                      method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-ghost btn-sm" title="Mark as read">
                                                        <i class="fi fi-rr-check"></i>
                                                    </button>
                                                </form>
                                            @endif

                                           <form action="{{ route('notifications.destroy', $notification) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-ghost btn-sm text-error" title="Delete">
                                                    <i class="fi fi-rr-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </div>

                                    <!-- Mobile action menu -->
                                    <div class="sm:hidden flex items-center">
                                        <details class="relative">
                                            <summary class="btn btn-ghost btn-circle btn-sm" aria-haspopup="true" aria-expanded="false">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 5v.01M12 12v.01M12 19v.01" />
                                                </svg>
                                            </summary>
                                            <div class="mt-2 p-2 bg-white shadow rounded-md w-40">
                                                <a href="{{ route('notifications.show', $notification) }}" class="block text-sm btn btn-ghost btn-sm w-full text-left">
                                                    <i class="fi fi-rr-eye mr-2"></i> View
                                                </a>

                                                @if(!$notification->is_read)
                                                    <form action="{{ route('notifications.mark-as-read', $notification) }}" method="POST" class="mt-1">
                                                        @csrf
                                                        <button type="submit" class="w-full text-left btn btn-ghost btn-sm text-sm">
                                                            <i class="fi fi-rr-check mr-2"></i> Mark read
                                                        </button>
                                                    </form>
                                                @endif

                                                <form action="{{ route('notifications.destroy', $notification) }}" method="POST" class="mt-1" onsubmit="return confirm('Are you sure?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="w-full text-left btn btn-ghost btn-sm text-error text-sm">
                                                        <i class="fi fi-rr-trash mr-2"></i> Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </details>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <i class="fi fi-rr-bell text-4xl text-gray-400 mb-2"></i>
                            <h3 class="text-base sm:text-lg font-medium text-gray-900">No notifications</h3>
                            <p class="text-sm sm:text-base text-gray-500 mt-2">You're all caught up!</p>
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
