<x-app-layout>
    <x-landing-page.navbar />

    <div class="flex flex-col justify-center items-center min-h-screen relative">
        <!-- Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('Theos.png') }}" alt="Background" class="w-full h-full object-cover">
            <div></div>
        </div>

        <!-- Login Card -->
        <div class="p-6 w-full max-w-sm rounded-lg shadow-lg bg-base-100 relative z-10">
            <!-- Logo and Title -->
            <div class="flex flex-col gap-3 items-center">
                <img src="{{ asset('logo-modified.png') }}" alt="Logo" class="object-cover w-16 h-16">
                <h1 class="text-3xl font-bold text-accent">Login</h1>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="mt-3 w-full text-xs text-error">
                    @foreach ($errors->all() as $error)
                        <p>• {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <!-- Login Form -->
            {{ $slot }}

            <!-- Register Link -->
            {{-- <p class="mt-4 text-sm text-center text-secondary">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-accent hover:underline">Sign up</a>
            </p> --}}
        </div>
    </div>
</x-app-layout>
