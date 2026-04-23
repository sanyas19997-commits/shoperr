<template>
    <div class="container py-4" v-if="order">
        <router-link :to="{ name: 'orders' }" class="small"><i class="bi bi-arrow-left me-1"></i>К заказам</router-link>
        <h1 class="h3 fw-bold mt-2 mb-4">Заказ № {{ order.number }}</h1>
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card p-3 mb-3">
                    <h5 class="fw-semibold">Состав</h5>
                    <div v-for="item in order.items" :key="item.id" class="d-flex gap-3 border-bottom py-2 align-items-center">
                        <img :src="item.product?.primary_image_url || item.product?.images?.[0]?.url || placeholder" class="rounded" style="width: 64px; height: 64px; object-fit: cover" />
                        <div class="flex-grow-1">
                            <div>{{ item.product_name }}</div>
                            <small class="text-muted">{{ item.quantity }} × {{ formatPrice(item.price) }} ₽</small>
                        </div>
                        <div class="fw-semibold">{{ formatPrice(item.subtotal) }} ₽</div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card p-3 mb-3">
                    <h6 class="fw-semibold">Статус</h6>
                    <span class="badge" :class="`badge-status-${order.status}`">{{ statusLabel(order.status) }}</span>
                    <hr />
                    <div class="small">Создан: {{ formatDate(order.created_at) }}</div>
                </div>
                <div class="card p-3 mb-3">
                    <h6 class="fw-semibold">Доставка</h6>
                    <div><strong>{{ order.customer_name }}</strong></div>
                    <div>{{ order.customer_phone }}</div>
                    <div>{{ order.customer_email }}</div>
                    <div class="small text-muted mt-2">{{ order.shipping_address }}</div>
                    <div v-if="order.comment" class="small mt-2"><em>{{ order.comment }}</em></div>
                </div>
                <div class="card p-3">
                    <div class="d-flex justify-content-between fs-5 fw-bold">
                        <span>Итого</span>
                        <span>{{ formatPrice(order.total) }} ₽</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import api from '../api';
import { formatDate, formatPrice, statusLabel } from '../utils/format';

const route = useRoute();
const order = ref(null);
const placeholder = 'data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%22100%22><rect fill=%22%23eef0f5%22 width=%22100%22 height=%22100%22/></svg>';

onMounted(async () => {
    const { data } = await api.get(`/orders/${route.params.id}`);
    order.value = data.data;
});
</script>
