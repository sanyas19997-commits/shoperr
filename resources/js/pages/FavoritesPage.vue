<template>
    <div class="container py-4">
        <h1 class="h3 fw-bold mb-4"><i class="bi bi-heart-fill text-danger me-2"></i>Избранное</h1>
        <div v-if="favorites.loading" class="text-center py-5"><div class="spinner-border"></div></div>
        <div v-else-if="!favorites.list.length" class="text-center py-5 text-muted">
            Список избранного пуст.
        </div>
        <ProductList v-else :products="favorites.list" />
    </div>
</template>

<script setup>
import { onMounted } from 'vue';
import { useFavoritesStore } from '../stores/favorites';
import ProductList from '../components/ProductList.vue';

const favorites = useFavoritesStore();
onMounted(() => favorites.fetch());
</script>
