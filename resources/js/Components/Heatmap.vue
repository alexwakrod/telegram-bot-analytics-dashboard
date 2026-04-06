<template>
    <div v-if="loading" class="flex justify-center py-10">
        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-600"></div>
    </div>
    <div v-else-if="error" class="text-red-600 text-center py-10">
        {{ error }}
    </div>
    <CalendarHeatmap v-else :start-date="startDate" :end-date="endDate" :values="heatmapData" />
</template>

<script setup>
import { ref, computed, onMounted } from 'vue';
import { CalendarHeatmap } from '@silverwind/vue3-calendar-heatmap';
import axios from 'axios';
import '@silverwind/vue3-calendar-heatmap/dist/style.css';

const loading = ref(false);
const error = ref(null);
const heatmapData = ref([]);

const startDate = computed(() => {
    if (heatmapData.value.length) return heatmapData.value[0].date;
    const d = new Date();
    d.setFullYear(d.getFullYear() - 1);
    return d.toISOString().slice(0,10);
});
const endDate = computed(() => {
    if (heatmapData.value.length) return heatmapData.value[heatmapData.value.length-1].date;
    return new Date().toISOString().slice(0,10);
});

async function fetchData() {
    loading.value = true;
    try {
        const res = await axios.get('/api/heatmap');
        heatmapData.value = res.data;
    } catch (err) {
        error.value = 'Failed to load heatmap data.';
        console.error(err);
    } finally {
        loading.value = false;
    }
}

onMounted(fetchData);
</script>