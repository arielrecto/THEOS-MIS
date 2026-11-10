@php
    use App\Models\Logo;
    use App\Models\AboutUs;
    use App\Models\ContactUs;
    use App\Models\AcademicYear;
    use App\Enums\AcademicYearStatus;
    use Illuminate\Support\Facades\Storage;

    $footerLogo = Logo::whereIn('type', ['footer', 'main'])
        ->where('is_active', true)
        ->orderByRaw("CASE WHEN type = 'footer' THEN 0 ELSE 1 END")
        ->latest()
        ->first();
    $footerLogoUrl = $footerLogo ? Storage::url($footerLogo->path) : asset('logo-modified.png');

    $aboutUs = AboutUs::first();
    $contactUs = ContactUs::first();
    $activeYear = AcademicYear::where('status', AcademicYearStatus::Active->value)->latest()->first();

    $established = config('school.established');
    $yearsOfService = now()->year - $established;

    $quickLinks = [
        ['label' => 'Home', 'url' => route('landing')],
        ['label' => 'Announcements', 'url' => route('landing') . '#announcement'],
        ['label' => 'Gallery', 'url' => route('gallery')],
        ['label' => 'About Us', 'url' => route('about')],
        ['label' => 'Contact Us', 'url' => route('contact')],
    ];

    $socialIcons = ['facebook' => 'fi-brands-facebook', 'instagram' => 'fi-brands-instagram', 'youtube' => 'fi-brands-youtube'];
    $socialLinks = collect(config('school.social'))->filter();
@endphp

<footer class="relative text-white bg-blue-500 bg-center bg-cover"
    style="background-image: url('{{ asset('thga_background_cover.png') }}')">
    <div class="container px-6 pt-12 pb-6 mx-auto md:px-12 lg:px-24">
        <div class="grid grid-cols-1 gap-10 md:grid-cols-2 lg:grid-cols-12">
            <!-- Brand -->
            <div class="lg:col-span-5">
                <div class="flex gap-4 items-center">
                    <img src="{{ $footerLogoUrl }}" alt="{{ config('school.name') }} logo"
                        onerror="this.src='{{ asset('logo-modified.png') }}'"
                        class="object-contain w-16 h-16 bg-white rounded-full ring-4 shadow-lg ring-white/40 shrink-0">
                    <div class="min-w-0">
                        <h2 class="text-xl font-bold leading-tight sm:text-2xl">{{ config('school.name') }}</h2>
                        <p class="text-sm italic text-white/85">Nurturing minds, shaping the future.</p>
                    </div>
                </div>

                <span class="inline-flex gap-2 items-center px-3 py-1 mt-5 text-xs font-semibold tracking-wider rounded-full border border-white/30 bg-white/15">
                    <span class="w-1.5 h-1.5 bg-yellow-300 rounded-full"></span>
                    EST. {{ $established }} | MATT 6:33
                </span>

                <p class="mt-4 max-w-sm text-sm leading-relaxed text-white/90">
                    Excellence in Christian education for over {{ $yearsOfService }} years, building character and
                    competence rooted in faith and academic excellence.
                </p>

                @if ($socialLinks->isNotEmpty())
                    <div class="flex gap-3 items-center mt-5">
                        @foreach ($socialLinks as $network => $url)
                            <a href="{{ $url }}" target="_blank" rel="noopener" aria-label="{{ ucfirst($network) }}"
                                class="flex justify-center items-center w-9 h-9 rounded-full border transition duration-200 border-white/30 bg-white/15 hover:bg-white hover:text-blue-600 hover:-translate-y-1 hover:shadow-lg">
                                <i class="flex fi {{ $socialIcons[$network] ?? 'fi-rr-link' }}"></i>
                            </a>
                        @endforeach
                        <span class="ml-1 text-xs text-white/80">Follow our journey</span>
                    </div>
                @endif
            </div>

            <!-- Quick links -->
            <div class="lg:col-span-3">
                <h3 class="flex gap-3 items-center text-xs font-semibold tracking-[0.2em] uppercase text-white/90">
                    Quick Links <span class="w-10 h-px bg-white/40"></span>
                </h3>
                <ul class="mt-5 space-y-3">
                    @foreach ($quickLinks as $link)
                        <li>
                            <a href="{{ $link['url'] }}"
                                class="group inline-flex gap-2 items-center text-sm transition duration-200 text-white/90 hover:text-white hover:translate-x-1">
                                <span class="w-0 h-px bg-yellow-300 transition-all duration-200 group-hover:w-3"></span>
                                {{ $link['label'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Contact -->
            <div class="md:col-span-2 lg:col-span-4">
                <h3 class="flex gap-3 items-center text-xs font-semibold tracking-[0.2em] uppercase text-white/90">
                    Contact Us <span class="w-10 h-px bg-white/40"></span>
                </h3>
                <ul class="mt-5 space-y-4 text-sm text-white/90">
                    @if ($aboutUs?->address)
                        <li class="flex gap-3 items-start">
                            <span class="flex justify-center items-center w-8 h-8 rounded-full bg-white/15 shrink-0">
                                <i class="flex fi fi-rr-marker"></i>
                            </span>
                            <span class="pt-1.5">{{ $aboutUs->address }}</span>
                        </li>
                    @endif
                    @if ($contactUs?->phone_number)
                        <li class="flex gap-3 items-center">
                            <span class="flex justify-center items-center w-8 h-8 rounded-full bg-white/15 shrink-0">
                                <i class="flex fi fi-rr-phone-call"></i>
                            </span>
                            <a href="tel:{{ preg_replace('/\s+/', '', $contactUs->phone_number) }}" class="hover:underline">{{ $contactUs->phone_number }}</a>
                        </li>
                    @endif
                    @if ($contactUs?->email_address)
                        <li class="flex gap-3 items-center">
                            <span class="flex justify-center items-center w-8 h-8 rounded-full bg-white/15 shrink-0">
                                <i class="flex fi fi-rr-envelope"></i>
                            </span>
                            <a href="mailto:{{ $contactUs->email_address }}" class="break-all hover:underline">{{ $contactUs->email_address }}</a>
                        </li>
                    @endif
                </ul>

                @if ($activeYear)
                    <div class="flex gap-3 items-start p-4 mt-6 text-sm rounded-xl border backdrop-blur-sm border-white/30 bg-white/15">
                        <span class="mt-1.5 w-2 h-2 bg-yellow-300 rounded-full shrink-0"></span>
                        <p>
                            <span class="font-semibold">Admissions open</span> for S.Y.
                            {{ \Illuminate\Support\Carbon::parse($activeYear->start_date)->year }}–{{ \Illuminate\Support\Carbon::parse($activeYear->end_date)->year }}
                            · Visit us Mon–Fri 8am–4pm
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Bottom bar -->
        <div class="flex flex-col gap-2 justify-between items-center pt-6 mt-10 text-xs border-t sm:flex-row border-white/25 text-white/85">
            <p>&copy; {{ now()->year }} {{ config('school.name') }}. All rights reserved.</p>
            <p class="italic text-center sm:text-right">“But seek first his kingdom and his righteousness…” — Matthew 6:33</p>
        </div>
    </div>
</footer>
