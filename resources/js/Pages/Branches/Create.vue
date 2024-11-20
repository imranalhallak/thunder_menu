<script setup>
import InputError from "@/Components/InputError.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
// import axios from "axios";
import { watch, ref } from "vue";

defineProps({
  categories: {
    type: Object,
    required: true,
  },
});

let sections = ref({});

const form = useForm({
  arabic_name: "",
  english_name: "",
  turkish_name: "",
  arabic_description:"",
  turkish_description:"",
  english_description:"",
  price :'',
  code:'',
  category_id:"",
  image: null,
});
const handleImageUpload = (event) => {
  const file = event.target.files[0];
  form.image = file; // This binds the file to the form's image field
};

// watch(
//     () => form.class_id,
//     (newValue) => {
//         getSections(newValue);
//     }
// );

// const getSections = (classId) => {
//     axios.get("/api/sections?class_id=" + classId).then((response) => {
//         sections.value = response.data;
//     });
// };

const createCategory = () => {
  form.post(route("categories.store"));
};
</script>

<template>
  <Head title="Create Student" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Student</h2>
    </template>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
      <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
        <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
            <div>asdasd</div>
          aa  {{ categories }}
          <form @submit.prevent="createCategory">
            <div class="shadow sm:rounded-md sm:overflow-hidden">
              <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                <div>
                  <h3 class="text-lg leading-6 font-medium text-gray-900">
                    Student Information
                  </h3>
                  <p class="mt-1 text-sm text-gray-500">
                    Use this form to create a new student.
                  </p>
                </div>

                <div class="grid grid-cols-6 gap-6">
                  <div class="col-span-6 sm:col-span-3">
                    <label
                      for="arabic_name"
                      class="block text-sm font-medium text-gray-700"
                      >Arabic Name</label
                    >
                    <input
                      v-model="form.arabic_name"
                      type="text"
                      id="name"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      :class="{
                        'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300':
                          form.errors.arabic_name,
                      }"
                    />
                    <InputError :message="form.errors.arabic_name" class="mt-2" />
                  </div>
                  <div class="col-span-6 sm:col-span-3">
                    <label
                      for="english_name"
                      class="block text-sm font-medium text-gray-700"
                      >English Name</label
                    >
                    <input
                      v-model="form.english_name"
                      type="text"
                      id="name"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      :class="{
                        'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300':
                          form.errors.english_name,
                      }"
                    />
                    <InputError :message="form.errors.english_name" class="mt-2" />
                  </div>
                  <div class="col-span-6 sm:col-span-3">
                    <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                    <select
                      v-model="category_id"
                      id="category"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      :class="{
                        'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.category_id,
                      }"
                    >
                      <option disabled value="">Select a category</option>
                      <option v-for="category in categories" :key="category.id" :value="category.id">
                        {{ category.arabic_name }}
                      </option>
                    </select>
                  </div>
                  <div class="col-span-6 sm:col-span-3">
                    <label
                      for="branch_id"
                      class="block text-sm font-medium text-gray-700"
                      >Branch</label
                    >
                    <input
                      v-model="form.branch_id"

                      type="text"
                      value="1"
                      id="branch_id"
                      class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                      :class="{
                        'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300':
                          form.errors.branch_id,
                      }"
                      disabled
                    />
                    <InputError :message="form.errors.branch_id" class="mt-2" />
                  </div>

                  <div>
                    <label for="image">Image</label>
                    <input type="file" @change="handleImageUpload" id="image" />
                    <span v-if="form.errors.image">{{ form.errors.image }}</span>
                  </div>
                </div>
              </div>
              <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                <a
                  href="#"
                  class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4"
                >
                  Cancel
                </a>
                <button
                  type="submit"
                  class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                  Save
                </button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
