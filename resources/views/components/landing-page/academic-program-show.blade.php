<x-landing-page.base>
    <div class="py-12 bg-gray-50">
        <div class="container px-4 mx-auto">
            <!-- Hero Section -->
            <div class="relative mb-12 h-96 rounded-2xl overflow-hidden">
                <img src="{{ Storage::url($program->path) }}"
                     alt="{{ $program->title }}"
                     class="w-full h-full object-cover"
                     onerror="this.src='https://images.unsplash.com/photo-1503676260728-1c00da094a0b?w=800&auto=format&fit=crop'">
                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/50 to-transparent"></div>
                <div class="absolute bottom-0 left-0 right-0 p-8">
                    <div class="max-w-3xl">
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-4">
                            {{ $program->title }}
                        </h1>
                        @if($program->category)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-accent/20 text-white">
                                <i class="fi fi-rr-graduation-cap mr-2"></i>
                                {{ ucfirst($program->category) }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Content Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <div class="p-4 sm:p-6 md:p-8 bg-white rounded-xl shadow-sm">
                        <div class="prose prose-sm sm:prose md:prose-lg max-w-none">
                            <h2 class="text-xl sm:text-2xl font-bold text-gray-800 mb-4 sm:mb-6">Program Overview</h2>
                            <div class="text-gray-600 space-y-4 text-sm sm:text-base break-words"
                                 x-data="{
                                     text: `{{ $program->description }}`,
                                     init() {
                                         this.linkifyDescription();
                                     },
                                     linkifyDescription() {
                                         const urlRegex = /(https?:\/\/[^\s]+)/g;
                                         const element = this.$el;

                                         if (urlRegex.test(this.text)) {
                                             const linked = this.text.replace(urlRegex, '<a href=`$1` target=`_blank` rel=`noopener noreferrer` class=`text-accent hover:underline font-medium`>$1</a>');
                                             element.innerHTML = linked;
                                         } else {
                                             element.textContent = this.text;
                                         }
                                     }
                                 }">
                                {{ $program->description }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Program Status -->
                    <div class="p-6 bg-white rounded-xl shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Program Status</h3>
                        <div class="flex items-center">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $program->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                <i class="fi {{ $program->is_active ? 'fi-rr-check' : 'fi-rr-cross' }} mr-2"></i>
                                {{ $program->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="p-6 bg-white rounded-xl shadow-sm">
                        <h3 class="text-lg font-semibold text-gray-800 mb-4">Interested?</h3>
                        <div class="space-y-4">
                            @if($activeEnrollment)
                                <a href="{{ route('enrollment.show', $activeEnrollment->id) }}"
                                   class="btn btn-accent w-full gap-2">
                                    <i class="fi fi-rr-graduation-cap"></i>
                                    Enroll Now
                                </a>
                            @endif
                            <a href="{{ route('contact') }}"
                               class="btn btn-outline w-full gap-2">
                                <i class="fi fi-rr-messages"></i>
                                Contact Us
                            </a>
                        </div>
                    </div>

                    <!-- Similar Programs -->
                    {{-- @if($similarPrograms && $similarPrograms->count() > 0)
                        <div class="p-6 bg-white rounded-xl shadow-sm">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Similar Programs</h3>
                            <div class="space-y-4">
                                @foreach($similarPrograms as $similar)
                                    <a href="{{ route('academic-programs.show', $similar->id) }}"
                                       class="flex items-center gap-4 p-3 rounded-lg hover:bg-gray-50 transition-colors">
                                        <img src="{{ Storage::url($similar->path) }}"
                                             alt="{{ $similar->title }}"
                                             class="w-16 h-16 rounded-lg object-cover"
                                             onerror="this.src='https://via.placeholder.com/64'">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $similar->title }}</h4>
                                            @if($similar->category)
                                                <p class="text-sm text-gray-500">{{ ucfirst($similar->category) }}</p>
                                            @endif
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif --}}
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            // Alpine is ready if needed for additional features
        });

        // Fallback if Alpine doesn't linkify properly
        document.querySelectorAll('[x-data*="linkifyDescription"]').forEach(el => {
            const urlRegex = /(https?:\/\/[^\s]+)/g;
            const text = el.textContent;

            if (urlRegex.test(text)) {
                const linked = text.replace(/(https?:\/\/[^\s]+)/g,
                    '<a href="$1" target="_blank" rel="noopener noreferrer" class="text-accent hover:underline font-medium">$1</a>');
                el.innerHTML = linked;
            }
        });
    </script>
    @endpush
</x-landing-page.base>
