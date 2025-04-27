@php
    use App\Models\User;
    use App\Actions\NotificationActions;
    $user = User::find(Auth::user()->id);
    $notifications = $user->notificationLogs()->latest()->take(5)->get();
    $unread_count = $user->getUnreadNotificationsCountAttribute();
@endphp

@props([
    'profile_url' => null,
])

<div class="w-full bg-white shadow-sm">
    <div class="container mx-auto px-4 py-3">
        <div class="flex items-center justify-between">
            <!-- Left side -->
            <div class="flex items-center gap-6">
                <!-- Menu Toggle for Mobile -->
                <button class="btn btn-ghost btn-sm lg:hidden">
                    <i class="fi fi-rr-menu-burger text-lg"></i>
                </button>

                <!-- Dashboard Title -->
                <div>
                    <h1 class="text-lg font-semibold text-gray-800">
                        Welcome back, {{ Auth::user()->name }}!
                    </h1>
                    <p class="text-sm text-gray-600">
                        {{ now()->format('l, F d, Y') }}
                    </p>
                </div>
            </div>

            <!-- Right side -->
            <div class="flex items-center gap-4">
                <!-- Notifications -->
                <div class="dropdown dropdown-end">
                    <button class="btn btn-ghost btn-sm">
                        <div class="indicator">
                            <i class="fi fi-rr-bell text-lg"></i>
                            @if($unread_count > 0)
                                <span class="badge badge-xs badge-accent indicator-item">{{ $unread_count }}</span>
                            @endif
                        </div>
                    </button>
                    <div class="dropdown-content z-[1] card card-compact w-80 shadow bg-base-100">
                        <div class="card-body">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-semibold">Notifications</h3>
                                @if($unread_count > 0)
                                    <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-sm text-accent hover:underline">
                                            Mark all as read
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <div class="divide-y max-h-64 overflow-y-auto">
                                @forelse($notifications as $notification)
                                    <div class="py-2 {{ $notification->is_read ? 'opacity-50' : '' }}">
                                        <div class="flex items-start gap-3">
                                            <div class="flex-1">
                                                <p class="text-sm font-medium">{{ $notification->header }}</p>
                                                <p class="text-xs text-gray-500">{{ $notification->message }}</p>
                                                <span class="text-xs text-gray-400">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            @if(!$notification->is_read)
                                                <form action="{{ route('notifications.mark-as-read', $notification) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-ghost btn-xs">
                                                        <i class="fi fi-rr-check text-xs"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-8 text-center">
                                        <i class="fi fi-rr-bell-ring text-2xl text-gray-400 mb-2"></i>
                                        <p class="text-sm text-gray-500">No notifications yet</p>
                                    </div>
                                @endforelse
                            </div>
                            @if($notifications->count() > 0)
                                <div class="card-actions mt-2">
                                    <a href="{{ route('notifications.index') }}" class="btn btn-ghost btn-sm btn-block">
                                        View All Notifications
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="dropdown dropdown-end">
                    <button class="btn btn-ghost btn-circle avatar">
                        <div class="w-10 rounded-full">
                            <img src="{{ Auth::user()->profile->image ?? asset('sticker/man.png') }}"
                                 alt="Profile"
                                 class="object-cover" />
                        </div>
                    </button>
                    <ul class="dropdown-content z-[1] menu menu-sm p-2 shadow bg-base-100 rounded-box w-52">
                        @if ($profile_url !== null)
                            <li>
                                <a href="{{ $profile_url }}" class="flex items-center gap-2">
                                    <i class="fi fi-rr-user"></i>
                                    My Profile
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->hasRole('admin'))
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
                                    <i class="fi fi-rr-shield"></i>
                                    Admin Dashboard
                                </a>
                            </li>
                            <li></li>
                                <a href="{{ route('hr.dashboard') }}" class="flex items-center gap-2">
                                    <i class="fi fi-rr-briefcase"></i>
                                    HR Dashboard
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->hasRole('teacher'))
                            <li>
                                <a href="{{ route('teacher.dashboard') }}" class="flex items-center gap-2">
                                    <i class="fi fi-rr-workshop"></i>
                                    Teacher Dashboard
                                </a>
                            </li>
                        @endif

                        <li>
                            <a href="#" class="flex items-center gap-2">
                                <i class="fi fi-rr-settings"></i>
                                Settings
                            </a>
                        </li>
                        <div class="divider my-1"></div>
                        <li>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button class="flex items-center gap-2 text-error">
                                    <i class="fi fi-rr-sign-out"></i>
                                    Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
