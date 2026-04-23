<template>
    <div>
        <div class="d-flex justify-content-between mb-3">
            <h1 class="h3 fw-bold">Товары</h1>
            <router-link :to="{ name: 'admin.products.new' }" class="btn btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Добавить
            </router-link>
        </div>
        <div class="card p-3">
            <div class="d-flex gap-2 mb-3">
                <input v-model="q" @keyup.enter="load(1)" class="form-control" placeholder="Поиск..." />
                <button class="btn btn-outline-primary" @click="load(1)">Найти</button>
            </div>
            <table class="table align-middle">
                <thead>
                    <tr><th></th><th>Название</th><th>Категория</th><th>Цена</th><th>Остаток</th><th>Активен</th><th></th></tr>
                </thead>
                <tbody>
                    <tr v-for="p in products" :key="p.id">
                        <td><img :src="p.primary_image_url || placeholder" class="rounded" style="width: 48px; height: 48px; object-fit: cover" /></td>
                        <td>{{ p.name }}</td>
                        <td>{{ p.category?.name }}</td>
                        <td>{{ formatPrice(p.price) }} ₽</td>
                        <td>{{ p.stock }}</td>
                        <td>
                            <span class="badge" :class="p.is_active ? 'text-bg-success' : 'text-bg-secondary'">
                                {{ p.is_active ? 'Да' : 'Нет' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <router-link :to="{ name: 'admin.products.edit', params: { id: p.id } }" class="btn btn-sm btn-outline-primary me-1">
                                <i class="bi bi-pencil"></i>
                            </router-link>
                            <button class="btn btn-sm btn-outline-danger" @click="remove(p)"><i class="bi bi-trash"></i></button>
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
import { formatPrice } from '../../utils/format';
import { useConfirmStore } from '../../stores/confirm';
import { useToastStore } from '../../stores/toast';

const confirmStore = useConfirmStore();
const toasts = useToastStore();
const products = ref([]);
const meta = reactive({ current_page: 1, last_page: 1 });
const q = ref('');
const placeholder = 'data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%2250%22 height=%2250%22><rect fill=%22%23eef0f5%22 width=%2250%22 height=%2250%22/></svg>';

async function load(page = 1) {
    const { data } = await api.get('/admin/products', { params: { page, q: q.value || undefined } });
    products.value = data.data;
    Object.assign(meta, data.meta);
}
async function remove(p) {
    const ok = await confirmStore.ask({
        title: 'Удалить товар',
        message: `Удалить «${p.name}»? Это действие нельзя отменить.`,
        confirmLabel: 'Удалить',
    });
    if (!ok) return;
    await api.delete(`/admin/products/${p.id}`);
    toasts.success(`«${p.name}» удалён`);
    await load(meta.current_page);
}
onMounted(() => load(1));
</script>
