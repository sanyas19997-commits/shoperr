<template>
    <div>
        <h1 class="h3 fw-bold mb-3">Пользователи</h1>
        <div class="card p-3">
            <div class="d-flex gap-2 mb-3">
                <input v-model="q" @keyup.enter="load(1)" class="form-control" placeholder="Поиск..." />
                <select v-model="role" @change="load(1)" class="form-select" style="max-width: 200px">
                    <option value="">Все роли</option>
                    <option value="user">Пользователь</option>
                    <option value="admin">Админ</option>
                </select>
                <button class="btn btn-outline-primary" @click="load(1)">Фильтр</button>
            </div>
            <table class="table align-middle">
                <thead><tr><th>Имя</th><th>Email</th><th>Телефон</th><th>Роль</th><th>Дата</th><th></th></tr></thead>
                <tbody>
                    <tr v-for="u in users" :key="u.id">
                        <td>{{ u.name }}</td>
                        <td>{{ u.email }}</td>
                        <td>{{ u.phone || '—' }}</td>
                        <td>
                            <select :value="u.role" class="form-select form-select-sm" style="max-width: 140px" @change="changeRole(u, $event.target.value)">
                                <option value="user">Пользователь</option>
                                <option value="admin">Админ</option>
                            </select>
                        </td>
                        <td>{{ formatDate(u.created_at) }}</td>
                        <td>
                            <button class="btn btn-sm btn-outline-danger" :disabled="u.is_admin" @click="remove(u)">
                                <i class="bi bi-trash"></i>
                            </button>
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
import { formatDate } from '../../utils/format';

const users = ref([]);
const meta = reactive({ current_page: 1, last_page: 1 });
const q = ref(''); const role = ref('');

async function load(page = 1) {
    const { data } = await api.get('/admin/users', { params: { page, q: q.value || undefined, role: role.value || undefined } });
    users.value = data.data;
    Object.assign(meta, data.meta);
}
async function changeRole(u, newRole) {
    await api.put(`/admin/users/${u.id}`, { role: newRole });
    u.role = newRole;
}
async function remove(u) {
    if (!confirm(`Удалить пользователя «${u.name}»?`)) return;
    await api.delete(`/admin/users/${u.id}`);
    await load(meta.current_page);
}
onMounted(() => load(1));
</script>
