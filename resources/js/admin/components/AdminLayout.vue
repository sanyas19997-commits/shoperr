<script setup>
import { ref, computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();
const route = useRoute();
const router = useRouter();
const sidebarOpen = ref(false);

const items = [
    { name: 'dashboard', label: 'Дашборд', icon: '📊' },
    { name: 'orders', label: 'Заказы', icon: '🛒' },
    { name: 'products', label: 'Товары', icon: '📦' },
    { name: 'categories', label: 'Категории', icon: '📂' },
    { name: 'brands', label: 'Бренды', icon: '🏷️' },
    { name: 'users', label: 'Пользователи', icon: '👥' },
    { name: 'logs', label: 'Логи действий', icon: '📝', adminOnly: true },
    { name: 'settings', label: 'Настройки', icon: '⚙️', adminOnly: true },
];
const visibleItems = computed(() => items.filter(i => !i.adminOnly || auth.isAdmin));

const pageTitle = computed(() => route.meta?.title || '');

function isActive(name) {
    if (name === 'dashboard') return route.name === 'dashboard';
    return route.name?.startsWith(name) || route.path.startsWith('/admin/' + name);
}

async function logout() {
    await auth.logout();
    router.push({ name: 'login' });
}
</script>

<template>
    <div class="admin-layout">
        <aside class="sidebar" :class="{ 'is-open': sidebarOpen }" @click="sidebarOpen = false">
            <div class="brand">🛍️ Billaro</div>
            <div class="nav-section">Магазин</div>
            <nav class="nav">
                <router-link
                    v-for="item in visibleItems"
                    :key="item.name"
                    :to="{ name: item.name }"
                    class="nav-item"
                    :class="{ 'is-active': isActive(item.name) }"
                >
                    <span>{{ item.icon }}</span>
                    <span>{{ item.label }}</span>
                </router-link>
            </nav>
            <div class="nav-section">Аккаунт</div>
            <nav class="nav">
                <router-link :to="{ name: 'profile' }" class="nav-item" :class="{ 'is-active': isActive('profile') }">
                    <span>👤</span><span>Профиль</span>
                </router-link>
                <a href="/" target="_blank" class="nav-item"><span>🌐</span><span>Витрина</span></a>
                <a class="nav-item" @click.prevent="logout"><span>↩️</span><span>Выход</span></a>
            </nav>
        </aside>
        <div class="main">
            <header class="topbar">
                <div style="display:flex; align-items:center; gap:12px;">
                    <button class="menu-toggle" @click="sidebarOpen = !sidebarOpen">☰</button>
                    <div class="page-title">{{ pageTitle }}</div>
                </div>
                <div class="user-menu">
                    <span class="user-name">{{ auth.user?.name }} ({{ auth.user?.role_label }})</span>
                </div>
            </header>
            <main class="content">
                <slot />
            </main>
        </div>
    </div>
</template>
