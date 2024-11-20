<template>
    <div v-if="!isLocaleSelected" class="language-selector">
      <h2>Select your language</h2>
      <select @change="changeLocale" v-model="selectedLocale">
        <option value="en">English</option>
        <option value="ar">عربي</option>
        <option value="tr">TR</option>
      </select>
    </div>
  </template>

  <script setup>
  import { ref, watch } from 'vue'
  import { useI18n } from 'vue-i18n'

  const { locale } = useI18n()
  const selectedLocale = ref(locale.value)
  const isLocaleSelected = localStorage.getItem('locale') !== null

  const changeLocale = (event) => {
    const newLocale = event.target.value
    locale.value = newLocale
    localStorage.setItem('locale', newLocale) // Save to local storage
  }
  </script>

  <style scoped>
  .language-selector {
    position: fixed;
    top: 20px;
    right: 20px;
    background: white;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    z-index: 1000;
  }
  </style>
