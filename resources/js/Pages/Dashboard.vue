<template>
    <AppLayout title="Dashboard">
        <div class="py-10 bg-gray-50/50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div class="relative bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 p-8 transition-all duration-400 hover:shadow-[0_8px_30px_rgb(0,0,0,0.08)] hover:-translate-y-1 group overflow-hidden animate-fade-in-up">
                    
                    <div class="absolute -top-24 -right-24 w-64 h-64 bg-emerald-50 rounded-full blur-3xl opacity-60 group-hover:opacity-100 transition-opacity duration-700 pointer-events-none"></div>

                    <div class="relative z-10">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between mb-8 gap-4">
                            <div>
                                <h2 class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-gray-900 to-gray-600">
                                    Command Usage Heatmap
                                </h2>
                                <div class="flex items-center mt-2 space-x-2">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        Last 365 Days
                                    </span>
                                    <p class="text-sm text-gray-500 font-medium">Historical execution frequency</p>
                                </div>
                            </div>
                            
                            <div class="p-3 bg-emerald-50/80 rounded-xl text-emerald-600 shadow-sm border border-emerald-100/50 flex-shrink-0 w-fit">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3v18h18M9 9h6v6H9zM15 3h6v6h-6zM3 15h6v6H3z"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="w-full relative bg-gray-50/30 rounded-xl p-2 border border-gray-50">
                            <Heatmap class="w-full" />
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </AppLayout>
</template>

<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Heatmap from '@/Components/Heatmap.vue';
</script>

<style scoped>
/* Custom Keyframe Animations for UI Elements */
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

.animate-fade-in-up {
    animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
}
</style>