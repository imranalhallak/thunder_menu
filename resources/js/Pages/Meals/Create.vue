<script setup>
import InputError from "@/Components/InputError.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
    menus: {
        type: Object,
        required: true,
    },
});

const form = useForm({
    price_1: "",
    price_2: "",
    price_3: "",
    arabic_name: "",
    english_name: "",
    turkish_name: "",
    arabic_description: "",
    english_description: "",
    turkish_description: "",
    images: [], // For multiple image files
    menu_id: "", // Related menu
});

const handleFileChange = (event) => {
    form.images = Array.from(event.target.files); // Store all selected files
};

const createMeal = () => {
    form.post(route("meals.store"));
};
</script>

<template>
    <Head title="Create Meal" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Create Meal</h2>
        </template>
        <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <form @submit.prevent="createMeal">
                <div class="shadow sm:rounded-md sm:overflow-hidden">
                    <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Meal Information</h3>
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
                            <div class="col-span-6">
                                <label for="images" class="block text-sm font-medium text-gray-700">Images</label>
                                <input type="file" multiple @change="handleFileChange" accept="image/*" class="mt-2" />
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
                            Create Meal
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
