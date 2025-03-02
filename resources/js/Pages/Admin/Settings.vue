<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import { Head } from '@inertiajs/vue3';

// Example settings data
const settings = {
  priceMatrix: {
    pricePerKg: '$5.00',
    pricePerCubicMeter: '$10.00',
  },
  userPreferences: {
    fontSize: 'Medium',
    theme: 'Light',
  },
};
</script>

<template>
  <Head title="Settings" />
  <EmployeeLayout>
    <div class="p-6">
      <h1 class="text-2xl font-semibold text-gray-900 mb-6">Settings</h1>

      <!-- Price Matrix Section -->
      <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Price Matrix</h2>
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Price per kg</label>
            <input
              type="text"
              v-model="settings.priceMatrix.pricePerKg"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            />
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Price per cubic meter</label>
            <input
              type="text"
              v-model="settings.priceMatrix.pricePerCubicMeter"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            />
          </div>
        </div>
      </div>

      <!-- User Preferences Section -->
      <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">User Preferences</h2>
        <div class="space-y-4">
          <div>
            <label class="block text-sm font-medium text-gray-700">Font Size</label>
            <select
              v-model="settings.userPreferences.fontSize"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            >
              <option>Small</option>
              <option>Medium</option>
              <option>Large</option>
            </select>
          </div>
          <div>
            <label class="block text-sm font-medium text-gray-700">Theme</label>
            <select
              v-model="settings.userPreferences.theme"
              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
            >
              <option>Light</option>
              <option>Dark</option>
            </select>
          </div>
        </div>
      </div>
    </div>
  </EmployeeLayout>
</template>