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
                <div class="card overflow-hidden">
                    <img :src="currentImage" class="w-100" style="aspect-ratio: 1/1; object-fit: cover" />
                </div>
                <div v-if="product.images && product.images.length > 1" class="d-flex gap-2 mt-3 flex-wrap">
                    <img
                        v-for="img in product.images"
                        :key="img.id"
                        :src="img.url"
                        @click="selectedImage = img.url"
                        class="border rounded"
                        :class="{ 'border-primary border-2': selectedImage === img.url }"
                        style="width: 72px; height: 72px; object-fit: cover; cursor: pointer"
                    />
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
    </div>
    <div v-else class="container py-5 text-center">
        <div class="spinner-border text-primary"></div>
    </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref, watch } from 'vue';
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
const selectedImage = ref(null);
const reviewForm = reactive({ rating: 0, body: '' });

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

const currentImage = computed(() => {
    if (selectedImage.value) return selectedImage.value;
    return product.value?.primary_image_url
        || product.value?.images?.[0]?.url
        || 'data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22600%22 height=%22600%22><rect fill=%22%23eef0f5%22 width=%22600%22 height=%22600%22/></svg>';
});

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
    selectedImage.value = null;
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

onMounted(load);
watch(() => route.params.slug, load);
</script>
