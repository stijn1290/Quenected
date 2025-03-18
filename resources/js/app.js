import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';

const appName = import.meta.env.VITE_APP_NAME || 'quenected';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue', { eager: true })),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        // Improved Preloading Directive
        app.directive('preload', {
            beforeMount(el, binding) {
                el.addEventListener('mouseenter', async () => {
                    const pages = import.meta.glob('./Pages/**/*.vue');
                    const componentPath = `./Pages/${binding.value}.vue`;

                    if (pages[componentPath]) {
                        await pages[componentPath]();
                    }
                });
            },
        });

        return app.use(plugin).use(ZiggyVue).mount(el);
    },
    progress: {
        color: '#4B5563',
        delay: 250,
        showSpinner: false,
    },
});
