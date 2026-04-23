<template>
    <div class="container py-4">
        <!-- HERO: main slider + 2 promo tiles -->
        <div class="row g-3 mb-4">
            <div class="col-lg-9">
                <div v-if="banners.length" id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div v-for="(b, idx) in banners" :key="b.id" class="carousel-item" :class="{ active: idx === 0 }">
                            <div class="hero-block" :style="heroStyle(b)">
                                <div>
                                    <div class="hero-eyebrow" v-if="b.subtitle">Специальное предложение</div>
                                    <h2 class="hero-title">{{ b.title }}</h2>
                                    <p v-if="b.subtitle" class="hero-sub">{{ b.subtitle }}</p>
                                    <div class="d-flex gap-2 flex-wrap">
                                        <router-link :to="b.url || '/catalog'" class="btn btn-warning btn-lg">В каталог</router-link>
                                        <router-link :to="{ name: 'about' }" class="btn btn-outline-light btn-lg">Подробнее</router-link>
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
                <div v-else class="hero-block" style="background: linear-gradient(120deg, #34495e, #2c3e50);">
                    <div>
                        <div class="hero-eyebrow">Открытие сезона</div>
                        <h2 class="hero-title">Скидки до 40% на электронику</h2>
                        <p class="hero-sub">Тысячи товаров, быстрая доставка, официальная гарантия.</p>
                        <router-link :to="{ name: 'catalog' }" class="btn btn-warning btn-lg">В каталог</router-link>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="promo-stack h-100">
                    <router-link :to="{ name: 'catalog' }" class="promo-tile">
                        <div class="promo-info">
                            <span class="promo-cut">-20%</span>
                            <div class="promo-title">Бестселлеры</div>
                            <div class="promo-sub">Только лучшие товары сезона</div>
                        </div>
                        <div class="promo-art" style="background-image: url('https://cdn-icons-png.flaticon.com/512/4275/4275579.png')"></div>
                    </router-link>
                    <router-link :to="{ name: 'catalog', query: { sort: 'newest' } }" class="promo-tile">
                        <div class="promo-info">
                            <span class="promo-cut" style="background: #e63946; color: #fff;">-40%</span>
                            <div class="promo-title">Смартфоны</div>
                            <div class="promo-sub">Новинки с выгодой</div>
                        </div>
                        <div class="promo-art" style="background-image: url('https://cdn-icons-png.flaticon.com/512/186/186239.png')"></div>
                    </router-link>
                </div>
            </div>
        </div>

        <!-- USP strip -->
        <div class="usp-strip mb-4">
            <div class="row g-0">
                <div class="col-6 col-md-3" v-for="u in usps" :key="u.title">
                    <div class="usp-item">
                        <i :class="`usp-icon bi ${u.icon}`"></i>
                        <div>
                            <div class="usp-title">{{ u.title }}</div>
                            <div class="usp-text">{{ u.text }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- DEAL OF THE DAY -->
        <section class="mf-section" v-if="dealProducts.length || loading.deal">
            <div class="mf-section-head">
                <div class="deal-head">
                    <h2 class="deal-title">Deal of the day</h2>
                    <span class="deal-end">Заканчивается через</span>
                    <span class="deal-countdown">
                        <span class="chip">{{ pad(countdown.h) }}</span>
                        <span class="sep">:</span>
                        <span class="chip">{{ pad(countdown.m) }}</span>
                        <span class="sep">:</span>
                        <span class="chip">{{ pad(countdown.s) }}</span>
                    </span>
                </div>
                <router-link :to="{ name: 'catalog' }" class="small fw-semibold">Все предложения <i class="bi bi-arrow-right"></i></router-link>
            </div>
            <div v-if="loading.deal" class="row g-0">
                <div v-for="i in 6" :key="i" class="col-6 col-md-4 col-lg-2 p-3"><SkeletonCard /></div>
            </div>
            <div v-else class="product-strip">
                <ProductCard v-for="p in dealProducts.slice(0, 6)" :key="p.id" :product="p" />
            </div>
        </section>

        <!-- TOP CATEGORIES -->
        <section class="mf-section" v-if="categories.length || loading.categories">
            <div class="mf-section-head">
                <h2>Топ категории</h2>
                <router-link :to="{ name: 'catalog' }" class="small fw-semibold">Все <i class="bi bi-arrow-right"></i></router-link>
            </div>
            <div class="mf-section-body">
                <div v-if="loading.categories" class="row g-3">
                    <div v-for="i in 8" :key="i" class="col-6 col-md-3"><div class="skeleton skeleton-block" style="height: 130px"></div></div>
                </div>
                <div v-else class="row g-3">
                    <div v-for="(c, i) in categories.slice(0, 8)" :key="c.id" class="col-6 col-md-3">
                        <router-link :to="{ name: 'category', params: { slug: c.slug } }" class="cat-tile">
                            <div class="cat-icon-wrap"><i :class="`bi ${iconFor(i)}`"></i></div>
                            <div class="cat-name">{{ c.name }}</div>
                            <div v-if="c.products_count" class="cat-count">{{ c.products_count }} товаров</div>
                        </router-link>
                    </div>
                </div>
            </div>
        </section>

        <!-- 3 mid promo banners -->
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <router-link :to="{ name: 'catalog' }" class="mid-promo">
                    <div>
                        <div class="mp-sub">Беспроводные</div>
                        <div class="mp-title">Acher Fluence<br/>Умная колонка</div>
                        <div class="mp-price">от 9 990 ₽</div>
                        <span class="mp-cta">Подробнее</span>
                    </div>
                    <div class="mp-art" style="background-image: url('https://cdn-icons-png.flaticon.com/512/3659/3659897.png')"></div>
                </router-link>
            </div>
            <div class="col-md-4">
                <router-link :to="{ name: 'catalog' }" class="mid-promo" style="background: #f9f4ea;">
                    <div>
                        <div class="mp-sub">Wooden</div>
                        <div class="mp-title">Minimalist<br/>Chairs</div>
                        <span class="mp-cta">Купить</span>
                    </div>
                    <div class="mp-art" style="background-image: url('https://cdn-icons-png.flaticon.com/512/1198/1198374.png')"></div>
                </router-link>
            </div>
            <div class="col-md-4">
                <router-link :to="{ name: 'catalog' }" class="mid-promo">
                    <div>
                        <div class="mp-sub">Для iPhone / Android</div>
                        <div class="mp-title">IQOS 2.4<br/>Holder & Charger</div>
                        <div class="mp-price">1 990 ₽</div>
                        <span class="mp-cta">Купить</span>
                    </div>
                    <div class="mp-art" style="background-image: url('https://cdn-icons-png.flaticon.com/512/1046/1046857.png')"></div>
                </router-link>
            </div>
        </div>

        <!-- FEATURED PRODUCTS -->
        <section class="mf-section" v-if="featured.length || loading.featured">
            <div class="mf-section-head">
                <h2>Популярные товары</h2>
                <router-link :to="{ name: 'catalog' }" class="small fw-semibold">Все <i class="bi bi-arrow-right"></i></router-link>
            </div>
            <div class="mf-section-body">
                <div v-if="loading.featured" class="row g-3">
                    <div v-for="i in 8" :key="i" class="col-6 col-md-4 col-lg-3"><SkeletonCard /></div>
                </div>
                <div v-else class="row g-3">
                    <div v-for="p in featured.slice(0, 8)" :key="p.id" class="col-6 col-md-4 col-lg-3">
                        <ProductCard :product="p" />
                    </div>
                </div>
            </div>
        </section>

        <!-- 2 inline banners -->
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <router-link :to="{ name: 'catalog' }" class="inline-banner" style="background: #fceded;">
                    <div>
                        <div class="ib-eyebrow">Ткань · красная</div>
                        <div class="ib-title">Fabric Red Sofa</div>
                        <div class="ib-price">от 29 990 ₽</div>
                        <span class="mp-cta">В коллекцию</span>
                    </div>
                    <div class="ib-art" style="background-image: url('https://cdn-icons-png.flaticon.com/512/2892/2892144.png')"></div>
                </router-link>
            </div>
            <div class="col-md-6">
                <router-link :to="{ name: 'catalog' }" class="inline-banner" style="background: #eef3f7;">
                    <div>
                        <div class="ib-eyebrow">Аудио</div>
                        <div class="ib-title">Pioneer Speaker</div>
                        <div class="ib-price">от 14 500 ₽</div>
                        <span class="mp-cta">Купить</span>
                    </div>
                    <div class="ib-art" style="background-image: url('https://cdn-icons-png.flaticon.com/512/2775/2775180.png')"></div>
                </router-link>
            </div>
        </div>

        <!-- EXCLUSIVE PRODUCTS with tabs -->
        <section class="mf-section" v-if="allExclusive.length">
            <div class="mf-section-head">
                <h2>Эксклюзивные товары</h2>
                <ul class="mf-section-tabs">
                    <li v-for="t in exclusiveTabs" :key="t.key">
                        <a :class="{ active: exclusiveTab === t.key }" @click.prevent="exclusiveTab = t.key">{{ t.label }}</a>
                    </li>
                </ul>
            </div>
            <div class="mf-section-body">
                <div class="row g-3">
                    <div v-for="p in currentExclusive.slice(0, 4)" :key="`ex-${p.id}`" class="col-6 col-md-3">
                        <ProductCard :product="p" />
                    </div>
                </div>
            </div>
        </section>

        <!-- COMPUTER & TECHNOLOGIES with sub-category tabs -->
        <section class="mf-section" v-if="computerProducts.length">
            <div class="mf-section-head">
                <h2>Компьютеры и Технологии</h2>
                <ul class="mf-section-tabs">
                    <li v-for="t in computerTabs" :key="t.key">
                        <a :class="{ active: computerTab === t.key }" @click.prevent="computerTab = t.key">{{ t.label }}</a>
                    </li>
                </ul>
            </div>
            <div class="mf-section-body">
                <div class="row g-3">
                    <div v-for="p in filteredComputer.slice(0, 4)" :key="`c-${p.id}`" class="col-6 col-md-3">
                        <ProductCard :product="p" />
                    </div>
                </div>
            </div>
        </section>

        <!-- App download block -->
        <section class="app-download mb-4">
            <div>
                <div class="ad-title">Скачайте приложение ShopHub</div>
                <div class="ad-text">Покупки быстро и удобно прямо со смартфона. Ссылку можно отправить на email.</div>
                <form class="ad-form" @submit.prevent="sendAppLink">
                    <input v-model="appLinkEmail" type="email" class="form-control" placeholder="your@email.com" />
                    <button class="btn btn-warning">Отправить</button>
                </form>
                <div class="ad-stores">
                    <a href="#" class="store-btn" aria-label="Google Play">
                        <i class="bi bi-google-play"></i>
                        <span><small>Доступно в</small><strong>Google Play</strong></span>
                    </a>
                    <a href="#" class="store-btn" aria-label="App Store">
                        <i class="bi bi-apple"></i>
                        <span><small>Скачать в</small><strong>App Store</strong></span>
                    </a>
                </div>
            </div>
            <div class="d-none d-md-block" aria-hidden="true" style="flex: 0 0 220px;">
                <img src="https://cdn-icons-png.flaticon.com/512/3221/3221613.png" alt="" style="width: 180px; height: auto; opacity: 0.85;" />
            </div>
        </section>

        <!-- NETWORKING tabs -->
        <section class="mf-section" v-if="newest.length || loading.newest">
            <div class="mf-section-head">
                <h2>Networking</h2>
                <ul class="mf-section-tabs">
                    <li><a :class="{ active: netTab === 'home' }" @click.prevent="netTab = 'home'">Домашние устройства</a></li>
                    <li><a :class="{ active: netTab === 'gaming' }" @click.prevent="netTab = 'gaming'">Gaming</a></li>
                    <li><a :class="{ active: netTab === 'security' }" @click.prevent="netTab = 'security'">Security</a></li>
                </ul>
            </div>
            <div class="mf-section-body">
                <div v-if="loading.newest" class="row g-3">
                    <div v-for="i in 4" :key="i" class="col-6 col-md-3"><SkeletonCard /></div>
                </div>
                <div v-else class="row g-3">
                    <div v-for="p in newest.slice(0, 4)" :key="`n-${p.id}`" class="col-6 col-md-3">
                        <ProductCard :product="p" />
                    </div>
                </div>
            </div>
        </section>

        <!-- Newsletter -->
        <section class="newsletter mb-4">
            <div>
                <h3>Подпишитесь на рассылку</h3>
                <p>Получайте новости, акции и персональные скидки первыми.</p>
            </div>
            <form @submit.prevent="subscribe" style="flex: 1; max-width: 520px;">
                <div class="input-group input-group-lg">
                    <input v-model="newsletter.email" type="email" class="form-control" placeholder="your@email.com" required />
                    <button class="btn" type="submit">Subscribe</button>
                </div>
            </form>
        </section>
    </div>
</template>

<script setup>
import { computed, onMounted, onBeforeUnmount, reactive, ref } from 'vue';
import api from '../api';
import ProductCard from '../components/ProductCard.vue';
import SkeletonCard from '../components/SkeletonCard.vue';
import { useToastStore } from '../stores/toast';

const toasts = useToastStore();

const banners = ref([]);
const categories = ref([]);
const featured = ref([]);
const newest = ref([]);
const dealProducts = ref([]);
const allExclusive = ref([]);
const computerProducts = ref([]);
const loading = reactive({ categories: true, featured: true, newest: true, deal: true });

const newsletter = reactive({ email: '' });
const appLinkEmail = ref('');

const exclusiveTabs = [
    { key: 'new', label: 'Новинки' },
    { key: 'best', label: 'Хиты продаж' },
    { key: 'special', label: 'Спец-предложения' },
];
const exclusiveTab = ref('new');

const computerTabs = [
    { key: 'all', label: 'Все' },
    { key: 'laptop', label: 'Ноутбуки' },
    { key: 'monitor', label: 'Мониторы' },
    { key: 'components', label: 'Компоненты' },
];
const computerTab = ref('all');
const netTab = ref('home');

const usps = [
    { icon: 'bi-truck', title: 'Быстрая доставка', text: 'По всей России, 1–3 дня' },
    { icon: 'bi-shield-check', title: 'Безопасная оплата', text: '100% защита платежей' },
    { icon: 'bi-headset', title: 'Поддержка 24/7', text: 'Помощь в чате и по телефону' },
    { icon: 'bi-patch-check', title: 'Гарантия качества', text: 'Только официальная продукция' },
];

const icons = ['bi-laptop', 'bi-phone', 'bi-pc-display', 'bi-house-gear',
               'bi-heart-pulse', 'bi-gem', 'bi-toys', 'bi-camera',
               'bi-controller', 'bi-headphones', 'bi-bicycle', 'bi-book'];
function iconFor(i) { return icons[i % icons.length]; }

function heroStyle(banner) {
    const overlay = 'linear-gradient(90deg, rgba(0,0,0,0.3), rgba(0,0,0,0) 55%)';
    if (!banner.image_url) return { background: 'linear-gradient(120deg, #34495e, #2c3e50)' };
    return { backgroundImage: `${overlay}, url(${banner.image_url})` };
}

// Countdown (until next midnight local time)
const countdown = reactive({ h: 0, m: 0, s: 0 });
let tickTimer = null;
function tick() {
    const now = new Date();
    const end = new Date(now);
    end.setHours(24, 0, 0, 0); // next midnight
    let diff = Math.max(0, end.getTime() - now.getTime());
    countdown.h = Math.floor(diff / 3_600_000); diff -= countdown.h * 3_600_000;
    countdown.m = Math.floor(diff / 60_000);     diff -= countdown.m * 60_000;
    countdown.s = Math.floor(diff / 1000);
}
function pad(n) { return n < 10 ? `0${n}` : `${n}`; }

const currentExclusive = computed(() => {
    if (exclusiveTab.value === 'new') {
        return [...allExclusive.value].sort((a, b) => new Date(b.created_at) - new Date(a.created_at));
    }
    if (exclusiveTab.value === 'best') {
        return [...allExclusive.value].sort((a, b) => (b.orders_count || 0) - (a.orders_count || 0));
    }
    return allExclusive.value.filter(p => p.discount_percent && p.discount_percent > 0);
});

const filteredComputer = computed(() => {
    if (computerTab.value === 'all') return computerProducts.value;
    const q = computerTab.value;
    return computerProducts.value.filter(p => {
        const name = (p.name || '').toLowerCase();
        const cat = (p.category?.name || '').toLowerCase();
        return name.includes(q) || cat.includes(q);
    });
});

onMounted(async () => {
    tick();
    tickTimer = setInterval(tick, 1000);

    try {
        const [b, c, f, n] = await Promise.all([
            api.get('/banners'),
            api.get('/categories', { params: { tree: true } }),
            api.get('/products', { params: { featured: 1, per_page: 8 } }),
            api.get('/products', { params: { sort: 'newest', per_page: 12 } }),
        ]);
        banners.value = b.data.data;
        categories.value = c.data.data;
        featured.value = f.data.data;
        newest.value = n.data.data;

        // Deal of the day: products with biggest discount
        dealProducts.value = [...newest.value, ...featured.value]
            .filter(p => p.discount_percent && p.discount_percent > 0)
            .sort((a, b) => (b.discount_percent || 0) - (a.discount_percent || 0))
            .slice(0, 6);
        if (dealProducts.value.length === 0) {
            dealProducts.value = featured.value.slice(0, 6);
        }

        allExclusive.value = newest.value.slice(0, 12);

        try {
            const { data: tech } = await api.get('/products', { params: { per_page: 12, q: 'book laptop pc monitor' } });
            computerProducts.value = tech.data;
        } catch (_) {
            computerProducts.value = newest.value;
        }
    } finally {
        loading.categories = false;
        loading.featured = false;
        loading.newest = false;
        loading.deal = false;
    }
});

onBeforeUnmount(() => {
    if (tickTimer) clearInterval(tickTimer);
});

function subscribe() {
    if (!newsletter.email) return;
    toasts.success(`${newsletter.email} — подписка оформлена`, 'Спасибо!');
    newsletter.email = '';
}

function sendAppLink() {
    if (!appLinkEmail.value) return;
    toasts.success('Ссылка на приложение отправлена', 'Готово!');
    appLinkEmail.value = '';
}
</script>
