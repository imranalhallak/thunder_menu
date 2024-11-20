<template>
    <div class="p-4">
      <div class="bg-blue-100 p-2 flex justify-between items-center">
        <h1 class="font-bold">GALLERY IMAGES</h1>
        <div>
          <button class="text-blue-600 mr-2" @click="saveOrder">Save Image Order</button>
          <button class="text-blue-600" @click="uploadImages">Upload</button>
        </div>
      </div>
      <div class="gallery-container mt-4" @dragover.prevent @drop="handleDrop">
        <div
          v-for="(image, index) in images"
          :key="image.id"
          class="gallery-item"
          :class="{ dragging: draggingIndex === index }"
          draggable="true"
          @dragstart="handleDragStart(index)"
          @dragend="handleDragEnd"
          @dragenter="handleDragEnter(index)"
        >
          <img :src="image.src" :alt="'Image ' + (index + 1)" />
        </div>
      </div>
      <div class="fixed bottom-4 left-4">
        <i class="fas fa-camera text-3xl"></i>
      </div>
    </div>
  </template>

  <script setup>
  import { ref } from 'vue';

  const images = ref([
    { id: 1, src: 'https://storage.googleapis.com/a1aa/image/bw4c4ek3u50Gek6t98t81qrEJaOL0ahzbNMgOH26TMhe81bnA.jpg' },
    { id: 2, src: 'https://storage.googleapis.com/a1aa/image/g4e0s6qXR6SPTCBzpYQrOZGlbRCnawHRpzRshN7Au08Pf6tTA.jpg' },
    { id: 3, src: 'https://storage.googleapis.com/a1aa/image/fNvwPzc7AQwKISIW66eJi7ort6eri9R0bdUyOHgK0n9y81bnA.jpg' },
    { id: 4, src: 'https://storage.googleapis.com/a1aa/image/aHzkcTJl2f0UDKLN3NxUVyQC82wRGDj6ndsEqotUOxece1bnA.jpg' }
  ]);

  const draggingIndex = ref(null);

  const handleDragStart = (index) => {
    draggingIndex.value = index;
  };

  const handleDragEnd = () => {
    draggingIndex.value = null;
  };

  const handleDragEnter = (index) => {
    if (draggingIndex.value !== null && draggingIndex.value !== index) {
      const draggedItem = images.value[draggingIndex.value];
      images.value.splice(draggingIndex.value, 1);
      images.value.splice(index, 0, draggedItem);
      draggingIndex.value = index;
    }
  };

  const handleDrop = (event) => {
    const files = event.dataTransfer.files;
    for (let i = 0; i < files.length; i++) {
      const file = files[i];
      const reader = new FileReader();
      reader.onload = (e) => {
        images.value.push({ id: Date.now() + i, src: e.target.result });
      };
      reader.readAsDataURL(file);
    }
  };

  const saveOrder = () => {
    alert('Image order saved!');
  };

  const uploadImages = () => {
    alert('Upload functionality not implemented.');
  };
  </script>

  <style>
  .gallery-container {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
  }
  .gallery-item {
    width: 100px;
    height: 100px;
    overflow: hidden;
    position: relative;
  }
  .gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }
  .dragging {
    opacity: 0.5;
  }
  </style>
