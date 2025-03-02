<template>
  <div class="flex">
    <!-- Fixed Sidebar -->
    <div
      class="bg-gray-900 text-white flex flex-col w-64 h-screen fixed top-0 left-0"
    >
      <!-- Logo Section -->
      <div class="p-4 flex items-center space-x-2 border-b border-gray-700">
        <ApplicationLogo class="w-8 h-8" />
        <div class="flex items-center space-x-2">
          <h1 class="text-lg font-bold">Infinitrix</h1>
          <p class="text-lg font-bold text-gray-400">• {{ role }}</p>
        </div>
      </div>

      <!-- User Info Section -->
      <div v-if="authUser" class="p-4 border-b border-gray-700">
        <p class="text-base font-semibold">{{ authUser.name }}</p>
        <p class="text-sm text-gray-100">{{ authUser.email }}</p>
        <NavLink
          :href="route('profile.edit')"
          class="flex items-center p-3 rounded hover:bg-indigo-500 hover:text-white mt-3 w-full"
          :class="{ 'bg-gray-800 text-blue-400': route().current('profile.edit') }"
        >
          <span class="text-xl">👤</span>
          <span class="ml-4">My Profile</span>
        </NavLink>
      </div>

      <!-- Navigation Links -->
      <nav class="flex-1 p-4 space-y-4 overflow-y-auto">
        <NavLink
          v-for="link in filteredLinks"
          :key="link.name"
          :href="link.href"
          :active="route().current(link.route)"
          class="flex items-center p-3 rounded hover:bg-indigo-500 hover:text-white w-full"
          :class="{ 'bg-gray-800 text-blue-400': route().current(link.route) }"
        >
          <span class="text-xl">{{ link.icon }}</span>
          <span class="ml-4">{{ link.name }}</span>
        </NavLink>
      </nav>

      <!-- Logout Button -->
      <div class="p-4 border-t border-gray-700">
        <DangerButton @click="logout" class="w-full">Logout</DangerButton>
      </div>
    </div>

    <!-- Main Content (Scrollable) -->
    <div class="ml-64 flex-1 overflow-y-auto">
      <slot />
    </div>
  </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';
import DangerButton from '@/Components/DangerButton.vue';

const { props } = usePage();

// User Info
const authUser = props.auth?.user;

// User Role
const role = authUser?.role ?? 'guest';

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
  guest: [],
};

// Filter Links by User Role
const filteredLinks = navLinks[role] || [];

// Logout Function
const logout = () => {
  router.post('/logout');
};
</script>

<style scoped>
/* Smooth Transition for Sidebar */
div {
  transition: all 0.3s ease;
}

/* Ensure hover and active states are visible */
.nav-link:hover {
  background-color: #3e569c;
  color: #ffffff;
}

.nav-link.active {
  background-color: #2d3748;
  color: #63b3ed;
}
</style>
