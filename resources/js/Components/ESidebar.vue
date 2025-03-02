<template>
  <div class="w-64 min-h-screen bg-gray-900 text-white flex flex-col">
      <!-- Logo -->
      <div class="p-4 flex items-center space-x-2">
          <ApplicationLogo class="w-8 h-8" />
          <h1 class="text-lg font-bold">LogiSys</h1>
      </div>

      <!-- Navigation Links -->
      <nav class="flex-1 px-2 space-y-1 mt-4">
          <NavLink
              v-for="link in filteredLinks"
              :key="link.name"
              :href="link.href"
              :active="route().current(link.route)"
              class="flex items-center space-x-3 p-2 rounded hover:bg-gray-700"
          >
              <span>{{ link.icon }}</span>
              <span>{{ link.name }}</span>
          </NavLink>
      </nav>

      <!-- Logout Button -->
      <div class="p-4 border-t border-gray-700">
          <DangerButton @click="logout" class="w-full">
              Logout
          </DangerButton>
      </div>
  </div>
</template>

<script setup>
import { usePage, router } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';
import DangerButton from '@/Components/DangerButton.vue';

const { props } = usePage();

// Get the user's role
const role = props.auth.user.role;

// Navigation Links by Role
const navLinks = {
  admin: [
      { name: 'Dashboard', href: '/admin/dashboard', route: 'admin.dashboard', icon: '🏠' },
      { name: 'Employees', href: '/admin/employees', route: 'admin.employees', icon: '👥' },
      { name: 'Customers', href: '/admin/customers', route: 'admin.customers', icon: '📋' },
      { name: 'Trucks', href: '/admin/trucks', route: 'admin.trucks', icon: '🚚' },
      { name: 'Cargo Assignment', href: '/admin/cargo', route: 'admin.cargo', icon: '📦' },
      { name: 'Package Tracking', href: '/admin/tracking', route: 'admin.tracking', icon: '🔍' },
      { name: 'Billing', href: '/admin/billing', route: 'admin.billing', icon: '💰' },
      { name: 'Payment Status', href: '/admin/payments', route: 'admin.payments', icon: '✅' },
      { name: 'Reports', href: '/admin/reports', route: 'admin.reports', icon: '📊' },
      { name: 'Settings', href: '/admin/settings', route: 'admin.settings', icon: '⚙️' },
  ],
  staff: [
      { name: 'Dashboard', href: '/staff/dashboard', route: 'staff.dashboard', icon: '🏠' },
      { name: 'Cargo Assignment', href: '/staff/cargo', route: 'staff.cargo', icon: '📦' },
      { name: 'Billing', href: '/staff/billing', route: 'staff.billing', icon: '💰' },
      { name: 'Waybill Report', href: '/staff/waybill', route: 'staff.waybill', icon: '📄' },
      { name: 'Truck Manifest', href: '/staff/manifest', route: 'staff.manifest', icon: '🚚' },
  ],
  driver: [
      { name: 'Dashboard', href: '/driver/dashboard', route: 'driver.dashboard', icon: '🏠' },
      { name: 'Assigned Deliveries', href: '/driver/deliveries', route: 'driver.deliveries', icon: '📦' },
      { name: 'Update Status', href: '/driver/update', route: 'driver.update', icon: '🔄' },
  ],
  collector: [
      { name: 'Dashboard', href: '/collector/dashboard', route: 'collector.dashboard', icon: '🏠' },
      { name: 'Payment Status', href: '/collector/payments', route: 'collector.payments', icon: '✅' },
      { name: 'Verify Payments', href: '/collector/verify', route: 'collector.verify', icon: '🔍' },
  ],
};

// Filter the links based on the user's role
const filteredLinks = navLinks[role] || [];

// Logout function
const logout = () => {
  router.post('/logout');
};
</script>

<style scoped>
/* Sidebar Hover Effect */
nav a:hover {
  transition: background-color 0.3s ease;
}
</style>
