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
const form = reactive({ id: null, link: '', sort_order: 0, is_active: true });
const errors = ref({});

function mediaUrl(p) {
    if (!p) return '';
    if (/^https?:\/\//i.test(p)) return p;
    if (p.startsWith('kidify/') || p.startsWith('/')) return '/' + p.replace(/^\//, '');
    return '/storage/' + p;
}

async function load(page = 1) {
    const { data } = await api.get('/instagram', { params: { page } });
    items.value = data.data;
    meta.value = data;
}

function startNew() {
    Object.assign(form, { id: null, link: '', sort_order: 0, is_active: true });
    imageFile.value = null;
    editing.value = 'new';
    errors.value = {};
}

function startEdit(p) {
    Object.assign(form, p);
    imageFile.value = null;
    editing.value = p.id;
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
    if (imageFile.value) fd.append('image', imageFile.value);
    try {
        await api.post(form.id ? `/instagram/${form.id}` : '/instagram', fd, { headers: { 'Content-Type': 'multipart/form-data' } });
        toast.success('Сохранено');
        editing.value = null;
        load(meta.value.current_page || 1);
    } catch (e) { errors.value = e.response?.data?.errors || {}; toast.error('Ошибка'); }
}

async function remove(p) {
    if (!confirm('Удалить?')) return;
    try { await api.delete(`/instagram/${p.id}`); toast.success('Удалено'); load(meta.value.current_page || 1); }
    catch (e) { toast.error(e.response?.data?.message || 'Ошибка'); }
}

function onImage(e) { imageFile.value = e.target.files[0] || null; }

onMounted(load);
</script>

<template>
    <div class="toolbar">
        <div class="grow"></div>
        <button class="btn btn-primary" @click="startNew">+ Добавить фото</button>
    </div>
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
        <div class="card">
            <div class="table-wrap">
                <table class="data">
                    <thead><tr><th>Фото</th><th>Ссылка</th><th>Порядок</th><th>Статус</th><th></th></tr></thead>
                    <tbody>
                        <tr v-for="p in items" :key="p.id">
                            <td><img v-if="p.image" :src="mediaUrl(p.image)" style="width:60px;height:60px;object-fit:cover;border-radius:6px;" /></td>
                            <td style="max-width:240px;overflow:hidden;text-overflow:ellipsis;"><a :href="p.link" target="_blank">{{ p.link }}</a></td>
                            <td>{{ p.sort_order }}</td>
                            <td><span class="badge" :class="p.is_active ? 'badge-paid' : 'badge-canceled'">{{ p.is_active ? 'активен' : 'скрыт' }}</span></td>
                            <td class="row-actions">
                                <button class="btn btn-sm" @click="startEdit(p)">Изм.</button>
                                <button v-if="auth.isAdmin" class="btn btn-sm btn-danger" @click="remove(p)">×</button>
                            </td>
                        </tr>
                        <tr v-if="!items.length"><td colspan="5" class="empty">Фото нет</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="editing" class="card">
            <div class="card-head"><h3>{{ form.id ? 'Редактирование' : 'Новое фото' }}</h3>
                <button class="btn btn-sm" @click="editing = null">×</button></div>
            <div class="card-pad">
                <div class="form-group"><label>Ссылка</label><input v-model="form.link" placeholder="https://instagram.com/p/..." /></div>
                <div class="form-group"><label>Порядок</label><input v-model.number="form.sort_order" type="number" /></div>
                <div class="form-group"><label>Картинка *</label>
                    <div v-if="form.image" style="margin-bottom:8px;"><img :src="mediaUrl(form.image)" style="width:120px;height:120px;object-fit:cover;border-radius:6px;" /></div>
                    <input type="file" accept="image/*" @change="onImage" />
                    <div v-if="errors.image" class="error-text">{{ errors.image[0] }}</div>
                </div>
                <div class="checkbox-row form-group"><input id="i-active" v-model="form.is_active" type="checkbox" /><label for="i-active" style="margin:0;">Активен</label></div>
                <button class="btn btn-primary" @click="save">Сохранить</button>
            </div>
        </div>
    </div>
</template>
