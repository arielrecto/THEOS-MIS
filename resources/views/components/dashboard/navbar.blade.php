@php
    use App\Models\User;
    use App\Actions\NotificationActions;
    $user = User::find(Auth::user()->id);
    $notifications = $user->notificationLogs()->latest()->take(5)->get();
    $unread_count = $user->getUnreadNotificationsCountAttribute();

    use App\Models\Logo;

    // Get active main logo or default to logo-modified.png
    $mainLogo = Logo::where('type', 'main')->where('is_active', true)->latest()->first();
    $logoPath = $mainLogo ? Storage::url($mainLogo->path) : asset('logo.jpg');

@endphp

@props([
    'profile_url' => null,
])

<div class="w-full bg-white shadow-sm">
    <div class="container px-4 py-3 mx-auto">
        <div class="flex justify-between items-center">
            <!-- Left side -->
            <div class="flex gap-4 items-center">
                <!-- Menu Toggle for Mobile -->
                <button id="mobile_menu_toggle" class="btn btn-ghost btn-sm lg:hidden" aria-label="Toggle menu">
                    {{-- <i class="text-lg fi fi-rr-menu-burger"></i> --}}
                    <img src="{{ $logoPath }}" alt="School Logo"
                        class="object-contain w-8 h-8 sm:w-10 sm:h-10 md:w-12 md:h-12 lg:w-20 lg:h-20 rounded-full"
                        </button>

                    <!-- Dashboard Title (responsive) -->
                    <div class="min-w-0">
                        <h1 class="text-sm lg:text-lg font-semibold text-gray-800 truncate">
                            <span class="hidden sm:inline">Welcome back, </span>
                            {{ Auth::user()->name }}!
                        </h1>
                        <p class="text-xs sm:text-sm text-gray-600 truncate">
                            {{ now()->format('l F d, Y') }}
                        </p>
                    </div>
                </div>
            <!-- Right side -->
            <div class="flex gap-3 items-center">
                <!-- Notifications -->
                <div class="dropdown dropdown-end relative">
                    <button class="btn btn-ghost btn-sm" aria-haspopup="true" aria-expanded="false">
                        <div class="indicator">
                            <i class="text-lg fi fi-rr-bell"></i>
                            @if ($unread_count > 0)
                                <span class="badge badge-xs badge-accent indicator-item">{{ $unread_count }}</span>
                            @endif
                        </div>
                    </button>
                    <div class="dropdown-content z-[1] card card-compact w-80 shadow bg-base-100 right-0">
                        <div class="card-body p-3">
                            <div class="flex justify-between items-center mb-2">
                                <h3 class="font-semibold">Notifications</h3>
                                @if ($unread_count > 0)
                                    <form action="{{ route('notifications.mark-all-read') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="text-sm text-accent hover:underline">
                                            Mark all read
                                        </button>
                                    </form>
                                @endif
                            </div>
                            <div class="overflow-y-auto max-h-56 divide-y">
                                @forelse($notifications as $notification)
                                    <div class="py-2 {{ $notification->is_read ? 'opacity-50' : '' }}">
                                        <div class="flex gap-3 items-start">
                                            <div class="flex-1">
                                                <p class="text-sm font-medium truncate">{{ $notification->header }}</p>
                                                <p class="text-xs text-gray-500 truncate">{{ $notification->message }}
                                                </p>
                                                <span class="text-xs text-gray-400">
                                                    {{ $notification->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                            @if (!$notification->is_read)
                                                <form action="{{ route('notifications.mark-as-read', $notification) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-ghost btn-xs">
                                                        <i class="text-xs fi fi-rr-check"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </div>
                                @empty
                                    <div class="py-6 text-center">
                                        <i class="mb-2 text-2xl text-gray-400 fi fi-rr-bell-ring"></i>
                                        <p class="text-sm text-gray-500">No notifications</p>
                                    </div>
                                @endforelse
                            </div>
                            @if ($notifications->count() > 0)
                                <div class="mt-2 card-actions">
                                    <a href="{{ route('notifications.index') }}" class="btn btn-ghost btn-sm w-full">
                                        View All
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Profile Dropdown (compact on mobile) -->
                <div class="dropdown dropdown-end">
                    <button id="profile_btn" class="btn btn-ghost btn-circle avatar" aria-haspopup="true"
                        aria-expanded="false">
                        <div class="w-10 rounded-full overflow-hidden">
                            @if ($user?->profile?->image)
                                <img src="{{ $user->profile->image }}" alt="Profile Picture"
                                    class="object-cover w-full h-full" />
                            @elseif ($user->profilePicture)
                                <img src="{{ $user->profilePicture->file_dir }}" alt="Profile Picture"
                                    class="object-cover w-full h-full" />
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=EBF4FF"
                                    alt="Profile Picture" class="object-cover w-full h-full" />
                            @endif
                        </div>
                    </button>

                    <ul class="dropdown-content z-[1] menu menu-sm p-2 shadow bg-base-100 rounded-box w-52 right-0">
                        @if ($profile_url !== null)
                            <li>
                                <a href="{{ $profile_url }}" class="flex gap-2 items-center">
                                    <i class="fi fi-rr-user"></i>
                                    My Profile
                                </a>
                            </li>
                        @endif

                        @if (Auth::user()->hasRole('admin'))
                            <li><a href="{{ route('admin.dashboard') }}" class="flex gap-2 items-center"><i
                                        class="fi fi-rr-shield"></i> Admin</a></li>
                            <li><a href="{{ route('hr.dashboard') }}" class="flex gap-2 items-center"><i
                                        class="fi fi-rr-briefcase"></i> HR</a></li>
                        @endif

                        @if (Auth::user()->hasRole('teacher'))
                            <li><a href="{{ route('teacher.dashboard') }}" class="flex gap-2 items-center"><i
                                        class="fi fi-rr-workshop"></i> Teacher</a></li>
                        @endif

                        @if (Auth::user()->hasRole('registrar'))
                            <li><a href="{{ route('registrar.dashboard') }}" class="flex gap-2 items-center"><i
                                        class="fi fi-rr-diploma"></i> Registrar</a></li>
                        @endif

                        @if (Auth::user()->hasRole('employee'))
                            <li><a href="{{ route('employee.dashboard') }}" class="flex gap-2 items-center"><i
                                        class="fi fi-rr-dashboard"></i> Employee</a></li>
                        @endif

                        @if (Auth::user()->hasRole('student'))
                            <li><a href="{{ route('student.enrollment.index') }}" class="flex gap-2 items-center"><i
                                        class="fi fi-rr-dashboard"></i> Enrollment</a></li>
                            @if (Auth::user()->studentProfile)
                                <li><a href="{{ route('student.dashboard') }}" class="flex gap-2 items-center"><i
                                            class="fi fi-rr-dashboard"></i> Dashboard</a></li>
                            @endif
                        @endif

                        <li><a href="{{ route('profile.edit') }}" class="flex gap-2 items-center"><i
                                    class="fi fi-rr-settings"></i> Settings</a></li>
                        <div class="my-1 divider"></div>
                        <li>
                            <form action="{{ route('logout') }}" method="post">
                                @csrf
                                <button class="flex gap-2 items-center text-error">
                                    <i class="fi fi-rr-sign-out"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Mobile slide panel (hidden on md+) -->
        <div id="mobile_panel" class="md:hidden mt-3 hidden">
            <div class="bg-white rounded-lg shadow p-3 space-y-3">
                <div class="flex items-center gap-3">
                    <div class="w-10 rounded-full overflow-hidden">
                        @if ($user?->profile?->image)
                            <img src="{{ $user->profile->image }}" alt="Profile Picture"
                                class="object-cover w-full h-full" />
                        @elseif ($user->profilePicture)
                            <img src="{{ $user->profilePicture->file_dir }}" alt="Profile Picture"
                                class="object-cover w-full h-full" />
                        @else
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&color=7F9CF5&background=EBF4FF"
                                alt="Profile Picture" class="object-cover w-full h-full" />
                        @endif
                    </div>
                    <div class="min-w-0">
                        <p class="font-medium truncate">{{ $user->name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                    </div>
                </div>

                <div class="divider"></div>

                {{-- <a href="{{ route('notifications.index') }}"
                    class="flex items-center gap-3 p-2 rounded hover:bg-gray-50">
                    <i class="fi fi-rr-bell"></i>
                    <span>Notifications</span>
                    @if ($unread_count > 0)
                        <span class="ml-auto badge badge-xs badge-accent">{{ $unread_count }}</span>
                    @endif
                </a> --}}



                @if (Auth::user()->hasRole('admin'))
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-50"><i
                            class="fi fi-rr-shield"></i> Admin</a>
                    <a href="{{ route('hr.dashboard') }}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-50"><i
                            class="fi fi-rr-briefcase"></i> HR</a>
                @endif

                @if (Auth::user()->hasRole('teacher'))
                    <a href="{{ route('teacher.dashboard') }}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-50"><i
                            class="fi fi-rr-workshop"></i> Teacher</a>
                @endif

                @if (Auth::user()->hasRole('registrar'))
                    <a href="{{ route('registrar.dashboard') }}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-50"><i
                            class="fi fi-rr-diploma"></i> Registrar</a>
                @endif

                @if (Auth::user()->hasRole('employee'))
                    <a href="{{ route('employee.dashboard') }}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-50"><i
                            class="fi fi-rr-dashboard"></i> Employee</a>
                @endif

                @if (Auth::user()->hasRole('student'))
                    <a href="{{ route('student.enrollment.index') }}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-50"><i
                            class="fi fi-rr-dashboard"></i> Enrollment</a>
                    @if (Auth::user()->studentProfile)
                        <a href="{{ route('student.dashboard') }}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-50"><i
                                class="fi fi-rr-dashboard"></i> Dashboard</a>
                    @endif
                @endif


                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 p-2 rounded hover:bg-gray-50">
                    <i class="fi fi-rr-settings"></i>
                    <span>Settings</span>
                </a>

                <form action="{{ route('logout') }}" method="post" class="mt-2">
                    @csrf
                    <button type="submit" class="w-full btn btn-error">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        (function() {
            const toggle = document.getElementById('mobile_menu_toggle');
            const panel = document.getElementById('mobile_panel');

            if (toggle && panel) {
                toggle.addEventListener('click', () => {
                    panel.classList.toggle('hidden');
                    panel.classList.toggle('block');
                    // ensure focus for accessibility
                    if (!panel.classList.contains('hidden')) panel.querySelector('a, button, input')?.focus();
                });
            }
        })();
    </script>
@endpush
