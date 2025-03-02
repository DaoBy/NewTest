<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Table, TableHead, TableRow, TableHeaderCell, TableBody, TableCell } from '@heroicons/vue/24/outline';

// Example payment status data (replace with actual data from your backend)
const paymentStatuses = [
  {
    id: 'PS001',
    customerName: 'John Doe',
    outstandingBalance: '$50.00',
    paymentStatus: 'Partially Paid',
  },
  // Add more payment statuses here
];
</script>

<template>
  <Head title="Payment Status" />
  <EmployeeLayout>
    <div class="p-6">
      <h1 class="text-2xl font-semibold text-gray-900 mb-6">Payment Status</h1>
      <div class="overflow-x-auto bg-white rounded-lg shadow">
        <Table class="min-w-full">
          <TableHead>
            <TableRow>
              <TableHeaderCell>Payment ID</TableHeaderCell>
              <TableHeaderCell>Customer Name</TableHeaderCell>
              <TableHeaderCell>Outstanding Balance</TableHeaderCell>
              <TableHeaderCell>Payment Status</TableHeaderCell>
            </TableRow>
          </TableHead>
          <TableBody>
            <TableRow v-for="status in paymentStatuses" :key="status.id">
              <TableCell>{{ status.id }}</TableCell>
              <TableCell>{{ status.customerName }}</TableCell>
              <TableCell>{{ status.outstandingBalance }}</TableCell>
              <TableCell>{{ status.paymentStatus }}</TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>
  </EmployeeLayout>
</template>