<template>
    <div>
        <h1 class="h3 fw-bold mb-4">Дашборд</h1>
        <div v-if="!data" class="text-center py-5"><div class="spinner-border"></div></div>
        <div v-else>
            <div class="row g-3 mb-4">
                <div class="col-md-3">
                    <div class="card p-3">
                        <small class="text-muted">Пользователи</small>
                        <div class="fs-3 fw-bold">{{ data.stats.users }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3">
                        <small class="text-muted">Товары</small>
                        <div class="fs-3 fw-bold">{{ data.stats.products }}</div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3">
                        <small class="text-muted">Заказы (новые)</small>
                        <div class="fs-3 fw-bold">{{ data.stats.orders }} <small class="text-primary">({{ data.stats.new_orders }})</small></div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card p-3">
                        <small class="text-muted">Выручка</small>
                        <div class="fs-3 fw-bold">{{ formatPrice(data.stats.revenue) }} ₽</div>
                    </div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-lg-7">
                    <div class="card p-3">
                        <h5 class="fw-semibold mb-3">Последние заказы</h5>
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr><th>№</th><th>Клиент</th><th>Сумма</th><th>Статус</th><th></th></tr>
                            </thead>
                            <tbody>
                                <tr v-for="o in data.recent_orders" :key="o.id">
                                    <td>{{ o.number }}</td>
                                    <td>{{ o.customer_name }}</td>
                                    <td>{{ formatPrice(o.total) }} ₽</td>
                                    <td><span class="badge" :class="`badge-status-${o.status}`">{{ statusLabel(o.status) }}</span></td>
                                    <td><router-link :to="{ name: 'admin.orders.show', params: { id: o.id } }" class="small">Открыть</router-link></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card p-3">
                        <h5 class="fw-semibold mb-3">Популярные товары</h5>
                        <div v-for="p in data.top_products" :key="p.id" class="d-flex align-items-center gap-2 border-bottom py-2">
                            <img :src="p.image_url || placeholder" class="rounded" style="width: 48px; height: 48px; object-fit: cover" />
                            <div class="flex-grow-1 small">{{ p.name }}</div>
                            <div class="small text-muted">{{ p.views }} <i class="bi bi-eye"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import api from '../../api';
import { formatPrice, statusLabel } from '../../utils/format';

const data = ref(null);
const placeholder = 'data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2250%22 height=%2250%22><rect fill=%22%23eef0f5%22 width=%2250%22 height=%2250%22/></svg>';
onMounted(async () => {
    const res = await api.get('/admin/dashboard');
    data.value = res.data;
});
</script>
