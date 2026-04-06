<template>
    <AppLayout title="Analytics">
        <div class="py-10 bg-gray-50/50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                
                <div class="relative bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 transition-all duration-400 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:-translate-y-1 group overflow-hidden">
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-indigo-50 rounded-full blur-3xl opacity-60 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600">
                                    Commands per Hour
                                </h2>
                                <p class="text-sm text-gray-500 mt-1 font-medium">Real-time execution metrics</p>
                            </div>
                            <div class="p-3 bg-indigo-50/80 rounded-xl text-indigo-600 shadow-sm border border-indigo-100/50">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="min-h-[350px] relative w-full">
                            <Transition name="fade-slide" mode="out-in">
                                <div v-if="hourlyLoading" class="absolute inset-0 flex flex-col items-center justify-center space-y-4">
                                    <div class="relative">
                                        <div class="w-14 h-14 rounded-full border-4 border-indigo-50"></div>
                                        <div class="w-14 h-14 rounded-full border-4 border-indigo-600 border-t-transparent animate-spin absolute top-0 left-0 drop-shadow-md"></div>
                                    </div>
                                    <span class="text-sm font-semibold text-indigo-600 tracking-wide animate-pulse">Syncing Telemetry...</span>
                                </div>
                                
                                <div v-else-if="hourlyError" class="absolute inset-0 flex items-center justify-center">
                                    <div class="bg-red-50 text-red-600 px-6 py-4 rounded-xl border border-red-100 flex items-center shadow-sm max-w-md w-full animate-shake">
                                        <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="font-medium">{{ hourlyError }}</span>
                                    </div>
                                </div>

                                <div v-else class="w-full h-full">
                                    <CommandChart :data="hourlyStats" class="w-full h-full animate-fade-in-up" />
                                </div>
                            </Transition>
                        </div>
                    </div>
                </div>

                <div class="relative bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 transition-all duration-400 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:-translate-y-1 group overflow-hidden">
                    <div class="absolute -bottom-24 -left-24 w-64 h-64 bg-purple-50 rounded-full blur-3xl opacity-60 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-8">
                            <div>
                                <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600">
                                    Top Users
                                </h2>
                                <p class="text-sm text-gray-500 mt-1 font-medium">Highest activity and engagement</p>
                            </div>
                            <div class="p-3 bg-purple-50/80 rounded-xl text-purple-600 shadow-sm border border-purple-100/50">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="min-h-[300px] relative w-full">
                            <Transition name="fade-slide" mode="out-in">
                                <div v-if="topLoading" class="absolute inset-0 flex flex-col items-center justify-center space-y-4">
                                    <div class="relative">
                                        <div class="w-14 h-14 rounded-full border-4 border-purple-50"></div>
                                        <div class="w-14 h-14 rounded-full border-4 border-purple-600 border-t-transparent animate-spin absolute top-0 left-0 drop-shadow-md"></div>
                                    </div>
                                    <span class="text-sm font-semibold text-purple-600 tracking-wide animate-pulse">Fetching Leaders...</span>
                                </div>

                                <div v-else-if="topError" class="absolute inset-0 flex items-center justify-center">
                                    <div class="bg-red-50 text-red-600 px-6 py-4 rounded-xl border border-red-100 flex items-center shadow-sm max-w-md w-full animate-shake">
                                        <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span class="font-medium">{{ topError }}</span>
                                    </div>
                                </div>

                                <div v-else class="w-full h-full">
                                    <TopUsers :users="topUsers" class="w-full h-full animate-fade-in-up" />
                                </div>
                            </Transition>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import CommandChart from '@/Components/CommandChart.vue';
import TopUsers from '@/Components/TopUsers.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const hourlyStats = ref([]);
const hourlyLoading = ref(false);
const hourlyError = ref(null);
const topUsers = ref([]);
const topLoading = ref(false);
const topError = ref(null);

async function fetchHourly() {
    hourlyLoading.value = true;
    hourlyError.value = null; // Reset error state on new fetch
    try {
        const res = await axios.get('/api/hourly-stats');
        hourlyStats.value = res.data;
    } catch (err) {
        hourlyError.value = 'Failed to load hourly stats. Please try again.';
    } finally {
        hourlyLoading.value = false;
    }
}

async function fetchTopUsers() {
    topLoading.value = true;
    topError.value = null; // Reset error state on new fetch
    try {
        const res = await axios.get('/api/top-users?limit=10');
        topUsers.value = res.data;
    } catch (err) {
        topError.value = 'Failed to load top users. Please try again.';
    } finally {
        topLoading.value = false;
    }
}

onMounted(() => {
    fetchHourly();
    fetchTopUsers();
});
</script>

<style scoped>
/* Vue Transition Component Animations */
.fade-slide-enter-active,
.fade-slide-leave-active {
    transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
}
.fade-slide-enter-from {
    opacity: 0;
    transform: translateY(15px) scale(0.98);
}
.fade-slide-leave-to {
    opacity: 0;
    transform: translateY(-15px) scale(0.98);
}

/* Custom Keyframe Animations for Internal UI Elements */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-4px); }
    20%, 40%, 60%, 80% { transform: translateX(4px); }
}

.animate-fade-in-up {
    animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}

.animate-shake {
    animation: shake 0.5s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
}
</style>