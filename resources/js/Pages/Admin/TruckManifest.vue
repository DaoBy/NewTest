<script setup>
import EmployeeLayout from '@/Layouts/EmployeeLayout.vue';
import { Head } from '@inertiajs/vue3';
import { Table, TableHead, TableRow, TableHeaderCell, TableBody, TableCell } from '@heroicons/vue/24/outline';

// Example truck manifest data 
const manifests = [
  {
    id: 'TM001',
    truckPlateNumber: 'ABC123',
    shipmentDate: '2023-10-01',
    packageInfo: '2 Carton Boxes',
    recipientInfo: 'John Doe',
    waybillReference: 'WB001',
  },
  // Add more manifests here
];
</script>

<template>
  <Head title="Truck Manifest" />
  <EmployeeLayout>
    <div class="p-6">
      <h1 class="text-2xl font-semibold text-gray-900 mb-6">Truck Manifest</h1>
      <div class="overflow-x-auto bg-white rounded-lg shadow">
        <Table class="min-w-full">
          <TableHead>
            <TableRow>
              <TableHeaderCell>Manifest ID</TableHeaderCell>
              <TableHeaderCell>Truck Plate Number</TableHeaderCell>
              <TableHeaderCell>Shipment Date</TableHeaderCell>
              <TableHeaderCell>Package Info</TableHeaderCell>
              <TableHeaderCell>Recipient Info</TableHeaderCell>
              <TableHeaderCell>Waybill Reference</TableHeaderCell>
            </TableRow>
          </TableHead>
          <TableBody>
            <TableRow v-for="manifest in manifests" :key="manifest.id">
              <TableCell>{{ manifest.id }}</TableCell>
              <TableCell>{{ manifest.truckPlateNumber }}</TableCell>
              <TableCell>{{ manifest.shipmentDate }}</TableCell>
              <TableCell>{{ manifest.packageInfo }}</TableCell>
              <TableCell>{{ manifest.recipientInfo }}</TableCell>
              <TableCell>{{ manifest.waybillReference }}</TableCell>
            </TableRow>
          </TableBody>
        </Table>
      </div>
    </div>
  </EmployeeLayout>
</template>