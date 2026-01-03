{{-- filepath: e:\Projects\Theos MIS\resources\views\components\landing-page\about-us.blade.php --}}
  @php
        use Illuminate\Support\Facades\Storage;

        $imageUrl = $aboutUs?->path ? Storage::url($aboutUs->path) : asset('logo-modified.png');

        // Prefer split fields; fallback to legacy combined field
        $visionText = $aboutUs?->vision ?? null;
        $missionText = $aboutUs?->mission ?? null;

        if ((!$visionText || !$missionText) && ($aboutUs?->mission_and_vision)) {
            // If legacy field exists, reuse it (no guessing/splitting)
            $visionText = $visionText ?: $aboutUs->mission_and_vision;
            $missionText = $missionText ?: $aboutUs->mission_and_vision;
        }
    @endphp

<x-landing-page.base>


    <section class="container px-6 mx-auto my-16">
        <div class="relative overflow-hidden rounded-3xl bg-sky-100/70">
            {{-- Background image (bg-1.png) --}}
            <div class="absolute inset-0 bg-center bg-no-repeat bg-cover opacity-40"
                 style="background-image: url('{{ asset('bg-1.png') }}');"></div>
            <div class="absolute inset-0 bg-sky-100/55"></div>

            {{-- Decorative shapes (like reference) --}}
            <div class="absolute -top-12 -right-12 w-44 h-44 rounded-full border-[18px] border-orange-400/90"></div>
            <div class="absolute -bottom-14 -left-14 w-56 h-56 rounded-full border-[10px] border-blue-700/30"></div>
            <div class="absolute -bottom-20 -left-20 w-72 h-72 rounded-full border-[10px] border-blue-700/20"></div>

            <div class="relative p-6 sm:p-10 lg:p-12">
                {{-- About (image left, text right) --}}
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-10 items-center">
                    <div class="lg:col-span-6">
                        <div class="rounded-2xl overflow-hidden shadow-lg bg-white">
                            <img
                                src="{{ $imageUrl }}"
                                alt="About image"
                                class="w-full h-[260px] sm:h-[320px] lg:h-[360px] object-cover"
                                onerror="this.src='{{ asset('logo-modified.png') }}'"
                            >
                        </div>
                    </div>

                    <div class="lg:col-span-6">
                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-extrabold tracking-tight text-accent">
                            {{ $aboutUs->title ?? 'About Our School' }}
                        </h2>

                        <p class="mt-3 text-sm sm:text-base font-semibold text-accent/80 leading-snug">
                            {{ $aboutUs->sub_title ?? 'We are committed to providing the best Christian education to guide students on their spiritual journey.' }}
                        </p>

                        <div class="mt-4 text-sm sm:text-base text-gray-700 leading-relaxed whitespace-pre-line">
                            {{ $aboutUs->description ?? 'Welcome to our school—where we nurture minds, build character, and pursue excellence.' }}
                        </div>
                    </div>
                </div>

                {{-- Mission & Vision (same section, like the 2nd image) --}}
                <div class="mt-10 lg:mt-12 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="rounded-2xl bg-blue-800 text-white p-6 sm:p-8 shadow-lg">
                        <h3 class="text-3xl font-extrabold tracking-wide text-orange-400">VISION</h3>
                        <p class="mt-4 text-sm sm:text-base leading-relaxed text-white/90 whitespace-pre-line">
                            {{ $visionText ?? '—' }}
                        </p>
                    </div>

                    <div class="rounded-2xl bg-blue-800 text-white p-6 sm:p-8 shadow-lg">
                        <h3 class="text-3xl font-extrabold tracking-wide text-orange-400">MISSION</h3>
                        <p class="mt-4 text-sm sm:text-base leading-relaxed text-white/90 whitespace-pre-line">
                            {{ $missionText ?? '—' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-landing-page.base>
