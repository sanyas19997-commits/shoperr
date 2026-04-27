<script setup>
import { Link, router } from '@inertiajs/vue3';
import { ref, computed } from 'vue';
import AppHead from '../../Components/AppHead.vue';
import ProductCard from '../../Components/ProductCard.vue';
import Price from '../../Components/Price.vue';

const props = defineProps({
    product: { type: Object, required: true },
    related: { type: Array, default: () => [] },
});

const qty = ref(1);
const selectedImg = ref(0);
const activeTab = ref('description');
const adding = ref(false);

const fallback = computed(() => {
    const idx = (props.product.id % 16) + 1;
    return `/kidify/assets/imgs/page/homepage1/product${idx}.png`;
});

function imgUrl(p) {
    if (!p) return fallback.value;
    if (p.startsWith('http') || p.startsWith('/')) return p;
    return '/storage/' + p;
}

const allImages = computed(() => {
    if (props.product.images && props.product.images.length) {
        return props.product.images.map(img => imgUrl(img.path));
    }
    if (props.product.main_image) return [imgUrl(props.product.main_image)];
    return [fallback.value];
});

const maxStock = computed(() => props.product.stock || 99);
function inc() { if (qty.value < maxStock.value) qty.value++; }
function dec() { if (qty.value > 1) qty.value--; }

const onSale = computed(() => props.product.sale_price && props.product.sale_price > 0 && props.product.sale_price < props.product.price);
const currentPrice = computed(() => onSale.value ? props.product.sale_price : props.product.price);
const discount = computed(() => onSale.value ? Math.round((props.product.price - props.product.sale_price) / props.product.price * 100) : 0);

function addToCart() {
    if (adding.value || props.product.stock <= 0) return;
    adding.value = true;
    router.post(`/cart/add/${props.product.id}`, { quantity: qty.value }, {
        preserveScroll: true,
        onFinish: () => { adding.value = false; },
    });
}
</script>

