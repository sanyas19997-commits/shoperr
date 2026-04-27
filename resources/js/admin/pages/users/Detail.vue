<script setup>
import { onMounted, reactive, ref } from 'vue';
import { useRoute } from 'vue-router';
import { toast } from 'vue3-toastify';
import api from '../../services/api';
import { useAuthStore } from '../../stores/auth';

const auth = useAuthStore();
const route = useRoute();
const user = ref(null);
const form = reactive({ name: '', email: '', phone: '', role: '', password: '' });
const errors = ref({});

async function load() {
    const { data } = await api.get(`/users/${route.params.id}`);
    user.value = data.data;
    Object.assign(form, { name: user.value.name, email: user.value.email, phone: user.value.phone || '', role: user.value.role });
}

async function save() {
    errors.value = {};
    const payload = { ...form };
    if (!payload.password) delete payload.password;
    try {
        await api.patch(`/users/${user.value.id}`, payload);
        toast.success('Сохранено');
        load();
    } catch (e) { errors.value = e.response?.data?.errors || {}; toast.error('Ошибка'); }
}

function fmt(n) { return new Intl.NumberFormat('ru-RU').format(n) + ' ₽'; }
function fmtDate(d) { return new Date(d).toLocaleDateString('ru-RU'); }

onMounted(load);
</script>

<template>
    <div v-if="!user" class="empty">Загрузка…</div>
    <div v-else style="display:grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="card">
            <div class="card-head"><h3>{{ user.name }}</h3><span class="badge" :class="user.role === 'admin' ? 'badge-shipped' : 'badge-new'">{{ user.role }}</span></div>
            <div class="card-pad">
                <div class="form-group"><label>Имя</label><input v-model="form.name" /></div>
                <div class="form-group"><label>Email</label><input v-model="form.email" /></div>
                <div class="form-group"><label>Телефон</label><input v-model="form.phone" /></div>
                <div v-if="auth.isAdmin && user.id !== auth.user.id" class="form-group"><label>Роль</label>
                    <select v-model="form.role">
                        <option value="customer">Клиент</option>
                        <option value="manager">Менеджер</option>
                        <option value="admin">Администратор</option>
                    </select>
                </div>
                <div v-if="auth.isAdmin && user.id !== auth.user.id" class="form-group"><label>Новый пароль</label><input v-model="form.password" type="password" minlength="8" placeholder="оставьте пустым, чтобы не менять" /></div>
                <button class="btn btn-primary" @click="save">Сохранить</button>
            </div>
        </div>
        <div class="card">
            <div class="card-head"><h3>История заказов</h3><span class="badge badge-new">{{ user.orders_count }}</span></div>
            <div class="table-wrap">
                <table class="data">
                    <thead><tr><th>Номер</th><th>Сумма</th><th>Статус</th><th>Дата</th></tr></thead>
                    <tbody>
                        <tr v-for="o in user.orders" :key="o.id">
                            <td><router-link :to="{ name: 'order-detail', params: { id: o.id } }">{{ o.number }}</router-link></td>
                            <td>{{ fmt(o.total) }}</td>
                            <td><span class="badge" :class="`badge-${o.status}`">{{ o.status }}</span></td>
                            <td>{{ fmtDate(o.created_at) }}</td>
                        </tr>
                        <tr v-if="!user.orders.length"><td colspan="4" class="empty">Заказов нет</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>
