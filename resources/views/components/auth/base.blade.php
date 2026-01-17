{{-- filepath: e:\Projects\Theos MIS\resources\views\components\auth\base.blade.php --}}
<x-app-layout>
    @php
        $loginContent = \App\Models\LoginContent::where('is_active', true)->with('backgroundImage')->first();
        $backgroundUrl = $loginContent?->backgroundImage?->file_dir
            ? asset($loginContent->backgroundImage->file_dir)
            : asset('Theos.png');
        $loginTitle = $loginContent?->title ?? 'Login';
        $loginDescription = $loginContent?->description ?? null;
    @endphp

    <x-landing-page.navbar />

    <div class="flex flex-col justify-center items-center min-h-screen relative">
        <!-- Dynamic Background Image -->
        <div class="absolute inset-0 z-0">
            <img src="{{ $backgroundUrl }}" alt="Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/30"></div>
        </div>

        <!-- Login Card -->
        <div class="p-6 w-full max-w-sm rounded-lg shadow-lg bg-base-100 relative z-10">
            <!-- Logo and Title -->
            <div class="flex flex-col gap-3 items-center">
                <img src="{{ asset('logo-modified.png') }}" alt="Logo" class="object-cover w-16 h-16">
                <h1 class="text-3xl font-bold text-accent">{{ $loginTitle }}</h1>
                @if($loginDescription)
                    <p class="text-xs text-center text-gray-600 mt-1">{{ $loginDescription }}</p>
                @endif
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
