<script setup>
import MagnifyingGlass from "@/Components/Icons/MagnifyingGlass.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";
import { Link, Head, useForm, router, usePage } from "@inertiajs/vue3";
import { ref, computed, watch } from "vue";

defineProps({
  products: {
    type: Object,
    required: true,
  },
});

// const page = usePage();

// let search = ref(usePage().props.search),
//     class_id = ref(usePage().props.class_id ?? ""),
//     pageNumber = ref(1);

// let studentsUrl = computed(() => {
//     let url = new URL(route("students.index"));
//     url.searchParams.append("page", pageNumber.value);

//     if (search.value) {
//         url.searchParams.append("search", search.value);
//     }

//     if (class_id.value) {
//         url.searchParams.append("class_id", class_id.value);
//     }

//     return url;
// });

// const updatedPageNumber = (link) => {
//     pageNumber.value = link.url.split("=")[1];
// };

// watch(
//     () => studentsUrl.value,
//     (updatedStudentsUrl) => {
//         router.visit(updatedStudentsUrl, {
//             preserveScroll: true,
//             preserveState: true,
//             replace: true,
//         });
//     }
// );

// watch(
//     () => search.value,
//     (value) => {
//         if (value) {
//             pageNumber.value = 1;
//         }
//     }
// );

const deletForm = useForm({});

const deleteProduct = (productId) => {
  if (confirm("Are you sure you want to delete this product?")) {
    deletForm.delete(route("products.destroy", productId));
  }
};

</script>

<template>
  <Head title="Products List" />

  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">Products List</h2>
    </template>
    <div class="bg-gray-100 py-10">
      <div class="mx-auto max-w-7xl">
        <div class="px-4 sm:px-6 lg:px-8">
          <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
              <h1 class="text-xl font-semibold text-gray-900">Products</h1>
              <p class="mt-2 text-sm text-gray-700">A list of all the Products.</p>
            </div>

            <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
              <Link
                :href="route('products.create')"
                class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
              >
                Add Product
              </Link>
            </div>
          </div>

          <div class="flex flex-col justify-start sm:flex-row mt-6">
            <div class="relative text-sm text-gray-800 col-span-3">
              <div
                class="absolute pl-2 left-0 top-0 bottom-0 flex items-center pointer-events-none text-gray-500"
              >
                <MagnifyingGlass />
              </div>

              <!-- <input
                                v-model="search"
                                type="text"
                                autocomplete="off"
                                placeholder="Search students data..."
                                id="search"
                                class="block rounded-lg border-0 py-2 pl-10 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                            /> -->
            </div>
            <!-- <select
                            v-model="class_id"
                            class="block rounded-lg border-0 py-2 ml-5 text-gray-900 ring-1 ring-inset ring-gray-200 placeholder:text-gray-400 sm:text-sm sm:leading-6"
                        >
                            <option value="">Filter By Class</option>
                            <option
                                :value="item.id"
                                :key="item.id"
                                v-for="item in classes.data"
                            >
                                {{ item.name }}
                            </option>
                        </select> -->
          </div>
          <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
              <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div
                  class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg relative"
                >
                  <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                      <tr>
                        <th
                          scope="col"
                          class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                        >
                          ID
                        </th>
                        <th
                          scope="col"
                          class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                        >
                          Arabic Name
                        </th>
                        <th
                          scope="col"
                          class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                        >
                          English Name
                        </th>
                        <th
                          scope="col"
                          class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        >
                          Turkish Name
                        </th>
                        <th
                          scope="col"
                          class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        >
                          Price
                        </th>
                        <th
                          scope="col"
                          class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        >
                          Image
                        </th>
                        <th
                          scope="col"
                          class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900"
                        >
                          Created At
                        </th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6" />
                      </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                      <tr v-for="product in products.data" :key="product.id">
                        <td
                          class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                        >
                          {{ product.id }}
                        </td>
                        <td
                          class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                        >
                          {{ product.arabic_name }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          {{ product.turkish_name }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          {{ product.english_name }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          {{ product.price }}
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          <img :src="`../${product.image}`" width="100" />
                        </td>
                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                          {{ product.created_at }}
                        </td>

                        <td
                          class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
                        >
                          <Link
                            :href="route('products.edit', product.id)"
                            class="text-indigo-600 hover:text-indigo-900"
                          >
                            Edit
                          </Link>
                          <button
                            @click="deleteProduct(product.id)"
                            class="ml-2 text-indigo-600 hover:text-indigo-900"
                          >
                            Delete
                          </button>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <Pagination :data="products" :updatedPageNumber="updatedPageNumber" />
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>
