<template>
    <div class="card product-card">
        <router-link :to="{ name: 'product', params: { slug: product.slug } }" class="position-relative d-block">
            <img :src="imageUrl" :alt="product.name" class="product-image card-img-top" loading="lazy" />
            <span v-if="product.discount_percent" class="discount-badge position-absolute top-0 start-0 m-2">
                -{{ product.discount_percent }}%
            </span>
            <button
                v-if="auth.isAuthenticated"
                type="button"
                class="btn btn-sm btn-light position-absolute top-0 end-0 m-2 rounded-circle"
                @click.prevent="toggleFavorite"
            >
                <i :class="isFav ? 'bi bi-heart-fill text-danger' : 'bi bi-heart'"></i>
            </button>
        </router-link>
        <div class="card-body d-flex flex-column">
            <div class="mb-1 small text-muted" v-if="product.category?.name">{{ product.category.name }}</div>
            <router-link :to="{ name: 'product', params: { slug: product.slug } }" class="text-dark mb-2 fw-medium">
                {{ product.name }}
            </router-link>
            <div class="mb-2">
                <RatingStars :value="product.rating" :reviews="product.reviews_count" />
            </div>
            <div class="mt-auto">
                <div class="d-flex align-items-baseline gap-2 mb-2">
                    <span class="fs-5 fw-semibold">{{ formatPrice(product.price) }} ₽</span>
                    <span v-if="product.old_price" class="old-price">{{ formatPrice(product.old_price) }} ₽</span>
                </div>
                <button class="btn btn-primary w-100 btn-sm" :disabled="!product.in_stock || adding" @click="addToCart">
                    <span v-if="adding"><span class="spinner-border spinner-border-sm"></span></span>
                    <span v-else-if="product.in_stock"><i class="bi bi-cart-plus me-1"></i>В корзину</span>
                    <span v-else>Нет в наличии</span>
                </button>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, ref } from 'vue';
import { useCartStore } from '../stores/cart';
import { useAuthStore } from '../stores/auth';
import { useFavoritesStore } from '../stores/favorites';
import RatingStars from './RatingStars.vue';
import { formatPrice } from '../utils/format';

const props = defineProps({
    product: { type: Object, required: true },
});

const cart = useCartStore();
const auth = useAuthStore();
const favorites = useFavoritesStore();
const adding = ref(false);

const imageUrl = computed(() => {
    return props.product.primary_image_url
        || props.product.images?.[0]?.url
        || 'data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22400%22><rect fill=%22%23eef0f5%22 width=%22400%22 height=%22400%22/><text x=%22200%22 y=%22210%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2220%22 fill=%22%23aab1be%22>Нет изображения</text></svg>';
});

const isFav = computed(() => favorites.has(props.product.id));

async function addToCart() {
    adding.value = true;
    try {
        await cart.addItem(props.product.id, 1);
    } finally {
        adding.value = false;
    }
}

async function toggleFavorite() {
    await favorites.toggle(props.product.id);
}
</script>
