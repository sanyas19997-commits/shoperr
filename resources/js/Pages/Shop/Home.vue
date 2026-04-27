<script setup>
import { Link } from '@inertiajs/vue3';
import { onMounted, ref } from 'vue';
import AppHead from '../../Components/AppHead.vue';
import ProductCard from '../../Components/ProductCard.vue';

const props = defineProps({
    featured: { type: Array, default: () => [] },
    newest: { type: Array, default: () => [] },
    onSale: { type: Array, default: () => [] },
    popular: { type: Array, default: () => [] },
    categories: { type: Array, default: () => [] },
    promo: { type: Object, default: () => ({}) },
});

const activeTab = ref('featured');

function catImage(cat, i) {
    if (cat.image) return '/storage/' + cat.image;
    const num = (i % 8) + 1;
    return `/kidify/assets/imgs/page/homepage3/cat${num === 1 ? '' : num}.png`;
}

onMounted(() => {
    // Инициализируем Swiper-карусели после того, как DOM готов
    if (typeof window !== 'undefined' && window.Swiper) {
        try {
            new window.Swiper('.swiper-banner', {
                loop: true,
                pagination: { el: '.swiper-pagination-banner', clickable: true },
                autoplay: { delay: 5000 },
            });
            new window.Swiper('.swiper-9-items', {
                slidesPerView: 9,
                spaceBetween: 20,
                breakpoints: {
                    320: { slidesPerView: 2 },
                    576: { slidesPerView: 3 },
                    768: { slidesPerView: 5 },
                    992: { slidesPerView: 7 },
                    1200: { slidesPerView: 9 },
                },
            });
        } catch (e) { /* swiper may not be loaded yet */ }
    }
});
</script>

