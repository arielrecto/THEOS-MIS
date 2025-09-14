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
    <div class="container px-4 py-3 mx-auto">
        <div class="flex justify-between items-center">
            <!-- Left side -->
            <div class="flex gap-6 items-center">
                <!-- Menu Toggle for Mobile -->
                <button class="btn btn-ghost btn-sm lg:hidden">
                    <i class="text-lg fi fi-rr-menu-burger"></i>
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
            <div class="flex gap-4 items-center">
                <!-- Notifications -->
                <div class="dropdown dropdown-end">
                    <button class="btn btn-ghost btn-sm">
                        <div class="indicator">
                            <i class="text-lg fi fi-rr-bell"></i>
                            @if($unread_count > 0)
                                <span class="badge badge-xs badge-accent indicator-item">{{ $unread_count }}</span>
                            @endif
                        </div>
                    </button>
                    <div class="dropdown-content z-[1] card card-compact w-80 shadow bg-base-100">
                        <div class="card-body">
                            <div class="flex justify-between items-center mb-2">
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
                            <div class="overflow-y-auto max-h-64 divide-y">
                                @forelse($notifications as $notification)
                                    <div class="py-2 {{ $notification->is_read ? 'opacity-50' : '' }}">
                                        <div class="flex gap-3 items-start">
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
                                                        <i class="text-xs fi fi-rr-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-8 text-center">
                                        <i class="mb-2 text-2xl text-gray-400 fi fi-rr-bell-ring"></i>
                                        <p class="text-sm text-gray-500">No notifications yet</p>
                                    </div>
                                @endforelse
                            </div>
                            @if($notifications->count() > 0)
                                <div class="mt-2 card-actions">
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

                            @if ($user->profile && $user->profile->profilePicture)
                                <img src="{{ $user->profile->profilePicture->file_dir }}" alt="Profile Picture" class="object-cover" />
                            @elseif ($user->profilePicture)
                                <img src="{{ $user->profilePicture->file_dir }}" alt="Profile Picture" class="object-cover" />
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=EBF4FF" alt="Profile Picture" class="object-cover" />

                            @endif

                            {{-- <img src="{{ $user->profilePicture->file_dir ?? asset('sticker/man.png') }}"
                                 alt="Profile"
                                 class="object-cover" /> --}}
                        </div>
                    </button>
                    <ul class="dropdown-content z-[1] menu menu-sm p-2 shadow bg-base-100 rounded-box w-52">
                        @if ($profile_url !== null)
                            <li>
                                <a href="{{ $profile_url }}" class="flex gap-2 items-center">
                                    <i class="fi fi-rr-user"></i>
                                    My Profile
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->hasRole('admin'))
                            <li>
                                <a href="{{ route('admin.dashboard') }}" class="flex gap-2 items-center">
                                    <i class="fi fi-rr-shield"></i>
                                    Admin Dashboard
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('hr.dashboard') }}" class="flex gap-2 items-center">
                                    <i class="fi fi-rr-briefcase"></i>
                                    HR Dashboard
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->hasRole('teacher'))
                            <li>
                                <a href="{{ route('teacher.dashboard') }}" class="flex gap-2 items-center">
                                    <i class="fi fi-rr-workshop"></i>
                                    Teacher Dashboard
                                </a>
                            </li>
                        @endif


                        @if (Auth::user()->hasRole('employee'))
                            <li>
                                <a href="{{ route('employee.dashboard') }}" class="flex gap-2 items-center">
                                    <i class="fi fi-rr-dashboard"></i>
                                    Employee Dashboard
                                </a>
                            </li>

                        @endif

                        <li>
                            <a href="{{route('profile.edit')}}" class="flex gap-2 items-center">
                                <i class="fi fi-rr-settings"></i>
                                Settings
                            </a>
                        </li>
                        <div class="my-1 divider"></div>
                        <li>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button class="flex gap-2 items-center text-error">
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
