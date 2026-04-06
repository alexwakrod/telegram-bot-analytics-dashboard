<template>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Commands</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <tr v-for="user in users" :key="user.user_id" class="hover:bg-gray-50 transition duration-150">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ user.user_id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">{{ user.total }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script setup>
defineProps(['users']);
</script>