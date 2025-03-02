<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import { Head } from '@inertiajs/vue3';
import { DocumentArrowDownIcon } from '@heroicons/vue/24/outline';

// Example waybill data 
const waybills = [
  {
    id: 'WB001',
    customerName: 'John Doe',
    origin: 'City A',
    destination: 'City B',
    packageDetails: '2 Carton Boxes',
    servicePrice: '$100.00',
  },
  // Add more waybills here
];
</script>

<template>
  <Head title="Waybill Download" />
  <EmployeeLayout>
    <div class="p-6">
      <h1 class="text-2xl font-semibold text-gray-900 mb-6">Waybill Download</h1>
      <div class="overflow-x-auto bg-white rounded-lg shadow">
        <table class="min-w-full">
          <thead>
            <tr>
              <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Waybill ID</th>
              <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Customer Name</th>
              <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Origin</th>
              <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Destination</th>
              <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Package Details</th>
              <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Service Price</th>
              <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Action</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="waybill in waybills" :key="waybill.id">
              <td class="px-6 py-4 text-sm text-gray-900">{{ waybill.id }}</td>
              <td class="px-6 py-4 text-sm text-gray-900">{{ waybill.customerName }}</td>
              <td class="px-6 py-4 text-sm text-gray-900">{{ waybill.origin }}</td>
              <td class="px-6 py-4 text-sm text-gray-900">{{ waybill.destination }}</td>
              <td class="px-6 py-4 text-sm text-gray-900">{{ waybill.packageDetails }}</td>
              <td class="px-6 py-4 text-sm text-gray-900">{{ waybill.servicePrice }}</td>
              <td class="px-6 py-4 text-sm text-gray-900">
                <button class="text-blue-500 hover:text-blue-700">
                  <DocumentArrowDownIcon class="size-5" />
                </button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </EmployeeLayout>
</template>