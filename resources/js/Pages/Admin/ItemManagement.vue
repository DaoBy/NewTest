<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Table, TableHead, TableRow, TableHeaderCell, TableBody, TableCell } from '@heroicons/vue/24/outline';

// Example item data 
const items = [
  {
    id: 'I001',
    name: 'Carton Box',
    category: 'Carton',
    weight: '5 kg',
    volume: '0.1 m³',
  },
  // Add more items here
];
</script>

<template>
  <Head title="Item Management" />
  <EmployeeLayout>
    <div class="p-6">
      <h1 class="text-2xl font-semibold text-gray-900 mb-6">Item Management</h1>
      <div class="overflow-x-auto bg-white rounded-lg shadow">
        <Table class="min-w-full">
          <TableHead>
            <TableRow>
              <TableHeaderCell>Item ID</TableHeaderCell>
              <TableHeaderCell>Name</TableHeaderCell>
              <TableHeaderCell>Category</TableHeaderCell>
              <TableHeaderCell>Weight</TableHeaderCell>
              <TableHeaderCell>Volume</TableHeaderCell>
            </TableRow>
          </TableHead>
          <TableBody>
            <TableRow v-for="item in items" :key="item.id">
              <TableCell>{{ item.id }}</TableCell>
              <TableCell>{{ item.name }}</TableCell>
              <TableCell>{{ item.category }}</TableCell>
              <TableCell>{{ item.weight }}</TableCell>
              <TableCell>{{ item.volume }}</TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>
  </EmployeeLayout>
</template>