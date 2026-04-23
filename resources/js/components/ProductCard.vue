<template>
    <div class="product-card">
        <router-link :to="{ name: 'product', params: { slug: product.slug } }" class="d-block">
            <div class="product-image-wrap">
                <img :src="imageUrl" :alt="product.name" class="product-image" loading="lazy" />
                <div class="ribbons">
                    <span v-if="isHit" class="ribbon ribbon-hot">Hot</span>
                    <span v-if="product.discount_percent" class="ribbon ribbon-save">-{{ product.discount_percent }}%</span>
                    <span v-if="isNew" class="ribbon ribbon-new">New</span>
                </div>
                <button type="button"
                        class="fav-btn"
                        :class="{ active: isFav }"
                        :aria-label="isFav ? 'Убрать из избранного' : 'В избранное'"
                        @click.prevent.stop="toggleFavorite">
                    <i :class="isFav ? 'bi bi-heart-fill' : 'bi bi-heart'"></i>
                </button>
                <div v-if="!product.in_stock" class="oos-overlay">Нет в наличии</div>
            </div>
        </router-link>
        <div class="card-body">
            <div class="vendor text-truncate">{{ vendorName }}</div>
            <router-link :to="{ name: 'product', params: { slug: product.slug } }" class="product-title">
                {{ product.name }}
            </router-link>
            <div class="rating">
                <RatingStars :value="product.rating" :reviews="product.reviews_count" />
            </div>
            <div class="prices">
                <span class="price">{{ formatPrice(product.price) }} ₽</span>
                <span v-if="product.old_price" class="price-old">{{ formatPrice(product.old_price) }} ₽</span>
            </div>
            <div v-if="product.category?.name" class="sold-by text-truncate">
                В категории: {{ product.category.name }}
            </div>
            <button class="add-to-cart" :disabled="!product.in_stock || adding" @click="addToCart">
                <span v-if="adding"><span class="spinner-border spinner-border-sm"></span></span>
                <template v-else-if="product.in_stock"><i class="bi bi-cart-plus me-1"></i>В корзину</template>
                <template v-else>Нет в наличии</template>
            </button>
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
        || 'data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22400%22 height=%22400%22><rect fill=%22%23f5f5f5%22 width=%22400%22 height=%22400%22/><text x=%22200%22 y=%22210%22 text-anchor=%22middle%22 font-family=%22Arial%22 font-size=%2218%22 fill=%22%23bcbcbc%22>Нет изображения</text></svg>';
});

const isFav = computed(() => favorites.has(props.product.id));

const isNew = computed(() => {
    if (!props.product.created_at) return false;
    const created = new Date(props.product.created_at).getTime();
    return created && (Date.now() - created) < 1000 * 60 * 60 * 24 * 30;
});
const isHit = computed(() => (props.product.orders_count || 0) > 10 || props.product.is_featured);

const vendorName = computed(() => {
    return (props.product.vendor && props.product.vendor.name)
        || props.product.brand
        || 'SHOPHUB';
});

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
