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
            <h3 class="h5 fw-bold mb-3">Отзывы</h3>
            <div v-if="auth.isAuthenticated" class="card p-3 mb-3">
                <h6 class="fw-semibold">Оставить отзыв</h6>
                <div class="mb-2">
                    <label class="small">Оценка:</label>
                    <div>
                        <i
                            v-for="i in 5"
                            :key="i"
                            class="bi fs-4"
                            :class="[i <= reviewForm.rating ? 'bi-star-fill rating-star' : 'bi-star rating-star empty']"
                            style="cursor: pointer"
                            @click="reviewForm.rating = i"
                        ></i>
                    </div>
                </div>
                <textarea v-model="reviewForm.body" class="form-control mb-2" rows="3" placeholder="Ваш отзыв..."></textarea>
                <div>
                    <button class="btn btn-primary btn-sm" @click="submitReview" :disabled="!reviewForm.rating">Отправить</button>
                </div>
            </div>
            <div v-else class="alert alert-info">
                <router-link :to="{ name: 'login' }">Войдите</router-link>, чтобы оставить отзыв.
            </div>

            <div v-if="reviews.length">
                <div v-for="r in reviews" :key="r.id" class="card p-3 mb-2">
                    <div class="d-flex justify-content-between">
                        <div>
                            <strong>{{ r.user_name || 'Пользователь' }}</strong>
                            <RatingStars :value="r.rating" class="ms-2" />
                        </div>
                        <small class="text-muted">{{ formatDate(r.created_at) }}</small>
                    </div>
                    <div v-if="r.body" class="mt-2">{{ r.body }}</div>
                </div>
            </div>
            <div v-else class="text-muted small">Отзывов пока нет.</div>
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
import ProductList from '../components/ProductList.vue';
import RatingStars from '../components/RatingStars.vue';
import { formatPrice, formatDate } from '../utils/format';

const route = useRoute();
const auth = useAuthStore();
const cart = useCartStore();
const favorites = useFavoritesStore();

const product = ref(null);
const similar = ref([]);
const reviews = ref([]);
const qty = ref(1);
const adding = ref(false);
const selectedImage = ref(null);
const reviewForm = reactive({ rating: 0, body: '' });

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
    similar.value = data.similar?.data || [];
    selectedImage.value = null;
    await loadReviews();
}

async function loadReviews() {
    const { data } = await api.get(`/products/${product.value.id}/reviews`);
    reviews.value = data.data;
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
    await api.post(`/products/${product.value.id}/reviews`, {
        rating: reviewForm.rating,
        body: reviewForm.body,
    });
    reviewForm.rating = 0;
    reviewForm.body = '';
    await loadReviews();
    await load();
}

onMounted(load);
watch(() => route.params.slug, load);
</script>
