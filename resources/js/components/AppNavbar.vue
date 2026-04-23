<template>
    <nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
        <div class="container">
            <router-link class="navbar-brand d-flex align-items-center gap-2" :to="{ name: 'home' }">
                <i class="bi bi-bag-fill text-primary fs-4"></i>
                <span>ShopHub</span>
            </router-link>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navContent">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navContent">
                <ul class="navbar-nav me-auto ms-3">
                    <li class="nav-item">
                        <router-link class="nav-link" :to="{ name: 'catalog' }">
                            <i class="bi bi-grid me-1"></i>Каталог
                        </router-link>
                    </li>
                    <li class="nav-item dropdown" v-if="categories.length">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Категории</a>
                        <ul class="dropdown-menu">
                            <li v-for="cat in categories" :key="cat.id">
                                <router-link class="dropdown-item" :to="{ name: 'category', params: { slug: cat.slug } }">
                                    {{ cat.name }}
                                </router-link>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">Информация</a>
                        <ul class="dropdown-menu">
                            <li><router-link class="dropdown-item" :to="{ name: 'delivery' }"><i class="bi bi-truck me-2"></i>Доставка</router-link></li>
                            <li><router-link class="dropdown-item" :to="{ name: 'payment' }"><i class="bi bi-credit-card me-2"></i>Оплата</router-link></li>
                            <li><router-link class="dropdown-item" :to="{ name: 'returns' }"><i class="bi bi-arrow-counterclockwise me-2"></i>Возврат</router-link></li>
                            <li><router-link class="dropdown-item" :to="{ name: 'about' }"><i class="bi bi-info-circle me-2"></i>О нас</router-link></li>
                            <li><router-link class="dropdown-item" :to="{ name: 'contacts' }"><i class="bi bi-chat-dots me-2"></i>Контакты</router-link></li>
                        </ul>
                    </li>
                </ul>
                <form class="search-form d-flex me-3" @submit.prevent="submitSearch">
                    <div class="input-group">
                        <input v-model="searchQuery" type="search" class="form-control" placeholder="Поиск товаров..." />
                        <button class="btn btn-primary" type="submit"><i class="bi bi-search"></i></button>
                    </div>
                </form>
                <ul class="navbar-nav">
                    <li class="nav-item" v-if="auth.isAuthenticated">
                        <router-link class="nav-link position-relative" :to="{ name: 'favorites' }">
                            <i class="bi bi-heart fs-5"></i>
                        </router-link>
                    </li>
                    <li class="nav-item">
                        <router-link class="nav-link position-relative" :to="{ name: 'cart' }">
                            <i class="bi bi-cart3 fs-5"></i>
                            <span v-if="cart.itemCount" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                {{ cart.itemCount }}
                            </span>
                        </router-link>
                    </li>
                    <li class="nav-item dropdown" v-if="auth.isAuthenticated">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                            <i class="bi bi-person-circle me-1"></i>{{ auth.user.name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><router-link class="dropdown-item" :to="{ name: 'profile' }">Профиль</router-link></li>
                            <li><router-link class="dropdown-item" :to="{ name: 'orders' }">Мои заказы</router-link></li>
                            <li><router-link class="dropdown-item" :to="{ name: 'favorites' }">Избранное</router-link></li>
                            <li v-if="auth.isAdmin"><hr class="dropdown-divider"></li>
                            <li v-if="auth.isAdmin"><router-link class="dropdown-item" :to="{ name: 'admin.dashboard' }">Админ-панель</router-link></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a href="#" class="dropdown-item" @click.prevent="logout">Выйти</a></li>
                        </ul>
                    </li>
                    <li class="nav-item" v-else>
                        <router-link class="btn btn-outline-primary ms-2" :to="{ name: 'login' }">Войти</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import api from '../api';
import { useAuthStore } from '../stores/auth';
import { useCartStore } from '../stores/cart';

const auth = useAuthStore();
const cart = useCartStore();
const router = useRouter();
const route = useRoute();

const searchQuery = ref(route.query.q || '');
const categories = ref([]);

onMounted(async () => {
    try {
        const { data } = await api.get('/categories', { params: { tree: true } });
        categories.value = data.data.slice(0, 10);
    } catch (_) {}
});

function submitSearch() {
    router.push({ name: 'catalog', query: { q: searchQuery.value || undefined } });
}

async function logout() {
    await auth.logout();
    await cart.fetchCart();
    router.push({ name: 'home' });
}
</script>
