<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Table, TableHead, TableRow, TableHeaderCell, TableBody, TableCell } from '@heroicons/vue/24/outline';

// Example driver monitoring data (replace with actual data from your backend)
const drivers = [
  {
    id: 'DR001',
    name: 'Driver A',
    departureTime: '2023-10-01 08:00',
    arrivalTime: '2023-10-01 12:00',
    currentLocation: 'City A',
  },
  // Add more drivers here
];
</script>

<template>
  <Head title="Driver Monitoring" />
  <EmployeeLayout>
    <div class="p-6">
      <h1 class="text-2xl font-semibold text-gray-900 mb-6">Driver Monitoring</h1>
      <div class="overflow-x-auto bg-white rounded-lg shadow">
        <Table class="min-w-full">
          <TableHead>
            <TableRow>
              <TableHeaderCell>Driver ID</TableHeaderCell>
              <TableHeaderCell>Name</TableHeaderCell>
              <TableHeaderCell>Departure Time</TableHeaderCell>
              <TableHeaderCell>Arrival Time</TableHeaderCell>
              <TableHeaderCell>Current Location</TableHeaderCell>
            </TableRow>
          </TableHead>
          <TableBody>
            <TableRow v-for="driver in drivers" :key="driver.id">
              <TableCell>{{ driver.id }}</TableCell>
              <TableCell>{{ driver.name }}</TableCell>
              <TableCell>{{ driver.departureTime }}</TableCell>
              <TableCell>{{ driver.arrivalTime }}</TableCell>
              <TableCell>{{ driver.currentLocation }}</TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>
  </EmployeeLayout>
</template>