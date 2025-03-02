<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Table, TableHead, TableRow, TableHeaderCell, TableBody, TableCell } from '@heroicons/vue/24/outline';

// Example backup data 
const backups = [
  {
    id: 'B001',
    backupDate: '2023-10-01 12:00',
    fileLocation: '/backups/backup_20231001.sql',
  },
  // Add more backups here
];
</script>

<template>
  <Head title="Backup & Restore" />
  <EmployeeLayout>
    <div class="p-6">
      <h1 class="text-2xl font-semibold text-gray-900 mb-6">Backup & Restore</h1>
      <div class="overflow-x-auto bg-white rounded-lg shadow">
        <Table class="min-w-full">
          <TableHead>
            <TableRow>
              <TableHeaderCell>Backup ID</TableHeaderCell>
              <TableHeaderCell>Backup Date</TableHeaderCell>
              <TableHeaderCell>File Location</TableHeaderCell>
              <TableHeaderCell>Action</TableHeaderCell>
            </TableRow>
          </TableHead>
          <TableBody>
            <TableRow v-for="backup in backups" :key="backup.id">
              <TableCell>{{ backup.id }}</TableCell>
              <TableCell>{{ backup.backupDate }}</TableCell>
              <TableCell>{{ backup.fileLocation }}</TableCell>
              <TableCell>
                <button class="text-blue-500 hover:text-blue-700">Restore</button>
              </TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>
  </EmployeeLayout>
</template>