<script setup>
import ESidebar from '@/Components/ESidebar.vue';
import { usePage } from '@inertiajs/vue3';

// Get current page
const page = usePage();
</script>

<template>
  <div class="min-h-screen bg-gray-100 flex">
    <!-- Sidebar -->
    <ESidebar />

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
      <!-- Main Content Area -->
      <main class="flex-1 w-full p-6">
        <slot />
      </main>

      <!-- Simplified Footer -->
      <footer class="bg-white border-t mt-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 text-center">
          <p class="text-sm text-gray-600">
            © {{ new Date().getFullYear() }} LogiSys. All rights reserved.
          </p>
          <p class="text-sm text-gray-600 mt-2">
            Employee Portal - Designed for efficient logistics management.
          </p>
        </div>
      </footer>
    </div>
  </div>
</template>

<style scoped>
/* Add any custom styles here if needed */
</style>