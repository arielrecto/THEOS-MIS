<x-landing-page.base>
    <!-- Hero Section - Improved responsiveness -->
    <div class="relative bg-gradient-to-br from-accent to-accent-focus">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative container px-4 sm:px-6 mx-auto py-12 sm:py-16">
            <div class="max-w-2xl mx-auto text-center text-white">
                <h1 class="text-3xl sm:text-4xl font-bold mb-3 sm:mb-4">School Gallery</h1>
                <p class="text-base sm:text-lg opacity-90 px-4">Discover the vibrant life and memorable moments at Theos Higher Ground Academe.</p>
            </div>
        </div>
    </div>

    <!-- Gallery Section -->
    <section class="container px-4 sm:px-6 mx-auto py-8 sm:py-16"
             x-data="gallery()"
             @keydown.escape="closeModal()">
        <!-- Pass server-side data to Alpine -->
        <script>
            window.galleries = @json($galleries);
        </script>

        <!-- Filter Tabs - Scrollable on mobile -->
        <div class="overflow-x-auto -mx-4 sm:mx-0 px-4 sm:px-0 mb-8 sm:mb-12">
            <div class="flex flex-nowrap sm:flex-wrap sm:justify-center gap-2 sm:gap-3 min-w-max sm:min-w-0">
                <a class="btn btn-sm whitespace-nowrap"
                   href="/gallery"
                   :class="request()->query('category') === 'all' || !request()->query('category') ? 'btn-accent' : 'btn-ghost hover:bg-accent/10'">
                    All
                </a>
                <template x-for="category in categories" :key="category">
                    <a class="btn btn-sm whitespace-nowrap"
                       :href="`/gallery?category=${category}`"
                       :class="'{{request()->query('category')}}' === category ? 'btn-accent' : 'btn-ghost hover:bg-accent/10'"
                       x-text="category">
                    </a>
                </template>
            </div>
        </div>

        <!-- Gallery Grid - Responsive columns -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
            <template x-for="(item, index) in filteredImages" :key="item.id">
                <div class="group relative overflow-hidden rounded-xl bg-white shadow-lg">
                    <!-- Image Container - Maintains aspect ratio -->
                    <div class="relative pt-[75%]">
                        <img :src="item.url"
                             :alt="item.title"
                             class="absolute inset-0 w-full h-full object-cover transform transition duration-500 group-hover:scale-110">

                        <!-- Overlay - Always visible on mobile, hover on desktop -->
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent
                                  sm:opacity-0 sm:group-hover:opacity-100 transition-all duration-300">
                            <div class="absolute bottom-0 left-0 right-0 p-3 sm:p-4">
                                <h3 class="text-white font-bold text-sm sm:text-base mb-1" x-text="item.title"></h3>
                                <p class="text-white/80 text-xs sm:text-sm line-clamp-2" x-text="item.description"></p>
                                <div class="flex items-center gap-2 mt-2">
                                    <i class="fi fi-rr-calendar text-white/60 text-xs sm:text-sm"></i>
                                    <span class="text-white/60 text-xs sm:text-sm" x-text="item.date"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Quick View Button - Visible on mobile -->
                        <button @click="openModal(item)"
                                class="absolute top-2 right-2 sm:top-4 sm:right-4 p-2 bg-white/90 rounded-full
                                       sm:opacity-0 sm:translate-y-2 sm:group-hover:opacity-100 sm:group-hover:translate-y-0
                                       transition-all duration-300 hover:bg-white">
                            <i class="fi fi-rr-expand text-gray-800 text-sm sm:text-base"></i>
                        </button>
                    </div>
                </div>
            </template>
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-8 sm:mt-12" x-show="hasMore">
            <button @click="loadMore"
                    class="btn btn-accent gap-2 w-full sm:w-auto"
                    :disabled="loading">
                <i class="fi fi-rr-refresh" :class="{ 'animate-spin': loading }"></i>
                <span x-text="loading ? 'Loading...' : 'Load More'"></span>
            </button>
        </div>

        <!-- Gallery Modal - Responsive sizing -->
        <div class="modal modal-bottom sm:modal-middle"
             :class="{ 'modal-open': isModalOpen }"
             @click.self="closeModal">
            <div class="modal-box max-w-5xl p-0 bg-white rounded-lg overflow-hidden">
                <div class="relative">
                    <img :src="selectedImage?.url"
                         :alt="selectedImage?.title"
                         class="w-full h-48 sm:h-auto object-cover">
                    <button @click="closeModal"
                            class="btn btn-sm btn-circle absolute top-2 right-2 sm:top-4 sm:right-4">
                        <i class="fi fi-rr-cross"></i>
                    </button>
                </div>
                <div class="p-4 sm:p-6">
                    <h3 class="font-bold text-base sm:text-lg" x-text="selectedImage?.title"></h3>
                    <p class="text-gray-600 mt-2 text-sm sm:text-base" x-text="selectedImage?.description"></p>
                    <div class="flex items-center gap-2 mt-4 text-gray-500 text-sm">
                        <i class="fi fi-rr-calendar"></i>
                        <span x-text="selectedImage?.date"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-landing-page.base>


