<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
</script>

<template>
  <GuestLayout>
    <!-- About Us Section -->
    <div class="py-12 bg-white">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center">
          <h2 class="text-3xl font-bold text-gray-900">About Us</h2>
          <p class="mt-4 text-lg text-gray-600">
            We stay winning with max skibidi energy, unmatched rizz levels, and a gyat that defies all logic—powered by chuchu vibes.
          </p>
        </div>

        <!-- Mission and Values -->
        <div class="mt-12 grid grid-cols-1 md:grid-cols-2 gap-8">
          <!-- Mission -->
          <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
            <h3 class="text-xl font-semibold text-gray-900">Our Mission</h3>
            <p class="mt-4 text-gray-600">
              Delivering peak skibidi efficiency while maintaining 100% rizz accuracy and an infinite gyat supply. Chuchu is not a choice—it's a lifestyle.
            </p>
          </div>

          <!-- Values -->
          <div class="bg-gray-50 p-6 rounded-lg shadow-sm">
            <h3 class="text-xl font-semibold text-gray-900">Our Values</h3>
            <ul class="mt-4 list-disc list-inside text-gray-600">
              <li>Skibidi Respect</li>
              <li>Certified Rizzology</li>
              <li>Maximum Gyatitude</li>
              <li>Chuchu Solidarity</li>
            </ul>
          </div>
        </div>

        <!-- Team Section -->
        <div class="mt-16">
          <h3 class="text-2xl font-bold text-gray-900 text-center">Meet Our Team</h3>
          <p class="mt-4 text-lg text-gray-600 text-center">
            Legends only. We operate at skibidi frequencies with unbreakable chuchu discipline.
          </p>
          <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Team Member 1 -->
            <div class="text-center">
              <img
                src="https://via.placeholder.com/150"
                alt="Team Member"
                class="mx-auto h-32 w-32 rounded-full"
              />
              <h4 class="mt-4 text-lg font-semibold text-gray-900">Skibidi Sigma</h4>
              <p class="text-gray-600">CEO of Rizz & Gyat</p>
            </div>

            <!-- Team Member 2 -->
            <div class="text-center">
              <img
                src="https://via.placeholder.com/150"
                alt="Team Member"
                class="mx-auto h-32 w-32 rounded-full"
              />
              <h4 class="mt-4 text-lg font-semibold text-gray-900">Lord Rizzington</h4>
              <p class="text-gray-600">Chief Gyat Officer</p>
            </div>

            <!-- Team Member 3 -->
            <div class="text-center">
              <img
                src="https://via.placeholder.com/150"
                alt="Team Member"
                class="mx-auto h-32 w-32 rounded-full"
              />
              <h4 class="mt-4 text-lg font-semibold text-gray-900">Chuchu Supreme</h4>
              <p class="text-gray-600">Skibidi Ambassador</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </GuestLayout>
</template>
