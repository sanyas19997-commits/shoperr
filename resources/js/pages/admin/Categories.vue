<template>
    <div>
        <div class="d-flex justify-content-between mb-3">
            <h1 class="h3 fw-bold">Категории</h1>
            <button class="btn btn-primary" @click="openForm(null)"><i class="bi bi-plus-lg me-1"></i>Добавить</button>
        </div>
        <div class="card p-3">
            <table class="table align-middle">
                <thead><tr><th>Название</th><th>Slug</th><th>Родитель</th><th>Сорт.</th><th>Активна</th><th></th></tr></thead>
                <tbody>
                    <tr v-for="c in categories" :key="c.id">
                        <td>{{ c.name }}</td>
                        <td class="text-muted">{{ c.slug }}</td>
                        <td>{{ findName(c.parent_id) }}</td>
                        <td>{{ c.sort_order }}</td>
                        <td>
                            <span class="badge" :class="c.is_active ? 'text-bg-success' : 'text-bg-secondary'">
                                {{ c.is_active ? 'Да' : 'Нет' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-primary me-1" @click="openForm(c)"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-outline-danger" @click="remove(c)"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-if="showForm" class="modal-overlay" @click.self="closeForm">
            <div class="modal-dialog-custom card p-4">
                <h5 class="fw-bold">{{ form.id ? 'Редактировать' : 'Новая категория' }}</h5>
                <form @submit.prevent="save">
                    <div class="mb-3">
                        <label class="form-label">Название *</label>
                        <input v-model="form.name" required class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Slug</label>
                        <input v-model="form.slug" class="form-control" placeholder="оставьте пустым для авто" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Родительская категория</label>
                        <select v-model.number="form.parent_id" class="form-select">
                            <option :value="null">Нет</option>
                            <option v-for="c in parentOptions" :key="c.id" :value="c.id">{{ c.name }}</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Описание</label>
                        <textarea v-model="form.description" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label">Сортировка</label>
                            <input v-model.number="form.sort_order" type="number" class="form-control" />
                        </div>
                        <div class="col-md-6 pt-4">
                            <div class="form-check form-switch">
                                <input id="cat_active" v-model="form.is_active" type="checkbox" class="form-check-input" />
                                <label for="cat_active" class="form-check-label">Активна</label>
                            </div>
                        </div>
                    </div>
                    <div v-if="error" class="alert alert-danger mt-2">{{ error }}</div>
                    <div class="mt-3 d-flex gap-2">
                        <button class="btn btn-primary" :disabled="saving">Сохранить</button>
                        <button type="button" class="btn btn-outline-secondary" @click="closeForm">Отмена</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import api from '../../api';

const categories = ref([]);
const showForm = ref(false);
const saving = ref(false);
const error = ref('');
const form = reactive({ id: null, name: '', slug: '', parent_id: null, description: '', sort_order: 0, is_active: true });

const parentOptions = computed(() => categories.value.filter(c => c.id !== form.id));

function findName(id) {
    return categories.value.find(c => c.id === id)?.name || '';
}

async function load() {
    const { data } = await api.get('/admin/categories');
    categories.value = data.data;
}
function openForm(c) {
    Object.assign(form, { id: null, name: '', slug: '', parent_id: null, description: '', sort_order: 0, is_active: true });
    if (c) Object.assign(form, c);
    error.value = '';
    showForm.value = true;
}
function closeForm() { showForm.value = false; }

async function save() {
    saving.value = true; error.value = '';
    try {
        const payload = { ...form };
        delete payload.id;
        if (form.id) await api.put(`/admin/categories/${form.id}`, payload);
        else await api.post('/admin/categories', payload);
        closeForm();
        await load();
    } catch (e) {
        const errs = e.response?.data?.errors;
        error.value = errs ? Object.values(errs).flat().join(' ') : (e.response?.data?.message || 'Ошибка');
    } finally {
        saving.value = false;
    }
}
async function remove(c) {
    if (!confirm(`Удалить «${c.name}»?`)) return;
    await api.delete(`/admin/categories/${c.id}`);
    await load();
}

onMounted(load);
</script>

<style scoped>
.modal-overlay {
    position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 1050;
    display: flex; align-items: center; justify-content: center; padding: 1rem;
}
.modal-dialog-custom { width: 100%; max-width: 560px; }
</style>
