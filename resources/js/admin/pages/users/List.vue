<script setup>
import { onMounted, reactive, ref, watch } from 'vue';
import { toast } from 'vue3-toastify';
import api from '../../services/api';
import { useAuthStore } from '../../stores/auth';

const auth = useAuthStore();
const items = ref([]);
const meta = ref({});
const filters = reactive({ q: '', role: '' });
const showCreate = ref(false);
const newUser = reactive({ name: '', email: '', phone: '', role: 'manager', password: '' });
const errors = ref({});
let timer;

async function load(page = 1) {
    const params = { page, ...filters };
    Object.keys(params).forEach(k => params[k] === '' && delete params[k]);
    const { data } = await api.get('/users', { params });
    items.value = data.data;
    meta.value = data;
}

watch(filters, () => { clearTimeout(timer); timer = setTimeout(() => load(1), 300); });

async function create() {
    errors.value = {};
    try {
        await api.post('/users', newUser);
        toast.success('Создано');
        showCreate.value = false;
        Object.assign(newUser, { name: '', email: '', phone: '', role: 'manager', password: '' });
        load(1);
    } catch (e) {
        errors.value = e.response?.data?.errors || {};
        toast.error(e.response?.data?.message || 'Ошибка');
    }
}

async function remove(u) {
    if (!confirm(`Удалить пользователя «${u.name}»?`)) return;
    try { await api.delete(`/users/${u.id}`); toast.success('Удалено'); load(meta.value.current_page); }
    catch (e) { toast.error(e.response?.data?.message || 'Ошибка'); }
}

onMounted(load);
</script>

<template>
    <div class="toolbar">
        <input v-model="filters.q" class="search-input" placeholder="Имя, email, телефон…" />
        <select v-model="filters.role">
            <option value="">Все роли</option>
            <option value="admin">Администраторы</option>
            <option value="manager">Менеджеры</option>
            <option value="customer">Клиенты</option>
        </select>
        <div class="grow"></div>
        <button v-if="auth.isAdmin" class="btn btn-primary" @click="showCreate = !showCreate">+ Создать сотрудника</button>
    </div>

    <div v-if="showCreate" class="card card-pad" style="margin-bottom:20px;">
        <h3 style="margin-top:0;">Новый сотрудник</h3>
        <div class="form-row">
            <div class="form-group"><label>Имя *</label><input v-model="newUser.name" required />
                <div v-if="errors.name" class="error-text">{{ errors.name[0] }}</div>
            </div>
            <div class="form-group"><label>Email *</label><input v-model="newUser.email" type="email" required />
                <div v-if="errors.email" class="error-text">{{ errors.email[0] }}</div>
            </div>
        </div>
        <div class="form-row">
            <div class="form-group"><label>Телефон</label><input v-model="newUser.phone" /></div>
            <div class="form-group"><label>Роль *</label>
                <select v-model="newUser.role">
                    <option value="manager">Менеджер</option>
                    <option value="admin">Администратор</option>
                </select>
            </div>
        </div>
        <div class="form-group"><label>Пароль *</label><input v-model="newUser.password" type="password" minlength="8" required />
            <div v-if="errors.password" class="error-text">{{ errors.password[0] }}</div>
        </div>
        <button class="btn btn-primary" @click="create">Создать</button>
    </div>

    <div class="card">
        <div class="table-wrap">
            <table class="data">
                <thead><tr><th>Имя</th><th>Email</th><th>Телефон</th><th>Роль</th><th>Заказов</th><th></th></tr></thead>
                <tbody>
                    <tr v-for="u in items" :key="u.id">
                        <td><router-link :to="{ name: 'user-detail', params: { id: u.id } }">{{ u.name }}</router-link></td>
                        <td>{{ u.email }}</td>
                        <td>{{ u.phone || '—' }}</td>
                        <td><span class="badge" :class="u.role === 'admin' ? 'badge-shipped' : (u.role === 'manager' ? 'badge-processing' : 'badge-new')">{{ u.role }}</span></td>
                        <td>{{ u.orders_count }}</td>
                        <td class="row-actions">
                            <router-link class="btn btn-sm" :to="{ name: 'user-detail', params: { id: u.id } }">Открыть</router-link>
                            <button v-if="auth.isAdmin && u.id !== auth.user.id" class="btn btn-sm btn-danger" @click="remove(u)">×</button>
                        </td>
                    </tr>
                    <tr v-if="!items.length"><td colspan="6" class="empty">Пользователей нет</td></tr>
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
