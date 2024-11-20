
<script setup>
import { ref } from 'vue';
import { Head, useForm } from "@inertiajs/vue3";

// Props received from the parent (Laravel)
const props = defineProps({
  branches: Array,
  branch_id: Number, // Globally shared branch_id from Laravel
});

// Reactive variable to keep track of the selected branch
const selectedBranchId = ref(props.branch_id);

// Create form handling for branch selection
const form = useForm({
  branch_id: selectedBranchId.value,
});

// Function to set the selected branch
const setBranch = (branchId) => {
  selectedBranchId.value = branchId;
  form.branch_id = branchId;

  // Send request to Laravel to persist the selected branch globally
  form.post('/set-branch', {
    onSuccess: () => {
    }
  });
};
</script>
<template>
    <div>
      <h1>Select Branch</h1>

      <!-- Display a list of branches with a button to select one -->
      <ul>
        <li v-for="branch in branches" :key="branch.id">
          <button
            @click="setBranch(branch.id)"
            :class="{
              'bg-blue-500 text-white': selectedBranchId === branch.id,
              'bg-gray-200': selectedBranchId !== branch.id
            }"
            class="px-4 py-2 rounded-md"
          >
            Set Branch: {{ branch.name }}
          </button>
        </li>
      </ul>

      <!-- Display the currently selected branch -->
      <p v-if="selectedBranchId">Current branch ID: {{ selectedBranchId }}</p>
    </div>
  </template>

