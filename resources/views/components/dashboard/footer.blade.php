@php
    use App\Models\Logo;
    use App\Models\AcademicYear;
    use App\Enums\AcademicYearStatus;
    use Illuminate\Support\Facades\Storage;

    $footerLogo = Logo::whereIn('type', ['footer', 'main'])
        ->where('is_active', true)
        ->orderByRaw("CASE WHEN type = 'footer' THEN 0 ELSE 1 END")
        ->latest()
        ->first();
    $footerLogoUrl = $footerLogo ? Storage::url($footerLogo->path) : asset('logo.jpg');

    $activeYear = AcademicYear::where('status', AcademicYearStatus::Active->value)->latest()->first();
@endphp

<footer {{ $attributes->merge(['class' => 'relative overflow-hidden rounded-2xl border border-white/70 bg-gradient-to-r from-white/80 via-blue-50/80 to-blue-100/80 px-5 py-4 shadow-lg backdrop-blur-sm sm:px-6']) }}>
    <div class="flex flex-col gap-4 items-center sm:flex-row sm:justify-between">
        <div class="flex gap-3 items-center min-w-0">
            <img src="{{ $footerLogoUrl }}" alt="{{ config('school.name') }} logo"
                class="object-contain w-12 h-12 rounded-full ring-2 ring-white shrink-0 sm:w-14 sm:h-14">
            <p class="text-sm text-slate-700">
                <span class="font-medium">{{ config('school.name') }}</span>
                <span class="text-slate-400">·</span>
                Established {{ config('school.established') }}
            </p>
        </div>

        <div class="flex gap-4 items-center">
            <p class="text-xs text-center sm:text-right text-slate-600">
                @if ($activeYear)
                    {{ $activeYear->name }}
                    <span class="text-slate-400">·</span>
                @endif
                <a href="{{ route('contact') }}" class="hover:text-blue-600 hover:underline">Support</a>
            </p>
            <x-illustrations.school-building class="hidden w-16 h-12 sm:block shrink-0" />
        </div>
    </div>
</footer>
