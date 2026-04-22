<template>
    <div class="container py-4">
        <div id="heroCarousel" class="carousel slide mb-4" data-bs-ride="carousel" v-if="banners.length">
            <div class="carousel-inner">
                <div v-for="(b, idx) in banners" :key="b.id" class="carousel-item" :class="{ active: idx === 0 }">
                    <div class="hero-banner" :style="heroStyle(b)">
                        <div>
                            <h2 class="display-6 fw-bold mb-2">{{ b.title }}</h2>
                            <p v-if="b.subtitle" class="lead mb-3">{{ b.subtitle }}</p>
                            <router-link :to="b.url || '/catalog'" class="btn btn-light btn-lg">
                                В каталог <i class="bi bi-arrow-right ms-1"></i>
                            </router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <section v-if="categories.length" class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0 fw-bold">Категории</h3>
                <router-link :to="{ name: 'catalog' }" class="small">Все <i class="bi bi-arrow-right"></i></router-link>
            </div>
            <div class="row g-3">
                <div v-for="c in categories.slice(0, 8)" :key="c.id" class="col-6 col-md-3">
                    <router-link :to="{ name: 'category', params: { slug: c.slug } }" class="card p-3 text-center text-decoration-none text-dark h-100">
                        <div class="mb-2 fs-2"><i class="bi bi-tag-fill text-primary"></i></div>
                        <div class="fw-medium">{{ c.name }}</div>
                    </router-link>
                </div>
            </div>
        </section>

        <section class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0 fw-bold">Хиты продаж</h3>
                <router-link :to="{ name: 'catalog' }" class="small">Все <i class="bi bi-arrow-right"></i></router-link>
            </div>
            <ProductList :products="featured" :loading="loading.featured" />
        </section>

        <section class="mb-5">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="mb-0 fw-bold">Новинки</h3>
            </div>
            <ProductList :products="newest" :loading="loading.newest" />
        </section>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import api from '../api';
import ProductList from '../components/ProductList.vue';

const banners = ref([]);
const categories = ref([]);
const featured = ref([]);
const newest = ref([]);
const loading = reactive({ featured: true, newest: true });

function heroStyle(banner) {
    if (!banner.image_url) {
        return { background: 'linear-gradient(120deg, #0d6efd, #6610f2)' };
    }
    return { backgroundImage: `url(${banner.image_url})` };
}

onMounted(async () => {
    try {
        const [b, c, f, n] = await Promise.all([
            api.get('/banners'),
            api.get('/categories', { params: { tree: true } }),
            api.get('/products', { params: { featured: 1, per_page: 8 } }),
            api.get('/products', { params: { sort: 'newest', per_page: 8 } }),
        ]);
        banners.value = b.data.data;
        categories.value = c.data.data;
        featured.value = f.data.data;
        newest.value = n.data.data;
    } finally {
        loading.featured = false;
        loading.newest = false;
    }
});
</script>
