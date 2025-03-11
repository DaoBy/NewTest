<script setup>
import { ref, computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';

// Get authenticated user
const authUser = computed(() => usePage().props.auth.user);

// Mobile menu state
const isMobileMenuOpen = ref(false);
const toggleMobileMenu = () => {
  isMobileMenuOpen.value = !isMobileMenuOpen.value;
};

// Determine Home Link (Public Home vs. Dashboard)
const homeLink = computed(() => {
  return authUser.value ? route('customer.home') : route('customer.home');
});
</script>

<template>
  <nav class="bg-white shadow-md w-full fixed top-0 z-50">
    <div class="w-full max-w-[90%] xl:max-w-[1280px] mx-auto flex justify-between items-center px-6 lg:px-12 py-4">
      <!-- Logo -->
      <a :href="route ('customer.home')" class="text-2xl font-bold">🚚 Infinitrix</a>

      <!-- Desktop Navigation -->
      <div class="hidden md:flex space-x-8">
        <NavLink :href="route('customer.home')">Home</NavLink>
        <NavLink :href="route('services')">Services</NavLink>
        <NavLink :href="route('about.us')">About Us</NavLink>
        <NavLink :href="route('contact.us')">Contact Us</NavLink>

      </div>

      <!-- Auth & User Dropdown -->
      <div v-if="authUser" class="hidden md:flex relative">
        <Dropdown>
          <template #trigger>
            <button class="flex items-center space-x-2 focus:outline-none">
              <!-- Profile Icon -->
              <svg
                class="w-8 h-8 text-gray-500"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
              >
                <path
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                />
              </svg>
              <span class="text-gray-700">{{ authUser.name }}</span>
              <svg
                class="-me-0.5 ms-2 h-4 w-4"
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
              >
                <path
                  fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                />
              </svg>
            </button>
          </template>
          <template #content>
            <div class="px-4 py-2 border-b border-gray-200">
              <div class="text-sm font-medium text-gray-800">{{ authUser.name }}</div>
              <div class="text-sm text-gray-500">{{ authUser.email }}</div>
            </div>
            <DropdownLink :href="route('profile.edit')">My Profile</DropdownLink>
            <DropdownLink :href="route('address.book')">Address Book</DropdownLink>
            <DropdownLink :href="route('request.delivery')">Request Delivery</DropdownLink>
            <DropdownLink :href="route('tracking')">Track Package</DropdownLink>
            <DropdownLink :href="route('transaction.history')">Transaction History</DropdownLink>
            <DropdownLink :href="route('logout')" method="post" as="button" class="text-lg font-medium text-red-600 hover:bg-gray-100 rounded-lg py-2"> Logout </DropdownLink>
          </template>
        </Dropdown>
      </div>

      <!-- Guest Links -->
      <div v-else class="hidden md:flex space-x-4">
        <NavLink :href="route('login')">
          <SecondaryButton>Sign In</SecondaryButton>
        </NavLink>
        <NavLink :href="route('customer.register')">
          <PrimaryButton>Sign Up</PrimaryButton>
        </NavLink>
      </div>

      <!-- Mobile Menu Button -->
      <button @click="toggleMobileMenu" class="md:hidden p-2 rounded focus:outline-none">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
        </svg>
      </button>
    </div>

      <!-- Mobile Navigation Menu -->
  <div v-if="isMobileMenuOpen" class="md:hidden bg-white shadow-md p-4 space-y-4 ">
    <!-- General Links -->
    <div class="flex flex-col space-y-2 px-6 justify-center">
      <NavLink :href="homeLink" class="text-lg font-medium text-gray-700 hover:bg-gray-100 rounded-lg py-2 justify-center">
        Home
      </NavLink>
      <NavLink :href="route('services')" class="text-lg font-medium text-gray-700 hover:bg-gray-100 rounded-lg py-2 justify-center">
        Services
      </NavLink>
      <NavLink :href="route('about.us')" class="text-lg font-medium text-gray-700 hover:bg-gray-100 rounded-lg py-2 justify-center">
        About US
      </NavLink>
      <NavLink :href="route('contact.us')" class="text-lg font-medium text-gray-700 hover:bg-gray-100 rounded-lg py-2 justify-center">
        Contact Us
      </NavLink>
    </div>

    <!-- Authenticated User Menu -->
    <div v-if="authUser" class="border-t pt-4 mt-4 px-6 items-center flex flex-col">
      <div class="pb-4">
  <div class="text-base font-semibold text-gray-800 text-center">{{ authUser.name }}</div>
  <div class="text-sm text-gray-500 text-center">{{ authUser.email }}</div>
</div>

      <div class="flex flex-col space-y-2 justify-center">
        <NavLink :href="route('profile.edit')" class="text-lg font-medium text-gray-700 hover:bg-gray-100 rounded-lg py-2 justify-center">
          My Profile
        </NavLink>
        <NavLink :href="route('address.book')" class="text-lg font-medium text-gray-700 hover:bg-gray-100 rounded-lg py-2 justify-center">
          Address Book
        </NavLink>
        <NavLink :href="route('request.delivery')" class="text-lg font-medium text-gray-700 hover:bg-gray-100 rounded-lg py-2 justify-center">
          Request Delivery
        </NavLink>
        <NavLink :href="route('tracking')" class="text-lg font-medium text-gray-700 hover:bg-gray-100 rounded-lg py-2 justify-center">
          Track Package
        </NavLink>
        <NavLink :href="route('transaction.history')" class="text-lg font-medium text-gray-700 hover:bg-gray-100 rounded-lg py-2 justify-center">
          Transaction History
        </NavLink>
        <NavLink :href="route('logout')" method="post" as="button" class="text-lg font-medium text-red-600 hover:bg-gray-100 rounded-lg py-2 justify-center">
          Logout
        </NavLink>
      </div>
    </div>

    <!-- Guest Links -->
    <div v-else class="border-t pt-4 space-y-2">
        <NavLink :href="route('login')">
          <SecondaryButton class="w-full">Sign In</SecondaryButton>
        </NavLink>
        <NavLink :href="route('customer.register')">
          <PrimaryButton class="w-full">Sign Up</PrimaryButton>
        </NavLink>
    </div>
  </div>
  </nav>
</template>