<x-app-layout>
    <div class="container mx-auto p-6">
        <div class="bg-white rounded-lg shadow-sm">
            <!-- Header -->
            <div class="border-b p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <div class="flex items-center gap-4">
                            <a href="{{ route('notifications.index') }}"
                               class="btn btn-ghost btn-sm gap-2">
                                <i class="fi fi-rr-arrow-left"></i>
                                Back to Notifications
                            </a>
                            <h1 class="text-2xl font-bold text-gray-800">Notification Details</h1>
                        </div>
                        <p class="text-gray-600 mt-2">
                            Received {{ $notification->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <div class="flex items-center gap-2">
                        @if($notification->url)
                            <a href="{{ $notification->url }}"
                               class="btn btn-accent gap-2">
                                <i class="fi fi-rr-link"></i>
                                View Related Content
                            </a>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Notification Content -->
            <div class="p-6">
                <div class="flex items-start gap-4">
                    <!-- Notification Icon -->
                    <div class="flex-shrink-0">
                        <div x-data="notificationIcons"
                             class="w-12 h-12 rounded-full bg-accent/10 flex items-center justify-center">
                            <i :class="`fi ${getNotificationIcon('{{$notification->type}}')} text-2xl text-accent`"></i>
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="flex-1">
                        <h2 class="text-xl font-semibold text-gray-900 mb-2">
                            {{ $notification->header }}
                        </h2>
                        <p class="text-gray-600 text-lg mb-4">
                            {{ $notification->message }}
                        </p>

                        <!-- Metadata -->
                        <div class="mt-6 pt-6 border-t">
                            <dl class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Type</dt>
                                    <dd class="mt-1 text-sm text-gray-900">{{ ucfirst($notification->type) }}</dd>
                                </div>
                                <div>
                                    <dt class="text-sm font-medium text-gray-500">Status</dt>
                                    <dd class="mt-1 text-sm">
                                        <span class="badge {{ $notification->is_read ? 'badge-ghost' : 'badge-accent' }}">
                                            {{ $notification->is_read ? 'Read' : 'Unread' }}
                                        </span>
                                    </dd>
                                </div>
                                @if($notification->read_at)
                                    <div>
                                        <dt class="text-sm font-medium text-gray-500">Read At</dt>
                                        <dd class="mt-1 text-sm text-gray-900">
                                            {{ date('F j, Y g:i A', strtotime($notification->read_at))  }}
                                        </dd>
                                    </div>
                                @endif
                            </dl>
                        </div>

                        <!-- Related Content Section -->
                        @if($relatedContent)
                            <div class="mt-6 pt-6 border-t">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Related Content</h3>
                                <div class="bg-gray-50 rounded-lg p-4">
                                    @switch(get_class($relatedContent))
                                        @case('App\Models\Announcement')
                                            <div class="flex items-center gap-2">
                                                <i class="fi fi-rr-megaphone text-accent"></i>
                                                <span>Announcement: {{ $relatedContent->title }}</span>
                                            </div>
                                            @break
                                        @case('App\Models\Task')
                                            <div class="flex items-center gap-2">
                                                <i class="fi fi-rr-document text-accent"></i>
                                                <span>Task: {{ $relatedContent->name }}</span>
                                            </div>
                                            @break
                                        @default
                                            <div class="flex items-center gap-2">
                                                <i class="fi fi-rr-info text-accent"></i>
                                                <span>Related content information</span>
                                            </div>
                                    @endswitch
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="border-t p-4 bg-gray-50 flex justify-end gap-2">
                <form action="{{ route('notifications.destroy', $notification) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this notification?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-ghost btn-sm text-error gap-2">
                        <i class="fi fi-rr-trash"></i>
                        Delete Notification
                    </button>
                </form>
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
                }[type] || 'fi-rr-bell';
            }
        })
    </script>
    @endpush
</x-app-layout>
