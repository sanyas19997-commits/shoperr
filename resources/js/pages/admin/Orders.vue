<template>
    <div>
        <h1 class="h3 fw-bold mb-3">Заказы</h1>
        <div class="card p-3">
            <div class="row g-2 mb-3">
                <div class="col-md-4">
                    <input v-model="q" @keyup.enter="load(1)" class="form-control" placeholder="Поиск по номеру/клиенту..." />
                </div>
                <div class="col-md-3">
                    <select v-model="status" @change="load(1)" class="form-select">
                        <option value="">Все статусы</option>
                        <option v-for="s in statuses" :key="s" :value="s">{{ statusLabel(s) }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-primary w-100" @click="load(1)">Фильтр</button>
                </div>
            </div>
            <table class="table align-middle">
                <thead><tr><th>№</th><th>Клиент</th><th>Сумма</th><th>Статус</th><th>Дата</th><th></th></tr></thead>
                <tbody>
                    <tr v-for="o in orders" :key="o.id">
                        <td>{{ o.number }}</td>
                        <td>{{ o.customer_name }}<br /><small class="text-muted">{{ o.customer_phone }}</small></td>
                        <td>{{ formatPrice(o.total) }} ₽</td>
                        <td>
                            <select :value="o.status" class="form-select form-select-sm" @change="changeStatus(o, $event.target.value)">
                                <option v-for="s in statuses" :key="s" :value="s">{{ statusLabel(s) }}</option>
                            </select>
                        </td>
                        <td>{{ formatDate(o.created_at) }}</td>
                        <td>
                            <router-link :to="{ name: 'admin.orders.show', params: { id: o.id } }" class="btn btn-sm btn-outline-primary">Детали</router-link>
                        </td>
                    </tr>
                </tbody>
            </table>
            <Pagination v-if="meta.last_page > 1" :current-page="meta.current_page" :last-page="meta.last_page" @change="load" />
        </div>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import api from '../../api';
import Pagination from '../../components/Pagination.vue';
import { formatDate, formatPrice, statusLabel } from '../../utils/format';

const orders = ref([]);
const meta = reactive({ current_page: 1, last_page: 1 });
const q = ref('');
const status = ref('');
const statuses = ['new', 'processing', 'shipped', 'completed', 'cancelled'];

async function load(page = 1) {
    const { data } = await api.get('/admin/orders', {
        params: { page, q: q.value || undefined, status: status.value || undefined }
    });
    orders.value = data.data;
    Object.assign(meta, data.meta);
}
async function changeStatus(o, newStatus) {
    await api.put(`/admin/orders/${o.id}/status`, { status: newStatus });
    o.status = newStatus;
}
onMounted(() => load(1));
</script>
