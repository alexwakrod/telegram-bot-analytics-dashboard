<template>
    <apexchart type="line" height="350" :options="chartOptions" :series="series" />
</template>

<script setup>
import { computed } from 'vue';
import VueApexCharts from 'vue3-apexcharts';

const props = defineProps({
    data: Array, // [{ hour: 0, total: 15 }]
});

const series = computed(() => [{
    name: 'Commands',
    data: props.data.map(d => d.total),
}]);

const chartOptions = computed(() => ({
    chart: {
        toolbar: { show: false },
        animations: { enabled: true, easing: 'easeinout', speed: 800 },
    },
    xaxis: { categories: props.data.map(d => `${d.hour}:00`) },
    title: { text: 'Command Frequency by Hour', style: { fontSize: '14px', fontWeight: 'bold' } },
    stroke: { curve: 'smooth', width: 2 },
    colors: ['#4F46E5'],
    tooltip: { theme: 'dark' },
}));
</script>