<template>
    <AppHead :title="product.name" :description="product.short_description || ''" />

    <section class="section box-section-shop-page">
        <div class="page-head">
            <div class="container">
                <h2 class="font-3xl-bold color-brand-3 mb-15">{{ product.name }}</h2>
                <ul class="breadcrumb">
                    <li><Link class="font-sm" href="/">Главная</Link></li>
                    <li><Link class="font-sm" href="/catalog">Каталог</Link></li>
                    <li v-if="product.category"><Link class="font-sm" :href="`/catalog/${product.category.slug}`">{{ product.category.name }}</Link></li>
                    <li><a class="font-sm" href="#">{{ product.name }}</a></li>
                </ul>
            </div>
        </div>

        <div class="container mt-30">
            <div class="box-product-detail">
                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <div class="gallery-image">
                            <div class="galleryProductSingle" style="background:#FFF6EC;border-radius:14px;padding:30px;text-align:center;">
                                <img :src="allImages[selectedImg]" :alt="product.name" style="width:100%;max-width:480px;height:auto;border-radius:10px;">
                            </div>
                            <div class="d-flex flex-wrap mt-15" style="gap:10px;">
                                <img v-for="(src, i) in allImages" :key="i"
                                    :src="src" :alt="product.name"
                                    @click="selectedImg = i"
                                    :style="{ width:'80px', height:'80px', objectFit:'cover', borderRadius:'8px', cursor:'pointer', border: '2px solid ' + (i === selectedImg ? '#FF6E30' : '#eee'), padding:'5px', background:'#fff' }">
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12">
                        <div class="info-product-detail pl-15">
                            <p v-if="product.category" class="font-sm neutral-500 mb-5">
                                <Link :href="`/catalog/${product.category.slug}`" style="color:#FF6E30;">{{ product.category.name }}</Link>
                            </p>
                            <h2 class="font-3xl-bold color-brand-3 mb-15">{{ product.name }}</h2>

                            <p v-if="product.sku" class="font-sm neutral-500 mb-10">Артикул: <strong>{{ product.sku }}</strong></p>

                            <div class="rating mb-15">
                                <span style="color:#FFC107;">★★★★★</span>
                                <span class="font-sm neutral-500 ml-5">(Отзывы скоро)</span>
                            </div>

                            <div class="price-product mb-20">
                                <h3 class="d-inline-block font-3xl-bold color-brand-3 mr-10" style="font-size:36px;">
                                    <Price :value="currentPrice" />
                                </h3>
                                <template v-if="onSale">
                                    <h5 class="d-inline-block neutral-500" style="text-decoration:line-through;font-size:20px;">
                                        <Price :value="product.price" />
                                    </h5>
                                    <span class="lbl-hot ml-10" style="background:#FF4D4F;color:#fff;padding:4px 12px;border-radius:6px;font-size:14px;">
                                        -{{ discount }}%
                                    </span>
                                </template>
                            </div>

                            <p v-if="product.short_description" class="font-md neutral-700 mb-20">{{ product.short_description }}</p>

                            <div class="mb-20">
                                <p v-if="product.stock > 0" class="font-sm" style="color:#4CAF50;">✓ В наличии: <strong>{{ product.stock }} шт.</strong></p>
                                <p v-else class="font-sm" style="color:#FF4D4F;">✗ Нет в наличии</p>
                            </div>

                            <form @submit.prevent="addToCart" class="box-buy-product">
                                <div class="d-flex align-items-center mb-15" style="gap:15px;flex-wrap:wrap;">
                                    <div class="quantity-input d-flex align-items-center" style="border:1px solid #ddd;border-radius:6px;background:#fff;">
                                        <button type="button" @click="dec" style="border:0;background:transparent;width:40px;height:44px;font-size:18px;">−</button>
                                        <input type="number" v-model.number="qty" min="1" :max="maxStock" style="width:60px;border:0;text-align:center;font-weight:600;background:transparent;">
                                        <button type="button" @click="inc" style="border:0;background:transparent;width:40px;height:44px;font-size:18px;">+</button>
                                    </div>
                                    <button type="submit" class="btn btn-brand-3" style="padding:12px 32px;" :disabled="product.stock <= 0 || adding">
                                        {{ adding ? 'Добавляем...' : 'В корзину' }}
                                    </button>
                                </div>
                            </form>

                            <div class="border-top pt-20 mt-15">
                                <div class="row">
                                    <div class="col-md-6">
                                        <p class="font-sm neutral-700 mb-10">🚚 <strong>Быстрая доставка</strong> по всей России</p>
                                        <p class="font-sm neutral-700 mb-0">↩️ <strong>Возврат</strong> в течение 14 дней</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="font-sm neutral-700 mb-10">🔒 <strong>Безопасная оплата</strong> онлайн</p>
                                        <p class="font-sm neutral-700 mb-0">⭐ <strong>Гарантия</strong> качества</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs -->
            <div class="box-product-tabs mt-50">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item"><button class="nav-link" :class="{ active: activeTab === 'description' }" @click="activeTab = 'description'" type="button">Описание</button></li>
                    <li class="nav-item"><button class="nav-link" :class="{ active: activeTab === 'specs' }" @click="activeTab = 'specs'" type="button">Характеристики</button></li>
                    <li class="nav-item"><button class="nav-link" :class="{ active: activeTab === 'reviews' }" @click="activeTab = 'reviews'" type="button">Отзывы</button></li>
                </ul>
                <div class="tab-content mt-20">
                    <div v-show="activeTab === 'description'" class="tab-pane fade show active">
                        <div v-if="product.description" class="font-md neutral-900" style="white-space:pre-wrap;">{{ product.description }}</div>
                        <p v-else class="font-md neutral-700">{{ product.short_description || 'Описание появится в ближайшее время.' }}</p>
                    </div>
                    <div v-show="activeTab === 'specs'" class="tab-pane fade show active">
                        <table class="table">
                            <tbody>
                                <tr v-if="product.sku"><th style="width:30%;">Артикул</th><td>{{ product.sku }}</td></tr>
                                <tr v-if="product.category"><th>Категория</th><td>{{ product.category.name }}</td></tr>
                                <tr><th>Наличие</th><td>{{ product.stock > 0 ? 'В наличии' : 'Нет в наличии' }}</td></tr>
                                <tr><th>Цена</th><td><Price :value="currentPrice" /></td></tr>
                            </tbody>
                        </table>
                    </div>
                    <div v-show="activeTab === 'reviews'" class="tab-pane fade show active">
                        <p class="font-md neutral-700">Отзывов пока нет. Станьте первым, кто оставит отзыв на этот товар.</p>
                    </div>
                </div>
            </div>

            <!-- Related -->
            <section v-if="related.length" class="section block-section-5 mt-50">
                <div class="top-head">
                    <h4 class="text-uppercase brand-1">Похожие товары</h4>
                    <Link class="btn btn-arrow-right" href="/catalog">Смотреть все<img src="/kidify/assets/imgs/template/icons/arrow.svg" alt=""></Link>
                </div>
                <div class="row">
                    <div v-for="p in related" :key="p.id" class="col-xl-3 col-lg-4 col-md-6 col-sm-6 mb-30">
                        <ProductCard :product="p" />
                    </div>
                </div>
            </section>
        </div>
    </section>
</template>
