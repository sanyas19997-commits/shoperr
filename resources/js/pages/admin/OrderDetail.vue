<template>
    <div v-if="order">
        <router-link :to="{ name: 'admin.orders' }" class="small"><i class="bi bi-arrow-left me-1"></i>К списку</router-link>
        <h1 class="h3 fw-bold mt-2 mb-3">Заказ № {{ order.number }}</h1>
        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card p-3">
                    <h5 class="fw-semibold">Состав</h5>
                    <table class="table">
                        <thead><tr><th>Товар</th><th>Цена</th><th>Кол-во</th><th>Сумма</th></tr></thead>
                        <tbody>
                            <tr v-for="i in order.items" :key="i.id">
                                <td>{{ i.product_name }}</td>
                                <td>{{ formatPrice(i.price) }} ₽</td>
                                <td>{{ i.quantity }}</td>
                                <td>{{ formatPrice(i.subtotal) }} ₽</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr><th colspan="3" class="text-end">Итого:</th><th>{{ formatPrice(order.total) }} ₽</th></tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card p-3 mb-3">
                    <h6 class="fw-semibold">Статус</h6>
                    <select v-model="order.status" @change="updateStatus" class="form-select">
                        <option v-for="s in statuses" :key="s" :value="s">{{ statusLabel(s) }}</option>
                    </select>
                </div>
                <div class="card p-3">
                    <h6 class="fw-semibold">Покупатель</h6>
                    <div>{{ order.customer_name }}</div>
                    <div>{{ order.customer_phone }}</div>
                    <div>{{ order.customer_email }}</div>
                    <hr />
                    <div class="small"><strong>Адрес:</strong> {{ order.shipping_address }}</div>
                    <div v-if="order.comment" class="small mt-2"><em>{{ order.comment }}</em></div>
                    <div class="small text-muted mt-2">{{ formatDate(order.created_at) }}</div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRoute } from 'vue-router';
import api from '../../api';
import { formatDate, formatPrice, statusLabel } from '../../utils/format';

const route = useRoute();
const order = ref(null);
const statuses = ['new', 'processing', 'shipped', 'completed', 'cancelled'];

async function load() {
    const { data } = await api.get(`/admin/orders/${route.params.id}`);
    order.value = data.data;
}
async function updateStatus() {
    await api.put(`/admin/orders/${order.value.id}/status`, { status: order.value.status });
}
onMounted(load);
</script>
