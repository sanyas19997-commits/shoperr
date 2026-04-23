<template>
    <div class="container py-4">
        <!-- Hero carousel -->
        <div v-if="banners.length" id="heroCarousel" class="carousel slide mb-4" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div v-for="(b, idx) in banners" :key="b.id" class="carousel-item" :class="{ active: idx === 0 }">
                    <div class="hero-banner" :style="heroStyle(b)">
                        <div>
                            <div class="hero-eyebrow mb-2" v-if="b.subtitle">
                                <i class="bi bi-stars me-1"></i>Специальное предложение
                            </div>
                            <h2 class="hero-title mb-3">{{ b.title }}</h2>
                            <p v-if="b.subtitle" class="hero-subtitle lead mb-4">{{ b.subtitle }}</p>
                            <div class="d-flex gap-2 flex-wrap">
                                <router-link :to="b.url || '/catalog'" class="btn btn-light btn-lg">
                                    В каталог <i class="bi bi-arrow-right ms-1"></i>
                                </router-link>
                                <router-link :to="{ name: 'about' }" class="btn btn-outline-light btn-lg">
                                    Подробнее
                                </router-link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div v-if="banners.length > 1" class="carousel-indicators">
                <button v-for="(b, i) in banners" :key="b.id" type="button" data-bs-target="#heroCarousel"
                        :data-bs-slide-to="i" :class="{ active: i === 0 }" :aria-label="`Slide ${i + 1}`"></button>
            </div>
        </div>
        <div v-else class="hero-banner mb-4" style="background: var(--gradient-primary);">
            <div>
                <div class="hero-eyebrow mb-2"><i class="bi bi-stars me-1"></i>Открытие сезона</div>
                <h2 class="hero-title mb-3">Умная электроника, спорт и дом — в одном месте</h2>
                <p class="hero-subtitle mb-4">Тысячи товаров, быстрая доставка, гарантия качества.</p>
                <router-link :to="{ name: 'catalog' }" class="btn btn-light btn-lg">
                    В каталог <i class="bi bi-arrow-right ms-1"></i>
                </router-link>
            </div>
        </div>

        <!-- USP strip -->
        <div class="usp-strip mb-5">
            <div class="row g-3 g-md-4">
                <div class="col-6 col-md-3" v-for="u in usps" :key="u.title">
                    <div class="usp-item">
                        <div class="usp-icon"><i :class="`bi ${u.icon}`"></i></div>
                        <div>
                            <div class="usp-title">{{ u.title }}</div>
                            <div class="usp-text">{{ u.text }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories -->
        <section v-if="categories.length || loading.categories" class="mb-5">
            <div class="section-heading">
                <h2>Категории</h2>
                <router-link :to="{ name: 'catalog' }" class="small">Все <i class="bi bi-arrow-right"></i></router-link>
            </div>
            <div v-if="loading.categories" class="row g-3">
                <div v-for="i in 8" :key="i" class="col-6 col-md-3 col-lg-2">
                    <div class="skeleton skeleton-block" style="height: 140px"></div>
                </div>
            </div>
            <div v-else class="row g-3">
                <div v-for="(c, i) in categories.slice(0, 12)" :key="c.id" class="col-6 col-md-3 col-lg-2">
                    <router-link :to="{ name: 'category', params: { slug: c.slug } }" class="category-tile">
                        <div class="cat-icon" :style="gradientFor(i)">
                            <i :class="`bi ${iconFor(i)}`"></i>
                        </div>
                        <div class="cat-name">{{ c.name }}</div>
                        <div v-if="c.products_count" class="cat-count">{{ c.products_count }} товаров</div>
                    </router-link>
                </div>
            </div>
        </section>

        <!-- Featured -->
        <section class="mb-5">
            <div class="section-heading">
                <h2>Хиты продаж</h2>
                <router-link :to="{ name: 'catalog' }" class="small">Все <i class="bi bi-arrow-right"></i></router-link>
            </div>
            <div v-if="loading.featured" class="row g-3 g-md-4">
                <div v-for="i in 8" :key="i" class="col-6 col-md-4 col-lg-3"><SkeletonCard /></div>
            </div>
            <ProductList v-else :products="featured" :loading="false" />
        </section>

        <!-- Newest -->
        <section class="mb-5">
            <div class="section-heading">
                <h2>Новинки</h2>
                <router-link :to="{ name: 'catalog', query: { sort: 'newest' } }" class="small">Все <i class="bi bi-arrow-right"></i></router-link>
            </div>
            <div v-if="loading.newest" class="row g-3 g-md-4">
                <div v-for="i in 4" :key="i" class="col-6 col-md-4 col-lg-3"><SkeletonCard /></div>
            </div>
            <ProductList v-else :products="newest" :loading="false" />
        </section>

        <!-- Newsletter / CTA -->
        <section class="mb-5">
            <div class="newsletter p-4 p-md-5">
                <div class="row align-items-center g-3">
                    <div class="col-md-7">
                        <h3 class="fw-bold mb-2">Скидки и новинки — в почту</h3>
                        <p class="mb-0 opacity-75">Подпишитесь на рассылку и первыми узнавайте о распродажах, новых коллекциях и спецпредложениях.</p>
                    </div>
                    <div class="col-md-5">
                        <form class="newsletter-form" @submit.prevent="subscribe">
                            <div class="input-group input-group-lg">
                                <input v-model="newsletter.email" type="email" class="form-control" placeholder="your@email.com" required />
                                <button class="btn btn-light">Подписаться</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import api from '../api';
import ProductList from '../components/ProductList.vue';
import SkeletonCard from '../components/SkeletonCard.vue';
import { useToastStore } from '../stores/toast';

const toasts = useToastStore();

const banners = ref([]);
const categories = ref([]);
const featured = ref([]);
const newest = ref([]);
const loading = reactive({ categories: true, featured: true, newest: true });

const newsletter = reactive({ email: '' });

const usps = [
    { icon: 'bi-truck', title: 'Доставка по РФ', text: '1–3 дня в крупные города' },
    { icon: 'bi-shield-check', title: 'Гарантия качества', text: 'Только официальная продукция' },
    { icon: 'bi-arrow-counterclockwise', title: 'Возврат 14 дней', text: 'Без лишних вопросов' },
    { icon: 'bi-headset', title: 'Поддержка 24/7', text: 'В чате, email и по телефону' },
];

const icons = ['bi-laptop','bi-phone','bi-headphones','bi-watch','bi-camera','bi-controller','bi-book','bi-bicycle','bi-house','bi-bag','bi-gift','bi-tv'];
const gradients = [
    'linear-gradient(135deg,#7c5cff 0%,#4e7fff 100%)',
    'linear-gradient(135deg,#f093fb 0%,#f5576c 100%)',
    'linear-gradient(135deg,#4facfe 0%,#00f2fe 100%)',
    'linear-gradient(135deg,#43e97b 0%,#38f9d7 100%)',
    'linear-gradient(135deg,#fa709a 0%,#fee140 100%)',
    'linear-gradient(135deg,#30cfd0 0%,#330867 100%)',
];
function iconFor(i) { return icons[i % icons.length]; }
function gradientFor(i) { return { background: gradients[i % gradients.length] }; }

function heroStyle(banner) {
    if (!banner.image_url) {
        return { background: 'var(--gradient-primary)' };
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
        loading.categories = false;
        loading.featured = false;
        loading.newest = false;
    }
});

function subscribe() {
    if (!newsletter.email) return;
    toasts.success(`${newsletter.email} подписан на рассылку`, 'Спасибо!');
    newsletter.email = '';
}
</script>

<style scoped>
.hero-eyebrow {
    display: inline-block;
    background: rgba(255, 255, 255, 0.18);
    backdrop-filter: blur(4px);
    padding: 6px 14px;
    border-radius: 999px;
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 0.02em;
}

.newsletter {
    background: var(--gradient-primary);
    color: #fff;
    border-radius: var(--bs-border-radius-2xl, 1.5rem);
    box-shadow: var(--shadow-lg);
}
.newsletter h3 { letter-spacing: -0.02em; }
.newsletter-form .btn-light { font-weight: 600; }
</style>
