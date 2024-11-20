<script setup>
import { ref, onMounted, getCurrentInstance } from 'vue';
import { usePage } from '@inertiajs/vue3';
import BackButton from "@/Components/BackButton.vue";
import { useI18n } from 'vue-i18n';
import { Swiper, SwiperSlide } from 'swiper/vue'; // Import Swiper and SwiperSlide components
import 'swiper/swiper-bundle.css'; // Import Swiper styles
import 'swiper/css';
import 'swiper/css/pagination';
import 'swiper/css/navigation';
import 'swiper/css/scrollbar';

// Access the global language variable
const { appContext } = getCurrentInstance();
const globalLanguage = appContext.config.globalProperties.$globalLanguage;
const { t } = useI18n();
const props = usePage().props;
// Reactive variable to track the selected language
const language = ref('en'); // Default language

// Load saved language from local storage on mount
onMounted(() => {
    document.documentElement.setAttribute('dir', globalLanguage.selectedLanguage === 'ar' ? 'rtl' : 'ltr');
});

// Define props
defineProps({
    product: {
        type: Object
    }
});

// Reactive product variable
const product = ref(props.product);

// Function to parse images
const parseImages = (imagesString) => {
    try {
        return JSON.parse(imagesString);
    } catch (error) {
        console.error("Error parsing images: ", error);
        return []; // Return an empty array if parsing fails
    }
};

// Get images array
const parsedImages = ref(parseImages(product.value.images));
</script>

<template>
    <div class="max-w-md mx-auto bg-white rounded-lg shadow-lg overflow-hidden mt-10">
        <div class="bg-white p-4 flex justify-between items-center">
            <span class="text-gray-700 font-semibold">
                {{ $t(product.category.name) }}
            </span>
        </div>

        <!-- Swiper Container -->
        <Swiper
            :slides-per-view="parsedImages.length === 1 ? 1 : 1.1"
            :pagination="{ clickable: true }"
            :space-between="parsedImages.length === 1 ? 0 : 10"
            class="mySwiper"
            style="max-width: 100%;"
        >
            <SwiperSlide v-for="(image, index) in parsedImages" :key="index">
                <img :src="`../${image}`" alt="Product Image" class="w-full h-auto object-cover" />
            </SwiperSlide>
        </Swiper>

        <div class="p-4">
            <div class="bg-brown-700 text-white p-2 rounded-lg flex justify-between items-center" style="background-color: brown;">
                <span>{{$t('Code')}}: {{ product.code }}</span>
            </div>
            <div class="text-center mt-4">
                <!-- Additional Product Details -->
                             <p v-if="product.notebook_size" class="text-gray-600 mt-2 animate-from-bottom">{{$t('Notebook Size')}}: {{ $t(product.notebook_size) }}</p>
                   <p v-if="product.cover_type" class="text-gray-600 mt-2 animate-from-bottom">{{$t('Cover Type')}}: {{ $t(product.cover_type) }}</p>
                <p v-if="product.paper_weight" class="text-gray-600 mt-2 animate-from-bottom">{{$t('Paper Weight')}}: {{ $t(product.paper_weight) }}</p>
                <p v-if="product.number_of_pages" class="text-gray-600 mt-2 animate-from-bottom">{{$t('Number of Pages')}}: {{ $t(product.number_of_pages) }}</p>
<p v-if="product.type_of_spiral" class="text-gray-600 mt-2 animate-from-bottom">{{ $t('Type of Spiral') }}: {{ $t(product.type_of_spiral) }}</p>
                <p v-if="product.notebook_ruling" class="text-gray-600 mt-2 animate-from-bottom">{{$t('Notebook Ruling')}}: {{ $t(product.notebook_ruling) }}</p>
            </div>
        </div>

        <div class="p-4 flex justify-end">
            <BackButton />
        </div>
    </div>
</template>

<style scoped>
/* Animation and Styling */
.animate-from-bottom {
    position: relative;
    opacity: 0;
    transform: translateY(100%);
    animation: slideUp 0.5s ease-out forwards;
}

@keyframes slideUp {
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
.mySwiper .swiper-pagination-bullet {
    background-color: #ff5733; /* Change this to your desired color */
}

.mySwiper .swiper-button-next,
.mySwiper .swiper-button-prev {
    color: #ff5733; /* Change this to your desired color */
}

body {
    font-family: 'Roboto', sans-serif;
    background-color: #f8f8f8;
}

.max-w-md {
    font-family: 'Cairo', sans-serif;
}

/* Other styling remains unchanged */
</style>
