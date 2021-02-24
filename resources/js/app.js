require('./bootstrap');

// Import modules...
import { createApp, h } from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue3';

const el = document.getElementById('app');

const app = createApp({
    render: () =>
        h(InertiaApp, {
            initialPage: JSON.parse(el.dataset.page),
            resolveComponent: (name) => require(`./Pages/${name}`).default,
        }),
})

app.config.globalProperties.$filters = {
    optional(value) {
        return value ? value : {}
    },
}

app.mixin({ methods: { route } })
app.use(InertiaPlugin)
app.mount(el);
