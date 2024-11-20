<script setup>
import InputError from '@/Components/InputError.vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import BranchSetter from "@/Pages/Branches/BranchSetter.vue";
import {Link, Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue"; // Import 'ref' to handle reactivity
import 'vue-advanced-cropper/dist/style.css';

const form = useForm({
    branch_id: "",
    name: "",
    slogan: "",
    phone: "",
    address1: "",
    address2: "",
    location: "",
    slug: "",
    mode: "light",
    facebook: "",
    instagram: "",
    whatsapp: "",
    logo: null,
    image: null,
});

const props = defineProps({
    branches: {
        type: Array, // Changed to Array since branches are usually a list
        required: true,

    },
    auth: {
        type: Object,
    }
});
const defaultBranchId = props.auth?.user?.default_branch?.id;
const imageSrc = ref(null);
const createBranch = () => {
    form.post(route("branches.store"));
};

const handleLogoUpload = (event) => {
    const file = event.target.files[0];
    form.logo = file; // This binds the file to the form's image field
};

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = (e) => {
            form.image = e.target.result; // Set the uploaded image as the source for the form
        };
        reader.readAsDataURL(file);
    }
};




</script>

<template>

    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Dashboard</h2>
        </template>


        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                            <div>
                                <h1>Select a Branch</h1>

                                <!-- Display a list of branches with buttons -->
                                <div class="flex flex-wrap gap-2">
                                    <Link
                                      v-for="branch in branches"
                                      :key="branch.id"
                                      :href=" route(defaultBranchId === branch.id?'branches.edit':'set-branch', { id: branch.id })"
                                      :class="{
                                        'bg-blue-500 text-white': defaultBranchId === branch.id,
                                        'bg-gray-200': defaultBranchId !== branch.id
                                      }"
                                      class="px-4 py-2 rounded-md border border-gray-300 transition duration-150 ease-in-out"
                                    >
                                      {{ branch.name }}
                                    </Link>
                                  </div>

                                <!-- Display the currently selected branch -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Create Branch</h3>
                                <p class="mt-1 text-sm text-gray-500">Fill out the information below to create a new
                                    branch.</p>
                            </div>

                            <form @submit.prevent="createBranch">
                                <div class="grid grid-cols-6 gap-6">
                                    <!-- Name -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                        <input v-model="form.name" type="text" id="name"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{ 'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.name }" />
                                        <InputError :message="form.errors.name" class="mt-2" />
                                    </div>

                                    <!-- Slogan -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="slogan"
                                            class="block text-sm font-medium text-gray-700">Slogan</label>
                                        <input v-model="form.slogan" type="text" id="slogan"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{ 'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.slogan }" />
                                        <InputError :message="form.errors.slogan" class="mt-2" />
                                    </div>

                                    <!-- Phone -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
                                        <input v-model="form.phone" type="text" id="phone"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{ 'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.phone }" />
                                        <InputError :message="form.errors.phone" class="mt-2" />
                                    </div>
                                    <!-- Location -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="location"
                                            class="block text-sm font-medium text-gray-700">Location</label>
                                        <input v-model="form.location" type="text" id="location"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{ 'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.location }" />
                                        <InputError :message="form.errors.location" class="mt-2" />
                                    </div>
                                    <!-- Address 1 -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="address1" class="block text-sm font-medium text-gray-700">Address
                                            Line
                                            1</label>
                                        <input v-model="form.address1" type="text" id="address1"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{ 'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.address1 }" />
                                        <InputError :message="form.errors.address1" class="mt-2" />
                                    </div>

                                    <!-- Address 2 -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="address2" class="block text-sm font-medium text-gray-700">Address
                                            Line
                                            2</label>
                                        <input v-model="form.address2" type="text" id="address2"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{ 'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.address2 }" />
                                        <InputError :message="form.errors.address2" class="mt-2" />
                                    </div>


                                    <!-- Facebook -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="facebook"
                                            class="block text-sm font-medium text-gray-700">Facebook</label>
                                        <input v-model="form.facebook" type="text" id="facebook"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{ 'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.facebook }" />
                                        <InputError :message="form.errors.facebook" class="mt-2" />
                                    </div>

                                    <!-- Instagram -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="instagram"
                                            class="block text-sm font-medium text-gray-700">Instagram</label>
                                        <input v-model="form.instagram" type="text" id="instagram"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{ 'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.instagram }" />
                                        <InputError :message="form.errors.instagram" class="mt-2" />
                                    </div>

                                    <!-- WhatsApp -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="whatsapp"
                                            class="block text-sm font-medium text-gray-700">WhatsApp</label>
                                        <input v-model="form.whatsapp" type="text" id="whatsapp"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{ 'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300': form.errors.whatsapp }" />
                                        <InputError :message="form.errors.whatsapp" class="mt-2" />
                                    </div>

                                    <!-- Mode -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="mode" class="block text-sm font-medium text-gray-700">Mode</label>
                                        <select v-model="form.mode" id="mode"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                            <option value="light">Light</option>
                                            <option value="dark">Dark</option>
                                        </select>
                                    </div>

                                    <!-- Logo -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="logo" class="block text-sm font-medium text-gray-700">Logo</label>
                                        <input type="file" id="logo" accept="image/*" @change="handleLogoUpload"
                                            class="mt-1 block w-full text-sm text-gray-500 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded-md file:text-sm file:bg-gray-50 file:text-gray-700 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
                                        <InputError :message="form.errors.logo" class="mt-2" />
                                    </div>

                                    <!-- Image -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                                        <input type="file" id="image" accept="image/*" @change="handleImageUpload"
                                            class="mt-1 block w-full text-sm text-gray-500 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded-md file:text-sm file:bg-gray-50 file:text-gray-700 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
                                        <InputError :message="form.errors.image" class="mt-2" />
                                    </div>

                                </div>



                                <div class="flex justify-end pt-6">
                                    <button type="submit"
                                        class="inline-flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                        Save Branch
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
