<script setup>
import { onMounted, reactive, ref } from 'vue';
import { toast } from 'vue3-toastify';
import api from '../../services/api';
import { useAuthStore } from '../../stores/auth';

const auth = useAuthStore();
const items = ref([]);
const meta = ref({});
const editing = ref(null);
const imageFile = ref(null);
const form = reactive({ id: null, name: '', role: '', text: '', rating: 5, sort_order: 0, is_active: true });
const errors = ref({});

function mediaUrl(p) {
    if (!p) return '';
    if (/^https?:\/\//i.test(p)) return p;
    if (p.startsWith('kidify/') || p.startsWith('/')) return '/' + p.replace(/^\//, '');
    return '/storage/' + p;
}

async function load(page = 1) {
    const { data } = await api.get('/testimonials', { params: { page } });
    items.value = data.data;
    meta.value = data;
}

function startNew() {
    Object.assign(form, { id: null, name: '', role: '', text: '', rating: 5, sort_order: 0, is_active: true });
    imageFile.value = null;
    editing.value = 'new';
    errors.value = {};
}

function startEdit(t) {
    Object.assign(form, t);
    imageFile.value = null;
    editing.value = t.id;
    errors.value = {};
}

async function save() {
    errors.value = {};
    const fd = new FormData();
    Object.entries(form).forEach(([k, v]) => {
        if (k === 'id') return;
        if (typeof v === 'boolean') fd.append(k, v ? '1' : '0');
        else if (v !== null && v !== undefined) fd.append(k, v);
    });
    if (imageFile.value) fd.append('avatar', imageFile.value);
    try {
        await api.post(form.id ? `/testimonials/${form.id}` : '/testimonials', fd, { headers: { 'Content-Type': 'multipart/form-data' } });
        toast.success('Сохранено');
        editing.value = null;
        load(meta.value.current_page || 1);
    } catch (e) { errors.value = e.response?.data?.errors || {}; toast.error('Ошибка'); }
}

async function remove(t) {
    if (!confirm(`Удалить отзыв «${t.name}»?`)) return;
    try { await api.delete(`/testimonials/${t.id}`); toast.success('Удалено'); load(meta.value.current_page || 1); }
    catch (e) { toast.error(e.response?.data?.message || 'Ошибка'); }
}

function onImage(e) { imageFile.value = e.target.files[0] || null; }

onMounted(load);
</script>

<template>
    <div class="toolbar">
        <div class="grow"></div>
        <button class="btn btn-primary" @click="startNew">+ Добавить отзыв</button>
    </div>
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
        <div class="card">
            <div class="table-wrap">
                <table class="data">
                    <thead><tr><th>Аватар</th><th>Имя</th><th>Должность</th><th>Рейтинг</th><th>Статус</th><th></th></tr></thead>
                    <tbody>
                        <tr v-for="t in items" :key="t.id">
                            <td><img v-if="t.avatar" :src="mediaUrl(t.avatar)" style="width:40px;height:40px;border-radius:50%;object-fit:cover;" /></td>
                            <td>{{ t.name }}</td>
                            <td>{{ t.role }}</td>
                            <td>{{ '★'.repeat(t.rating || 5) }}</td>
                            <td><span class="badge" :class="t.is_active ? 'badge-paid' : 'badge-canceled'">{{ t.is_active ? 'активен' : 'скрыт' }}</span></td>
                            <td class="row-actions">
                                <button class="btn btn-sm" @click="startEdit(t)">Изм.</button>
                                <button v-if="auth.isAdmin" class="btn btn-sm btn-danger" @click="remove(t)">×</button>
                            </td>
                        </tr>
                        <tr v-if="!items.length"><td colspan="6" class="empty">Отзывов нет</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="editing" class="card">
            <div class="card-head"><h3>{{ form.id ? 'Редактирование' : 'Новый отзыв' }}</h3>
                <button class="btn btn-sm" @click="editing = null">×</button></div>
            <div class="card-pad">
                <div class="form-group"><label>Имя *</label><input v-model="form.name" required />
                    <div v-if="errors.name" class="error-text">{{ errors.name[0] }}</div></div>
                <div class="form-group"><label>Должность / роль</label><input v-model="form.role" /></div>
                <div class="form-group"><label>Текст отзыва *</label><textarea v-model="form.text" required rows="4"></textarea>
                    <div v-if="errors.text" class="error-text">{{ errors.text[0] }}</div></div>
                <div class="form-group"><label>Рейтинг (1-5)</label><input v-model.number="form.rating" type="number" min="1" max="5" /></div>
                <div class="form-group"><label>Порядок</label><input v-model.number="form.sort_order" type="number" /></div>
                <div class="form-group"><label>Аватар</label>
                    <div v-if="form.avatar" style="margin-bottom:8px;"><img :src="mediaUrl(form.avatar)" style="width:64px;height:64px;border-radius:50%;object-fit:cover;" /></div>
                    <input type="file" accept="image/*" @change="onImage" /></div>
                <div class="checkbox-row form-group"><input id="t-active" v-model="form.is_active" type="checkbox" /><label for="t-active" style="margin:0;">Активен</label></div>
                <button class="btn btn-primary" @click="save">Сохранить</button>
            </div>
        </div>
    </div>
</template>
