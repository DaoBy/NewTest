<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Table, TableHead, TableRow, TableHeaderCell, TableBody, TableCell } from '@heroicons/vue/24/outline';

// Example package tracking data 
const pack = [
  {
    id: 'P001',
    currentLocation: 'City A',
    destination: 'City B',
    status: 'In Transit',
  },
  // Add more packages here
];
</script>

<template>
  <Head title="Package Tracking" />
  <EmployeeLayout>
    <div class="p-6">
      <h1 class="text-2xl font-semibold text-gray-900 mb-6">Package Tracking</h1>
      <div class="overflow-x-auto bg-white rounded-lg shadow">
        <Table class="min-w-full">
          <TableHead>
            <TableRow>
              <TableHeaderCell>Package ID</TableHeaderCell>
              <TableHeaderCell>Current Location</TableHeaderCell>
              <TableHeaderCell>Destination</TableHeaderCell>
              <TableHeaderCell>Status</TableHeaderCell>
            </TableRow>
          </TableHead>
          <TableBody>
            <TableRow v-for="pack in packages" :key="package.id">
              <TableCell>{{ pack.id }}</TableCell>
              <TableCell>{{ pack.currentLocation }}</TableCell>
              <TableCell>{{ pack.destination }}</TableCell>
              <TableCell>{{ pack.status }}</TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>
  </EmployeeLayout>
</template>