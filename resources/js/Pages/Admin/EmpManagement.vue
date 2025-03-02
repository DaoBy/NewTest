<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Table, TableHead, TableRow, TableHeaderCell, TableBody, TableCell } from '@heroicons/vue/24/outline';

// Example employee data 
const employees = [
  {
    id: 'E001',
    name: 'John Doe',
    contact: 'john.doe@example.com',
    address: '123 Main St, City',
    role: 'Admin',
  },
  // Add more employees here
];
</script>

<template>
  <Head title="Employee Management" />
  <EmployeeLayout>
    <div class="p-6">
      <h1 class="text-2xl font-semibold text-gray-900 mb-6">Employee Management</h1>
      <div class="overflow-x-auto bg-white rounded-lg shadow">
        <Table class="min-w-full">
          <TableHead>
            <TableRow>
              <TableHeaderCell>Employee ID</TableHeaderCell>
              <TableHeaderCell>Name</TableHeaderCell>
              <TableHeaderCell>Contact</TableHeaderCell>
              <TableHeaderCell>Address</TableHeaderCell>
              <TableHeaderCell>Role</TableHeaderCell>
            </TableRow>
          </TableHead>
          <TableBody>
            <TableRow v-for="employee in employees" :key="employee.id">
              <TableCell>{{ employee.id }}</TableCell>
              <TableCell>{{ employee.name }}</TableCell>
              <TableCell>{{ employee.contact }}</TableCell>
              <TableCell>{{ employee.address }}</TableCell>
              <TableCell>{{ employee.role }}</TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>
  </EmployeeLayout>
</template>