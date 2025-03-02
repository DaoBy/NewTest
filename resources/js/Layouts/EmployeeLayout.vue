<script setup>
import ESidebar from '@/Components/ESidebar.vue';
import { usePage } from '@inertiajs/vue3';
import { FaceSmileIcon, CameraIcon, ChatBubbleLeftRightIcon } from '@heroicons/vue/24/outline';

// Get current page
const page = usePage();
</script>

<template>
  <div class="min-h-screen bg-gray-100 flex">
    <!-- Sidebar -->
    <ESidebar />

    <!-- Main Content -->
    <div class="flex-1 flex flex-col">
      <!-- Navigation Bar (Optional, if needed) -->
      <!-- <NavBar /> -->

      <!-- Main Content Area -->
      <main class="flex-1 w-full p-6">
        <slot />
      </main>

      <!-- Footer -->
      <footer class="bg-white border-t mt-4">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
          <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Company Information -->
            <div class="space-y-4">
              <h3 class="text-lg font-semibold text-gray-900">Infinitrix Cargo Express</h3>
              <p class="text-sm text-gray-600">
                Fast, reliable, and secure logistics services for all your delivery needs.
              </p>
              <div class="text-sm text-gray-600">
                <p>123 Logistics Street</p>
                <p>City, Province, ZIP Code</p>
                <p>Country</p>
              </div>
            </div>

            <!-- Quick Links -->
            <div class="space-y-4">
              <h3 class="text-lg font-semibold text-gray-900">Quick Links</h3>
              <ul class="space-y-2">
                <li>
                  <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Home</a>
                </li>
                <li>
                  <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Services</a>
                </li>
                <li>
                  <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Contact Us</a>
                </li>
                <li>
                  <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Privacy Policy</a>
                </li>
                <li>
                  <a href="#" class="text-sm text-gray-600 hover:text-gray-900">Terms of Service</a>
                </li>
              </ul>
            </div>

            <!-- Contact Information -->
            <div class="space-y-4">
              <h3 class="text-lg font-semibold text-gray-900">Contact Us</h3>
              <div class="text-sm text-gray-600">
                <p>Email: support@infinitrixcargo.com</p>
                <p>Phone: +1 (123) 456-7890</p>
                <p>Fax: +1 (123) 456-7891</p>
              </div>
              <div class="flex space-x-4">
                <a href="#" class="text-gray-600 hover:text-gray-900">
                  <FaceSmileIcon class="size-6" />
                </a>
                <a href="#" class="text-gray-600 hover:text-gray-900">
                  <CameraIcon class="size-6" />
                </a>
                <a href="#" class="text-gray-600 hover:text-gray-900">
                  <ChatBubbleLeftRightIcon class="size-6" />
                </a>
              </div>
            </div>
          </div>

          <!-- Copyright -->
          <div class="border-t border-gray-200 mt-6 py-4 text-center text-sm text-gray-600">
            © {{ new Date().getFullYear() }} Infinitrix Cargo Express. All Rights Reserved.
          </div>
        </div>
      </footer>
    </div>
  </div>
</template>

<style scoped>
/* Add any custom styles here if needed */
</style>