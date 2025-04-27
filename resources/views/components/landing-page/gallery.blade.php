<x-landing-page.base>
    <!-- Hero Section -->
    <div class="relative bg-gradient-to-br from-accent to-accent-focus">
        <div class="absolute inset-0 bg-black/20"></div>
        <div class="relative container px-6 mx-auto py-16">
            <div class="max-w-2xl mx-auto text-center text-white">
                <h1 class="text-4xl font-bold mb-4">School Gallery</h1>
                <p class="text-lg opacity-90">Discover the vibrant life and memorable moments at Theos Higher Ground Academe.</p>
            </div>
        </div>
    </div>

    <!-- Gallery Section -->
    <section class="container px-6 mx-auto py-16"
             x-data="gallery()"
             @keydown.escape="closeModal()">
        <!-- Pass server-side data to Alpine -->
        <script>
            window.galleries = @json($galleries);
        </script>

        <!-- Filter Tabs -->
        <div class="flex flex-wrap justify-center gap-3 mb-12">
            <button class="btn btn-sm"
                    :class="selectedCategory === 'all' ? 'btn-accent' : 'btn-ghost hover:bg-accent/10'"
                    @click="filterGallery('all')">
                All
            </button>
            <template x-for="category in categories" :key="category">
                <button class="btn btn-sm"
                        :class="selectedCategory === category ? 'btn-accent' : 'btn-ghost hover:bg-accent/10'"
                        @click="filterGallery(category)"
                        x-text="category">
                </button>
            </template>
        </div>

        <!-- Gallery Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            <template x-for="(item, index) in filteredImages" :key="item.id">
                <div class="group relative overflow-hidden rounded-xl bg-white shadow-lg">
                    <!-- Image Container -->
                    <div class="relative pt-[75%]">
                        <img :src="item.url"
                             :alt="item.title"
                             class="absolute inset-0 w-full h-full object-cover transform transition duration-500 group-hover:scale-110">
                    </div>

                    <!-- Overlay -->
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/50 to-transparent opacity-0 group-hover:opacity-100 transition-all duration-300">
                        <div class="absolute bottom-0 left-0 right-0 p-4">
                            <h3 class="text-white font-bold mb-1" x-text="item.title"></h3>
                            <p class="text-white/80 text-sm line-clamp-2" x-text="item.description"></p>
                            <div class="flex items-center gap-2 mt-2">
                                <i class="fi fi-rr-calendar text-white/60 text-sm"></i>
                                <span class="text-white/60 text-sm" x-text="item.date"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Quick View Button -->
                    <button @click="openModal(item)"
                            class="absolute top-4 right-4 p-2 bg-white/90 rounded-full opacity-0 translate-y-2 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-300 hover:bg-white">
                        <i class="fi fi-rr-expand text-gray-800"></i>
                    </button>
                </div>
            </template>
        </div>

        <!-- Load More Button -->
        <div class="text-center mt-12" x-show="hasMore">
            <button @click="loadMore" class="btn btn-accent gap-2" :disabled="loading">
                <i class="fi fi-rr-refresh" :class="{ 'animate-spin': loading }"></i>
                <span x-text="loading ? 'Loading...' : 'Load More'"></span>
            </button>
        </div>

        <!-- Gallery Modal -->
        <div class="modal" :class="{ 'modal-open': isModalOpen }" @click.self="closeModal">
            <div class="modal-box max-w-5xl p-0 bg-white rounded-lg overflow-hidden">
                <div class="relative">
                    <img :src="selectedImage?.url"
                         :alt="selectedImage?.title"
                         class="w-full">
                    <button @click="closeModal"
                            class="btn btn-sm btn-circle absolute top-4 right-4">
                        <i class="fi fi-rr-cross"></i>
                    </button>
                </div>
                <div class="p-6">
                    <h3 class="font-bold text-lg" x-text="selectedImage?.title"></h3>
                    <p class="text-gray-600 mt-2" x-text="selectedImage?.description"></p>
                    <div class="flex items-center gap-2 mt-4 text-gray-500">
                        <i class="fi fi-rr-calendar"></i>
                        <span x-text="selectedImage?.date"></span>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-landing-page.base>


