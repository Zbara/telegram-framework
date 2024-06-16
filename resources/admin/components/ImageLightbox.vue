<template>
    <div>
        <button @click="openLightbox">Открыть Lightbox</button>
        <div v-if="lightboxOpen" class="lightbox-overlay" @click="closeLightbox">
            <img :src="imageUrl" :alt="imageAlt" class="lightbox-image" />
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            lightboxOpen: false,
            imageUrl: "url_вашей_фотографии.jpg",
            imageAlt: "Описание фотографии",
        };
    },
    methods: {
        openLightbox() {
            this.lightboxOpen = true;
        },
        closeLightbox() {
            this.lightboxOpen = false;
        },
    },
};
</script>

<style scoped>
.lightbox-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
}

.lightbox-image {
    max-width: 90%;
    max-height: 90%;
}
</style>
