<script setup>
import { onMounted, reactive, ref } from 'vue';
import { toast } from 'vue3-toastify';
import api from '../../services/api';
import { useAuthStore } from '../../stores/auth';

const auth = useAuthStore();
const items = ref([]);
const meta = ref({});
const placementFilter = ref('');
const editing = ref(null);
const form = reactive({ id: null, placement: 'header', title: '', url: '/', sort_order: 0, is_active: true, open_new_tab: false });
const errors = ref({});

const placements = [
    { value: 'header', label: 'Верхнее меню шапки' },
    { value: 'footer_shop', label: 'Футер — Магазин' },
    { value: 'footer_customers', label: 'Футер — Покупателям' },
    { value: 'footer_help', label: 'Футер — Помощь' },
];

async function load(page = 1) {
    const { data } = await api.get('/menu', { params: { page, placement: placementFilter.value || undefined } });
    items.value = data.data;
    meta.value = data;
}

function startNew() {
    Object.assign(form, { id: null, placement: placementFilter.value || 'header', title: '', url: '/', sort_order: 0, is_active: true, open_new_tab: false });
    editing.value = 'new';
    errors.value = {};
}

function startEdit(m) {
    Object.assign(form, m);
    editing.value = m.id;
    errors.value = {};
}

async function save() {
    errors.value = {};
    try {
        await api.post(form.id ? `/menu/${form.id}` : '/menu', form);
        toast.success('Сохранено');
        editing.value = null;
        load(meta.value.current_page || 1);
    } catch (e) { errors.value = e.response?.data?.errors || {}; toast.error('Ошибка'); }
}

async function remove(m) {
    if (!confirm(`Удалить пункт «${m.title}»?`)) return;
    try { await api.delete(`/menu/${m.id}`); toast.success('Удалено'); load(meta.value.current_page || 1); }
    catch (e) { toast.error(e.response?.data?.message || 'Ошибка'); }
}

function placementLabel(p) { return placements.find(x => x.value === p)?.label || p; }

onMounted(load);
</script>

<template>
    <div class="toolbar">
        <select v-model="placementFilter" @change="load(1)" class="search-input">
            <option value="">Все места</option>
            <option v-for="p in placements" :key="p.value" :value="p.value">{{ p.label }}</option>
        </select>
        <div class="grow"></div>
        <button class="btn btn-primary" @click="startNew">+ Добавить пункт</button>
    </div>
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
        <div class="card">
            <div class="table-wrap">
                <table class="data">
                    <thead><tr><th>Место</th><th>Название</th><th>URL</th><th>Порядок</th><th>Статус</th><th></th></tr></thead>
                    <tbody>
                        <tr v-for="m in items" :key="m.id">
                            <td style="font-size:12px;">{{ placementLabel(m.placement) }}</td>
                            <td>{{ m.title }}</td>
                            <td style="font-family:monospace;font-size:12px;">{{ m.url }}</td>
                            <td>{{ m.sort_order }}</td>
                            <td><span class="badge" :class="m.is_active ? 'badge-paid' : 'badge-canceled'">{{ m.is_active ? 'активен' : 'скрыт' }}</span></td>
                            <td class="row-actions">
                                <button class="btn btn-sm" @click="startEdit(m)">Изм.</button>
                                <button v-if="auth.isAdmin" class="btn btn-sm btn-danger" @click="remove(m)">×</button>
                            </td>
                        </tr>
                        <tr v-if="!items.length"><td colspan="6" class="empty">Пунктов нет</td></tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div v-if="editing" class="card">
            <div class="card-head"><h3>{{ form.id ? 'Редактирование' : 'Новый пункт' }}</h3>
                <button class="btn btn-sm" @click="editing = null">×</button></div>
            <div class="card-pad">
                <div class="form-group"><label>Место *</label>
                    <select v-model="form.placement">
                        <option v-for="p in placements" :key="p.value" :value="p.value">{{ p.label }}</option>
                    </select>
                </div>
                <div class="form-group"><label>Название *</label><input v-model="form.title" required />
                    <div v-if="errors.title" class="error-text">{{ errors.title[0] }}</div></div>
                <div class="form-group"><label>URL *</label><input v-model="form.url" required placeholder="/catalog или https://…" />
                    <div v-if="errors.url" class="error-text">{{ errors.url[0] }}</div></div>
                <div class="form-group"><label>Порядок</label><input v-model.number="form.sort_order" type="number" /></div>
                <div class="checkbox-row form-group"><input id="m-active" v-model="form.is_active" type="checkbox" /><label for="m-active" style="margin:0;">Активен</label></div>
                <div class="checkbox-row form-group"><input id="m-newtab" v-model="form.open_new_tab" type="checkbox" /><label for="m-newtab" style="margin:0;">Открывать в новой вкладке</label></div>
                <button class="btn btn-primary" @click="save">Сохранить</button>
            </div>
        </div>
    </div>
</template>
