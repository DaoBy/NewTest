<script setup>
import { ref } from 'vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import NavLink from '@/Components/NavLink.vue';
import deliveryImage from '@/assets/delivery.jpg';
import trackingImage from '@/assets/tracking.jpg';
import secureImage from '@/assets/secure.jpg';

// FAQ State
const faqs = ref([
  { question: 'How can I track my package?', answer: 'You can track your package by entering your tracking ID on our tracking page.', open: false },
  { question: 'What areas do you deliver to?', answer: 'We deliver to all major cities and regions across the country.', open: false },
  { question: 'What happens if my package is delayed?', answer: 'We will notify you immediately if there are any delays and work to resolve the issue.', open: false },
  { question: 'How do I request a delivery?', answer: 'Simply visit our delivery request page and provide the necessary information.', open: false },
  { question: 'Is my package insured?', answer: 'Yes, all shipments are insured against damage or loss during transit.', open: false },
  { question: 'Can I change my delivery address?', answer: 'You can update your address before the package is out for delivery.', open: false },
  { question: 'What are your delivery hours?', answer: 'Our deliveries are made between 8 AM and 8 PM from Monday to Saturday.', open: false },
  { question: 'Do you offer express delivery?', answer: 'Yes, we offer same-day and next-day delivery options for urgent shipments.', open: false },
]);

// Toggle FAQ item
const toggleFAQ = (index) => {
  faqs.value[index].open = !faqs.value[index].open;
};
</script>

<template>
  <GuestLayout>
    <!-- Hero Section -->
    <div class="w-full max-w-[90%] xl:max-w-[1280px] mx-auto text-center py-24 px-6 md:px-12 lg:px-20">
      <h1 class="text-3xl md:text-5xl font-bold text-gray-900 leading-tight">
        Fast & Reliable Logistics Services 🚚
      </h1>
      <p class="mt-4 text-lg md:text-xl text-gray-600">
        Track your packages and request deliveries with ease.
      </p>

      <!-- Action Buttons -->
<div class="mt-8 flex flex-col md:flex-row justify-center md:space-x-6 space-y-4 md:space-y-0">
  <NavLink :href="route('tracking')">
    <PrimaryButton class="w-full md:w-auto flex items-center justify-center">Track Package</PrimaryButton>
  </NavLink>

  <NavLink :href="route('request.delivery')">
    <PrimaryButton class="w-full md:w-auto flex items-center justify-center">Request Delivery</PrimaryButton>
  </NavLink>
</div>

    </div>

   <!-- Company Information (Text + Images One Below the Other) -->
<div class="w-full bg-white shadow-md py-12 px-6 md:px-12 lg:px-20">
  <div class="max-w-[90%] xl:max-w-[1280px] mx-auto space-y-12">
    <!-- Info 1 -->
    <div class="flex flex-col md:flex-row items-center gap-8">
      <div class="flex-1">
        <h2 class="text-2xl font-semibold text-gray-900">Fast Delivery</h2>
        <p class="mt-2 text-gray-600">We prioritize speedy delivery while ensuring the safety of your packages.</p>
      </div>
      <img :src="deliveryImage" alt="Delivery" class="w-full md:w-1/2 rounded-lg shadow-md" />
    </div>

    <!-- Info 2 -->
    <div class="flex flex-col md:flex-row items-center gap-8">
      <div class="flex-1">
        <h2 class="text-2xl font-semibold text-gray-900">Real-Time Tracking</h2>
        <p class="mt-2 text-gray-600">Stay updated with real-time tracking for every shipment.</p>
      </div>
      <img :src="trackingImage" alt="Tracking" class="w-full md:w-1/2 rounded-lg shadow-md" />
    </div>

    <!-- Info 3 -->
    <div class="flex flex-col md:flex-row items-center gap-8">
      <div class="flex-1">
        <h2 class="text-2xl font-semibold text-gray-900">Secure Handling</h2>
        <p class="mt-2 text-gray-600">We ensure secure handling to protect your valuable items during transit.</p>
      </div>
      <img :src="secureImage" alt="Secure" class="w-full md:w-1/2 rounded-lg shadow-md" />
    </div>
  </div>
</div>


  <!-- Fun Section -->
<div class="w-full bg-gray-100 py-16 px-6 md:px-12 lg:px-20">
  <div class="max-w-[90%] xl:max-w-[1280px] mx-auto">
    
    <!-- Fun Header -->
    <div class="text-center mb-12">
      <h2 class="text-4xl font-bold text-gray-900">
        🚀 Regional Delivery Services – Fast, Fun & Fabulous!
      </h2>
      <p class="mt-4 text-lg text-gray-700">
        Skibidi Infinitrix SKibi gyat gyat pot cat
      </p>
    </div>

    <!-- Fun Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Gyat Deliveries -->
      <div class="p-6 bg-white rounded-lg shadow-sm text-center">
        <h3 class="text-xl font-semibold text-gray-900">🍑 Gyat Deliveries</h3>
        <p class="mt-2 text-gray-600"> We'll deliver it—no cap. 💌</p>
      </div>

      <!-- Skibidi On-Time Shipments -->
      <div class="p-6 bg-white rounded-lg shadow-sm text-center">
        <h3 class="text-xl font-semibold text-gray-900">⏱️ Skibidi On-Time Shipments</h3>
        <p class="mt-2 text-gray-600">Faster than you can say "rizz,". 🔥</p>
      </div>

      <!-- Amongus Handling -->
      <div class="p-6 bg-white rounded-lg shadow-sm text-center">
        <h3 class="text-xl font-semibold text-gray-900">ඞ Amongus Handling</h3>
        <p class="mt-2 text-gray-600">We vent your packages with sus-level. 🕵️</p>
      </div>
    </div>
  </div>
</div>


    <!-- FAQ Section -->
    <div class="w-full py-12 px-6 md:px-12 lg:px-20">
      <div class="max-w-[90%] xl:max-w-[1280px] mx-auto">
        <h2 class="text-3xl font-semibold text-gray-900 text-center mb-8">Frequently Asked Questions</h2>

        <div class="space-y-4">
          <div v-for="(faq, index) in faqs" :key="index" class="border border-gray-300 rounded-lg">
            <button @click="toggleFAQ(index)" class="w-full p-4 text-left flex justify-between items-center focus:outline-none">
              <span class="text-lg text-gray-900">{{ faq.question }}</span>
              <span>{{ faq.open ? '−' : '+' }}</span>
            </button>
            <div v-if="faq.open" class="p-4 border-t text-gray-600">
              {{ faq.answer }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </GuestLayout>
</template>
