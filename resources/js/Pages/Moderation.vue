<template>
    <AppLayout title="Moderation">
        <div class="py-10 bg-gray-50/50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                
                <div class="bg-white rounded-2xl shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-gray-100 overflow-hidden animate-fade-in">
                    
                    <div class="p-8 border-b border-gray-100 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-gradient-to-r from-white to-gray-50/50">
                        <div>
                            <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Auto-Moderation Rules</h2>
                            <p class="text-sm text-gray-500 mt-1 font-medium">Define automated triggers and safety thresholds</p>
                        </div>
                        <button 
                            @click="showForm = !showForm" 
                            class="inline-flex items-center px-5 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-xl shadow-md shadow-indigo-200 transition-all duration-200 active:scale-95 group"
                        >
                            <svg class="w-5 h-5 mr-2 group-hover:rotate-90 transition-transform duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                            </svg>
                            Add New Rule
                        </button>
                    </div>

                    <div class="p-8">
                        <Transition name="expand">
                            <div v-if="showForm" class="mb-8 p-6 rounded-2xl bg-indigo-50/30 border border-indigo-100/50 backdrop-blur-sm">
                                <h3 class="text-indigo-900 font-bold mb-4 flex items-center">
                                    <span class="w-2 h-2 bg-indigo-500 rounded-full mr-2"></span>
                                    Create Rule
                                </h3>
                                <ModerationRuleForm :rule="null" @saved="fetchRules" @cancel="showForm = false" />
                            </div>
                        </Transition>

                        <Transition name="expand">
                            <div v-if="editingRule" class="mb-8 p-6 rounded-2xl bg-amber-50/30 border border-amber-100/50 backdrop-blur-sm">
                                <h3 class="text-amber-900 font-bold mb-4 flex items-center">
                                    <span class="w-2 h-2 bg-amber-500 rounded-full mr-2"></span>
                                    Edit Rule: {{ editingRule.rule_type }}
                                </h3>
                                <ModerationRuleForm :rule="editingRule" @saved="fetchRules" @cancel="editingRule = null" />
                            </div>
                        </Transition>

                        <div v-if="loading" class="flex flex-col items-center justify-center py-20">
                            <div class="relative w-12 h-12">
                                <div class="w-12 h-12 rounded-full border-4 border-indigo-50"></div>
                                <div class="w-12 h-12 rounded-full border-4 border-indigo-600 border-t-transparent animate-spin absolute top-0"></div>
                            </div>
                            <p class="mt-4 text-sm font-medium text-indigo-600 animate-pulse">Loading Security Protocols...</p>
                        </div>

                        <div v-else-if="error" class="text-center py-12 bg-red-50 rounded-2xl border border-red-100">
                            <div class="text-red-500 font-semibold">{{ error }}</div>
                            <button @click="fetchRules" class="mt-4 text-sm text-red-600 underline hover:no-underline">Try again</button>
                        </div>

                        <div v-else class="overflow-x-auto rounded-xl border border-gray-100">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-gray-50/80">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Type</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Threshold</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Duration</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-400 uppercase tracking-widest">Status</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-gray-400 uppercase tracking-widest">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-50">
                                    <tr v-for="rule in rules" :key="rule.id" class="hover:bg-indigo-50/30 transition-colors duration-150 group">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="text-sm font-bold text-gray-700 capitalize group-hover:text-indigo-700 transition-colors">{{ rule.rule_type }}</span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-lg text-xs font-bold bg-gray-100 text-gray-600">
                                                {{ rule.threshold }} units
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                            {{ rule.duration_minutes ? rule.duration_minutes + ' min' : 'Permanent' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span 
                                                class="px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-tighter shadow-sm border"
                                                :class="rule.enabled ? 'bg-emerald-50 text-emerald-600 border-emerald-100' : 'bg-rose-50 text-rose-600 border-rose-100'"
                                            >
                                                {{ rule.enabled ? 'Active' : 'Disabled' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <div class="flex justify-end items-center space-x-3">
                                                <button @click="editRule(rule)" class="text-indigo-500 hover:text-indigo-700 p-2 hover:bg-white rounded-lg transition-all shadow-sm shadow-transparent hover:shadow-gray-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" stroke-width="2" /></svg>
                                                </button>
                                                <button @click="deleteRule(rule.id)" class="text-rose-400 hover:text-rose-600 p-2 hover:bg-white rounded-lg transition-all shadow-sm shadow-transparent hover:shadow-gray-200">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" stroke-width="2" /></svg>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            
                            <div v-if="rules.length === 0" class="text-center py-12">
                                <div class="text-gray-300 mb-2">No moderation rules found.</div>
                                <div class="text-xs text-gray-400">Click "+ Add Rule" to get started.</div>
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
import ModerationRuleForm from '@/Components/ModerationRuleForm.vue';
import { ref, onMounted } from 'vue';
import axios from 'axios';

const rules = ref([]);
const showForm = ref(false);
const editingRule = ref(null);
const loading = ref(false);
const error = ref(null);

async function fetchRules() {
    loading.value = true;
    error.value = null;
    try {
        const res = await axios.get('/api/moderation-rules');
        rules.value = res.data;
    } catch (err) {
        error.value = 'Security module failed to synchronize.';
        console.error(err);
    } finally {
        loading.value = false;
        showForm.value = false;
        editingRule.value = null;
    }
}

async function deleteRule(id) {
    // Custom confirm could be added later for better UI
    if (!confirm('This action will disable this security rule. Proceed?')) return;
    try {
        await axios.delete(`/api/moderation-rules/${id}`);
        await fetchRules();
    } catch (err) {
        alert('Critical error during deletion.');
    }
}

function editRule(rule) {
    showForm.value = false; // Close "Add" form if open
    editingRule.value = rule;
}

onMounted(fetchRules);
</script>

<style scoped>
/* Page Entry Animation */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in {
    animation: fadeIn 0.5s ease-out forwards;
}

/* Form Expand/Collapse Animation */
.expand-enter-active, .expand-leave-active {
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    max-height: 500px;
}
.expand-enter-from, .expand-leave-to {
    opacity: 0;
    max-height: 0;
    transform: scale(0.98);
    margin-bottom: 0;
    padding-top: 0;
    padding-bottom: 0;
}
</style>