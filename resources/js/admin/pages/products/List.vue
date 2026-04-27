<script setup>
import { onMounted, reactive, ref, watch } from 'vue';
import { toast } from 'vue3-toastify';
import api from '../../services/api';
import { useAuthStore } from '../../stores/auth';

const auth = useAuthStore();
const items = ref([]);
const meta = ref({ current_page: 1, last_page: 1, total: 0 });
const filters = reactive({ q: '', category_id: '', brand_id: '', is_active: '', sort: '-id' });
const categories = ref([]);
const brands = ref([]);
const loading = ref(false);
let timer;

async function load(page = 1) {
    loading.value = true;
    const params = { page, ...filters };
    Object.keys(params).forEach((k) => params[k] === '' && delete params[k]);
    const { data } = await api.get('/products', { params });
    items.value = data.data;
    meta.value = data;
    loading.value = false;
}

watch(filters, () => { clearTimeout(timer); timer = setTimeout(() => load(1), 300); });

async function remove(p) {
    if (!confirm(`Удалить товар «${p.name}»?`)) return;
    try {
        await api.delete(`/products/${p.id}`);
        toast.success('Удалено');
        load(meta.value.current_page);
    } catch (e) { toast.error(e.response?.data?.message || 'Ошибка'); }
}

onMounted(async () => {
    [{ data: { data: categories.value } }, { data: brands.value }] = await Promise.all([
        api.get('/categories', { params: { flat: 1 } }).then(r => ({ data: { data: r.data } })),
        api.get('/brands/all'),
    ]);
    load();
});

function fmt(p) { return new Intl.NumberFormat('ru-RU').format(p) + ' ₽'; }
</script>

<template>
    <div class="toolbar">
        <input v-model="filters.q" class="search-input" placeholder="Поиск по названию/SKU…" />
        <select v-model="filters.category_id"><option value="">Все категории</option><option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option></select>
        <select v-model="filters.brand_id"><option value="">Все бренды</option><option v-for="b in brands" :key="b.id" :value="b.id">{{ b.name }}</option></select>
        <select v-model="filters.is_active"><option value="">Любой статус</option><option value="1">Активные</option><option value="0">Скрытые</option></select>
        <select v-model="filters.sort">
            <option value="-id">Новые сверху</option>
            <option value="id">Старые сверху</option>
            <option value="name">По имени ↑</option>
            <option value="-price">Цена ↓</option>
            <option value="price">Цена ↑</option>
            <option value="stock">Остаток ↑</option>
        </select>
        <div class="grow"></div>
        <router-link class="btn btn-primary" :to="{ name: 'product-new' }">+ Добавить</router-link>
    </div>

    <div class="card">
        <div class="table-wrap">
            <table class="data">
                <thead><tr><th></th><th>Название</th><th>SKU</th><th>Категория</th><th>Бренд</th><th>Цена</th><th>Остаток</th><th>Статус</th><th></th></tr></thead>
                <tbody>
                    <tr v-for="p in items" :key="p.id">
                        <td><img v-if="p.image" :src="`/storage/${p.image}`" class="image-thumb" /></td>
                        <td><router-link :to="{ name: 'product-edit', params: { id: p.id } }">{{ p.name }}</router-link></td>
                        <td>{{ p.sku || '—' }}</td>
                        <td>{{ p.category?.name || '—' }}</td>
                        <td>{{ p.brand?.name || '—' }}</td>
                        <td>{{ fmt(p.sale_price || p.price) }}</td>
                        <td>{{ p.stock }}</td>
                        <td><span class="badge" :class="p.is_active ? 'badge-paid' : 'badge-canceled'">{{ p.is_active ? 'Активен' : 'Скрыт' }}</span></td>
                        <td class="row-actions">
                            <router-link class="btn btn-sm" :to="{ name: 'product-edit', params: { id: p.id } }">Изм.</router-link>
                            <button v-if="auth.isAdmin" class="btn btn-sm btn-danger" @click="remove(p)">Удалить</button>
                        </td>
                    </tr>
                    <tr v-if="!loading && !items.length"><td colspan="9" class="empty">Товары не найдены</td></tr>
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
