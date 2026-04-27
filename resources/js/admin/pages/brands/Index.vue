<script setup>
import { onMounted, reactive, ref } from 'vue';
import { toast } from 'vue3-toastify';
import api from '../../services/api';
import { useAuthStore } from '../../stores/auth';

const auth = useAuthStore();
const items = ref([]);
const meta = ref({});
const search = ref('');
const editing = ref(null);
const form = reactive({ id: null, name: '', slug: '', description: '', is_active: true });
const errors = ref({});

async function load(page = 1) {
    const { data } = await api.get('/brands', { params: { page, q: search.value || undefined } });
    items.value = data.data;
    meta.value = data;
}

function startNew() { Object.assign(form, { id: null, name: '', slug: '', description: '', is_active: true }); editing.value = 'new'; errors.value = {}; }
async function startEdit(b) { Object.assign(form, b); editing.value = b.id; errors.value = {}; }

async function save() {
    errors.value = {};
    try {
        await api.post(form.id ? `/brands/${form.id}` : '/brands', form);
        toast.success('Сохранено'); editing.value = null; load(meta.value.current_page);
    } catch (e) { errors.value = e.response?.data?.errors || {}; toast.error('Ошибка'); }
}

async function remove(b) {
    if (!confirm(`Удалить бренд «${b.name}»?`)) return;
    try { await api.delete(`/brands/${b.id}`); toast.success('Удалено'); load(meta.value.current_page); }
    catch (e) { toast.error(e.response?.data?.message || 'Ошибка'); }
}

onMounted(load);
</script>

<template>
    <div class="toolbar">
        <input v-model="search" class="search-input" placeholder="Поиск…" @input="load(1)" />
        <div class="grow"></div>
        <button class="btn btn-primary" @click="startNew">+ Добавить бренд</button>
    </div>

    <div style="display:grid; grid-template-columns: 1fr 1fr; gap:20px;">
        <div class="card">
            <div class="table-wrap">
                <table class="data">
                    <thead><tr><th>Название</th><th>Slug</th><th>Статус</th><th></th></tr></thead>
                    <tbody>
                        <tr v-for="b in items" :key="b.id">
                            <td>{{ b.name }}</td>
                            <td>{{ b.slug }}</td>
                            <td><span class="badge" :class="b.is_active ? 'badge-paid' : 'badge-canceled'">{{ b.is_active ? 'активен' : 'скрыт' }}</span></td>
                            <td class="row-actions">
                                <button class="btn btn-sm" @click="startEdit(b)">Изм.</button>
                                <button v-if="auth.isAdmin" class="btn btn-sm btn-danger" @click="remove(b)">×</button>
                            </td>
                        </tr>
                        <tr v-if="!items.length"><td colspan="4" class="empty">Брендов нет</td></tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div v-if="editing" class="card">
            <div class="card-head"><h3>{{ form.id ? 'Редактирование' : 'Новый бренд' }}</h3>
                <button class="btn btn-sm" @click="editing = null">×</button></div>
            <div class="card-pad">
                <div class="form-group"><label>Название *</label><input v-model="form.name" required />
                    <div v-if="errors.name" class="error-text">{{ errors.name[0] }}</div>
                </div>
                <div class="form-group"><label>Slug</label><input v-model="form.slug" /></div>
                <div class="form-group"><label>Описание</label><textarea v-model="form.description"></textarea></div>
                <div class="checkbox-row form-group"><input id="brand-active" v-model="form.is_active" type="checkbox" /><label for="brand-active" style="margin:0;">Активен</label></div>
                <button class="btn btn-primary" @click="save">Сохранить</button>
            </div>
        </div>
    </div>
</template>
