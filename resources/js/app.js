import { createApp } from 'vue';
import { createPinia } from 'pinia';
import App from './App.vue';
import router from './router';
import api from './api';
import { useAuthStore } from './stores/auth';
import { useCartStore } from './stores/cart';

import 'bootstrap/dist/js/bootstrap.bundle.min.js';

async function bootstrap() {
    const app = createApp(App);
    const pinia = createPinia();

    app.use(pinia);
    app.use(router);

    app.config.globalProperties.$api = api;

    const auth = useAuthStore();
    const cart = useCartStore();

    try {
        await auth.fetchUser();
    } catch (_) {
        // ignore
    }
    try {
        await cart.fetchCart();
    } catch (_) {
        // ignore
    }

    app.mount('#app');
}

bootstrap();
