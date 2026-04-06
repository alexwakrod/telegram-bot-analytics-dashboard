<template>
    <Head title="Welcome to the Core" />
    
    <div class="relative min-h-screen bg-[#050505] text-gray-300 selection:bg-indigo-500 selection:text-white overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full overflow-hidden pointer-events-none">
            <div class="absolute -top-[10%] -left-[10%] w-[40%] h-[40%] bg-indigo-900/20 rounded-full blur-[120px] animate-pulse"></div>
            <div class="absolute top-[20%] -right-[5%] w-[30%] h-[30%] bg-emerald-900/10 rounded-full blur-[120px]"></div>
        </div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 lg:px-8">
            <header class="flex justify-between items-center py-8">
                <div class="flex items-center space-x-3 group">
                    <div class="w-10 h-10 bg-gradient-to-br from-indigo-600 to-violet-700 rounded-xl flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:rotate-12 transition-transform duration-300">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <span class="text-xl font-black tracking-tighter text-white uppercase">Nexus<span class="text-indigo-500">Core</span></span>
                </div>

                <nav v-if="canLogin" class="flex items-center space-x-6">
                    <Link
                        v-if="$page.props.auth.user"
                        :href="route('dashboard')"
                        class="text-sm font-bold text-white bg-white/5 hover:bg-white/10 px-5 py-2.5 rounded-xl border border-white/10 transition-all"
                    >
                        Enter Dashboard
                    </Link>

                    <template v-else>
                        <Link :href="route('login')" class="text-sm font-medium hover:text-white transition-colors">Log in</Link>
                        <Link
                            v-if="canRegister"
                            :href="route('register')"
                            class="text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-500 px-5 py-2.5 rounded-xl shadow-lg shadow-indigo-500/20 transition-all active:scale-95"
                        >
                            Get Started
                        </Link>
                    </template>
                </nav>
            </header>

            <main class="mt-16 lg:mt-24 pb-20">
                <div class="text-center max-w-3xl mx-auto mb-20 animate-fade-in-up">
                    <h1 class="text-5xl lg:text-7xl font-black text-white tracking-tight mb-6">
                        Automate Everything with <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-400 to-emerald-400">Precision.</span>
                    </h1>
                    <p class="text-lg text-gray-400 leading-relaxed">
                        The ultimate command center for moderation, reminders, and ecosystem management. Built for speed, scaled for performance.
                    </p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    
                    <div class="group p-8 rounded-3xl bg-[#0A0A0A] border border-white/5 hover:border-indigo-500/50 transition-all duration-500 animate-fade-in-up" style="animation-delay: 0.1s;">
                        <div class="w-12 h-12 bg-indigo-500/10 rounded-2xl flex items-center justify-center text-indigo-400 mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 8v8m-4-5v5m-4-2v2m-2 4h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Live Analytics</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Track command usage and server heatmaps in real-time with zero latency overhead.</p>
                    </div>

                    <div class="group p-8 rounded-3xl bg-[#0A0A0A] border border-white/5 hover:border-emerald-500/50 transition-all duration-500 animate-fade-in-up" style="animation-delay: 0.2s;">
                        <div class="w-12 h-12 bg-emerald-500/10 rounded-2xl flex items-center justify-center text-emerald-400 mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Auto-Moderation</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Define complex rules and safety thresholds to keep your community secure 24/7.</p>
                    </div>

                    <div class="group p-8 rounded-3xl bg-[#0A0A0A] border border-white/5 hover:border-violet-500/50 transition-all duration-500 animate-fade-in-up" style="animation-delay: 0.3s;">
                        <div class="w-12 h-12 bg-violet-500/10 rounded-2xl flex items-center justify-center text-violet-400 mb-6 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Vibrant Ecosystem</h3>
                        <p class="text-sm text-gray-500 leading-relaxed">Integrated tools for reminders, game-linked commands, and automated reporting.</p>
                    </div>

                </div>
            </main>

            <footer class="py-12 border-t border-white/5 flex flex-col md:flex-row justify-between items-center gap-4 text-xs font-mono tracking-widest text-gray-600 uppercase">
                <div class="flex items-center space-x-4">
                    <span>Laravel v{{ laravelVersion }}</span>
                    <span class="w-1 h-1 bg-gray-800 rounded-full"></span>
                    <span>PHP v{{ phpVersion }}</span>
                </div>
                <div>&copy; 2026 NexusCore System. All Rights Reserved.</div>
            </footer>
        </div>
    </div>
</template>

<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<style scoped>
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in-up {
    animation: fadeInUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    opacity: 0;
}
</style>