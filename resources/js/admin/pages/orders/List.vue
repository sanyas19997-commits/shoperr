<script setup>
import { onMounted, reactive, ref, watch } from 'vue';
import api from '../../services/api';

const items = ref([]);
const meta = ref({ current_page: 1, last_page: 1 });
const filters = reactive({ q: '', status: '', from: '', to: '' });
const statuses = ref({});
let timer;

async function load(page = 1) {
    const params = { page, ...filters };
    Object.keys(params).forEach(k => params[k] === '' && delete params[k]);
    const { data } = await api.get('/orders', { params });
    items.value = data.data;
    meta.value = data;
}

watch(filters, () => { clearTimeout(timer); timer = setTimeout(() => load(1), 300); });

function exportCsv() {
    const params = new URLSearchParams();
    Object.entries(filters).forEach(([k, v]) => v && params.append(k, v));
    const token = localStorage.getItem('admin_token');
    fetch('/api/admin/orders/export?' + params.toString(), { headers: { Authorization: `Bearer ${token}` } })
        .then(r => r.blob()).then(b => {
            const a = document.createElement('a');
            a.href = URL.createObjectURL(b);
            a.download = `orders-${new Date().toISOString().slice(0,10)}.csv`;
            a.click();
        });
}

function fmt(n) { return new Intl.NumberFormat('ru-RU').format(n) + ' ₽'; }
function fmtDate(d) { return new Date(d).toLocaleString('ru-RU'); }

onMounted(async () => {
    const { data } = await api.get('/orders/options');
    statuses.value = data.statuses;
    load();
});
</script>

<template>
    <div class="toolbar">
        <input v-model="filters.q" class="search-input" placeholder="Номер, имя, email…" />
        <select v-model="filters.status">
            <option value="">Все статусы</option>
            <option v-for="(label, key) in statuses" :key="key" :value="key">{{ label }}</option>
        </select>
        <input v-model="filters.from" type="date" />
        <input v-model="filters.to" type="date" />
        <div class="grow"></div>
        <button class="btn" @click="exportCsv">⬇ Экспорт CSV</button>
    </div>
    <div class="card">
        <div class="table-wrap">
            <table class="data">
                <thead><tr><th>Номер</th><th>Клиент</th><th>Контакт</th><th>Статус</th><th>Сумма</th><th>Дата</th><th></th></tr></thead>
                <tbody>
                    <tr v-for="o in items" :key="o.id">
                        <td><router-link :to="{ name: 'order-detail', params: { id: o.id } }">{{ o.number }}</router-link></td>
                        <td>{{ o.customer_name }}</td>
                        <td><div>{{ o.customer_phone }}</div><div style="color:var(--muted); font-size:12px;">{{ o.customer_email }}</div></td>
                        <td><span class="badge" :class="`badge-${o.status}`">{{ statuses[o.status] || o.status }}</span></td>
                        <td>{{ fmt(o.total) }}</td>
                        <td>{{ fmtDate(o.created_at) }}</td>
                        <td><router-link class="btn btn-sm" :to="{ name: 'order-detail', params: { id: o.id } }">Открыть</router-link></td>
                    </tr>
                    <tr v-if="!items.length"><td colspan="7" class="empty">Заказов нет</td></tr>
                </tbody>
            </table>
        </div>
        <div class="pager" v-if="meta.last_page > 1">
            <button class="page" @click="load(meta.current_page - 1)" :disabled="meta.current_page === 1">←</button>
            <span class="page is-active">{{ meta.current_page }} / {{ meta.last_page }}</span>
            <button class="page" @click="load(meta.current_page + 1)" :disabled="meta.current_page === meta.last_page">→</button>
        </div>
    </div>
</template>
