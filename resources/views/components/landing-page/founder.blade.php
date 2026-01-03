{{-- filepath: e:\Projects\Theos MIS\resources\views\components\landing-page\founder.blade.php --}}
@props([
    'founders' => collect(),
])

@if($founders->count())
    <section id="founders" class="relative overflow-hidden">
        {{-- Background --}}
        <div class="absolute inset-0">
            <div class="absolute inset-0 bg-cover bg-center"
                 style="background-image: url('{{ asset('bg-2.png') }}');"></div>
            <div class="absolute inset-0 bg-white/85"></div>
        </div>

        <div class="relative container mx-auto px-6 py-16 md:py-20">
            {{-- Header --}}
            <div class="max-w-3xl">
                <h2 class="text-3xl md:text-5xl font-extrabold tracking-tight text-accent">
                    MEET THE <span class="text-orange-500">FOUNDERS</span>
                </h2>
                <p class="mt-4 text-gray-700 leading-relaxed">
                    Get to know the people behind our vision—committed to faith, excellence, and a lasting impact in education.
                </p>
            </div>

            {{-- Founder rows (multiple) --}}
            <div class="mt-10 space-y-10">
                @foreach($founders as $founder)
                    @php
                        $imageUrl = $founder->image?->file_dir ? asset($founder->image->file_dir) : null;
                        $isEven = $loop->iteration % 2 === 0;
                    @endphp

                    <div class="grid grid-cols-1 lg:grid-cols-12 items-center gap-8">
                        {{-- Image --}}
                        <div class="lg:col-span-5 {{ $isEven ? 'lg:order-2' : '' }}">
                            <div class="mx-auto w-full max-w-md">
                                <div class="relative aspect-square rounded-full overflow-hidden bg-gray-100 shadow-xl ring-4 ring-white">
                                    @if($imageUrl)
                                        <img
                                            src="{{ $imageUrl }}"
                                            alt="{{ $founder->name }}"
                                            class="h-full w-full object-cover"
                                        >
                                    @else
                                        <div class="h-full w-full flex items-center justify-center text-gray-400">
                                            <i class="fi fi-rr-user text-6xl"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Content --}}
                        <div class="lg:col-span-7 {{ $isEven ? 'lg:order-1' : '' }}">
                            <div class="bg-white/70 backdrop-blur rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8">
                                <div class="flex items-start justify-between gap-4">
                                    <div class="min-w-0">
                                        <h3 class="text-xl md:text-2xl font-bold text-gray-900 break-words">
                                            {{ $founder->name }}
                                        </h3>
                                        <div class="mt-2 h-1 w-16 bg-accent rounded-full"></div>
                                    </div>

                                    <div class="hidden md:flex items-center gap-2 text-accent/80">
                                        <i class="fi fi-rr-quote-right text-xl"></i>
                                    </div>
                                </div>

                                <p class="mt-5 text-gray-700 leading-relaxed whitespace-pre-line">
                                    {{ $founder->bio ?? '—' }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
