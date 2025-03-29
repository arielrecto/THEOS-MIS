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
                            <span class="badge badge-xs badge-accent indicator-item">2</span>
                        </div>
                    </button>
                    <div class="dropdown-content z-[1] card card-compact w-80 shadow bg-base-100">
                        <div class="card-body">
                            <div class="flex items-center justify-between mb-2">
                                <h3 class="font-semibold">Notifications</h3>
                                <a href="#" class="text-sm text-accent hover:underline">Mark all as read</a>
                            </div>
                            <div class="divide-y">
                                <!-- Notification Items Here -->
                            </div>
                            <div class="card-actions mt-2">
                                <a href="#" class="btn btn-ghost btn-sm btn-block">View All</a>
                            </div>
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
