<template>
    <div class="container py-4">
        <nav aria-label="breadcrumb" class="small">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link :to="{ name: 'home' }">Главная</router-link></li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ currentCategory?.name || 'Каталог' }}
                </li>
            </ol>
        </nav>

        <h1 class="h3 fw-bold mb-4">{{ currentCategory?.name || 'Каталог товаров' }}</h1>

        <div class="row g-4">
            <aside class="col-lg-3">
                <Filters v-model="filters" :categories="categories" :facets="facets" @change="applyFilters" />
            </aside>
            <div class="col-lg-9">
                <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
                    <div class="text-muted small">Найдено: {{ meta.total || 0 }}</div>
                    <div class="d-flex align-items-center gap-2">
                        <label class="small mb-0 text-muted">Сортировка:</label>
                        <select v-model="sort" class="form-select form-select-sm" style="width: auto" @change="loadProducts()">
                            <option value="newest">Новые</option>
                            <option value="price_asc">Сначала дешевле</option>
                            <option value="price_desc">Сначала дороже</option>
                            <option value="rating">По рейтингу</option>
                            <option value="popular">По популярности</option>
                            <option value="name">По названию</option>
                        </select>
                    </div>
                </div>

                <ProductList :products="products" :loading="loading" />

                <div class="mt-4">
                    <Pagination
                        v-if="meta.last_page > 1"
                        :current-page="meta.current_page"
                        :last-page="meta.last_page"
                        @change="goToPage"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref, watch } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api from '../api';
import ProductList from '../components/ProductList.vue';
import Pagination from '../components/Pagination.vue';
import Filters from '../components/Filters.vue';

const route = useRoute();
const router = useRouter();

const products = ref([]);
const meta = reactive({ current_page: 1, last_page: 1, total: 0 });
const categories = ref([]);
const facets = ref([]);
const loading = ref(false);
const sort = ref(route.query.sort || 'newest');

// Decode `?attrs[color]=red,blue` from the URL into {color: ['red','blue']}.
function decodeAttrsFromQuery(q) {
    const out = {};
    for (const key of Object.keys(q || {})) {
        const m = key.match(/^attrs\[([A-Za-z0-9_\-]+)\]$/);
        if (!m) continue;
        const raw = q[key];
        const values = (Array.isArray(raw) ? raw : String(raw).split(','))
            .map((v) => String(v).trim())
            .filter(Boolean);
        if (values.length) out[m[1]] = values;
    }
    return out;
}

const filters = ref({
    category: route.params.slug || route.query.category || '',
    price_min: route.query.price_min || null,
    price_max: route.query.price_max || null,
    in_stock: route.query.in_stock === '1',
    attrs: decodeAttrsFromQuery(route.query),
});

const currentCategory = computed(() => categories.value.find((c) => c.slug === filters.value.category));

async function loadCategories() {
    const { data } = await api.get('/categories');
    categories.value = data.data;
}

async function loadProducts(page = 1) {
    loading.value = true;
    try {
        const params = {
            page,
            per_page: 12,
            sort: sort.value,
            q: route.query.q || undefined,
            category: filters.value.category || undefined,
            price_min: filters.value.price_min || undefined,
            price_max: filters.value.price_max || undefined,
            in_stock: filters.value.in_stock ? 1 : undefined,
        };
        // Flatten attrs into `attrs[code]=a,b` query params so `params:` serialization
        // matches the shape the API `normalizeAttrsInput` expects.
        for (const code of Object.keys(filters.value.attrs || {})) {
            const vals = filters.value.attrs[code];
            if (Array.isArray(vals) && vals.length) {
                params[`attrs[${code}]`] = vals.join(',');
            }
        }
        const { data } = await api.get('/products', { params });
        products.value = data.data;
        facets.value = data.facets || [];
        Object.assign(meta, data.meta || {});
    } finally {
        loading.value = false;
    }
}

function applyFilters() {
    const query = {
        q: route.query.q || undefined,
        price_min: filters.value.price_min || undefined,
        price_max: filters.value.price_max || undefined,
        in_stock: filters.value.in_stock ? '1' : undefined,
        sort: sort.value !== 'newest' ? sort.value : undefined,
    };
    for (const code of Object.keys(filters.value.attrs || {})) {
        const vals = filters.value.attrs[code];
        if (Array.isArray(vals) && vals.length) {
            query[`attrs[${code}]`] = vals.join(',');
        }
    }
    if (filters.value.category && filters.value.category !== route.params.slug) {
        router.push({ name: 'category', params: { slug: filters.value.category }, query });
    } else if (!filters.value.category && route.name === 'category') {
        router.push({ name: 'catalog', query });
    } else {
        router.replace({ ...route, query });
        loadProducts(1);
    }
}

function goToPage(page) {
    loadProducts(page);
}

watch(() => route.params.slug, (slug) => {
    filters.value.category = slug || '';
    loadProducts(1);
});
watch(() => route.query.q, () => loadProducts(1));
// Navbar links like /catalog?sort=newest only mutate the URL — without
// watching the sort query, the page keeps showing the previous order.
watch(() => route.query.sort, (next) => {
    const nextSort = next || 'newest';
    if (nextSort !== sort.value) {
        sort.value = nextSort;
    }
    loadProducts(1);
});
// Same for other filter query params so the catalog stays in sync with URL.
watch(() => route.query.category, (next) => {
    if (!route.params.slug) {
        filters.value.category = next || '';
        loadProducts(1);
    }
});
watch(() => [route.query.price_min, route.query.price_max, route.query.in_stock], () => {
    filters.value.price_min = route.query.price_min || null;
    filters.value.price_max = route.query.price_max || null;
    filters.value.in_stock = route.query.in_stock === '1';
    loadProducts(1);
});

onMounted(async () => {
    await loadCategories();
    await loadProducts(1);
});
</script>
