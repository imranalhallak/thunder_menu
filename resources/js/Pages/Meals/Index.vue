<template>

    <Head title="Meals List" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Meals List</h2> <!-- Change the title -->
        </template>
        <div class="bg-gray-100 py-10">
            <div class="mx-auto max-w-7xl">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold text-gray-900">Meals</h1> <!-- Change Products to Meals -->
                            <p class="mt-2 text-sm text-gray-700">A list of all the Meals.</p>
                            <!-- Change Products to Meals -->
                        </div>

                        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                            <Link :href="route('meals.create')"
                                class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto">
                            Add Meal <!-- Change Add Product to Add Meal -->
                            </Link>
                        </div>
                    </div>

                    <div class="flex flex-col justify-start sm:flex-row mt-6">
                        <div class="relative text-sm text-gray-800 col-span-3">
                            <div
                                class="absolute pl-2 left-0 top-0 bottom-0 flex items-center pointer-events-none text-gray-500">
                                <MagnifyingGlass />
                            </div>

                            <input v-model="search" type="text" autocomplete="off" placeholder="Search meals data..."
                                class="block rounded-lg border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        </div>
                    </div>
                    <div class="mt-8 flex flex-col">
                        <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                                <div
                                    class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg relative">
                                    <table class="min-w-full divide-y divide-gray-300">
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">
                                                    ID
                                                </th>

                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Menu <!-- Change Category to Menu -->
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Type of Spiral
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Code
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Price
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Image
                                                </th>
                                                <th scope="col"
                                                    class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                                                    Created At
                                                </th>
                                                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6" />
                                            </tr>
                                        </thead>
                                        <tbody v-if="meals && meals.data.length"
                                            class="divide-y divide-gray-200 bg-white">
                                            <tr v-for="meal in meals.data" :key="meal.id">
                                                <!-- Change product to meal -->
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                                    {{ meal.id }} <!-- Change product to meal -->
                                                </td>

                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ meal.menu.arabic_name }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ meal.english_name }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ meal.price_1 }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ meal.price2 }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ meal.price3 }}
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    <img v-if="firstImage(meal.images)" :src="firstImage(meal.images)"
                                                        :alt="firstImage(meal.images)" class="w-full h-10 rounded " />
                                                </td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    {{ meal.created_at }} <!-- Change product to meal -->
                                                </td>


                                                <td
                                                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                                    <Link :href="route('meals.edit', meal.id)"
                                                        class="text-indigo-600 hover:text-indigo-900">
                                                    Edit
                                                    </Link>
                                                    <button @click="deleteMeal(meal.id)"
                                                        class="ml-2 text-indigo-600 hover:text-indigo-900">
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="8" class="text-center text-gray-500">No meals available.
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <Pagination :data="meals" :updatedPageNumber="updatedPageNumber" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import MagnifyingGlass from "@/Components/Icons/MagnifyingGlass.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import { Link, Head, useForm, router, usePage } from "@inertiajs/vue3";
import { ref, computed, watch } from "vue";

defineProps({
    meals: {
        type: Object,
        required: true,
    },
});

let search = ref(usePage().props.search),
    class_id = ref(usePage().props.class_id ?? ""),
    pageNumber = ref(1);

let mealsUrl = computed(() => {
    let url = new URL(route("meals.index"));
    url.searchParams.append("page", pageNumber.value);

    if (search.value) {
        url.searchParams.append("search", search.value);
    }

    if (class_id.value) {
        url.searchParams.append("class_id", class_id.value);
    }

    return url;
});

const updatedPageNumber = (link) => {
    pageNumber.value = link.url.split("=")[1];
};

watch(
    () => mealsUrl.value,
    (updatedMealsUrl) => {
        router.visit(updatedMealsUrl, {
            preserveScroll: true,
            preserveState: true,
            replace: true,
        });
    }
);

watch(
    () => search.value,
    (value) => {
        if (value) {
            pageNumber.value = 1;
        }
    }
);
const parseImages = (imagesString) => {
    try {
        return JSON.parse(imagesString);
    } catch (error) {
        return []; // Return an empty array if parsing fails
    }
};
const firstImage = (imagesString) => {
    const images = parseImages(imagesString);
    return images.length > 0 ? `../${images[0]}` : null; // Return the first image's path or null if none exist
};
const deletForm = useForm({});

const deleteMeal = (mealId) => {
    if (confirm("Are you sure you want to delete this meal?")) {
        deletForm.post(route("meals.destroy", mealId), {
            preserveScroll: true,
        });
    }
};
</script>
