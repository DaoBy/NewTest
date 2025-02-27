<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { router } from '@inertiajs/vue3';

import { ShieldCheckIcon, BriefcaseIcon, TruckIcon, HandRaisedIcon } from '@heroicons/vue/24/solid';

const selectRole = (role) => {
    router.get('/employee/login', { role: role });
};

const registerEmployee = () => {
    router.visit(route('employee.register'));
};
</script>


<template>
    
        <div class="flex items-center justify-center min-h-screen bg-gray-100 dark:bg-gray-900">
            <div class="w-full max-w-md p-6 bg-white dark:bg-gray-800 shadow-md rounded-md">
                <h2 class="text-2xl font-bold text-center text-gray-900 dark:text-white mb-4">
                    Select Your Role
                </h2>

                <!-- 2x2 Grid Layout -->
                <div class="grid grid-cols-2 gap-4">
                    <!-- Admin -->
                    <button @click="selectRole('admin')" class="flex flex-col items-center p-4 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition">
                        <ShieldCheckIcon class="w-8 h-8" />
                        <span>Admin</span>
                    </button>

                    <!-- Staff -->
                    <button @click="selectRole('staff')" class="flex flex-col items-center p-4 bg-green-500 text-white rounded-md hover:bg-green-600 transition">
                        <BriefcaseIcon class="w-8 h-8" />
                        <span>Staff</span>
                    </button>

                    <!-- Driver -->
                    <button @click="selectRole('driver')" class="flex flex-col items-center p-4 bg-yellow-500 text-white rounded-md hover:bg-yellow-600 transition">
                        <TruckIcon class="w-8 h-8" />
                        <span>Driver</span>
                    </button>

                    <!-- Collector -->
                    <button @click="selectRole('collector')" class="flex flex-col items-center p-4 bg-purple-500 text-white rounded-md hover:bg-purple-600 transition">
                        <HandRaisedIcon class="w-8 h-8" />
                        <span>Collector</span>
                    </button>
                </div>

                <!-- Register Button (Separate Below) -->
                <div class="mt-6">
                    <button @click="registerEmployee" class="w-full px-6 py-3 bg-indigo-600 text-white rounded-md hover:bg-indigo-700 transition">
                        Register as Employee
                    </button>
                </div>
            </div>
        </div>
    
</template>

