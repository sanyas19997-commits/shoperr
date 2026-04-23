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

    // Mount immediately — the auth store was hydrated synchronously from
    // localStorage at creation, so the router guard can already decide. Keep
    // `/me` and cart fetches in the background so page reloads on /profile
    // don't redirect to /login while waiting on the server.
    app.mount('#app');

    auth.fetchUser().catch(() => {});
    cart.fetchCart().catch(() => {});
}

bootstrap();
