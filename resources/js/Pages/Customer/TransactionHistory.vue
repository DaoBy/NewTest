<script setup>
import { ref } from 'vue'; // Import ref here
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head } from '@inertiajs/vue3';

// Placeholder data for transactions
const transactions = ref([
  { id: 1, date: '2023-10-01', description: 'Package Delivery', amount: '$25.00', status: 'Completed' },
  { id: 2, date: '2023-09-28', description: 'Express Delivery', amount: '$40.00', status: 'Completed' },
  { id: 3, date: '2023-09-25', description: 'Standard Delivery', amount: '$15.00', status: 'Cancelled' },
]);
</script>

<template>
  <Head title="Transaction History" />

  <GuestLayout>
    <template #header>
      <h2 class="text-xl font-semibold leading-tight text-gray-800">Transaction History</h2>
      
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <!-- Transaction Table -->
            <div class="overflow-x-auto">
              <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                  <tr>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Description</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Amount</th>
                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                  </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                  <tr v-for="transaction in transactions" :key="transaction.id">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ transaction.date }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ transaction.description }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ transaction.amount }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                      <span :class="{
                        'bg-green-100 text-green-800': transaction.status === 'Completed',
                        'bg-red-100 text-red-800': transaction.status === 'Cancelled',
                      }" class="px-2.5 py-0.5 rounded text-sm font-medium">
                        {{ transaction.status }}
                      </span>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </GuestLayout>
</template> 