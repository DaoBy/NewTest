<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Table, TableHead, TableRow, TableHeaderCell, TableBody, TableCell } from '@heroicons/vue/24/outline';

// Example billing data (replace with actual data from your backend)
const bills = [
  {
    id: 'B001',
    customerName: 'John Doe',
    serviceBreakdown: '2 Carton Boxes - $50.00',
    totalCost: '$100.00',
    origin: 'City A',
    destination: 'City B',
    waybillNumber: 'WB001',
  },
  // Add more bills here
];
</script>

<template>
  <Head title="Billing" />
  <EmployeeLayout>
    <div class="p-6">
      <h1 class="text-2xl font-semibold text-gray-900 mb-6">Billing</h1>
      <div class="overflow-x-auto bg-white rounded-lg shadow">
        <Table class="min-w-full">
          <TableHead>
            <TableRow>
              <TableHeaderCell>Bill ID</TableHeaderCell>
              <TableHeaderCell>Customer Name</TableHeaderCell>
              <TableHeaderCell>Service Breakdown</TableHeaderCell>
              <TableHeaderCell>Total Cost</TableHeaderCell>
              <TableHeaderCell>Origin</TableHeaderCell>
              <TableHeaderCell>Destination</TableHeaderCell>
              <TableHeaderCell>Waybill Number</TableHeaderCell>
            </TableRow>
          </TableHead>
          <TableBody>
            <TableRow v-for="bill in bills" :key="bill.id">
              <TableCell>{{ bill.id }}</TableCell>
              <TableCell>{{ bill.customerName }}</TableCell>
              <TableCell>{{ bill.serviceBreakdown }}</TableCell>
              <TableCell>{{ bill.totalCost }}</TableCell>
              <TableCell>{{ bill.origin }}</TableCell>
              <TableCell>{{ bill.destination }}</TableCell>
              <TableCell>{{ bill.waybillNumber }}</TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>
  </EmployeeLayout>
</template>