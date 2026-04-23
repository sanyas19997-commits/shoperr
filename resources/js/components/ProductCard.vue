<template>
    <div class="card product-card">
        <router-link :to="{ name: 'product', params: { slug: product.slug } }" class="d-block">
            <div class="product-image-wrap">
                <img :src="imageUrl" :alt="product.name" class="product-image" loading="lazy" />
                <div class="product-badges">
                    <span v-if="product.discount_percent" class="discount-badge">-{{ product.discount_percent }}%</span>
                    <span v-if="isNew" class="badge-new">Новинка</span>
                    <span v-if="isHit" class="badge-hit">Хит</span>
                </div>
                <div class="product-actions" @click.stop.prevent>
                    <button type="button"
                            class="fav-btn"
                            :class="{ active: isFav }"
                            :aria-label="isFav ? 'Убрать из избранного' : 'В избранное'"
                            @click.prevent="toggleFavorite">
                        <i :class="isFav ? 'bi bi-heart-fill' : 'bi bi-heart'"></i>
                    </button>
                </div>
                <div v-if="!product.in_stock" class="oos-overlay">Нет в наличии</div>
            </div>
        </router-link>
        <div class="card-body d-flex flex-column">
            <div class="mb-1 small text-muted text-truncate" v-if="product.category?.name">{{ product.category.name }}</div>
            <router-link :to="{ name: 'product', params: { slug: product.slug } }" class="text-dark product-title mb-2">
                {{ product.name }}
            </router-link>
            <div class="mb-2">
                <RatingStars :value="product.rating" :reviews="product.reviews_count" />
            </div>
            <div class="mt-auto">
                <div class="d-flex align-items-baseline gap-2 mb-2">
                    <span class="current-price">{{ formatPrice(product.price) }} ₽</span>
                    <span v-if="product.old_price" class="old-price">{{ formatPrice(product.old_price) }} ₽</span>
                </div>
                <button class="btn btn-primary w-100 btn-sm" :disabled="!product.in_stock || adding" @click="addToCart">
                    <span v-if="adding"><span class="spinner-border spinner-border-sm"></span></span>
                    <template v-else-if="product.in_stock"><i class="bi bi-cart-plus me-1"></i>В корзину</template>
                    <template v-else>Нет в наличии</template>
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
import { useToastStore } from '../stores/toast';
import RatingStars from './RatingStars.vue';
import { formatPrice } from '../utils/format';

const props = defineProps({
    product: { type: Object, required: true },
});

const cart = useCartStore();
const auth = useAuthStore();
const favorites = useFavoritesStore();
const toasts = useToastStore();
const adding = ref(false);

const imageUrl = computed(() => {
    return props.product.primary_image_url
        || props.product.images?.[0]?.url
        || 'data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22400%22><rect fill=%22%23eef0f5%22 width=%22400%22 height=%22400%22/><text x=%22200%22 y=%22210%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2220%22 fill=%22%23aab1be%22>Нет изображения</text></svg>';
});

const isFav = computed(() => favorites.has(props.product.id));

const isNew = computed(() => {
    if (!props.product.created_at) return false;
    const created = new Date(props.product.created_at).getTime();
    return created && (Date.now() - created) < 1000 * 60 * 60 * 24 * 30;
});
const isHit = computed(() => (props.product.orders_count || 0) > 10);

async function addToCart() {
    adding.value = true;
    try {
        await cart.addItem(props.product.id, 1);
        toasts.success(`${props.product.name} добавлен в корзину`, 'В корзине');
    } finally {
        adding.value = false;
    }
}

async function toggleFavorite() {
    if (!auth.isAuthenticated) {
        toasts.info('Войдите в аккаунт, чтобы добавить в избранное');
        return;
    }
    try {
        const wasActive = isFav.value;
        await favorites.toggle(props.product.id);
        toasts.success(wasActive ? 'Удалено из избранного' : 'Добавлено в избранное', '');
    } catch (_) {}
}
</script>

<style scoped>
.oos-overlay {
    position: absolute;
    inset: 0;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(255, 255, 255, 0.75);
    color: #475569;
    font-weight: 600;
    letter-spacing: 0.02em;
    backdrop-filter: blur(2px);
}
</style>
