<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Table, TableHead, TableRow, TableHeaderCell, TableBody, TableCell } from '@heroicons/vue/24/outline';

// Example customer data 
const customers = [
  {
    id: 'C001',
    name: 'John Doe',
    contact: 'john.doe@example.com',
    address: '123 Main St, City',
    type: 'Regular',
  },
  // Add more customers here
];
</script>

<template>
  <Head title="Customer Management" />
  <EmployeeLayout>
    <div class="p-6">
      <h1 class="text-2xl font-semibold text-gray-900 mb-6">Customer Management</h1>
      <div class="overflow-x-auto bg-white rounded-lg shadow">
        <Table class="min-w-full">
          <TableHead>
            <TableRow>
              <TableHeaderCell>Customer ID</TableHeaderCell>
              <TableHeaderCell>Name</TableHeaderCell>
              <TableHeaderCell>Contact</TableHeaderCell>
              <TableHeaderCell>Address</TableHeaderCell>
              <TableHeaderCell>Type</TableHeaderCell>
            </TableRow>
          </TableHead>
          <TableBody>
            <TableRow v-for="customer in customers" :key="customer.id">
              <TableCell>{{ customer.id }}</TableCell>
              <TableCell>{{ customer.name }}</TableCell>
              <TableCell>{{ customer.contact }}</TableCell>
              <TableCell>{{ customer.address }}</TableCell>
              <TableCell>{{ customer.type }}</TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>
  </EmployeeLayout>
</template>