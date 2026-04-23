<template>
    <div class="admin-layout">
        <aside class="admin-sidebar">
            <div class="d-flex align-items-center gap-2 px-2 py-3">
                <i class="bi bi-bag-fill text-primary fs-4"></i>
                <strong class="text-white">ShopHub Admin</strong>
            </div>
            <nav class="mt-3 d-flex flex-column gap-1">
                <router-link :to="{ name: 'admin.dashboard' }" exact><i class="bi bi-speedometer2 me-2"></i>Дашборд</router-link>
                <router-link :to="{ name: 'admin.products' }"><i class="bi bi-box-seam me-2"></i>Товары</router-link>
                <router-link :to="{ name: 'admin.categories' }"><i class="bi bi-tags me-2"></i>Категории</router-link>
                <router-link :to="{ name: 'admin.orders' }"><i class="bi bi-bag me-2"></i>Заказы</router-link>
                <router-link :to="{ name: 'admin.users' }"><i class="bi bi-people me-2"></i>Пользователи</router-link>
                <router-link :to="{ name: 'admin.banners' }"><i class="bi bi-image me-2"></i>Баннеры</router-link>
                <router-link :to="{ name: 'admin.feedback' }" class="d-flex align-items-center justify-content-between">
                    <span><i class="bi bi-chat-dots me-2"></i>Обратная связь</span>
                    <span v-if="newFeedback" class="badge bg-danger rounded-pill">{{ newFeedback }}</span>
                </router-link>
                <hr class="border-secondary" />
                <router-link to="/"><i class="bi bi-arrow-left me-2"></i>На сайт</router-link>
                <a href="#" @click.prevent="logout"><i class="bi bi-box-arrow-right me-2"></i>Выйти</a>
            </nav>
        </aside>
        <main class="admin-content">
            <router-view />
        </main>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRouter } from 'vue-router';
import api from '../../api';
import { useAuthStore } from '../../stores/auth';

const auth = useAuthStore();
const router = useRouter();
const newFeedback = ref(0);

async function loadStats() {
    try {
        const { data } = await api.get('/admin/feedback/stats', { silent: true });
        newFeedback.value = data.new || 0;
    } catch (_) {}
}

onMounted(() => {
    loadStats();
    // Refresh every 60s so newly submitted feedback shows up without manual refresh.
    window.setInterval(loadStats, 60000);
});

async function logout() {
    await auth.logout();
    router.push({ name: 'home' });
}
</script>
