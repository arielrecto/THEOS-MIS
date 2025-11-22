export default () => ({
    // categories: ['School Events', 'Academic Events', 'Campus Life', 'Activities'],
    categories: [],
    selectedCategory: '',
    isModalOpen: false,
    selectedImage: null,
    loading: false,
    page: 1,
    hasMore: false,
    images: [],

    init() {
        // Get images from server-side data
        this.images = window.galleries || [];
        this.hasMore = this.images.length >= 12; // Show load more if more than 12 images
    },

    get filteredImages() {
        return this.selectedCategory === ''
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
        this.selectedImage = null;
        document.body.style.overflow = 'auto';
    },

    async loadMore() {
        this.loading = true;
        try {
            const response = await fetch(`/gallery/load-more?page=${this.page + 1}`);
            const data = await response.json();

            if (data.images.length) {
                this.images.push(...data.images);
                this.page++;
                this.hasMore = data.hasMore;
            } else {
                this.hasMore = false;
            }
        } catch (error) {
            console.error('Error loading more images:', error);
        } finally {
            this.loading = false;
        }
    }
});
