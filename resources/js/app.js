import './bootstrap';
import '../css/app.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { createPinia } from 'pinia';
import { Link } from '@inertiajs/vue3';
import VueApexCharts from 'vue3-apexcharts';  // <-- ADD THIS

const appName = import.meta.env.VITE_APP_NAME || 'NexusCore';
const pinia = createPinia();

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(pinia)
            .use(ZiggyVue);

        // Register global components
        app.component('Link', Link);
        app.component('apexchart', VueApexCharts);  // <-- ADD THIS

        app.mount(el);
    },
    progress: {
        color: '#4f46e5',
        includeCSS: true,
        showSpinner: false,
    },
});