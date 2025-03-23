export default () => ({
    categories: ['Academic Events', 'Campus Life', 'Sports', 'Arts & Culture'],
    selectedCategory: 'all',
    isModalOpen: false,
    selectedImage: null,
    loading: false,
    page: 1,
    hasMore: true,
    images: Array.from({ length: 8 }, (_, i) => ({
        id: i + 1,
        url: `https://source.unsplash.com/800x600/?school,education&sig=${i}`,
        title: `School Event ${i + 1}`,
        description: 'Capturing memorable moments from our school events and activities',
        date: 'March 2024',
        category: this.categories[Math.floor(Math.random() * this.categories.length)]
    })),

    get filteredImages() {
        return this.selectedCategory === 'all'
            ? this.images
            : this.images.filter(img => img.category === this.selectedCategory);
    },

    filterGallery(category) {
        this.selectedCategory = category;
    },

    openModal(image) {
        this.selectedImage = image;
        this.isModalOpen = true;
        document.body.style.overflow = 'hidden';
    },

    closeModal() {
        this.isModalOpen = false;
        document.body.style.overflow = 'auto';
    },

    async loadMore() {
        this.loading = true;
        await new Promise(resolve => setTimeout(resolve, 1000)); // Simulate API call

        const newImages = Array.from({ length: 4 }, (_, i) => ({
            id: this.images.length + i + 1,
            url: `https://source.unsplash.com/800x600/?school,education&sig=${this.images.length + i}`,
            title: `School Event ${this.images.length + i + 1}`,
            description: 'Capturing memorable moments from our school events and activities',
            date: 'March 2024',
            category: this.categories[Math.floor(Math.random() * this.categories.length)]
        }));

        this.images.push(...newImages);
        this.page++;
        this.hasMore = this.page < 3; // Limit to 3 pages for demo
        this.loading = false;
    }
});