<template>
    <AppHead />

    <!-- Hero banner slider -->
    <section class="section banner-homepage1">
        <div class="container">
            <div class="box-swiper">
                <div class="swiper-container swiper-banner pb-0">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="box-banner-home1">
                                <div class="box-cover-image" :style="`background-image:url(/kidify/assets/imgs/page/homepage1/banner.png);background-size:cover;background-position:center;`"></div>
                                <div class="box-banner-info">
                                    <div class="block-info-banner">
                                        <p class="font-3xl-bold neutral-900 title-line mb-10">Сезонные</p>
                                        <h2 class="heading-banner mb-10">
                                            <span class="text-up">скидки</span>
                                            <span class="text-under">скидки</span>
                                        </h2>
                                        <h4 class="heading-4 title-line-2 mb-30">Качественные товары для всей семьи</h4>
                                        <div class="text-center mt-10">
                                            <Link class="btn btn-double-border" href="/catalog"><span>Все предложения</span></Link>
                                            <Link class="btn btn-arrow-right" href="/about">О нас<img src="/kidify/assets/imgs/template/icons/arrow.svg" alt=""></Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="box-banner-home1">
                                <div class="box-cover-image" :style="`background-image:url(/kidify/assets/imgs/page/homepage1/banner2.png);background-size:cover;background-position:center;`"></div>
                                <div class="box-banner-info">
                                    <div class="block-info-banner">
                                        <p class="font-3xl-bold neutral-900 title-line mb-10">Новая</p>
                                        <h2 class="heading-banner mb-10">
                                            <span class="text-up">коллекция</span>
                                            <span class="text-under">коллекция</span>
                                        </h2>
                                        <h4 class="heading-4 title-line-2 mb-30">Большой выбор, выгодные цены и быстрая доставка по всей России.</h4>
                                        <div class="text-center mt-10">
                                            <Link class="btn btn-double-border" href="/catalog"><span>В каталог</span></Link>
                                            <Link class="btn btn-arrow-right" href="/contact">Контакты<img src="/kidify/assets/imgs/template/icons/arrow.svg" alt=""></Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box-pagination-button">
                        <div class="swiper-pagination swiper-pagination-banner"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories slider -->
    <div v-if="categories.length" class="section block-section block-section-categories-slider">
        <div class="container">
            <div class="box-swiper">
                <div class="swiper-container swiper-9-items pb-0">
                    <div class="swiper-wrapper">
                        <div v-for="(cat, i) in categories" :key="cat.id" class="swiper-slide">
                            <div class="cardCategory">
                                <div class="cardImage">
                                    <Link :href="`/catalog/${cat.slug}`">
                                        <img :src="catImage(cat, i)" :alt="cat.name">
                                    </Link>
                                </div>
                                <div class="cardInfo">
                                    <Link :href="`/catalog/${cat.slug}`">{{ cat.name }}</Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Product tabs -->
    <section v-if="featured.length || newest.length" class="section block-section-1">
        <div class="container">
            <div class="text-center">
                <p class="font-xl brand-2"><span class="rounded-text">НОВОЕ В МАГАЗИНЕ</span></p>
                <div class="box-tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" :class="{ active: activeTab === 'featured' }" type="button" @click="activeTab = 'featured'">Хиты продаж</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" :class="{ active: activeTab === 'newest' }" type="button" @click="activeTab = 'newest'">Новинки</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" :class="{ active: activeTab === 'sale' }" type="button" @click="activeTab = 'sale'">Со скидкой</button>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="tab-content">
                <div v-show="activeTab === 'featured'" class="tab-pane fade show active">
                    <div class="row">
                        <div v-for="p in featured" :key="p.id" class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                            <ProductCard :product="p" />
                        </div>
                    </div>
                </div>
                <div v-show="activeTab === 'newest'" class="tab-pane fade show active">
                    <div class="row">
                        <div v-for="p in newest" :key="p.id" class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                            <ProductCard :product="p" />
                        </div>
                    </div>
                </div>
                <div v-show="activeTab === 'sale'" class="tab-pane fade show active">
                    <div class="row">
                        <div v-for="p in onSale" :key="p.id" class="col-xl-3 col-lg-4 col-md-6 col-sm-6">
                            <ProductCard :product="p" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-30">
                <Link class="btn btn-brand-3" href="/catalog">Смотреть все товары</Link>
            </div>
        </div>
    </section>

    <!-- Promo banner -->
    <section class="section block-section-2">
        <div class="container">
            <div class="box-info-section2">
                <h2 class="heading-banner mb-25">
                    <span class="text-up">{{ promo.title || 'Спецпредложение' }}</span>
                    <span class="text-under">{{ promo.title || 'Спецпредложение' }}</span>
                </h2>
                <p class="font-3xl-bold neutral-900 mb-35">{{ promo.text || 'Скидки на популярные категории. Успей купить по выгодной цене!' }}</p>
                <Link class="btn btn-brand-3" href="/catalog">В магазин</Link>
            </div>
            <div class="block-section-img"><img src="/kidify/assets/imgs/page/homepage1/bg-section2.png" alt=""></div>
        </div>
    </section>

    <!-- Two collections -->
    <section v-if="categories.length >= 2" class="section block-section-4">
        <div class="container">
            <div class="box-section-4">
                <div class="row">
                    <div v-for="(cat, idx) in categories.slice(0, 2)" :key="cat.id" class="col-lg-6">
                        <div class="box-collection" :class="{ 'box-collection-2': idx === 1 }">
                            <div class="box-collection-info">
                                <h4 class="heading-4 mb-15">{{ cat.name }}</h4>
                                <p class="font-md neutral-900 mb-35">Скидки до 35% на товары этой категории. Успей купить!</p>
                                <Link class="btn btn-brand-1 text-uppercase" :href="`/catalog/${cat.slug}`">Перейти</Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Popular -->
    <section v-if="popular.length" class="section block-section-5">
        <div class="container">
            <div class="top-head">
                <h4 class="text-uppercase brand-1">Популярные товары</h4>
                <Link class="btn btn-arrow-right" href="/catalog">Смотреть все<img src="/kidify/assets/imgs/template/icons/arrow.svg" alt=""></Link>
            </div>
            <div class="row">
                <div v-for="p in popular" :key="p.id" class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-30">
                    <ProductCard :product="p" />
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section class="section block-section-6">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 mb-30 text-center">
                    <div style="font-size:48px;">🚚</div>
                    <h5 class="mt-15 mb-10">Быстрая доставка</h5>
                    <p class="font-sm neutral-700">Доставим заказ по всей России курьером или в ПВЗ от 1 дня</p>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 mb-30 text-center">
                    <div style="font-size:48px;">🔒</div>
                    <h5 class="mt-15 mb-10">Безопасная оплата</h5>
                    <p class="font-sm neutral-700">Картой онлайн, СБП или при получении — выбирайте удобный способ</p>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 mb-30 text-center">
                    <div style="font-size:48px;">↩️</div>
                    <h5 class="mt-15 mb-10">Возврат 14 дней</h5>
                    <p class="font-sm neutral-700">Без лишних вопросов в течение 14 дней с момента получения</p>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 mb-30 text-center">
                    <div style="font-size:48px;">⭐</div>
                    <h5 class="mt-15 mb-10">Гарантия качества</h5>
                    <p class="font-sm neutral-700">Только проверенные бренды и сертифицированные товары</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter -->
    <section class="section block-section-10 mb-50">
        <div class="container">
            <div class="box-section-10">
                <h3 class="heading-3 wow animate__animated animate__fadeIn">Подпишитесь на рассылку</h3>
                <p class="font-md neutral-900">Узнавайте первыми о скидках, новинках и спецпредложениях</p>
                <form @submit.prevent>
                    <input type="email" placeholder="Введите ваш email" required>
                    <button type="submit" class="btn btn-brand-1">Подписаться</button>
                </form>
            </div>
        </div>
    </section>
</template>
