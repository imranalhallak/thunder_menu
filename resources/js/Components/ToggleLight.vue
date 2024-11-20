
  <template>
    <div>
        <select v-model="selectedLanguage" @change="changeLanguage" class="language-dropdown">
            <option value="en">En</option>
          <option value="ar">ع</option>
          <option value="tr">Tr</option>
        </select>

      <div class="text-center mb-10">
        <!-- Your existing content here -->
      </div>

    </div>
  </template>
  <script setup>
  import { getCurrentInstance, ref } from 'vue';

  // Access the global language variable
  const { appContext } = getCurrentInstance();
  const globalLanguage = appContext.config.globalProperties.$globalLanguage;

  // Define a local ref for the selected language
  const selectedLanguage = ref(globalLanguage.selectedLanguage);

  // Function to change the language
  const changeLanguage = () => {
    globalLanguage.selectedLanguage = selectedLanguage.value;
  };
  </script>


<style scoped>
.language-selector {
  display: flex;
  justify-content: center;
  align-items: center;
  margin: 20px;
}

select {
  padding: 10px;
  background-color: #a39268; /* SaddleBrown color */
  color: #FFF8DC; /* Cornsilk color for contrast */
  border: 1px solid #5E3610; /* Darker brown for border */
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
  appearance: none; /* Removes the default arrow in most browsers */
}

select:focus {
  outline: none;
  border-color: #a39268; /* A bit lighter brown when focused */
  box-shadow: 0px 0px 5px #D2691E;
}

/* Your existing styles here */
</style>
