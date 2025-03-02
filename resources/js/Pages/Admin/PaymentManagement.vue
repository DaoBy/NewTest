<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Table, TableHead, TableRow, TableHeaderCell, TableBody, TableCell } from '@heroicons/vue/24/outline';

// Example payment management data (replace with actual data from your backend)
const payments = [
  {
    id: 'P001',
    customerName: 'John Doe',
    transactionId: 'T001',
    paymentType: 'GCash',
    paymentProof: 'Screenshot',
    paymentStatus: 'Verified',
  },
  // Add more payments here
];
</script>

<template>
  <Head title="Payment Management" />
  <EmployeeLayout>
    <div class="p-6">
      <h1 class="text-2xl font-semibold text-gray-900 mb-6">Payment Management</h1>
      <div class="overflow-x-auto bg-white rounded-lg shadow">
        <Table class="min-w-full">
          <TableHead>
            <TableRow>
              <TableHeaderCell>Payment ID</TableHeaderCell>
              <TableHeaderCell>Customer Name</TableHeaderCell>
              <TableHeaderCell>Transaction ID</TableHeaderCell>
              <TableHeaderCell>Payment Type</TableHeaderCell>
              <TableHeaderCell>Payment Proof</TableHeaderCell>
              <TableHeaderCell>Payment Status</TableHeaderCell>
            </TableRow>
          </TableHead>
          <TableBody>
            <TableRow v-for="payment in payments" :key="payment.id">
              <TableCell>{{ payment.id }}</TableCell>
              <TableCell>{{ payment.customerName }}</TableCell>
              <TableCell>{{ payment.transactionId }}</TableCell>
              <TableCell>{{ payment.paymentType }}</TableCell>
              <TableCell>{{ payment.paymentProof }}</TableCell>
              <TableCell>{{ payment.paymentStatus }}</TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>
  </EmployeeLayout>
</template>