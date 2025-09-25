import '../css/app.css';

import { createInertiaApp } from '@inertiajs/vue3';
import { configureEcho, echo } from '@laravel/echo-vue';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import type { DefineComponent } from 'vue';
import { createApp, h } from 'vue';
import { ZiggyVue } from 'ziggy-js';
import { initializeTheme } from './composables/useAppearance';

declare global {
    interface Window {
        Echo: typeof echo;
    }
}

// Configuration de Laravel Echo pour Reverb
configureEcho({
    broadcaster: 'reverb',
    key: import.meta.env.VITE_REVERB_APP_KEY,
    wsHost: import.meta.env.VITE_REVERB_HOST || window.location.hostname,
    wsPort: import.meta.env.VITE_REVERB_PORT || 8080,
    wssPort: import.meta.env.VITE_REVERB_PORT || 8080,
    forceTLS: false,
    enabledTransports: ['ws', 'wss'],
});

window.Echo = echo;

if ((window.Echo as any).connector?.socket) {
    const socket = (window.Echo as any).connector.socket;

    socket.onopen = () => {
        console.log('🔌 Reverb WebSocket connecté ✅');
    };
    socket.onclose = () => {
        console.log('❌ Reverb WebSocket déconnecté');
    };
    socket.onerror = (err: any) => {
        console.error('⚠️ Reverb WebSocket erreur :', err);
    };
}

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => (title ? `${title} - ${appName}` : appName),
    resolve: (name) => resolvePageComponent(`./pages/${name}.vue`, import.meta.glob<DefineComponent>('./pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

// This will set light / dark mode on page load...
initializeTheme();
