<template>
    <Head :title="branch.name" />
    <div class="bg-gray-700">
      <!-- Image Section -->
      <div class="flex justify-center">
        <div class="bg-black max-w-[600px]">
          <img
            src="branch_images/Unti1tled.png"
            alt="Restaurant front view at night with bright lights"
            class="w-full max-w-[600px] rounded-lg"
          />
        </div>
      </div>

      <!-- Content Section -->
      <div class="bg-black p-4 w-full max-w-[600px] mx-auto">
        <!-- Header -->
        <div class="flex justify-between items-center">
          <h1 class="text-3xl font-bold text-white">{{ branch.name }}</h1>
          <button class="bg-gray-700 text-white border-4 border-white px-4 py-2 rounded-2xl">
            Türkçe
          </button>
        </div>

        <!-- Branch Information -->
        <div class="mt-2 text-white">
          <p>
            VİRANŞEHİR MAH/SEMT 34330 SK.<br />
            NO: 1 B İÇ KAPI NO: 25 MEZİTLİ/ MERSİN<br />
            {{ branch.phone || '+905011221122' }}<br />
            Wifi: Friends4321
          </p>
        </div>

        <!-- Menu Categories -->
        <div class="flex flex-wrap gap-2 mt-4">
          <button
            v-for="(menu, index) in branch.menus"
            :key="index"
            @click="selectMenu(index)"
            :class="{
              'bg-white text-gray-700 border-gray-700': selectedMenuIndex === index,
              'bg-gray-700 text-white border-white': selectedMenuIndex !== index,
            }"
            class="px-2 py-1 rounded-2xl border-4"
          >
            {{ menu.english_name }}
          </button>
        </div>

        <!-- Featured Dishes -->
        <div v-for="(meal, index) in branch.menus[selectedMenuIndex].meals" :key="index" class="p-7">
          <h2 class="text-2xl font-bold text-white">{{ meal.english_name }}</h2>
          <img
            :src="meal.images ? JSON.parse(meal.images)[0] : 'default_image.jpg'"
            :alt="meal.english_name"
            class="w-full rounded-3xl mt-2"
          />
          <div class="flex justify-around items-center mt-4">
            <div v-for="(price, optionIndex) in [meal.price_1, meal.price_2, meal.price_3]" :key="optionIndex" class="flex items-center gap-2">
              <p class="text-xl font-bold text-white">
                {{ Math.floor(price) }}.
                <span class="text-sm text-gray-300">{{ (price % 1).toFixed(1).substring(2) }}</span>
              </p>
              <button
                class="bg-gray-700 text-white px-3 py-1 border-4 border-white rounded-2xl text-lg"
                @click="addToCart(meal, price)"
              >
                +
              </button>
            </div>
          </div>
        </div>

        <!-- Cart Button -->
        <div class="w-full flex justify-center">
            <button
              v-if="cartHasItems && cartButtonVisible"
              class="fixed-bottom bg-gray-700 border-t-4 border-l-4 border-r-4 text-white animated-cart rounded-t-xl w-96"
              @click="goToCart"
            >
            Cart {{ cartItemCount  }}
        </button>
          </div>


        <!-- Cart Section -->
        <div v-if="cartHasItems" class="bg-gray-800 p-4 rounded-lg mt-6 ">
            <h2 class=" text-2xl font-bold text-white mb-4">Cart</h2>
            <div v-for="(item, id) in cart" :key="id" class="flex justify-between items-center text-white mb-2">
              <div>
                <p class="font-bold">{{ item.name+ ' s' }}</p>
                <p class="text-sm text-gray-400">Price: {{ item.price }}</p>
              </div>
              <div class="flex items-center gap-2">
                <button @click="updateCart(id, -1)" class="button minus">-</button>
                <h1 class="text-xl font-bold">{{ item.quantity }}</h1>
                <button @click="updateCart(id, 1)" class="button plus">+</button>
              </div>
            </div>
            <p class="text-lg font-bold text-white mt-4">Total: {{ cartTotal }}</p>
            <button class="border-white border-4 rounded-lg p-2 text-white btn-primary mt-4" @click="sendCartToWhatsApp">
                Confirm order
              </button>
          </div>
        <!-- Footer -->
        <div class="bg-black p-4 w-full  text-white max-w-[600px] mx-auto">
            <div class="flex justify-center items-center">
              <p class="text-sm">thundermenu.com © All rights reserved.</p>
            </div>
          </div>
      </div>
    </div>
  </template>

  <style scoped>
  .counter-wrapper {
    display: flex;
    flex-direction: column;
    gap: 5px; /* Space between each counter */
  }

  .counter-item {
    display: flex;
    align-items: center; /* Aligns buttons and counter value vertically */
    justify-content: center; /* Centers items horizontally */
    gap: 10px; /* Space between buttons and counter value */
  }

  .button {
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    font-weight: bold;
    border: 2px solid white;
    border-radius: 10px;
    color: white;
    cursor: pointer;
  }

  .minus {
    background-color: #e63946; /* Red color for minus button */
  }

  .plus {
    background-color: #2a9d8f; /* Green color for plus button */
  }

  .counter-value {
    font-size: 3.5rem;
    font-weight: bold;
    color: white;
  }
