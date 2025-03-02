<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Table, TableHead, TableRow, TableHeaderCell, TableBody, TableCell } from '@heroicons/vue/24/outline';

// Example region data (replace with actual data from your backend)
const regions = [
  {
    id: 'R001',
    name: 'City A',
    warehouseAddress: '123 Warehouse St, City A',
    status: 'Active',
  },
  // Add more regions here
];
</script>

<template>
  <Head title="Region/Area Management" />
  <EmployeeLayout>
    <div class="p-6">
      <h1 class="text-2xl font-semibold text-gray-900 mb-6">Region/Area Management</h1>
      <div class="overflow-x-auto bg-white rounded-lg shadow">
        <Table class="min-w-full">
          <TableHead>
            <TableRow>
              <TableHeaderCell>Region ID</TableHeaderCell>
              <TableHeaderCell>Region Name</TableHeaderCell>
              <TableHeaderCell>Warehouse Address</TableHeaderCell>
              <TableHeaderCell>Status</TableHeaderCell>
            </TableRow>
          </TableHead>
          <TableBody>
            <TableRow v-for="region in regions" :key="region.id">
              <TableCell>{{ region.id }}</TableCell>
              <TableCell>{{ region.name }}</TableCell>
              <TableCell>{{ region.warehouseAddress }}</TableCell>
              <TableCell>{{ region.status }}</TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>
  </EmployeeLayout>
</template>