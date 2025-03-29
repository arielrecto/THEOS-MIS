@php
    use App\Models\Enrollment;
    use App\Enums\EnrollmentStatus;

    $enrollment = Enrollment::where('status', EnrollmentStatus::ONGOING)->latest()->first();
@endphp

<header class="sticky top-0 z-50 w-full bg-white shadow-md">
    <div class="container flex justify-between items-center px-6 py-4 mx-auto">
        <a href="/" class="flex gap-4 items-center">
            <img src="{{ asset('logo-modified.png') }}" alt="School Logo" class="w-14 h-14">
            <h1 class="text-2xl font-bold text-blue-900">Theos Higher Ground Academe</h1>
        </a>

        <nav class="hidden gap-6 md:flex">
            <a href="/" class="font-medium text-blue-900 transition hover:text-blue-600">Home</a>
            <a href="/#announcement" class="font-medium text-blue-900 transition hover:text-blue-600">Announcements</a>
            <a href="{{ route('gallery') }}"
                class="font-medium text-blue-900 transition hover:text-blue-600">Gallery</a>
            <a href="{{ route('about') }}" class="font-medium text-blue-900 transition hover:text-blue-600">About</a>
            <a href="{{ route('contact') }}" class="font-medium text-blue-900 transition hover:text-blue-600">Contact
                Us</a>

            @if ($enrollment)
                <div class="indicator">
                    <span class="text-xs text-white indicator-item badge badge-secondary"></span>
                    <a href="{{ route('enrollment.show', ['id' => $enrollment->id]) }}"
                        class="font-medium text-blue-900 transition hover:text-blue-600">Enrollment</a>
                </div>
            @endif
            <a href="{{ route('job-opportunities') }}" class="font-medium text-blue-900 transition hover:text-blue-600">Job Opportunities</a>
        </nav>


        @if (!auth()->check())
            <a href="{{ route('login') }}"
                class="px-4 py-2 text-white bg-blue-600 rounded-md transition hover:bg-blue-700">Login</a>
        @else
            <a href="{{ route('home') }}"
                class="px-4 py-2 text-white bg-blue-600 rounded-md transition hover:bg-blue-700">Dashboard</a>
        @endif
    </div>
</header>
