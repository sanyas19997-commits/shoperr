<template>
    <header class="app-header sticky-top">
        <!-- Top utility bar (yellow) -->
        <div class="top-bar">
            <div class="container d-flex flex-wrap align-items-center justify-content-between">
                <div class="d-none d-md-flex align-items-center">
                    <span><i class="bi bi-telephone me-1"></i>+7 (800) 000-00-00</span>
                    <span class="divider">|</span>
                    <span>Пн–Вс: 9:00 — 21:00</span>
                </div>
                <div class="d-flex align-items-center">
                    <router-link :to="{ name: 'delivery' }">Доставка</router-link>
                    <span class="divider">|</span>
                    <router-link :to="{ name: 'returns' }">Возврат</router-link>
                    <span class="divider">|</span>
                    <router-link :to="{ name: 'about' }">О нас</router-link>
                    <span class="divider">|</span>
                    <router-link :to="{ name: 'contacts' }">Контакты</router-link>
                </div>
            </div>
        </div>

        <!-- Main bar (logo + search + actions) -->
        <div class="main-bar">
            <div class="container">
                <div class="row g-3 align-items-center flex-nowrap">
                    <div class="col-auto">
                        <router-link class="brand-logo" :to="{ name: 'home' }">
                            <i class="bi bi-bag-heart-fill dot"></i>
                            <span>Shop<span class="dot">Hub</span></span>
                        </router-link>
                    </div>
                    <div class="col d-none d-lg-block">
                        <form class="search-megabar" @submit.prevent="submitSearch">
                            <div class="input-group">
                                <select v-model="searchCat" class="form-select" aria-label="Категория">
                                    <option value="">Все категории</option>
                                    <option v-for="c in categories.slice(0, 20)" :key="c.id" :value="c.slug">{{ c.name }}</option>
                                </select>
                                <input v-model="searchQuery" type="search" class="form-control" placeholder="Искать товар..." />
                                <button class="btn" type="submit"><i class="bi bi-search"></i></button>
                            </div>
                        </form>
                    </div>
                    <div class="col-auto ms-auto">
                        <div class="nav-actions">
                            <router-link v-if="auth.isAuthenticated" :to="{ name: 'favorites' }" class="nav-action icon-only" aria-label="Избранное" title="Избранное">
                                <span class="icon-wrap"><i class="bi bi-heart"></i></span>
                            </router-link>
                            <router-link :to="{ name: 'cart' }" class="nav-action" aria-label="Корзина">
                                <span class="icon-wrap">
                                    <i class="bi bi-cart3"></i>
                                    <span v-if="cart.itemCount" class="count-badge">{{ cart.itemCount }}</span>
                                </span>
                                <span class="nav-action-label">
                                    <span class="t">Корзина</span>
                                    <span class="s">{{ formatPrice(cart.total || 0) }} ₽</span>
                                </span>
                            </router-link>
                            <div v-if="auth.isAuthenticated" class="dropdown">
                                <a class="nav-action dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                                    <span class="icon-wrap"><i class="bi bi-person"></i></span>
                                    <span class="nav-action-label">
                                        <span class="t">Привет,</span>
                                        <span class="s text-truncate" :title="firstName">{{ firstName }}</span>
                                    </span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-end mega-menu">
                                    <li><router-link class="dropdown-item" :to="{ name: 'profile' }"><i class="bi bi-person me-2"></i>Профиль</router-link></li>
                                    <li><router-link class="dropdown-item" :to="{ name: 'orders' }"><i class="bi bi-box-seam me-2"></i>Мои заказы</router-link></li>
                                    <li><router-link class="dropdown-item" :to="{ name: 'favorites' }"><i class="bi bi-heart me-2"></i>Избранное</router-link></li>
                                    <li v-if="auth.isAdmin"><hr class="dropdown-divider" /></li>
                                    <li v-if="auth.isAdmin"><router-link class="dropdown-item" :to="{ name: 'admin.dashboard' }"><i class="bi bi-shield-check me-2"></i>Админ-панель</router-link></li>
                                    <li><hr class="dropdown-divider" /></li>
                                    <li><a href="#" class="dropdown-item" @click.prevent="logout"><i class="bi bi-box-arrow-right me-2"></i>Выйти</a></li>
                                </ul>
                            </div>
                            <router-link v-else :to="{ name: 'login' }" class="nav-action" aria-label="Войти">
                                <span class="icon-wrap"><i class="bi bi-person"></i></span>
                                <span class="nav-action-label">
                                    <span class="t">Аккаунт</span>
                                    <span class="s">Войти</span>
                                </span>
                            </router-link>
                        </div>
                    </div>
                </div>
                <!-- Mobile / tablet search -->
                <div class="row d-lg-none mt-2">
                    <div class="col-12">
                        <form class="search-megabar" @submit.prevent="submitSearch">
                            <div class="input-group">
                                <input v-model="searchQuery" type="search" class="form-control" placeholder="Искать товар..." />
                                <button class="btn" type="submit"><i class="bi bi-search"></i></button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories ribbon -->
        <div class="categories-bar d-none d-lg-block">
            <div class="container">
                <div class="d-flex align-items-stretch">
                    <div class="dropdown">
                        <a href="#" class="all-cats d-inline-flex align-items-center gap-2" data-bs-toggle="dropdown">
                            <i class="bi bi-list"></i>Все категории
                        </a>
                        <ul class="dropdown-menu mega-menu">
                            <li v-for="c in categories" :key="c.id">
                                <router-link class="dropdown-item" :to="{ name: 'category', params: { slug: c.slug } }">
                                    <i class="bi bi-chevron-right me-1 text-muted small"></i>{{ c.name }}
                                </router-link>
                            </li>
                        </ul>
                    </div>
                    <router-link :to="{ name: 'catalog' }"
                                 :class="['cat-pill', { active: isCatalogTab(null) }]"
                                 active-class=""
                                 exact-active-class=""><i class="bi bi-grid me-2"></i>Каталог</router-link>
                    <router-link :to="{ name: 'catalog', query: { sort: 'newest' } }"
                                 :class="['cat-pill', { active: isCatalogTab('newest') }]"
                                 active-class=""
                                 exact-active-class="">Новинки</router-link>
                    <router-link :to="{ name: 'catalog', query: { sort: 'popular' } }"
                                 :class="['cat-pill', { active: isCatalogTab('popular') }]"
                                 active-class=""
                                 exact-active-class="">Хиты продаж</router-link>
                    <router-link :to="{ name: 'catalog', query: { sort: 'price_desc' } }"
                                 :class="['cat-pill', { active: isCatalogTab('price_desc') }]"
                                 active-class=""
                                 exact-active-class="">Премиум</router-link>
                    <router-link :to="{ name: 'delivery' }" class="cat-pill">Доставка</router-link>
                    <a href="tel:+78000000000" class="cat-help ms-auto">
                        <i class="bi bi-headset me-2"></i>
                        <span class="cat-help-label">
                            <span class="t">Нужна помощь?</span>
                            <span class="s">+7 (800) 000-00-00</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </header>
