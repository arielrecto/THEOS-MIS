{{-- filepath: e:\Projects\Theos MIS\resources\views\components\landing-page\campuses.blade.php --}}
@props([
    'campuses' => [],
])

@php
    use App\Models\CampusContent;

    // Get active campus content
    $campusContent = CampusContent::where('is_active', true)->first();

    // Fallback values if no active content
    $title = $campusContent?->title ?? 'Our Campuses';
    $description =
        $campusContent?->description ??
        'Discover our network of campuses providing quality education across multiple locations';
@endphp

<section id="campuses" class="py-20 bg-white">
    <div class="container px-4 mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">{{ $title }}</h2>
            <div class="w-24 h-1 bg-accent mx-auto mb-4"></div>
            <p class="text-lg text-gray-600 max-w-2xl mx-auto">
                {{ $description }}
            </p>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @forelse($campuses as $campus)
                <div
                    class="group relative bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <!-- Image Container -->
                    <div class="relative h-64 overflow-hidden bg-gray-100">
                        @if ($campus->image)
                            <img src="{{ asset($campus->image->file_dir) }}" alt="{{ $campus->name }}"
                                class="w-full h-full object-cover transform transition-transform duration-500 group-hover:scale-110"
                                onerror="this.src='https://images.unsplash.com/photo-1562774053-701939374585?w=800&auto=format&fit=crop'">
                        @else
                            <div
                                class="w-full h-full flex items-center justify-center bg-gradient-to-br from-accent/20 to-accent/10">
                                <i class="fi fi-rr-school text-6xl text-accent/40"></i>
                            </div>
                        @endif

                        <!-- Gradient Overlay -->
                        <div
                            class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent opacity-60 group-hover:opacity-90 transition-opacity duration-300">
                        </div>

                        <!-- Campus Name (Always Visible) -->
                        <div
                            class="absolute bottom-0 left-0 right-0 p-4 text-white transform transition-transform duration-300">
                            <h3 class="text-xl font-bold mb-1 line-clamp-2">{{ $campus->name }}</h3>
                        </div>

                        <!-- Hover Details Overlay -->
                        <div
                            class="absolute inset-0 bg-accent/95 p-6 opacity-0 group-hover:opacity-100 transition-opacity duration-300 flex flex-col justify-center">
                            <div class="text-white space-y-4">
                                <div>
                                    <h3 class="text-xl font-bold mb-3 border-b border-white/30 pb-2">{{ $campus->name }}
                                    </h3>
                                </div>

                                @if ($campus->address)
                                    <div class="flex items-start gap-3">
                                        <i class="fi fi-rr-marker flex-shrink-0 mt-1"></i>
                                        <div>
                                            <p class="text-sm font-medium mb-1">Address</p>
                                            <p class="text-xs text-white/90 line-clamp-2">{{ $campus->address }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if ($campus->phone)
                                    <div class="flex items-start gap-3">
                                        <i class="fi fi-rr-phone-call flex-shrink-0 mt-1"></i>
                                        <div>
                                            <p class="text-sm font-medium mb-1">Phone</p>
                                            <p class="text-xs text-white/90">{{ $campus->phone }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if ($campus->email)
                                    <div class="flex items-start gap-3">
                                        <i class="fi fi-rr-envelope flex-shrink-0 mt-1"></i>
                                        <div>
                                            <p class="text-sm font-medium mb-1">Email</p>
                                            <p class="text-xs text-white/90 break-all">{{ $campus->email }}</p>
                                        </div>
                                    </div>
                                @endif

                                @if ($campus->description)
                                    <div class="pt-2 border-t border-white/30">
                                        <p class="text-xs text-white/90 line-clamp-3">{{ $campus->description }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="flex flex-col items-center justify-center py-16 bg-gray-50 rounded-xl">
                        <i class="fi fi-rr-school text-5xl text-gray-400 mb-4"></i>
                        <p class="text-gray-500 text-lg">No campuses available at the moment</p>
                    </div>
                </div>
            @endforelse
        </div>

        @if ($campuses->count() > 0)
            <div class="text-center mt-12">
                <p class="text-sm text-gray-600">
                    <i class="fi fi-rr-info-circle mr-2"></i>
                    Hover over each campus to view more details
                </p>
            </div>
        @endif
    </div>
</section>
