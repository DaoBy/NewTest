<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Table, TableHead, TableRow, TableHeaderCell, TableBody, TableCell } from '@heroicons/vue/24/outline';

// Example truck data (replace with actual data from your backend)
const trucks = [
  {
    id: 'T001',
    make: 'Ford F-150',
    plateNumber: 'ABC123',
    capacity: '1000 kg',
    status: 'Available',
  },
  // Add more trucks here
];
</script>

<template>
  <Head title="Truck Management" />
  <EmployeeLayout>
    <div class="p-6">
      <h1 class="text-2xl font-semibold text-gray-900 mb-6">Truck Management</h1>
      <div class="overflow-x-auto bg-white rounded-lg shadow">
        <Table class="min-w-full">
          <TableHead>
            <TableRow>
              <TableHeaderCell>Truck ID</TableHeaderCell>
              <TableHeaderCell>Make & Model</TableHeaderCell>
              <TableHeaderCell>Plate Number</TableHeaderCell>
              <TableHeaderCell>Capacity</TableHeaderCell>
              <TableHeaderCell>Status</TableHeaderCell>
            </TableRow>
          </TableHead>
          <TableBody>
            <TableRow v-for="truck in trucks" :key="truck.id">
              <TableCell>{{ truck.id }}</TableCell>
              <TableCell>{{ truck.make }}</TableCell>
              <TableCell>{{ truck.plateNumber }}</TableCell>
              <TableCell>{{ truck.capacity }}</TableCell>
              <TableCell>{{ truck.status }}</TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>
  </EmployeeLayout>
</template>