</template>

<script setup>
import { computed, onMounted, ref } from 'vue';
import { useRouter, useRoute } from 'vue-router';
import api from '../api';
import { useAuthStore } from '../stores/auth';
import { useCartStore } from '../stores/cart';
import { formatPrice } from '../utils/format';

const auth = useAuthStore();
const cart = useCartStore();
const router = useRouter();
const route = useRoute();

const searchQuery = ref(route.query.q || '');
const searchCat = ref(route.query.category || '');
const categories = ref([]);

const firstName = computed(() => {
    const full = auth.user?.name || 'Гость';
    const first = full.split(' ')[0] || full;
    return first.length > 12 ? first.slice(0, 11) + '…' : first;
});

// Router's built-in `router-link-active` matches by path only, so every
// /catalog?sort=… link lights up on the catalog page. Compare both the
// route name AND the current `sort` query to pick exactly one pill.
function isCatalogTab(sortKey) {
    if (route.name !== 'catalog' && route.name !== 'category') return false;
    const current = route.query?.sort || null;
    return current === sortKey;
}

onMounted(async () => {
    try {
        const { data } = await api.get('/categories', { params: { tree: true } });
        categories.value = data.data;
    } catch (_) {}
});

function submitSearch() {
    const query = {};
    if (searchQuery.value) query.q = searchQuery.value;
    if (searchCat.value) query.category = searchCat.value;
    router.push({ name: 'catalog', query });
}

async function logout() {
    await auth.logout();
    await cart.fetchCart();
    router.push({ name: 'home' });
}
</script>

<style scoped>
.app-header { background: #fff; }
</style>
