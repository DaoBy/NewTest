<template>
    <EmployeeLayout>
      <Head title="Delivery Request Management" />
      <div class="p-6">
        <h1 class="text-2xl font-semibold text-gray-900 mb-6">Delivery Request Management</h1>
  
        <!-- Status Filter -->
        <div class="mb-6">
          <label for="status-filter" class="block text-sm font-medium text-gray-700">Filter by Status</label>
          <select
            id="status-filter"
            v-model="statusFilter"
            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm"
          >
            <option value="">All</option>
            <option value="Pending">Pending</option>
            <option value="Approved">Approved</option>
            <option value="Rejected">Rejected</option>
          </select>
        </div>
  
        <!-- Delivery Requests Table -->
        <div class="overflow-x-auto bg-white rounded-lg shadow">
          <table class="min-w-full">
            <thead>
              <tr>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Request ID</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Customer Name</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Date</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Status</th>
                <th class="px-6 py-3 text-left text-sm font-medium text-gray-900">Actions</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="request in filteredRequests" :key="request.id">
                <td class="px-6 py-4 text-sm text-gray-900">{{ request.id }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ request.customerName }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">{{ request.date }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">
                  <span
                    :class="{
                      'bg-yellow-100 text-yellow-800': request.status === 'Pending',
                      'bg-green-100 text-green-800': request.status === 'Approved',
                      'bg-red-100 text-red-800': request.status === 'Rejected',
                    }"
                    class="px-2 py-1 text-xs font-medium rounded-full"
                  >
                    {{ request.status }}
                  </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-900">
                  <button
                    v-if="request.status === 'Pending'"
                    @click="approveRequest(request.id)"
                    class="text-green-500 hover:text-green-700 mr-2"
                  >
                    Approve
                  </button>
                  <button
                    v-if="request.status === 'Pending'"
                    @click="rejectRequest(request.id)"
                    class="text-red-500 hover:text-red-700"
                  >
                    Reject
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </EmployeeLayout>
  </template>
  
  <script setup>
  import { ref, computed } from 'vue';
  import { Head } from '@inertiajs/vue3';
  import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
  
  // Example delivery requests data 
  const deliveryRequests = ref([
    {
      id: 'DR001',
      customerName: 'John Doe',
      date: '2023-10-01',
      status: 'Pending',
    },
    {
      id: 'DR002',
      customerName: 'Jane Smith',
      date: '2023-10-02',
      status: 'Approved',
    },
    {
      id: 'DR003',
      customerName: 'Alice Johnson',
      date: '2023-10-03',
      status: 'Rejected',
    },
  ]);
  
  // Status filter
  const statusFilter = ref('');
  
  // Filtered requests based on status
  const filteredRequests = computed(() => {
    if (!statusFilter.value) return deliveryRequests.value;
    return deliveryRequests.value.filter((request) => request.status === statusFilter.value);
  });
  
  // Approve a request
  const approveRequest = (requestId) => {
    const request = deliveryRequests.value.find((req) => req.id === requestId);
    if (request) request.status = 'Approved';
  };
  
  // Reject a request
  const rejectRequest = (requestId) => {
    const request = deliveryRequests.value.find((req) => req.id === requestId);
    if (request) request.status = 'Rejected';
  };
  </script>