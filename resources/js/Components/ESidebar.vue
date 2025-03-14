<template>
  <!-- Sidebar (Dynamic Width & Fully Optimized) -->
  <div
    :class="[
      'bg-gray-900 text-white flex flex-col transition-all duration-300',
      isSidebarOpen ? 'w-64' : 'w-20',
    ]"
    :style="{ height: '100vh' }"
  >
   <!-- Logo (Clickable to Toggle Sidebar) -->
<div
  class="p-4 flex items-center space-x-2 border-b border-gray-700 cursor-pointer"
  @click="toggleSidebar"
>
  <!-- Ensure the logo size is consistent -->
  <ApplicationLogo :class="isSidebarOpen ? 'w-12 h-11' : 'w-12 h-11'" />
  <div v-if="isSidebarOpen" class="flex items-center space-x-2">
    <!-- Ensure proper alignment of text -->
    <h1 class="text-lg font-bold">{{ role }}</h1>
    <p class="text-lg font-bold text-gray-400"></p>
  </div>
</div>

<!-- User Info Section -->
<div v-if="authUser" class="p-4 border-b border-gray-700">
  <p v-if="isSidebarOpen" class="text-base font-semibold">{{ authUser.name }}</p>
  <p v-if="isSidebarOpen" class="text-sm text-gray-100">{{ authUser.email }}</p>
  <NavLink
    :href="route('profile.edit')"
    class="flex items-center p-3 rounded hover:bg-indigo-500 hover:text-white mt-3 w-full"
    :class="{ 'bg-gray-800 text-blue-400': route().current('profile.edit') }"
  >
    <!-- Ensure the icon size matches the ApplicationLogo size -->
    <v-icon :size="isSidebarOpen ? '24px' : '20px'">mdi-account</v-icon>
    <span v-if="isSidebarOpen" class="ml-4">My Profile</span>
  </NavLink>
</div>

    <!-- Navigation Links (Role-Specific & Stacked) -->
    <nav class="flex-1 p-4 space-y-4 flex flex-col overflow-y-auto">
      <NavLink
        v-for="link in filteredLinks"
        :key="link.name"
        :href="link.href"
        :active="route().current(link.route)"
        class="flex items-center p-3 rounded hover:bg-indigo-500 hover:text-white w-full"
        :class="{ 'bg-gray-800 text-blue-400': route().current(link.route) }"
      >
        <v-icon>{{ link.icon }}</v-icon>
        <span v-if="isSidebarOpen" class="ml-4">{{ link.name }}</span>
      </NavLink>
    </nav>

    <!-- Logout Button -->
    <div class="p-4 border-t border-gray-700">
      <DangerButton @click="logout" class="w-full">
        <v-icon>mdi-logout</v-icon>
        <span v-if="isSidebarOpen" class="ml-2">Logout</span>
      </DangerButton>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { usePage, router } from '@inertiajs/vue3';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import NavLink from '@/Components/NavLink.vue';
import DangerButton from '@/Components/DangerButton.vue';

const { props } = usePage();

// Sidebar State (Persistent using localStorage)
const isSidebarOpen = ref(true);

const toggleSidebar = () => {
  isSidebarOpen.value = !isSidebarOpen.value;
  localStorage.setItem('sidebarOpen', isSidebarOpen.value);
};

onMounted(() => {
  const savedState = localStorage.getItem('sidebarOpen');
  isSidebarOpen.value = savedState === 'true';
});

// User Info
const authUser = props.auth?.user;

// User Role
const role = authUser?.role ?? 'guest';

// Navigation Links by Role (Updated with MDI Icons)
const navLinks = {
  admin: [
    { name: 'Dashboard', href: '/admin/dashboard', route: 'admin.dashboard', icon: 'mdi-home' },
    { name: 'Employees', href: '/admin/employees', route: 'admin.employees', icon: 'mdi-account-group' },
    { name: 'Customers', href: '/admin/customers', route: 'admin.customers', icon: 'mdi-account-box' },
    { name: 'Trucks', href: '/admin/trucks', route: 'admin.trucks', icon: 'mdi-truck' },
    { name: 'Cargo Assignment', href: '/admin/cargo', route: 'admin.cargo', icon: 'mdi-package-variant' },
    { name: 'Package Tracking', href: '/admin/tracking', route: 'admin.tracking', icon: 'mdi-magnify' },
    { name: 'Billing', href: '/admin/billing', route: 'admin.billing', icon: 'mdi-cash' },
    { name: 'Payment Status', href: '/admin/payments', route: 'admin.payments', icon: 'mdi-check' },
    { name: 'Reports', href: '/admin/reports', route: 'admin.reports', icon: 'mdi-chart-bar' },
    { name: 'Settings', href: '/admin/settings', route: 'admin.settings', icon: 'mdi-cog' },
  ],
  staff: [
    { name: 'Dashboard', href: '/staff/dashboard', route: 'staff.dashboard', icon: 'mdi-home' },
    { name: 'Cargo Assignment', href: '/staff/cargo', route: 'staff.cargo', icon: 'mdi-package-variant' },
    { name: 'Billing', href: '/staff/billing', route: 'staff.billing', icon: 'mdi-cash' },
    { name: 'Waybill Report', href: '/staff/waybill', route: 'staff.waybill', icon: 'mdi-file-document' },
    { name: 'Truck Manifest', href: '/staff/manifest', route: 'staff.manifest', icon: 'mdi-truck' },
  ],
  driver: [
    { name: 'Dashboard', href: '/driver/dashboard', route: 'driver.dashboard', icon: 'mdi-home' },
    { name: 'Assigned Deliveries', href: '/driver/deliveries', route: 'driver.deliveries', icon: 'mdi-package-variant' },
    { name: 'Update Status', href: '/driver/update', route: 'driver.update', icon: 'mdi-refresh' },
  ],
  collector: [
    { name: 'Dashboard', href: '/collector/dashboard', route: 'collector.dashboard', icon: 'mdi-home' },
    { name: 'Payment Status', href: '/collector/payments', route: 'collector.payments', icon: 'mdi-check' },
    { name: 'Verify Payments', href: '/collector/verify', route: 'collector.verify', icon: 'mdi-magnify' },
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
:deep(.flex.items-center.px-4.py-2.rounded-md.text-sm.font-medium.text-gray-500:hover) {
  background-color: #64142c; /* Adjust as needed */
  color: #ffffff;
}

:deep(.flex.items-center.px-4.py-2.rounded-md.text-sm.font-medium.text-white.bg-indigo-500) {
  background-color: #abb1bb; /* Adjust as needed */
  color: #63b3ed;
}

/* Ensure the sidebar doesn't overflow */
.overflow-y-auto {
  overflow-y: auto;
}

/* Adjust padding for collapsed state */
.w-20 .p-4 {
  padding: 0.9rem; /* Reduce padding when sidebar is collapsed */
}

/* Adjust icon size for collapsed state */
.w-16 .v-icon {
  font-size: 1.25rem; /* Ensure icons are consistent in size when sidebar is collapsed */
}

/* Ensure the logo and text are aligned properly */
.flex.items-center.space-x-2 {
  display: flex;
  align-items: center;
  gap: 0.8rem; /* Adjust spacing between logo and text */
}

/* Ensure the role text is aligned with the Infinitrix text */
.text-lg.font-bold.text-gray-400 {
  margin-left: 0.25rem; /* Adjust spacing between Infinitrix and role */
}
</style>