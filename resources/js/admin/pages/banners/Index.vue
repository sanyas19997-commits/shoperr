<script setup>
import { onMounted, reactive, ref, computed } from 'vue';
import { toast } from 'vue3-toastify';
import api from '../../services/api';
import { useAuthStore } from '../../stores/auth';

const auth = useAuthStore();
const items = ref([]);
const meta = ref({});
const placeFilter = ref('');
const editing = ref(null);
const imageFile = ref(null);
const form = reactive({
    id: null, place: 'hero_slide', title: '', subtitle: '', label: '', price_label: '',
    link: '', button_text: '', sort_order: 0, is_active: true,
});
const errors = ref({});

const places = [
    { value: 'hero_slide', label: 'Hero-слайд (главная)' },
    { value: 'deal_left', label: 'Левый баннер (block-section-4)' },
    { value: 'deal_right', label: 'Правый баннер (block-section-4)' },
    { value: 'animal_kids', label: 'Коллекция (block-section-6)' },
    { value: 'promo_bg', label: 'Промо (block-section-2)' },
];

function mediaUrl(path) {
    if (!path) return '';
    if (/^https?:\/\//i.test(path)) return path;
    if (path.startsWith('kidify/') || path.startsWith('/')) return '/' + path.replace(/^\//, '');
    return '/storage/' + path;
}

async function load(page = 1) {
    const { data } = await api.get('/banners', { params: { page, place: placeFilter.value || undefined } });
    items.value = data.data;
    meta.value = data;
}

function startNew() {
    Object.assign(form, { id: null, place: 'hero_slide', title: '', subtitle: '', label: '', price_label: '', link: '', button_text: '', sort_order: 0, is_active: true });
    imageFile.value = null;
    editing.value = 'new';
    errors.value = {};
}

function startEdit(b) {
    Object.assign(form, b);
    imageFile.value = null;
    editing.value = b.id;
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
        await api.post(form.id ? `/banners/${form.id}` : '/banners', fd, { headers: { 'Content-Type': 'multipart/form-data' } });
        toast.success('Сохранено');
        editing.value = null;
        load(meta.value.current_page || 1);
    } catch (e) {
        errors.value = e.response?.data?.errors || {};
        toast.error('Ошибка сохранения');
    }
}

async function remove(b) {
    if (!confirm(`Удалить баннер «${b.title || b.place}»?`)) return;
    try {
        await api.delete(`/banners/${b.id}`);
        toast.success('Удалено');
        load(meta.value.current_page || 1);
    } catch (e) {
        toast.error(e.response?.data?.message || 'Ошибка');
    }
}

function onImage(e) { imageFile.value = e.target.files[0] || null; }
function placeLabel(p) { return places.find(x => x.value === p)?.label || p; }

onMounted(load);
</script>

<template>
    <div class="toolbar">
        <select v-model="placeFilter" @change="load(1)" class="search-input">
            <option value="">Все места</option>
            <option v-for="p in places" :key="p.value" :value="p.value">{{ p.label }}</option>
        </select>
        <div class="grow"></div>
        <button class="btn btn-primary" @click="startNew">+ Добавить баннер</button>
    </div>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
        <div class="card">
            <div class="table-wrap">
                <table class="data">
                    <thead><tr><th>Картинка</th><th>Место</th><th>Заголовок</th><th>Порядок</th><th>Статус</th><th></th></tr></thead>
                    <tbody>
                        <tr v-for="b in items" :key="b.id">
                            <td><img v-if="b.image" :src="mediaUrl(b.image)" style="width:60px;height:40px;object-fit:cover;border-radius:6px;" /></td>
                            <td><span style="font-size:12px;">{{ placeLabel(b.place) }}</span></td>
                            <td>{{ b.title }}</td>
                            <td>{{ b.sort_order }}</td>
                            <td><span class="badge" :class="b.is_active ? 'badge-paid' : 'badge-canceled'">{{ b.is_active ? 'активен' : 'скрыт' }}</span></td>
                            <td class="row-actions">
                                <button class="btn btn-sm" @click="startEdit(b)">Изм.</button>
                                <button v-if="auth.isAdmin" class="btn btn-sm btn-danger" @click="remove(b)">×</button>
                            </td>
                        </tr>
                        <tr v-if="!items.length"><td colspan="6" class="empty">Баннеров нет</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div v-if="editing" class="card">
            <div class="card-head">
                <h3>{{ form.id ? 'Редактирование' : 'Новый баннер' }}</h3>
                <button class="btn btn-sm" @click="editing = null">×</button>
            </div>
            <div class="card-pad">
                <div class="form-group">
                    <label>Место *</label>
                    <select v-model="form.place">
                        <option v-for="p in places" :key="p.value" :value="p.value">{{ p.label }}</option>
                    </select>
                </div>
                <div class="form-group"><label>Заголовок</label><input v-model="form.title" /></div>
                <div class="form-group"><label>Подзаголовок / текст</label><textarea v-model="form.subtitle"></textarea></div>
                <div class="form-group"><label>Доп. лейбл</label><input v-model="form.label" /></div>
                <div class="form-group"><label>Цена/значок</label><input v-model="form.price_label" /></div>
                <div class="form-group"><label>Ссылка</label><input v-model="form.link" placeholder="/catalog" /></div>
                <div class="form-group"><label>Текст кнопки</label><input v-model="form.button_text" /></div>
                <div class="form-group"><label>Порядок</label><input v-model.number="form.sort_order" type="number" /></div>
                <div class="form-group"><label>Картинка</label>
                    <div v-if="form.image" style="margin-bottom:8px;"><img :src="mediaUrl(form.image)" style="max-height:100px;border-radius:6px;" /></div>
                    <input type="file" accept="image/*" @change="onImage" />
                </div>
                <div class="checkbox-row form-group"><input id="banner-active" v-model="form.is_active" type="checkbox" /><label for="banner-active" style="margin:0;">Активен</label></div>
                <button class="btn btn-primary" @click="save">Сохранить</button>
            </div>
        </div>
    </div>
</template>
