<x-app-layout>
    <div class="container mx-auto p-4 sm:p-6">
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Header -->
            <div class="border-b p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                    <div class="flex items-start sm:items-center gap-4 min-w-0">
                        <a href="{{ route('notifications.index') }}" class="btn btn-ghost btn-sm gap-2 shrink-0">
                            <i class="fi fi-rr-arrow-left"></i>
                            Back to Notifications
                        </a>

                        <div class="min-w-0">
                            <h1 class="text-xl sm:text-2xl font-bold text-gray-800 truncate break-words">
                                Notification Details
                            </h1>
                            <p class="text-sm text-gray-600 mt-1">
                                Received {{ $notification->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        @if ($notification->url)
                            <a href="{{ $notification->url }}" class="btn btn-accent gap-2 whitespace-nowrap">
                                <i class="fi fi-rr-link"></i>
                                View Related Content
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Notification Content -->
            <div class="p-4 sm:p-6">
                <div class="flex flex-col sm:flex-row items-start sm:items-start gap-4">
                    <!-- Notification Icon -->
                    <div class="flex-shrink-0 self-start">
                        <div x-data="notificationIcons"
                            class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-accent/10 flex items-center justify-center">
                            <i
                                :class="`fi ${getNotificationIcon('{{ $notification->type }}')} text-xl sm:text-2xl text-accent`"></i>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="flex-1 min-w-0">
                        <h2 class="text-lg sm:text-xl font-semibold text-gray-900 mb-2 truncate break-words">
                            {{ $notification->header }}
                        </h2>

                        <p
                            class="text-gray-600 text-base sm:text-lg mb-4 leading-relaxed break-words whitespace-pre-wrap">
                            {{ $notification->message }}
                        </p>

                        <!-- Metadata -->
                        <div class="mt-6 pt-4 border-t">
                            <dl class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Type</dt>
                                    <dd class="mt-1 text-sm text-gray-900 truncate">{{ ucfirst($notification->type) }}
                                    </dd>
                                </div>

                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1 text-sm">
                                        <span
                                            class="badge {{ $notification->is_read ? 'badge-ghost' : 'badge-accent' }}">
                                            {{ $notification->is_read ? 'Read' : 'Unread' }}
                                        </span>
                                    </dd>
                                </div>

                                @if ($notification->read_at)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Read At</dt>
                                        <dd class="mt-1 text-sm text-gray-900 truncate">
                                            {{ date('F j, Y g:i A', strtotime($notification->read_at)) }}
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        <!-- Related Content Section -->
                        @if ($relatedContent)
                            <div class="mt-6 pt-4 border-t">
                                <h3 class="text-base font-medium text-gray-900 mb-3">Related Content</h3>
                                <div class="bg-gray-50 rounded-lg p-3">
                                    @switch(get_class($relatedContent))
                                        @case('App\Models\Announcement')
                                            <div class="flex items-center gap-3">
                                                <i class="fi fi-rr-megaphone text-accent"></i>
                                                <span class="text-sm truncate break-words">Announcement:
                                                    {{ $relatedContent->title }}</span>
                                            </div>
                                        @break

                                        @case('App\Models\Task')
                                            <div class="flex items-center gap-3">
                                                <i class="fi fi-rr-document text-accent"></i>
                                                <span class="text-sm truncate break-words">Task:
                                                    {{ $relatedContent->name }}</span>
                                            </div>
                                        @break

                                        @default
                                            <div class="flex items-center gap-3">
                                                <i class="fi fi-rr-info text-accent"></i>
                                                <span class="text-sm truncate break-words">Related content information</span>
                                            </div>
                                    @endswitch
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="border-t p-4 sm:p-4 bg-gray-50">
                <div class="flex flex-col sm:flex-row sm:justify-end gap-2">
                    <form action="{{ route('notifications.destroy', $notification) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this notification?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-ghost btn-sm text-error gap-2 w-full sm:w-auto">
                            <i class="fi fi-rr-trash"></i>
                            Delete Notification
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <script>
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
                    } [type] || 'fi-rr-bell';
                }
            })
        </script>
    @endpush
</x-app-layout>
