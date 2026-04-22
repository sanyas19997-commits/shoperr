<template>
    <div>
        <div v-if="loading" class="text-center py-5">
            <div class="spinner-border text-primary"></div>
        </div>
        <div v-else-if="!products.length" class="text-center py-5 text-muted">
            <i class="bi bi-search fs-1 d-block mb-2"></i>
            Товары не найдены
        </div>
        <div v-else class="row g-3 g-md-4">
            <div v-for="product in products" :key="product.id" class="col-6 col-md-4 col-lg-3">
                <ProductCard :product="product" />
            </div>
        </div>
    </div>
</template>

<script setup>
import ProductCard from './ProductCard.vue';

defineProps({
    products: { type: Array, default: () => [] },
    loading: { type: Boolean, default: false },
});
</script>
