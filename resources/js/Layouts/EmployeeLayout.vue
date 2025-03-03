<script setup>
import ESidebar from '@/Components/ESidebar.vue';
import { usePage } from '@inertiajs/vue3';

// Get current page
const page = usePage();
</script>

<template>
  <v-app>
    <!-- Main Layout -->
    <v-layout style="height: 100vh; overflow: hidden;">
      <!-- Sidebar -->
      <ESidebar />

      <!-- Main Content -->
      <v-main class="flex-1 flex flex-col" style="overflow-y: auto;">
        <!-- Main Content Area -->
        <v-container fluid class="flex-1 w-full pa-6">
          <slot />
        </v-container>

        <!-- Simplified Footer -->
        <v-footer class="bg-white border-t mt-4">
          <v-container>
            <v-row justify="center">
              <v-col cols="12" class="text-center">
                <p class="text-sm text-gray-600">
                  © {{ new Date().getFullYear() }} LogiSys. All rights reserved.
                </p>
                <p class="text-sm text-gray-600 mt-2">
                  Employee Portal - Designed for efficient logistics management.
                </p>
              </v-col>
            </v-row>
          </v-container>
        </v-footer>
      </v-main>
    </v-layout>
  </v-app>
</template>

<style scoped>
/* Ensure the layout takes full height */
.v-application {
  height: 100vh;
}

/* Ensure the sidebar and main content take full height */
.v-layout {
  height: 100%;
}

/* Ensure the main content area scrolls if needed */
.v-main {
  overflow-y: auto;
}
</style>