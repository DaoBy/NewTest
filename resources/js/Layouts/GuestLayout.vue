<script setup>
import NavLink from '@/Components/NavLink.vue';
import NavBar from '@/Components/NavBar.vue';
import { usePage } from '@inertiajs/vue3';
import { FaceSmileIcon, CameraIcon, ChatBubbleLeftRightIcon } from '@heroicons/vue/24/outline'

// Get current page
const page = usePage();
</script>

<template>
  <div class="min-h-screen bg-gray-100 flex flex-col">
    <!-- Navigation Bar -->
    <NavBar />

    <!-- Main Content -->
    <!-- Increased padding-top to add more space below the navbar -->
    <main class="flex-1 w-full pt-28"> <!-- Increased padding-top from 16 to 24 -->
      <slot />
    </main>

    <!-- Footer -->
    <!-- Increased margin-top to add more space above the footer -->
    <footer class="bg-white border-t mt-16"> <!-- Increased margin-top from 4 to 8 -->
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
        <NavLink :href="route('customer.home')" class="text-sm text-gray-600 hover:text-gray-900">Home</NavLink>
      </li>
      <li>
        <NavLink :href="route('services')" class="text-sm text-gray-600 hover:text-gray-900">Services</NavLink>
      </li>
      <li>
        <NavLink :href="route('contact.us')" class="text-sm text-gray-600 hover:text-gray-900">Contact Us</NavLink>
      </li>
      <li>
        <NavLink :href="route('about.us')" class="text-sm text-gray-600 hover:text-gray-900">About Us</NavLink>
      </li>
      <li>
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
</template>