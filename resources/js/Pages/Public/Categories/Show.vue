
<script setup>
import { ref, onMounted, getCurrentInstance, watch } from 'vue';
import Logo from "@/Components/Logo.vue";
import BackButton from "@/Components/BackButton.vue";
import { usePage,Link } from '@inertiajs/vue3'; // Ensure this is imported

// Access the global language variable
const { appContext } = getCurrentInstance();
const globalLanguage = appContext.config.globalProperties.$globalLanguage;
const props = usePage().props;
// const goToCategory = (id) => {
    onMounted(() => {
    const { appContext } = getCurrentInstance();


    document.documentElement.setAttribute('dir', globalLanguage.selectedLanguage === 'ar' ? 'rtl' : 'ltr');
});
const parseImages = (imagesString) => {
  try {
    return JSON.parse(imagesString);
  } catch (error) {
    console.error("Error parsing images: ", error);
    return []; // Return an empty array if parsing fails
  }
};

// Function to get the first image
const firstImage = (imagesString) => {
  const images = parseImages(imagesString);
  return images.length > 0 ? images[0] : null; // Return the first image or null if none exist
};
// Define the menu items array as a reactive reference
const menuItems = ref(props.category.data.categories || []); // Ensure it's a reactive reference
// Define a reactive array to track which items have animated in
const enteredItems = ref([]);

// Function to animate the menu items
const animateMenuItems = () => {
    enteredItems.value = []; // Reset the entered items before animation
    menuItems.value.forEach((item, index) => {
        setTimeout(() => {
            enteredItems.value.push(index);
        }, index * 50); // Adjust the delay for each item as needed
    });
};

watch(() => props.category.data.products, (newProducts) => {
    menuItems.value = newProducts; // Update menuItems
    animateMenuItems(); // Re-run animation when categories change
}, { immediate: true }); // This ensures that it updates on initial mount as well

// Automatically animate items when the component is mounted
onMounted(() => {
    animateMenuItems(); // Animate items on initial mount
});
</script>

<template>
<div>{{parseImages[0]}}</div>
    <div class="full-screen-container1">
      <title></title>
      <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
      <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet" />

      <div class="content-container1 max-w-lg mx-auto rounded-lg shadow-lg p-4">
        <div class="header1 flex justify-between items-center mb-4">
          <Logo class="w-52" />
          <h1 class="text-xl font-bold text-gray-700">
            {{ props.category.data.arabic_name }}
          </h1>
        </div>

        <!-- Scrollable grid container -->
        <div class="grid-container1 grid grid-cols-2 gap-2 overflow-y-auto">
            <Link
            v-for="(item, index) in menuItems"
            :key="index"
            :href="route('category.product', { category: props.category.data.id, product: item.id })"
            class="bg-white p-4 rounded-lg shadow"
            :class="['menu-item1', { 'enter': enteredItems.includes(index) }]"
            :style="{ transitionDuration: (index > 10 ? (0.3 + index * 0.2) : 0.3) + 's' }"
          >
            <img
              v-if="firstImage(item.images)"
              :src="firstImage(item.images)"
              :alt="firstImage(item.images)"
              class="w-full h-auto rounded"
            />
            <p class="mt-2 text-center text-gray-600">
              {{ item.code }}
            </p>
          </Link>
        <BackButton/>
        </div>
      </div>
    </div>
  </template>

  <style>
body1 {
    overflow-x: hidden;
  font-family: 'Roboto', sans-serif;
  background-color: #f8f8f8;
  margin: 0; /* Remove default margin for full-height effect */
}

.full-screen-container1 {
  display: flex;
  flex-direction: column;
  height: 100vh; /* Full height of the viewport */
}

.content-container1 {
  display: flex;
  flex-direction: column;
  height: 100%; /* Take up the full height of the container */
}

.header1 {
  flex-shrink: 0; /* Ensure the header1 stays at the top */
}

.grid-container1 {
  /*flex-grow: 1;  Take up remaining space in the container */


  /* Hide scrollbar */
  scrollbar-width: none; /* Firefox */
}
.grid-container1::-webkit-scrollbar {
  display: none; /* Chrome, Safari, and Edge */
}

.menu-item1 {
  background-color: #ffffff;
  color: #a39268;
  font-weight: 700;
  padding: 5px;
  margin: 5px 0;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  text-align: center;
  transform: translateX(50%);
  opacity: 0;
  transition: transform 0.3s ease, opacity 0.3s ease;
  cursor: pointer;
}

.menu-item1.enter {
  transform: translateX(0);
  opacity: 1;
}

.menu-item1:hover {
  transform: scale(1.05);
  box-shadow: 0 8px 12px rgba(0, 0, 0, 0.2);
  background-color: #f0e5d6;
}
</style>
