import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress';

import BaseLayout from './Layouts/Base';
import components from './components';

InertiaProgress.init();

createInertiaApp({
    resolve: (name) => {
        var page = require(`./Pages/${name}.vue`).default;

        return {
            ...page,
            layout: BaseLayout
        };
    },
    setup({ el, app, props, plugin }) {
        var app = createApp({ render: () => h(app, props) }).use(plugin).use(components).mount(el);
    },
})
