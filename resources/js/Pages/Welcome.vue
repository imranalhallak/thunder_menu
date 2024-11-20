<script setup>
// Imports
import { ref, onMounted, watch, getCurrentInstance } from 'vue';
import { usePage, Link } from '@inertiajs/vue3';
import { useI18n } from 'vue-i18n';
import ToggleLight from "@/Components/ToggleLight.vue";
import Logo from "@/Components/Logo.vue";

// Language and translation
const { t } = useI18n();
const props = usePage().props;

// Reactive variable for language selection
const language = ref('en');

// Get global language setting
const { appContext } = getCurrentInstance();
const globalLanguage = appContext.config.globalProperties.$globalLanguage;

// Set page direction based on language selection
const setDirection = (lang) => {
    document.documentElement.setAttribute('dir', lang === 'ar' ? 'rtl' : 'ltr');
};
const showImage = ref(false);

// Load saved language and set direction on mount
onMounted(() => {
    setDirection(globalLanguage.selectedLanguage);
    // Set a timeout to display the image after 2 seconds
    setTimeout(() => {
        showImage.value = true;
    }, 2000);
});

// Watch for language changes to update page direction
watch(
    () => globalLanguage.selectedLanguage,
    (newLanguage) => {
        setDirection(newLanguage);
    }
);

// Menu items and animations
const menuItems = ref(props.$menus.data.menus);
const enteredItems = ref([]);

const animateMenuItems = () => {
    enteredItems.value = [];
    menuItems.value.forEach((item, index) => {
        setTimeout(() => {
            enteredItems.value.push(index);
        }, index * 50);
    });
};

// Update menu items and animate them immediately
watch(() => props.$menus.data, (newMenus) => {
    menuItems.value = newMenus;
    animateMenuItems();
}, { immediate: true });

onMounted(() => {
    animateMenuItems();
});
</script>

<template>
    <div>
        <!-- Toggle Light Mode Button -->
        <ToggleLight style="position: fixed; direction: rtl; text-align: right;" />

        <!-- Load External Fonts and Icons -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

        <!-- Logo Component -->
        <div class="logo-container">
            <Logo class="w-52 m-auto my-container" />
        </div>

        <!-- Main Content and Menu Items -->
        <div class="text-center mb-10">
            <div class="centered-div" style="width:100vw;">
                <div class="col col-md-6">
                    <Link
                        v-for="(item, index) in menuItems"
                        :key="index"
                        :class="['w-full h-auto menu-item2', { 'enter': enteredItems.includes(index) }]"
                        :href="route('menu', { menu: item.id })"
                        :style="{ transitionDuration: (0.3 + index * 0.2) + 's' }"
                    >
                        <div style="display: flex; align-items: center; justify-content: space-between; padding: 0 16px;">
                            <!-- SVG Icon with Color -->
                            <img :src="item.svg" class="svg-icon" />

                            <!-- Centered Item Name -->
                            <span style="flex: 1; text-align: center;">{{ $t(item.name) }}</span>
                        </div>
                    </Link>

                    <!-- Additional Links -->
                    <Link :href="route('about')">
                        <div class="container w-40 menu-item" style="font-size: 20px;">{{ $t('About Us') }}</div>
                    </Link>

                    <!-- Embedded Video -->
                    <div class="video-container">
                        <div class="responsive-video-container">
                            <iframe
                                src="https://www.youtube.com/embed/mDibbOjcg_k?si=ykZr9Pt-JLvPis2C"
                                title="YouTube video player"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>

                    <div class="social-media-icons">
                        <a href="tel:+905077911764" target="_blank" rel="noopener noreferrer">
                            <i class="fa fa-phone"></i>
                        </a>
                        <a href="https://wa.me/905077911764" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-whatsapp"></i>
                        </a>
                        <a href="https://www.facebook.com/profile.php?id=61564511385301&mibextid=ZbWKwL" target="_blank" rel="noopener noreferrer">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://www.torkyaprak.com/" target="_blank" rel="noopener noreferrer">
                            <i class="fa fa-globe"></i>
                        </a>
                        <a href="https://www.google.com/maps?q=36.8369331359863,34.7048149108887" target="_blank" rel="noopener noreferrer">
                            <i class="fa fa-map-marker-alt"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
/* Updated styles remain the same */
</style>
