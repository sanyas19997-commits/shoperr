<template>
    <div class="container py-4">
        <h1 class="h3 fw-bold mb-4">Мои заказы</h1>
        <div v-if="loading" class="text-center py-5"><div class="spinner-border"></div></div>
        <div v-else-if="!orders.length" class="text-center py-5 text-muted">
            Заказов пока нет. <router-link :to="{ name: 'catalog' }">Перейти в каталог</router-link>
        </div>
        <div v-else class="row g-3">
            <div v-for="order in orders" :key="order.id" class="col-12">
                <router-link :to="{ name: 'order', params: { id: order.id } }" class="card p-3 text-decoration-none text-dark">
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                        <div>
                            <div class="fw-semibold">№ {{ order.number }}</div>
                            <small class="text-muted">{{ formatDate(order.created_at) }}</small>
                        </div>
                        <div>
                            <span class="badge" :class="`badge-status-${order.status}`">{{ statusLabel(order.status) }}</span>
                        </div>
                        <div class="fw-semibold">{{ formatPrice(order.total) }} ₽</div>
                    </div>
                </router-link>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import api from '../api';
import { formatDate, formatPrice, statusLabel } from '../utils/format';

const orders = ref([]);
const loading = ref(true);

onMounted(async () => {
    try {
        const { data } = await api.get('/orders');
        orders.value = data.data;
    } finally {
        loading.value = false;
    }
});
</script>
