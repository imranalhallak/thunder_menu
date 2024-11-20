<template>
    <div>
      <!-- Fixed Back Button -->
      <button @click="goBack" class="fixed-back-button">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-arrow-left-short" viewBox="0 0 16 16">
            <path fill-rule="evenodd" d="M12 8a.5.5 0 0 1-.5.5H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5a.5.5 0 0 1 .5.5"/>
          </svg>      </button>

      <!-- Your existing content -->

    </div>
  </template>
  <script setup>
  function goBack() {
    window.history.back();
  }
  </script>
<style>
.fixed-back-button {
  position: fixed;
  bottom: 20px; /* Adjust based on your layout */
  left: 20px; /* Adjust based on your layout */
  padding: 10px 15px;
  color: brown;
  border: none;
  border-radius: 100px;
  font-size: 20px;
  cursor: pointer;
  z-index: 1000; /* Ensure it stays above other elements */
  transition: background-color 0.3s;
}

.fixed-back-button:hover {
  background-color: rgb(227, 83, 83); /* Darken color on hover */
  color: white;
}
</style>
