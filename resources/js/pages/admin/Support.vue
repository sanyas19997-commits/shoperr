<template>
    <div>
        <div class="d-flex align-items-center justify-content-between mb-3">
            <div>
                <h1 class="h4 fw-bold mb-1">Поддержка</h1>
                <div class="small text-muted">
                    Всего: {{ stats.total || 0 }} · Открыто: {{ stats.open || 0 }} · Непрочитанных: {{ stats.unread || 0 }}
                </div>
            </div>
        </div>

        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body p-3 d-flex flex-wrap gap-2">
                <input v-model="search" @keyup.enter="load" class="form-control" style="max-width: 300px" placeholder="Поиск по теме, имени, email..." />
                <select v-model="statusFilter" @change="load" class="form-select" style="max-width: 200px">
                    <option value="">Все статусы</option>
                    <option value="open">Ожидает ответа</option>
                    <option value="pending">На рассмотрении</option>
                    <option value="answered">Отвечено</option>
                    <option value="closed">Закрыт</option>
                </select>
                <button class="btn btn-primary" @click="load">
                    <i class="bi bi-search me-1"></i>Найти
                </button>
            </div>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div v-if="loading" class="text-center text-muted py-4">
                    <span class="spinner-border spinner-border-sm me-2"></span>Загрузка…
                </div>
                <div v-else-if="!tickets.length" class="text-center text-muted py-4">Тикетов нет.</div>
                <div v-else class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Пользователь</th>
                                <th>Тема</th>
                                <th>Статус</th>
                                <th>Обновлено</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="t in tickets" :key="t.id" :class="{ 'table-warning': t.unread > 0 }">
                                <td class="text-muted">#{{ t.id }}</td>
                                <td>
                                    <div class="fw-semibold">{{ t.user_name }}</div>
                                    <div class="small text-muted">{{ t.user_email }}</div>
                                </td>
                                <td>
                                    <div>{{ t.subject }}</div>
                                    <div v-if="t.last_message" class="small text-muted text-truncate" style="max-width: 360px">
                                        <i v-if="t.last_message.is_admin" class="bi bi-reply me-1"></i>
                                        {{ t.last_message.body }}
                                    </div>
                                </td>
                                <td><span class="badge" :class="statusClass(t.status)">{{ statusLabel(t.status) }}</span></td>
                                <td class="small text-muted">{{ formatDateTime(t.last_message_at) }}</td>
                                <td class="text-end">
                                    <router-link :to="{ name: 'admin.support.show', params: { id: t.id } }" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-chat-right-text me-1"></i>Открыть
                                        <span v-if="t.unread > 0" class="badge bg-danger ms-1">{{ t.unread }}</span>
                                    </router-link>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import api from '../../api';
import { formatDateTime } from '../../utils/format';

const tickets = ref([]);
const stats = ref({});
const loading = ref(true);
const search = ref('');
const statusFilter = ref('');

async function load() {
    loading.value = true;
    try {
        const params = {};
        if (search.value) params.search = search.value;
        if (statusFilter.value) params.status = statusFilter.value;
        const [list, s] = await Promise.all([
            api.get('/admin/support/tickets', { params }),
            api.get('/admin/support/stats', { silent: true }),
        ]);
        tickets.value = list.data.data || [];
        stats.value = s.data || {};
    } finally {
        loading.value = false;
    }
}

function statusLabel(s) {
    return { open: 'Открыт', answered: 'Отвечено', pending: 'Ждёт ответа', closed: 'Закрыт' }[s] || s;
}
function statusClass(s) {
    return {
        open: 'bg-warning text-dark',
        answered: 'bg-success',
        pending: 'bg-info text-dark',
        closed: 'bg-secondary',
    }[s] || 'bg-secondary';
}

onMounted(load);
</script>
