<script setup>
import { Link, router } from '@inertiajs/vue3';
import { ref } from 'vue';
import Price from './Price.vue';

const props = defineProps({
    product: { type: Object, required: true },
});

const adding = ref(false);

function addToCart() {
    if (adding.value) return;
    adding.value = true;
    router.post(`/cart/add/${props.product.id}`, { quantity: 1 }, {
        preserveScroll: true,
        preserveState: true,
        onFinish: () => { adding.value = false; },
    });
}

function img(p) {
    if (!p) return '/kidify/assets/imgs/page/homepage1/product1.png';
    if (p.startsWith('http') || p.startsWith('/')) return p;
    return '/storage/' + p;
}
</script>

<template>
    <div class="cardProduct wow animate__animated animate__fadeIn">
        <div class="cardImage">
            <Link :href="`/product/${product.slug}`">
                <img class="image-1" :src="img(product.main_image || product.image)" :alt="product.name">
                <img class="image-2" :src="img(product.image_2 || product.main_image || product.image)" :alt="product.name">
            </Link>
            <div v-if="product.sale_price && product.sale_price > 0 && product.sale_price < product.price" class="cardLabel">
                <span class="label-sale">SALE</span>
            </div>
        </div>
        <div class="cardInfo">
            <span class="font-xs neutral-500" v-if="product.category">{{ product.category.name }}</span>
            <h6 class="font-md-bold neutral-900 cardTitle">
                <Link :href="`/product/${product.slug}`">{{ product.name }}</Link>
            </h6>
            <div class="cardPrice">
                <h6 class="font-md-bold price-main neutral-900">
                    <Price :value="product.sale_price && product.sale_price > 0 ? product.sale_price : product.price" />
                </h6>
                <h6 v-if="product.sale_price && product.sale_price > 0 && product.sale_price < product.price"
                    class="font-md price-line neutral-500">
                    <Price :value="product.price" />
                </h6>
            </div>
            <div class="cardBtn">
                <button type="button" class="btn btn-cart" :disabled="adding" @click="addToCart">
                    {{ adding ? 'Добавляем...' : 'В корзину' }}
                </button>
            </div>
        </div>
    </div>
</template>
