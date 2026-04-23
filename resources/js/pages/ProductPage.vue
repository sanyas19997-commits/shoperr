<template>
    <div class="container py-4" v-if="product">
        <nav aria-label="breadcrumb" class="small">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><router-link :to="{ name: 'home' }">Главная</router-link></li>
                <li class="breadcrumb-item"><router-link :to="{ name: 'catalog' }">Каталог</router-link></li>
                <li v-if="product.category" class="breadcrumb-item">
                    <router-link :to="{ name: 'category', params: { slug: product.category.slug } }">{{ product.category.name }}</router-link>
                </li>
                <li class="breadcrumb-item active">{{ product.name }}</li>
            </ol>
        </nav>

        <div class="row g-4">
            <div class="col-md-6">
                <div class="gallery">
                    <div class="gallery-thumbs">
                        <button v-for="(img, i) in galleryImages"
                                :key="img.id || i"
                                type="button"
                                class="thumb"
                                :class="{ active: activeIndex === i }"
                                @click="activeIndex = i"
                                @mouseenter="activeIndex = i">
                            <img :src="img.url" :alt="`${product.name} — фото ${i + 1}`" />
                        </button>
                    </div>
                    <div class="gallery-main">
                        <button v-if="galleryImages.length > 1"
                                type="button"
                                class="gallery-arrow left"
                                aria-label="Предыдущее фото"
                                @click="prev">
                            <i class="bi bi-chevron-left"></i>
                        </button>
                        <div class="gallery-stage"
                             @click="openLightbox(activeIndex)"
                             @touchstart.passive="onTouchStart"
                             @touchend="onTouchEnd">
                            <img :src="galleryImages[activeIndex]?.url"
                                 :alt="product.name"
                                 class="gallery-image" />
                            <span class="zoom-hint"><i class="bi bi-zoom-in"></i></span>
                        </div>
                        <button v-if="galleryImages.length > 1"
                                type="button"
                                class="gallery-arrow right"
                                aria-label="Следующее фото"
                                @click="next">
                            <i class="bi bi-chevron-right"></i>
                        </button>
                    </div>
                    <div v-if="galleryImages.length > 1" class="gallery-counter small text-muted text-center mt-2">
                        {{ activeIndex + 1 }} / {{ galleryImages.length }}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <h1 class="h4 fw-bold">{{ product.name }}</h1>
                <div class="mb-2"><RatingStars :value="product.rating" :reviews="product.reviews_count" /></div>
                <div v-if="product.sku" class="small text-muted mb-2">Артикул: {{ product.sku }}</div>

                <div class="d-flex align-items-baseline gap-2 mb-3">
                    <span class="display-6 fw-bold">{{ formatPrice(product.price) }} ₽</span>
                    <span v-if="product.old_price" class="old-price fs-5">{{ formatPrice(product.old_price) }} ₽</span>
                    <span v-if="product.discount_percent" class="discount-badge">-{{ product.discount_percent }}%</span>
                </div>

                <p v-if="product.short_description" class="text-muted">{{ product.short_description }}</p>

                <div class="mb-3">
                    <span v-if="product.in_stock" class="badge text-bg-success"><i class="bi bi-check2 me-1"></i>В наличии</span>
                    <span v-else class="badge text-bg-secondary">Нет в наличии</span>
                </div>

                <div class="d-flex gap-2 mb-3">
                    <div class="input-group" style="max-width: 140px">
                        <button class="btn btn-outline-secondary" @click="qty = Math.max(1, qty - 1)">-</button>
                        <input type="number" v-model.number="qty" min="1" class="form-control text-center" />
                        <button class="btn btn-outline-secondary" @click="qty = qty + 1">+</button>
                    </div>
                    <button class="btn btn-primary flex-grow-1" :disabled="!product.in_stock || adding" @click="addToCart">
                        <i class="bi bi-cart-plus me-1"></i>В корзину
                    </button>
                    <button
                        v-if="auth.isAuthenticated"
                        class="btn btn-outline-danger"
                        @click="toggleFav"
                    >
                        <i :class="isFav ? 'bi bi-heart-fill' : 'bi bi-heart'"></i>
                    </button>
                </div>

                <div v-if="product.description" class="mb-3">
                    <h6 class="fw-semibold">Описание</h6>
                    <div class="text-muted" style="white-space: pre-line">{{ product.description }}</div>
                </div>

                <div v-if="attributesList.length" class="mb-3">
                    <h6 class="fw-semibold">Характеристики</h6>
                    <table class="table table-sm">
                        <tbody>
                            <tr v-for="(v, k) in attributesList" :key="k">
                                <td class="text-muted">{{ v[0] }}</td>
                                <td>{{ v[1] }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <section class="mt-5">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h3 class="h5 fw-bold mb-0">Отзывы <span class="text-muted fw-normal">({{ reviewsTotal }})</span></h3>
                <div v-if="reviewsTotal > 0" class="small text-muted">
                    <RatingStars :value="product.rating" /> <span class="ms-1">{{ formatRating(product.rating) }} / 5</span>
                </div>
            </div>

            <div v-if="auth.isAuthenticated" class="card border-0 shadow-sm p-3 mb-3">
                <h6 class="fw-semibold mb-2">
                    {{ myReview ? 'Ваш отзыв' : 'Оставить отзыв' }}
                </h6>
                <div class="mb-2">
                    <label class="small d-block">Оценка:</label>
                    <div>
                        <i v-for="i in 5" :key="i"
                           class="bi fs-4"
                           :class="[i <= reviewForm.rating ? 'bi-star-fill rating-star' : 'bi-star rating-star empty']"
                           style="cursor: pointer"
                           @click="reviewForm.rating = i"></i>
                        <span v-if="reviewForm.rating" class="ms-2 small text-muted">{{ reviewForm.rating }} / 5</span>
                    </div>
                </div>
                <textarea v-model="reviewForm.body"
                          class="form-control mb-2"
                          rows="3"
                          maxlength="2000"
                          placeholder="Расскажите и понравившемся, и о недостатках..."></textarea>
                <div class="d-flex gap-2">
                    <button class="btn btn-primary btn-sm" @click="submitReview" :disabled="!reviewForm.rating || submittingReview">
                        <span v-if="submittingReview" class="spinner-border spinner-border-sm me-1"></span>
                        {{ myReview ? 'Обновить' : 'Отправить' }}
                    </button>
                    <button v-if="myReview"
                            class="btn btn-outline-danger btn-sm"
                            :disabled="deletingReview"
                            @click="deleteMyReview">
                        <i class="bi bi-trash me-1"></i>Удалить отзыв
                    </button>
                </div>
            </div>
            <div v-else class="alert alert-info">
                <router-link :to="{ name: 'login' }">Войдите</router-link>, чтобы оставить отзыв.
            </div>

            <div v-if="reviewsLoading" class="text-center text-muted py-3">
                <span class="spinner-border spinner-border-sm me-2"></span>Загрузка отзывов…
            </div>
            <div v-else-if="reviews.length">
                <div v-for="r in reviews" :key="r.id"
                     class="card border-0 shadow-sm p-3 mb-2"
                     :class="{ 'border-primary border-2': isMine(r) }">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <strong>{{ r.user_name || 'Пользователь' }}</strong>
                            <span v-if="isMine(r)" class="badge bg-primary ms-2">Ваш отзыв</span>
                            <div class="mt-1">
                                <RatingStars :value="r.rating" />
                                <span class="ms-1 small text-muted">{{ r.rating }} / 5</span>
                            </div>
                        </div>
                        <div class="text-end">
                            <small class="text-muted d-block">{{ formatDate(r.created_at) }}</small>
                        </div>
                    </div>
                    <div v-if="r.body" class="mt-2 review-body">{{ r.body }}</div>
                </div>
            </div>
            <div v-else class="text-muted small">Пока нет отзывов. Будьте первым!</div>
        </section>

        <section v-if="similar.length" class="mt-5">
            <h3 class="h5 fw-bold mb-3">Похожие товары</h3>
            <ProductList :products="similar" />
        </section>

        <!-- Lightbox — pinch/double-tap zoom via CSS scale. Click outside the
             image or press Esc to close. -->
        <transition name="lb-fade">
            <div v-if="lightboxOpen" class="lightbox" @click.self="closeLightbox">
                <button type="button" class="lb-btn lb-close" aria-label="Закрыть" @click="closeLightbox">
                    <i class="bi bi-x-lg"></i>
                </button>
                <button v-if="galleryImages.length > 1"
                        type="button"
                        class="lb-btn lb-nav lb-prev"
                        aria-label="Предыдущее фото"
                        @click.stop="prev">
                    <i class="bi bi-chevron-left"></i>
                </button>
                <div class="lb-stage"
                     @click.self="closeLightbox"
                     @touchstart.passive="onTouchStart"
                     @touchend="onTouchEnd">
                    <img :src="galleryImages[activeIndex]?.url"
                         :alt="product.name"
                         class="lb-image"
                         :class="{ zoomed }"
                         :style="zoomed ? zoomStyle : ''"
                         @click.stop="toggleZoom"
                         @mousemove="onZoomMove"
                         @wheel.prevent="onWheel" />
                </div>
                <button v-if="galleryImages.length > 1"
                        type="button"
                        class="lb-btn lb-nav lb-next"
                        aria-label="Следующее фото"
                        @click.stop="next">
                    <i class="bi bi-chevron-right"></i>
                </button>
                <div class="lb-counter">{{ activeIndex + 1 }} / {{ galleryImages.length }}</div>
            </div>
        </transition>
    </div>
    <div v-else class="container py-5 text-center">
        <div class="spinner-border text-primary"></div>
    </div>
</template>

<script setup>
import { computed, onBeforeUnmount, onMounted, reactive, ref, watch } from 'vue';
import { useRoute } from 'vue-router';
import api from '../api';
import { useAuthStore } from '../stores/auth';
import { useCartStore } from '../stores/cart';
import { useFavoritesStore } from '../stores/favorites';
import { useConfirmStore } from '../stores/confirm';
import ProductList from '../components/ProductList.vue';
import RatingStars from '../components/RatingStars.vue';
import { formatPrice, formatDate } from '../utils/format';

const route = useRoute();
const auth = useAuthStore();
const cart = useCartStore();
const favorites = useFavoritesStore();
const confirm = useConfirmStore();

const product = ref(null);
const similar = ref([]);
const reviews = ref([]);
const reviewsLoading = ref(false);
const reviewsTotal = ref(0);
const submittingReview = ref(false);
const deletingReview = ref(false);
const qty = ref(1);
const adding = ref(false);
const activeIndex = ref(0);
const lightboxOpen = ref(false);
const zoomed = ref(false);
const zoomOrigin = reactive({ x: 50, y: 50 });
const zoomScale = ref(2);
const reviewForm = reactive({ rating: 0, body: '' });

// Gallery always has at least one image — synthesize a placeholder if the
// product has none so the layout doesn't collapse.
const galleryImages = computed(() => {
    const imgs = Array.isArray(product.value?.images) ? product.value.images : [];
    if (imgs.length) return imgs;
    const fallback = product.value?.primary_image_url;
    return [{
        id: 'placeholder',
        url: fallback || 'data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22600%22 height=%22600%22><rect fill=%22%23eef0f5%22 width=%22600%22 height=%22600%22/></svg>',
    }];
});

const zoomStyle = computed(() => ({
    transform: `scale(${zoomScale.value})`,
    transformOrigin: `${zoomOrigin.x}% ${zoomOrigin.y}%`,
}));

const myReview = computed(() => {
    const uid = auth.user?.id;
    if (!uid) return null;
    return reviews.value.find((r) => Number(r.user_id) === Number(uid)) || null;
});
function isMine(r) {
    return !!auth.user?.id && Number(r.user_id) === Number(auth.user.id);
}
function formatRating(v) {
    const n = Number(v || 0);
    return Number.isInteger(n) ? n.toFixed(0) : n.toFixed(1);
}

function prev() {
    if (!galleryImages.value.length) return;
    activeIndex.value = (activeIndex.value - 1 + galleryImages.value.length) % galleryImages.value.length;
    zoomed.value = false;
}
function next() {
    if (!galleryImages.value.length) return;
    activeIndex.value = (activeIndex.value + 1) % galleryImages.value.length;
    zoomed.value = false;
}
function openLightbox(i) {
    activeIndex.value = i;
    zoomed.value = false;
    zoomScale.value = 2;
    lightboxOpen.value = true;
}
function closeLightbox() {
    lightboxOpen.value = false;
    zoomed.value = false;
}
function toggleZoom() {
    zoomed.value = !zoomed.value;
    if (!zoomed.value) zoomScale.value = 2;
}
function onZoomMove(event) {
    if (!zoomed.value) return;
    const rect = event.currentTarget.getBoundingClientRect();
    zoomOrigin.x = ((event.clientX - rect.left) / rect.width) * 100;
    zoomOrigin.y = ((event.clientY - rect.top) / rect.height) * 100;
}
function onWheel(event) {
    if (!zoomed.value) {
        zoomed.value = true;
    }
    const delta = event.deltaY > 0 ? -0.2 : 0.2;
    zoomScale.value = Math.min(5, Math.max(1.5, zoomScale.value + delta));
}

let touchStartX = 0;
let touchStartY = 0;
function onTouchStart(event) {
    const t = event.touches?.[0];
    if (!t) return;
    touchStartX = t.clientX;
    touchStartY = t.clientY;
}
function onTouchEnd(event) {
    const t = event.changedTouches?.[0];
    if (!t) return;
    const dx = t.clientX - touchStartX;
    const dy = t.clientY - touchStartY;
    // Require a decisively horizontal swipe so vertical scroll still works.
    if (Math.abs(dx) > 40 && Math.abs(dx) > Math.abs(dy)) {
        if (dx < 0) next();
        else prev();
    }
}

function onKey(event) {
    if (!lightboxOpen.value) return;
    if (event.key === 'Escape') closeLightbox();
    else if (event.key === 'ArrowLeft') prev();
    else if (event.key === 'ArrowRight') next();
}

const attributesList = computed(() => {
    const a = product.value?.attributes;
    if (!a || typeof a !== 'object') return [];
    return Object.entries(a);
});

const isFav = computed(() => product.value ? favorites.has(product.value.id) : false);

async function load() {
    const { data } = await api.get(`/products/${route.params.slug}`);
    product.value = data.data;
    // ProductController::show embeds `ProductResource::collection(...)` inline, which
    // serializes as a flat array (no outer `data` wrapper), so use `data.similar` directly.
    similar.value = Array.isArray(data.similar) ? data.similar : (data.similar?.data || []);
    activeIndex.value = 0;
    zoomed.value = false;
    await loadReviews();
}

async function loadReviews() {
    reviewsLoading.value = true;
    try {
        const { data } = await api.get(`/products/${product.value.id}/reviews`, { silent: true });
        reviews.value = data.data || [];
        reviewsTotal.value = data.meta?.total ?? reviews.value.length;
        // Prefill the form with the user's own review so the submit button
        // acts as «edit» instead of silently creating a duplicate
        // (the backend does updateOrCreate, but the form should reflect it).
        if (myReview.value) {
            reviewForm.rating = myReview.value.rating || 0;
            reviewForm.body = myReview.value.body || '';
        }
    } finally {
        reviewsLoading.value = false;
    }
}

async function addToCart() {
    adding.value = true;
    try {
        await cart.addItem(product.value.id, qty.value);
    } finally {
        adding.value = false;
    }
}

async function toggleFav() {
    await favorites.toggle(product.value.id);
}

async function submitReview() {
    if (!reviewForm.rating) return;
    submittingReview.value = true;
    try {
        await api.post(`/products/${product.value.id}/reviews`, {
            rating: reviewForm.rating,
            body: reviewForm.body,
        });
        await loadReviews();
        await load();
    } finally {
        submittingReview.value = false;
    }
}

async function deleteMyReview() {
    if (!myReview.value) return;
    const ok = await confirm.ask({
        title: 'Удалить отзыв?',
        message: 'Ваш отзыв об этом товаре будет удалён безвозвратно.',
        confirmLabel: 'Удалить',
        variant: 'danger',
    });
    if (!ok) return;
    deletingReview.value = true;
    try {
        await api.delete(`/reviews/${myReview.value.id}`);
        reviewForm.rating = 0;
        reviewForm.body = '';
        await loadReviews();
        await load();
    } finally {
        deletingReview.value = false;
    }
}

onMounted(() => {
    load();
    window.addEventListener('keydown', onKey);
});
onBeforeUnmount(() => {
    window.removeEventListener('keydown', onKey);
});
watch(() => route.params.slug, load);
</script>

<style scoped>
.gallery {
    display: grid;
    grid-template-columns: 72px 1fr;
    gap: 0.75rem;
}
.gallery-thumbs {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    max-height: 480px;
    overflow-y: auto;
}
.gallery-thumbs::-webkit-scrollbar { width: 6px; }
.gallery-thumbs::-webkit-scrollbar-thumb { background: rgba(0,0,0,.15); border-radius: 4px; }
.thumb {
    padding: 0;
    background: none;
    border: 2px solid transparent;
    border-radius: 6px;
    cursor: pointer;
    overflow: hidden;
    transition: border-color .15s;
}
.thumb img {
    display: block;
    width: 64px;
    height: 64px;
    object-fit: cover;
    border-radius: 4px;
}
.thumb:hover, .thumb.active { border-color: var(--bs-warning, #fdb827); }
.gallery-main {
    position: relative;
    background: #fff;
    border: 1px solid var(--mf-border, #e5e7eb);
    border-radius: 8px;
    overflow: hidden;
}
.gallery-stage {
    position: relative;
    aspect-ratio: 1 / 1;
    cursor: zoom-in;
    overflow: hidden;
}
.gallery-image {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .3s;
}
.gallery-stage:hover .gallery-image { transform: scale(1.03); }
.zoom-hint {
    position: absolute;
    top: 12px;
    right: 12px;
    width: 34px;
    height: 34px;
    border-radius: 50%;
    background: rgba(0,0,0,.45);
    color: #fff;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 16px;
    pointer-events: none;
    opacity: 0;
    transition: opacity .2s;
}
.gallery-stage:hover .zoom-hint { opacity: 1; }
.gallery-arrow {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 36px;
    height: 36px;
    border-radius: 50%;
    background: rgba(255,255,255,.9);
    border: 1px solid var(--mf-border, #e5e7eb);
    box-shadow: 0 2px 6px rgba(0,0,0,.08);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #222;
    z-index: 2;
    cursor: pointer;
    opacity: 0;
    transition: opacity .2s;
}
.gallery-main:hover .gallery-arrow { opacity: 1; }
.gallery-arrow.left { left: 10px; }
.gallery-arrow.right { right: 10px; }
.gallery-arrow:hover { background: var(--bs-warning, #fdb827); }

@media (max-width: 575.98px) {
    .gallery { grid-template-columns: 1fr; }
    .gallery-thumbs {
        flex-direction: row;
        max-height: none;
        order: 2;
        overflow-x: auto;
    }
    .gallery-main { order: 1; }
}

/* Lightbox */
.lightbox {
    position: fixed;
    inset: 0;
    z-index: 2000;
    background: rgba(0, 0, 0, 0.92);
    display: flex;
    align-items: center;
    justify-content: center;
}
.lb-stage {
    width: 90vw;
    height: 90vh;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.lb-image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    cursor: zoom-in;
    transition: transform .25s ease-out;
    user-select: none;
    -webkit-user-drag: none;
}
.lb-image.zoomed { cursor: zoom-out; }
.lb-btn {
    position: absolute;
    background: rgba(255, 255, 255, 0.12);
    border: none;
    color: #fff;
    width: 48px;
    height: 48px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 20px;
    cursor: pointer;
    transition: background .2s;
}
.lb-btn:hover { background: rgba(255, 255, 255, 0.25); }
.lb-close { top: 18px; right: 18px; }
.lb-nav { top: 50%; transform: translateY(-50%); }
.lb-prev { left: 24px; }
.lb-next { right: 24px; }
.lb-counter {
    position: absolute;
    bottom: 18px;
    left: 50%;
    transform: translateX(-50%);
    color: rgba(255, 255, 255, 0.8);
    font-size: 0.9rem;
    background: rgba(0, 0, 0, 0.35);
    padding: 4px 12px;
    border-radius: 12px;
}
.lb-fade-enter-active, .lb-fade-leave-active { transition: opacity .2s; }
.lb-fade-enter-from, .lb-fade-leave-to { opacity: 0; }
</style>
