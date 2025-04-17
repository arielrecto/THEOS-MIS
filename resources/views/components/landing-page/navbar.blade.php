@php
    use App\Models\Enrollment;
    use App\Models\Logo;
    use App\Enums\EnrollmentStatus;
    use Illuminate\Support\Facades\Storage;

    $enrollment = Enrollment::where('status', EnrollmentStatus::ONGOING)->latest()->first();
    $mainLogo = Logo::where('type', 'main')
        ->where('is_active', true)
        ->latest()
        ->first();
    $logoPath = $mainLogo ? Storage::url($mainLogo->path) : asset('logo-modified.png');
@endphp

<header x-data="{ isDrawerOpen: false }" class="sticky top-0 z-50 w-full bg-white shadow-md">
    <div class="container flex justify-between items-center px-6 py-4 mx-auto">
        <!-- Logo and Title -->
        <a href="/" class="flex gap-4 items-center">
            <img src="{{ $logoPath }}"
                 alt="School Logo"
                 class="w-14 h-14 object-contain"
                 onerror="this.src='{{ asset('logo-modified.png') }}'"
            >
            <h1 class="text-2xl font-bold text-blue-900">Theos Higher Ground Academe</h1>
        </a>

        <!-- Burger Menu Button -->
        <button @click="isDrawerOpen = true" class="text-blue-900 hover:text-blue-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
    </div>

    <!-- Drawer Menu -->
    <div x-show="isDrawerOpen"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-black bg-opacity-50 z-50">

        <!-- Drawer Content -->
        <div x-show="isDrawerOpen" x-cloak
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-300"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed right-0 top-0 h-full w-80 bg-white shadow-lg overflow-y-auto">

            <!-- Drawer Header -->
            <div class="flex justify-between items-center p-4 border-b">
                <h2 class="text-xl font-semibold text-blue-900">Menu</h2>
                <button @click="isDrawerOpen = false" class="text-gray-500 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Drawer Navigation -->
            <nav class="flex flex-col p-4 space-y-4">
                <a href="/" @click="isDrawerOpen = false"
                   class="flex items-center gap-3 p-2 text-blue-900 hover:bg-blue-50 rounded-lg">
                    <i class="fi fi-rr-home"></i>
                    <span>Home</span>
                </a>

                <a href="/#announcement" @click="isDrawerOpen = false"
                   class="flex items-center gap-3 p-2 text-blue-900 hover:bg-blue-50 rounded-lg">
                    <i class="fi fi-rr-megaphone"></i>
                    <span>Announcements</span>
                </a>

                <a href="{{ route('gallery') }}" @click="isDrawerOpen = false"
                   class="flex items-center gap-3 p-2 text-blue-900 hover:bg-blue-50 rounded-lg">
                    <i class="fi fi-rr-picture"></i>
                    <span>Gallery</span>
                </a>

                <a href="{{ route('about') }}" @click="isDrawerOpen = false"
                   class="flex items-center gap-3 p-2 text-blue-900 hover:bg-blue-50 rounded-lg">
                    <i class="fi fi-rr-info"></i>
                    <span>About</span>
                </a>

                <a href="{{ route('contact') }}" @click="isDrawerOpen = false"
                   class="flex items-center gap-3 p-2 text-blue-900 hover:bg-blue-50 rounded-lg">
                    <i class="fi fi-rr-phone-call"></i>
                    <span>Contact Us</span>
                </a>

                @if ($enrollment)
                    <a href="{{ route('enrollment.show', ['id' => $enrollment->id]) }}" @click="isDrawerOpen = false"
                       class="flex items-center gap-3 p-2 text-blue-900 hover:bg-blue-50 rounded-lg">
                        <i class="fi fi-rr-graduation-cap"></i>
                        <span>Enrollment</span>
                        <span class="ml-auto text-xs text-white bg-secondary px-2 py-1 rounded-full">New</span>
                    </a>
                @endif

                <a href="{{ route('job-opportunities') }}" @click="isDrawerOpen = false"
                   class="flex items-center gap-3 p-2 text-blue-900 hover:bg-blue-50 rounded-lg">
                    <i class="fi fi-rr-briefcase"></i>
                    <span>Job Opportunities</span>
                </a>

                <div class="pt-4 border-t">
                    @if (!auth()->check())
                        <a href="{{ route('login') }}" @click="isDrawerOpen = false"
                           class="flex items-center gap-3 p-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                            <i class="fi fi-rr-sign-in"></i>
                            <span>Login</span>
                        </a>
                    @else
                        <a href="{{ route('home') }}" @click="isDrawerOpen = false"
                           class="flex items-center gap-3 p-2 text-white bg-blue-600 hover:bg-blue-700 rounded-lg">
                            <i class="fi fi-rr-dashboard"></i>
                            <span>Dashboard</span>
                        </a>
                    @endif
                </div>
            </nav>
        </div>
    </div>
</header>