/* Basic styling for the fixed button */
.fixed-bottom {
    position: fixed;

    bottom: 0;
    z-index: 1000;
    padding: 10px 20px;
    display: flex;
    justify-content: center;
  }

  /* Styling for the button */


  /* Animation for the button from bottom to top */
  .animated-cart {
    animation: slideUp 0.5s ease-in-out;
  }

  @keyframes slideUp {
    0% {
      transform: translateY(100%);
    }
    100% {
      transform: translateY(0);
    }
  }

  /* Hide the cart button when scrolled to the bottom */
  .hide-cart-button {
    opacity: 0;
    visibility: hidden;
  }

</style>

  <script setup>
  import { ref, onMounted , computed, onBeforeUnmount,watchEffect,  } from "vue";
  import { Head, Link, useForm } from '@inertiajs/vue3';

  // Accepting the branch data as a prop
  const cartHasItems = computed(() => Object.keys(cart.value).length > 0);
  const cartItemCount = computed(() =>
  Object.values(cart.value).reduce((count, item) => count + item.quantity, 0)
);
 const props = defineProps({
  branch: {
    type: Object,
    required: true, // Ensure it must be provided
  },
  errors: {
    type: Object,
    required: true,
  },
  auth: {
    type: Object,
    required: true,
  },
  message: {
    type: Array,
    required: true,
  },

});



  const selectedMenuIndex = ref(0); // Default index
  const cart = ref({}); // Cart to store items
  const cartDetails = ref(null); // Cart to store items

  // Function to select a menu
  const selectMenu = (index) => {
    selectedMenuIndex.value = index;
  };
  const generateCartDetails = () => {
  // Check if the cart is empty
  if (!Object.keys(cart.value).length) {
    console.error("Cart is empty. Add items before generating details.");
    return "Cart is empty.";
  }

  // Generate the formatted details string
  const cartDetails = Object.entries(cart.value)
    .map(([id, item]) => {
      const totalPrice = (parseFloat(item.price) * item.quantity).toFixed(2);
      return `- ${item.name} (x${item.quantity}) - Price: ${item.price} - Total: ${totalPrice}`;
    })
    .join("\n");


  return cartDetails;
};


const sendCartToWhatsApp = () => {
    const phoneNumber = "+ asd wqe90 539 740 08 45"; // Replace with your WhatsApp number

  // Ensure cart has items before proceeding
  if (Object.keys(cart.value).length === 0) {
    console.error("Cart is empty. Add items before sending to WhatsApp.");
    return;
  }

  const cartDetails = generateCartDetails(); // Call the function to get details

  // Calculate total price
  const total = cartTotal.value.toFixed(2);

  // Construct the message with cart details and total
  const message = `Order Summary:\n${cartDetails}\n\nTotal: ${total}`;

  // Generate the WhatsApp Web URL (encoded properly)
  const encodedMessage = encodeURIComponent(message);
  const url = `https://wa.me/${phoneNumber.replace(/[^0-9]/g, "")}?text=${encodedMessage}`;

  // Open WhatsApp Web link in a new tab
  window.open(url, "_blank");
};



  // Add item to the cart
  const addToCart = (meal, price) => {
    const id = `${meal.english_name}-${price}`;
    if (!cart.value[id]) {
      cart.value[id] = {
        name: meal.english_name,
        price,
        quantity: 1,
      };
    } else {
      cart.value[id].quantity += 1;
    }
  };

  // Update cart item quantity
  const updateCart = (id, delta) => {
    if (cart.value[id]) {
      cart.value[id].quantity += delta;
      if (cart.value[id].quantity <= 0) {
        delete cart.value[id];
      }
    }
  };

  // Calculate total
  const cartTotal = computed(() =>
    Object.values(cart.value).reduce((total, item) => total + item.price * item.quantity, 0)
  );
  const scrollPosition = ref(0);
  const cartButtonVisible = ref(true);

// Watch for scroll events
const handleScroll = () => {
  scrollPosition.value = window.scrollY;

  // Hide the cart button when scrolled to the bottom
  if (window.innerHeight + window.scrollY >= document.body.offsetHeight) {
    // Set a class to hide the cart button
    cartButtonVisible.value = false;
  } else {
    cartButtonVisible.value = true;
  }
};
// Remove scroll event listener on cleanup
onBeforeUnmount(() => {
  window.removeEventListener('scroll', handleScroll);
});

const goToCart = () => {
  // Scroll to the bottom of the page
  window.scrollTo({
    top: document.body.scrollHeight, // Scroll to the bottom
    behavior: 'smooth', // Smooth scrolling effect
  });

};



  onMounted(() => {
  if (props.branch.menus && props.branch.menus.length > 0) {
    selectedMenuIndex.value = 0;
  }
  window.addEventListener('scroll', handleScroll);

});
  </script>
