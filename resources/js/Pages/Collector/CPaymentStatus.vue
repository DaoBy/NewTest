<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Table, TableHead, TableRow, TableHeaderCell, TableBody, TableCell } from '@heroicons/vue/24/outline';

// Example collector payment data (replace with actual data from your backend)
const collectorPayments = [
  {
    customerName: 'John Doe',
    transactionId: 'T001',
    paymentStatus: 'Partially Paid',
    outstandingBalance: '$50.00',
    paymentType: 'GCash',
  },
  // Add more payments here
];
</script>

<template>
  <Head title="Collector Payment Status" />
  <EmployeeLayout>
    <div class="p-6">
      <h1 class="text-2xl font-semibold text-gray-900 mb-6">Collector Payment Status</h1>
      <div class="overflow-x-auto bg-white rounded-lg shadow">
        <Table class="min-w-full">
          <TableHead>
            <TableRow>
              <TableHeaderCell>Customer Name</TableHeaderCell>
              <TableHeaderCell>Transaction ID</TableHeaderCell>
              <TableHeaderCell>Payment Status</TableHeaderCell>
              <TableHeaderCell>Outstanding Balance</TableHeaderCell>
              <TableHeaderCell>Payment Type</TableHeaderCell>
            </TableRow>
          </TableHead>
          <TableBody>
            <TableRow v-for="payment in collectorPayments" :key="payment.transactionId">
              <TableCell>{{ payment.customerName }}</TableCell>
              <TableCell>{{ payment.transactionId }}</TableCell>
              <TableCell>{{ payment.paymentStatus }}</TableCell>
              <TableCell>{{ payment.outstandingBalance }}</TableCell>
              <TableCell>{{ payment.paymentType }}</TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>
  </EmployeeLayout>
</template>