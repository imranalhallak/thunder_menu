<script setup>
import InputError from "@/Components/InputError.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, usePage, } from "@inertiajs/vue3";
import { ref, computed, onMounted } from "vue";
import { VueDraggable } from 'vue-draggable-plus';


const meal = usePage().props.meal;
const menus = usePage().props.menus;

// Parse the images string into an array
const mealImages = computed(() => {
  try {
    return JSON.parse(meal.images || '[]');
  } catch (e) {
    return [];
  }
});

const mealImages1 = ref([]); // Initialize mealImages1 as an empty ref

// Populate mealImages1 on mount
onMounted(() => {
  mealImages1.value = [...mealImages.value]; // Assign computed value to ref as an array copy
});

// Populate form with existing meal data
const form = useForm({
  price_1: meal.price_1 ||"",
  price_2: meal.price_2 || "",
  menu_id: meal.menu_id || "",
  images: [], // New images for upload
  price_3: meal.price_3 || "",
  arabic_name: meal.arabic_name || "",
  english_name: meal.english_name || "",
  turkish_name: meal.turkish_name || "",
  arabic_desicription: meal.arabic_desicription || "",
  turkish_desicription: meal.turkish_desicription || "",
  english_desicription: meal.english_desicription || ""
});
const imagesInput = ref(null);

// Handle file input changes
const handleFileChange = async (event) => {
  form.images = Array.from(event.target.files); // Store all selected files

  // Submit the form and wait for the response
  await form.post(route("meals.update", { id: meal.id,

    preserveScroll: true,
            preserveState: true,

            replace: true,
   }), {
    onSuccess: () => {
      if (imagesInput.value) {
        imagesInput.value.value = ''; // Reset the file input value
      }
    }
  });
};

// Update meal
const updateMeal = async () => {
  const formData = new FormData();

  // Append form data fields
  Object.keys(form).forEach((key) => {
    formData.append(key, form[key]);
  });

  // Append images
  form.images.forEach((file) => {
    formData.append("images[]", file);
  });

  // Send the form data
  await form.post(route("meals.update", { id: meal.id ,
    preserveScroll: true,
            preserveState: true,

            replace: true,
  }), {

    forceFormData: true, // Ensure FormData is used for the request
    onSuccess: () => {
      // Reload the page or update the images after successful upload
      mealImages1.value = [...form.images];
    }

  });

};

// Dynamic input class based on error presence
const inputClass = (error) => {
  return {
    'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': error,
    'border-gray-300': !error
  };
};

const deletedImages = ref([]); // Track images marked for deletion

const deleteImage = (index) => {
  const image = mealImages1.value[index];
  if (image) {
    // Add the image to the deletion list for backend processing
    deletedImages.value.push(image);

    // Remove the image from the displayed array
    mealImages1.value.splice(index, 1);

    // Update form.images with the current list of meal images after deletion
    form.images = [...mealImages1.value];
    form.post(route("meals.delete-image", { id: meal.id }));
  }
};

// Handle reorder event
const handleReorder = async () => {



    // Update form images with the reordered list
    form.images = [...mealImages1.value];

    // Submit the form
    await form.post(route("meals.order-image", {
      id: meal.id,
    }), {
      preserveScroll: true, // Ensure Inertia does not trigger scroll
      preserveState: true,
      replace: true,
    });

};

</script>

<template>
  <Head title="Edit Meal" />

  <AuthenticatedLayout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
            <form @submit.prevent="updateMeal">
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Meal</h3>
                        <div class="grid grid-cols-6 gap-6">
                            <!-- Price Fields -->
                            <div v-for="n in 3" :key="'price_' + n" class="col-span-6 sm:col-span-2">
                                <label :for="'price_' + n" class="block text-sm font-medium text-gray-700">Price {{ n }}</label>
                                <input
                                    v-model="form[`price_${n}`]"
                                    :id="'price_' + n"
                                    type="number"
                                    step="0.5"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                />
                                <InputError :message="form.errors[`price_${n}`]" class="mt-2" />
                            </div>

                            <!-- Name Fields -->
                            <div v-for="lang in ['arabic', 'english', 'turkish']" :key="'name_' + lang" class="col-span-6">
                                <label :for="'name_' + lang" class="block text-sm font-medium text-gray-700">
                                    Name ({{ lang.charAt(0).toUpperCase() + lang.slice(1) }})
                                </label>
                                <input
                                    v-model="form[`${lang}_name`]"
                                    :id="'name_' + lang"
                                    type="text"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                />
                                <InputError :message="form.errors[`${lang}_name`]" class="mt-2" />
                            </div>

                            <!-- Description Fields -->
                            <div v-for="lang in ['arabic', 'english', 'turkish']" :key="'description_' + lang" class="col-span-6">
                                <label :for="'description_' + lang" class="block text-sm font-medium text-gray-700">
                                    Description ({{ lang.charAt(0).toUpperCase() + lang.slice(1) }})
                                </label>
                                <textarea
                                    v-model="form[`${lang}_description`]"
                                    :id="'description_' + lang"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                ></textarea>
                                <InputError :message="form.errors[`${lang}_description`]" class="mt-2" />
                            </div>

                            <!-- Menu Selection -->
                            <div class="col-span-6">
                                <label for="menu_id" class="block text-sm font-medium text-gray-700">Menu</label>
                                <select
                                    v-model="form.menu_id"
                                    id="menu_id"
                                    class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                >
                                    <option disabled value="">Select a menu</option>
                                    <option v-for="menu in menus" :key="menu.id" :value="menu.id">{{ menu.name }}</option>
                                </select>
                                <InputError :message="form.errors.menu_id" class="mt-2" />
                            </div>

                            <!-- Images -->
                            <div class="col-span-6 sm:col-span-3">
                                <h1>Meal Images</h1>
                                <div v-if="mealImages1.length" class="flex flex-wrap gap-4 mb-4">
                                    <VueDraggable v-model="mealImages1" @end="handleReorder" class="flex gap-2 overflow-x-auto">
                                        <div
                                          v-for="(image, index) in mealImages1"
                                          :key="index"
                                          class=" relative w-16 h-24 border rounded overflow-hidden flex-shrink-0"
                                        >
                                          <img class="" :src="`../../../${image}`" alt="Meal Image" />
                                          <div
                                            @click="deleteImage(index)"
                                            class="w absolute top-1 right-1  bg-red-600 hover:bg-red-700 text-white rounded-full w-6 h-6 flex items-center justify-center"
                                            aria-label="Delete image"
                                          >
                                            &times;
                                          </div>
                                        </div>
                                      </VueDraggable>
                                </div>
                                <div v-else>
                                  <p>No images available</p>
                                </div>
                                <label for="images" class="block text-sm font-medium text-gray-700 mt-4">Images</label>
                                <input
                                type="file"
                                id="images"
                                multiple
                                @change="handleFileChange"
                                class="mt-2"
                                ref="imagesInput"
                              />
                                <InputError :message="form.errors.images" class="mt-2" />
                              </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                        <button
                            type="submit"
                            class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:ring-indigo-500"
                        >
                            Update Meal
                        </button>
                    </div>
                </div>
            </form>

        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
