import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3'
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';

import BaseLayout from './Layouts/Base.vue';
import components from './components.js';

createInertiaApp({
    resolve: async (name) => {
        let page = await resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue'));

        return {
            ...page.default,
            layout: BaseLayout
        };
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(components)
            .mount(el);
    },
})
