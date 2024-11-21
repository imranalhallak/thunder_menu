<script setup>
import InputError from '@/Components/InputError.vue';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";

// Assuming `branch` is passed as a prop to prefill the form for editing
const props = defineProps({
    branch: {
        type: Object, // The branch object to prefill the form
        required: true,
    },
    auth: {
        type: Object,
    }
});

const form = useForm({
    branch_id: props.branch?.id || "",
    name: props.branch?.name || "",
    slogan: props.branch?.slogan || "",
    phone: props.branch?.phone || "",
    address1: props.branch?.address1 || "",
    address2: props.branch?.address2 || "",
    location: props.branch?.location || "",
    slug: props.branch?.slug || "",
    mode: props.branch?.mode || "light",
    facebook: props.branch?.facebook || "",
    instagram: props.branch?.instagram || "",
    whatsapp: props.branch?.whatsapp || "",
    logo: props.branch?.logo || null,
    image: props.branch?.image || null,
});

// Function to handle form submission (create or update)
const submitBranch = () => {
        form.post(route("branches.update", {id:props.branch.id})); // Use a specific update route for editing

};

const handleLogoUpload = (event) => {
    const file = event.target.files[0];
    form.logo = file; // This binds the file to the form's image field
};

const handleImageUpload = (event) => {
    const file = event.target.files[0];
    form.image = file; // This binds the file to the form's image field
};
</script>

<template>

    <Head title="Edit Branch" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">Edit Branch</h2>
        </template>

        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                            <div>
                                <h3 class="text-lg leading-6 font-medium text-gray-900">Edit Branch</h3>
                                <p class="mt-1 text-sm text-gray-500">Modify the information below to update the branch.
                                </p>
                            </div>

                            <form @submit.prevent="submitBranch">
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


                                    <!-- Logo Upload -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="logo" class="block text-sm font-medium text-gray-700">Logo</label>
                                        <input type="file" id="logo" accept="image/*" @change="handleLogoUpload"
                                            class="mt-1 block w-full text-sm text-gray-500 file:py-2 file:px-4 file:border file:border-gray-300 file:rounded-md file:text-sm file:bg-gray-50 file:text-gray-700 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500" />
                                        <InputError :message="form.errors.logo" class="mt-2" />
                                    </div>

                                    <!-- Image Upload -->
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
