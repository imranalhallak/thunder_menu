<template>
    <div class="cart-container bg-gray-800 text-white p-4 rounded-lg mt-4">
      <h2 class="text-2xl font-bold mb-4">Cart</h2>
      <div v-if="Object.keys(cartItems ?? {}).length > 0">
        <div v-for="(item, id) in cartItems" :key="id" class="flex justify-between items-center mb-2">
          <p class="font-semibold">{{ item.name }}</p>
          <div class="counter-item flex items-center gap-2">
            <button class="button minus" @click="updateCartItem(id, -1)">-</button>
            <span class="counter-value">{{ item.quantity }}</span>
            <button class="button plus" @click="updateCartItem(id, 1)">+</button>
          </div>
          <p class="font-semibold">{{ item.price * item.quantity }} ₺</p>
        </div>
        <div class="flex justify-between mt-4">
          <h3 class="font-bold text-xl">Total:</h3>
          <p class="font-bold text-xl">{{ cartTotal }} ₺</p>
        </div>
      </div>
      <p v-else class="text-gray-400">Your cart is empty.</p>
    </div>
  </template>

  <script setup>
  import { computed } from "vue";

  // Props to accept cart and updateCart method
  defineProps({
    cartItems: Object,
    updateCartItem: Function,
  });

  // Computed property to calculate the total
  const cartTotal = computed(() =>
    Object.values(cartItems ?? {}).reduce((total, item) => total + item.price * item.quantity, 0)
  );
  </script>
