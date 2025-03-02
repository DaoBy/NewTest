<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Table, TableHead, TableRow, TableHeaderCell, TableBody, TableCell } from '@heroicons/vue/24/outline';

// Example cargo assignment data (replace with actual data from your backend)
const cargoAssignments = [
  {
    id: 'CA001',
    driver: 'Driver A',
    truck: 'ABC123',
    items: '2 Carton Boxes',
    customer: 'John Doe',
    assignedDate: '2023-10-01',
  },
  // Add more assignments here
];
</script>

<template>
  <Head title="Cargo Assignment" />
  <EmployeeLayout>
    <div class="p-6">
      <h1 class="text-2xl font-semibold text-gray-900 mb-6">Cargo Assignment</h1>
      <div class="overflow-x-auto bg-white rounded-lg shadow">
        <Table class="min-w-full">
          <TableHead>
            <TableRow>
              <TableHeaderCell>Assignment ID</TableHeaderCell>
              <TableHeaderCell>Driver</TableHeaderCell>
              <TableHeaderCell>Truck</TableHeaderCell>
              <TableHeaderCell>Items</TableHeaderCell>
              <TableHeaderCell>Customer</TableHeaderCell>
              <TableHeaderCell>Assigned Date</TableHeaderCell>
            </TableRow>
          </TableHead>
          <TableBody>
            <TableRow v-for="assignment in cargoAssignments" :key="assignment.id">
              <TableCell>{{ assignment.id }}</TableCell>
              <TableCell>{{ assignment.driver }}</TableCell>
              <TableCell>{{ assignment.truck }}</TableCell>
              <TableCell>{{ assignment.items }}</TableCell>
              <TableCell>{{ assignment.customer }}</TableCell>
              <TableCell>{{ assignment.assignedDate }}</TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>
  </EmployeeLayout>
</template>