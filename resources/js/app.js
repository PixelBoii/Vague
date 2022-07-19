import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

import BaseLayout from './Layouts/Base.vue';
import components from './components.js';

InertiaProgress.init();

createInertiaApp({
    resolve: async (name) => {
        let page = await resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'));

        return {
            ...page.default,
            layout: BaseLayout
        };
    },
    setup({ el, app, props, plugin }) {
        var app = createApp({ render: () => h(app, props) }).use(plugin).use(components).mount(el);
    },
})
