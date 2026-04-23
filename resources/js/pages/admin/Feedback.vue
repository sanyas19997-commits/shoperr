<template>
    <div>
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="h4 mb-0">Обратная связь</h2>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <div class="row g-2 mb-3">
                    <div class="col-md-4">
                        <input v-model="filters.q" type="search" class="form-control" placeholder="Поиск по имени, email, теме..." @keyup.enter="load" />
                    </div>
                    <div class="col-md-3">
                        <select v-model="filters.status" class="form-select" @change="load">
                            <option value="">Все статусы</option>
                            <option v-for="s in STATUSES" :key="s.value" :value="s.value">{{ s.label }}</option>
                        </select>
                    </div>
                    <div class="col-md-5 text-md-end">
                        <button class="btn btn-outline-primary" @click="load"><i class="bi bi-arrow-clockwise me-1"></i>Обновить</button>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table align-middle">
                        <thead>
                            <tr>
                                <th>Дата</th>
                                <th>От кого</th>
                                <th>Тема</th>
                                <th>Статус</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-if="!items.length && !loading">
                                <td colspan="5" class="text-center text-muted py-4">Пока нет сообщений</td>
                            </tr>
                            <tr v-for="it in items" :key="it.id" :class="{ 'table-warning': it.status === 'new' }">
                                <td class="small text-muted">{{ formatDate(it.created_at) }}</td>
                                <td>
                                    <div class="fw-semibold">{{ it.name }}</div>
                                    <div class="small text-muted">{{ it.email }}<span v-if="it.phone"> · {{ it.phone }}</span></div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-truncate" style="max-width: 300px;">{{ it.subject }}</div>
                                    <div class="small text-muted text-truncate" style="max-width: 420px;">{{ it.message }}</div>
                                </td>
                                <td>
                                    <span class="badge" :class="statusBadge(it.status)">{{ statusLabel(it.status) }}</span>
                                </td>
                                <td class="text-end">
                                    <router-link :to="{ name: 'admin.feedback.show', params: { id: it.id } }" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i>
                                    </router-link>
                                    <button class="btn btn-sm btn-outline-danger ms-1" @click="confirmDelete(it)">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div v-if="meta.last_page > 1" class="d-flex justify-content-center mt-3">
                    <ul class="pagination mb-0">
                        <li class="page-item" :class="{ disabled: meta.current_page <= 1 }">
                            <a href="#" class="page-link" @click.prevent="go(meta.current_page - 1)">‹</a>
                        </li>
                        <li v-for="p in meta.last_page" :key="p" class="page-item" :class="{ active: p === meta.current_page }">
                            <a href="#" class="page-link" @click.prevent="go(p)">{{ p }}</a>
                        </li>
                        <li class="page-item" :class="{ disabled: meta.current_page >= meta.last_page }">
                            <a href="#" class="page-link" @click.prevent="go(meta.current_page + 1)">›</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <AppModal v-model="deleteModal.open" title="Удалить сообщение?" size="sm">
            <p class="mb-0">Сообщение от <strong>{{ deleteModal.item?.name }}</strong> будет удалено без возможности восстановления.</p>
            <template #footer>
                <button class="btn btn-light" @click="deleteModal.open = false">Отмена</button>
                <button class="btn btn-danger" :disabled="deleteModal.busy" @click="doDelete">
                    <span v-if="deleteModal.busy" class="spinner-border spinner-border-sm me-2"></span>Удалить
                </button>
            </template>
        </AppModal>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import api from '../../api';
import AppModal from '../../components/AppModal.vue';

const STATUSES = [
    { value: 'new', label: 'Новое' },
    { value: 'read', label: 'Прочитано' },
    { value: 'answered', label: 'Отвечено' },
    { value: 'archived', label: 'В архиве' },
];

const items = ref([]);
const meta = reactive({ current_page: 1, last_page: 1, total: 0 });
const loading = ref(false);
const filters = reactive({ q: '', status: '' });
const deleteModal = reactive({ open: false, item: null, busy: false });

function statusLabel(s) {
    return STATUSES.find((x) => x.value === s)?.label || s;
}
function statusBadge(s) {
    return { new: 'bg-danger', read: 'bg-secondary', answered: 'bg-success', archived: 'bg-dark' }[s] || 'bg-secondary';
}
function formatDate(iso) {
    if (!iso) return '';
    try {
        return new Date(iso).toLocaleString('ru-RU', { dateStyle: 'short', timeStyle: 'short' });
    } catch (_) {
        return iso;
    }
}

async function load(page = 1) {
    loading.value = true;
    try {
        const { data } = await api.get('/admin/feedback', {
            params: { page, q: filters.q || undefined, status: filters.status || undefined },
        });
        items.value = data.data;
        Object.assign(meta, data.meta || { current_page: 1, last_page: 1, total: data.data.length });
    } finally {
        loading.value = false;
    }
}

function go(page) {
    if (page < 1 || page > meta.last_page) return;
    load(page);
}

function confirmDelete(item) {
    deleteModal.item = item;
    deleteModal.open = true;
}
async function doDelete() {
    deleteModal.busy = true;
    try {
        await api.delete(`/admin/feedback/${deleteModal.item.id}`);
        deleteModal.open = false;
        await load(meta.current_page);
    } finally {
        deleteModal.busy = false;
    }
}

onMounted(() => load());
</script>
