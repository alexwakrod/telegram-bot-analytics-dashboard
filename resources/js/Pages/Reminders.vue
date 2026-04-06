<template>
    <AppLayout title="Reminders">
        <div class="py-10 bg-gray-50/50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden animate-fade-in">
                    
                    <div class="p-8 border-b border-gray-100 flex items-center justify-between bg-gradient-to-r from-white to-gray-50/30">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 tracking-tight flex items-center">
                                <svg class="w-6 h-6 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Active Reminders
                            </h2>
                            <p class="text-sm text-gray-500 mt-1 font-medium">Upcoming scheduled notifications and alerts</p>
                        </div>
                        
                        <div class="hidden sm:block">
                            <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-xs font-bold rounded-full border border-indigo-100">
                                {{ reminders.length }} Pending
                            </span>
                        </div>
                    </div>

                    <div class="p-6">
                        <div v-if="loading" class="flex flex-col items-center justify-center py-20">
                            <div class="relative w-12 h-12">
                                <div class="w-12 h-12 rounded-full border-4 border-indigo-50"></div>
                                <div class="w-12 h-12 rounded-full border-4 border-indigo-600 border-t-transparent animate-spin absolute top-0"></div>
                            </div>
                            <p class="mt-4 text-sm font-medium text-indigo-600 animate-pulse font-mono tracking-widest">FETCHING_QUEUED_TASKS</p>
                        </div>

                        <div v-else-if="error" class="text-center py-12">
                            <div class="inline-flex p-4 rounded-full bg-red-50 text-red-600 mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900">{{ error }}</h3>
                            <button @click="fetchReminders" class="mt-4 text-sm font-bold text-indigo-600 hover:text-indigo-800 transition-colors">Re-attempt Sync</button>
                        </div>

                        <div v-else class="overflow-hidden border border-gray-100 rounded-xl">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50/80">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Recurrence</th>
                                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Timestamp</th>
                                        <th class="px-6 py-4 text-left text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Payload / Message</th>
                                        <th class="px-6 py-4 text-right text-[10px] font-bold text-gray-400 uppercase tracking-[0.2em]">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-50">
                                    <TransitionGroup name="list">
                                        <tr v-for="rem in reminders" :key="rem.id" class="hover:bg-indigo-50/30 transition-all duration-200 group">
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="w-8 h-8 rounded-lg bg-gray-100 text-gray-500 flex items-center justify-center text-xs font-bold group-hover:bg-indigo-100 group-hover:text-indigo-600 transition-colors">
                                                        ID
                                                    </div>
                                                    <span class="ml-3 text-sm font-bold text-gray-700 tracking-tight">#{{ rem.user_id }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap">
                                                <div class="flex flex-col">
                                                    <span class="text-sm font-semibold text-gray-900">{{ new Date(rem.remind_at).toLocaleDateString() }}</span>
                                                    <span class="text-xs text-gray-500 font-mono">{{ new Date(rem.remind_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'}) }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5">
                                                <div class="max-w-md">
                                                    <p class="text-sm text-gray-600 leading-relaxed font-medium line-clamp-2 italic group-hover:text-gray-900 transition-colors">
                                                        "{{ rem.message }}"
                                                    </p>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 whitespace-nowrap text-right">
                                                <button 
                                                    @click="deleteReminder(rem.id)" 
                                                    class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-bold rounded-lg text-rose-600 bg-rose-50 hover:bg-rose-100 hover:text-rose-700 transition-all active:scale-95"
                                                >
                                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" /></svg>
                                                    Discard
                                                </button>
                                            </td>
                                        </tr>
                                    </TransitionGroup>
                                </tbody>
                            </table>
                            
                            <div v-if="reminders.length === 0" class="flex flex-col items-center justify-center py-24 bg-white">
                                <div class="w-20 h-20 bg-gray-50 rounded-full flex items-center justify-center mb-4">
                                    <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                </div>
                                <h3 class="text-gray-400 font-bold uppercase tracking-widest text-sm">Silence is Golden</h3>
                                <p class="text-xs text-gray-400 mt-1">No pending reminders are currently in the queue.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const reminders = ref([]);
const loading = ref(false);
const error = ref(null);

async function fetchReminders() {
    loading.value = true;
    error.value = null;
    try {
        const res = await axios.get('/api/reminders');
        reminders.value = res.data;
    } catch (err) {
        error.value = 'Failed to load transmission schedule.';
    } finally {
        loading.value = false;
    }
}

async function deleteReminder(id) {
    if (!confirm('This will purge the scheduled reminder. Confirm?')) return;
    try {
        await axios.delete(`/api/reminders/${id}`);
        await fetchReminders();
    } catch (err) {
        alert('Action failed: Record could not be removed.');
    }
}

onMounted(fetchReminders);
</script>

<style scoped>
/* Page Entrance */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fadeIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

/* Row List Transitions */
.list-enter-active,
.list-leave-active {
    transition: all 0.4s ease;
}
.list-enter-from {
    opacity: 0;
    transform: translateX(30px);
}
.list-leave-to {
    opacity: 0;
    transform: translateX(-30px);
}
</style>