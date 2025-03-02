<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Table, TableHead, TableRow, TableHeaderCell, TableBody, TableCell } from '@heroicons/vue/24/outline';

// Example archive data (replace with actual data from your backend)
const archives = [
  {
    id: 'A001',
    dataType: 'Receipts',
    archiveDate: '2023-10-01',
    retrievalStatus: 'Available',
  },
  // Add more archives here
];
</script>

<template>
  <Head title="Archive" />
  <EmployeeLayout>
    <div class="p-6">
      <h1 class="text-2xl font-semibold text-gray-900 mb-6">Archive</h1>
      <div class="overflow-x-auto bg-white rounded-lg shadow">
        <Table class="min-w-full">
          <TableHead>
            <TableRow>
              <TableHeaderCell>Archive ID</TableHeaderCell>
              <TableHeaderCell>Data Type</TableHeaderCell>
              <TableHeaderCell>Archive Date</TableHeaderCell>
              <TableHeaderCell>Retrieval Status</TableHeaderCell>
              <TableHeaderCell>Action</TableHeaderCell>
            </TableRow>
          </TableHead>
          <TableBody>
            <TableRow v-for="archive in archives" :key="archive.id">
              <TableCell>{{ archive.id }}</TableCell>
              <TableCell>{{ archive.dataType }}</TableCell>
              <TableCell>{{ archive.archiveDate }}</TableCell>
              <TableCell>{{ archive.retrievalStatus }}</TableCell>
              <TableCell>
                <button class="text-blue-500 hover:text-blue-700">Retrieve</button>
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>
  </EmployeeLayout>
</template>