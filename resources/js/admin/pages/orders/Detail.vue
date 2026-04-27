<script setup>
import { onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { toast } from 'vue3-toastify';
import api from '../../services/api';
import { useAuthStore } from '../../stores/auth';

const auth = useAuthStore();
const route = useRoute();
const router = useRouter();
const order = ref(null);
const statuses = ref({});

async function load() {
    const [{ data }, { data: opts }] = await Promise.all([
        api.get(`/orders/${route.params.id}`),
        api.get('/orders/options'),
    ]);
    order.value = data.data;
    statuses.value = opts.statuses;
}

async function changeStatus() {
    try {
        await api.patch(`/orders/${order.value.id}`, { status: order.value.status });
        toast.success('Статус изменён');
        load();
    } catch (e) { toast.error('Ошибка'); }
}

async function remove() {
    if (!confirm('Удалить заказ?')) return;
    try {
        await api.delete(`/orders/${order.value.id}`);
        toast.success('Удалено');
        router.push({ name: 'orders' });
    } catch (e) { toast.error(e.response?.data?.message || 'Ошибка'); }
}

function fmt(n) { return new Intl.NumberFormat('ru-RU').format(n) + ' ₽'; }

onMounted(load);
</script>

<template>
    <div v-if="!order" class="empty">Загрузка…</div>
    <div v-else>
        <div class="toolbar">
            <router-link class="btn" :to="{ name: 'orders' }">← К списку</router-link>
            <h2 style="margin:0;">Заказ {{ order.number }}</h2>
            <div class="grow"></div>
            <select v-model="order.status" @change="changeStatus">
                <option v-for="(label, key) in statuses" :key="key" :value="key">{{ label }}</option>
            </select>
            <button v-if="auth.isAdmin" class="btn btn-danger" @click="remove">Удалить</button>
        </div>
        <div style="display:grid; grid-template-columns: 2fr 1fr; gap:20px;">
            <div class="card">
                <div class="card-head"><h3>Состав</h3></div>
                <div class="table-wrap">
                    <table class="data">
                        <thead><tr><th>Товар</th><th>Цена</th><th>Кол-во</th><th>Сумма</th></tr></thead>
                        <tbody>
                            <tr v-for="i in order.items" :key="i.id">
                                <td>{{ i.name }} <span style="color:var(--muted); font-size:12px;">{{ i.product?.sku ? '· ' + i.product.sku : '' }}</span></td>
                                <td>{{ fmt(i.price) }}</td>
                                <td>{{ i.quantity }}</td>
                                <td>{{ fmt(i.price * i.quantity) }}</td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr><th colspan="3" style="text-align:right;">Подытог</th><th>{{ fmt(order.subtotal) }}</th></tr>
                            <tr v-if="order.shipping_cost > 0"><th colspan="3" style="text-align:right;">Доставка</th><th>{{ fmt(order.shipping_cost) }}</th></tr>
                            <tr v-if="order.discount > 0"><th colspan="3" style="text-align:right;">Скидка</th><th>−{{ fmt(order.discount) }}</th></tr>
                            <tr><th colspan="3" style="text-align:right;">Итого</th><th>{{ fmt(order.total) }}</th></tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="card card-pad">
                <h3 style="margin-top:0;">Клиент</h3>
                <p><strong>{{ order.customer_name }}</strong></p>
                <p><a :href="`mailto:${order.customer_email}`">{{ order.customer_email }}</a></p>
                <p><a :href="`tel:${order.customer_phone}`">{{ order.customer_phone }}</a></p>
                <h4>Доставка</h4>
                <p>{{ order.delivery_method_label }}</p>
                <p v-if="order.city">{{ order.city }}, {{ order.address }}</p>
                <h4>Оплата</h4>
                <p>{{ order.payment_method_label }} ({{ order.payment_status || '—' }})</p>
                <h4 v-if="order.comment">Комментарий</h4>
                <p v-if="order.comment">{{ order.comment }}</p>
            </div>
        </div>
    </div>
</template>
