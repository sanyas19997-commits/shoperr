<template>
    <div>
        <div class="d-flex justify-content-between mb-3">
            <h1 class="h3 fw-bold">Баннеры</h1>
            <button class="btn btn-primary" @click="openForm(null)"><i class="bi bi-plus-lg me-1"></i>Добавить</button>
        </div>
        <div class="card p-3">
            <table class="table align-middle">
                <thead><tr><th></th><th>Заголовок</th><th>URL</th><th>Сорт.</th><th>Активен</th><th></th></tr></thead>
                <tbody>
                    <tr v-for="b in banners" :key="b.id">
                        <td><img :src="b.image_url" style="width: 120px; height: 60px; object-fit: cover" class="rounded border" /></td>
                        <td>{{ b.title }}<br /><small class="text-muted">{{ b.subtitle }}</small></td>
                        <td class="small">{{ b.url || '—' }}</td>
                        <td>{{ b.sort_order }}</td>
                        <td>
                            <span class="badge" :class="b.is_active ? 'text-bg-success' : 'text-bg-secondary'">
                                {{ b.is_active ? 'Да' : 'Нет' }}
                            </span>
                        </td>
                        <td class="text-end">
                            <button class="btn btn-sm btn-outline-primary me-1" @click="openForm(b)"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-sm btn-outline-danger" @click="remove(b)"><i class="bi bi-trash"></i></button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div v-if="showForm" class="modal-overlay" @click.self="closeForm">
            <div class="modal-dialog-custom card p-4">
                <h5 class="fw-bold">{{ form.id ? 'Редактировать' : 'Новый баннер' }}</h5>
                <form @submit.prevent="save">
                    <div class="mb-3"><label class="form-label">Заголовок *</label><input v-model="form.title" required class="form-control" /></div>
                    <div class="mb-3"><label class="form-label">Подзаголовок</label><input v-model="form.subtitle" class="form-control" /></div>
                    <div class="mb-3"><label class="form-label">URL изображения</label><input v-model="form.image" class="form-control" placeholder="https://..." /></div>
                    <div class="mb-3"><label class="form-label">URL ссылки</label><input v-model="form.url" class="form-control" placeholder="/catalog" /></div>
                    <div class="row g-2">
                        <div class="col-md-6"><label class="form-label">Сортировка</label><input v-model.number="form.sort_order" type="number" class="form-control" /></div>
                        <div class="col-md-6 pt-4">
                            <div class="form-check form-switch">
                                <input id="bn_active" v-model="form.is_active" type="checkbox" class="form-check-input" />
                                <label for="bn_active" class="form-check-label">Активен</label>
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
import { onMounted, reactive, ref } from 'vue';
import api from '../../api';
import { useConfirmStore } from '../../stores/confirm';
import { useToastStore } from '../../stores/toast';

const confirmStore = useConfirmStore();
const toasts = useToastStore();
const banners = ref([]);
const showForm = ref(false);
const saving = ref(false);
const error = ref('');
const form = reactive({ id: null, title: '', subtitle: '', image: '', url: '', sort_order: 0, is_active: true });

async function load() { const { data } = await api.get('/admin/banners'); banners.value = data.data; }
function openForm(b) {
    Object.assign(form, { id: null, title: '', subtitle: '', image: '', url: '', sort_order: 0, is_active: true });
    if (b) Object.assign(form, b);
    error.value = ''; showForm.value = true;
}
function closeForm() { showForm.value = false; }
async function save() {
    saving.value = true; error.value = '';
    try {
        const payload = { ...form };
        delete payload.id;
        if (form.id) await api.put(`/admin/banners/${form.id}`, payload);
        else await api.post('/admin/banners', payload);
        closeForm(); await load();
    } catch (e) {
        const errs = e.response?.data?.errors;
        error.value = errs ? Object.values(errs).flat().join(' ') : (e.response?.data?.message || 'Ошибка');
    } finally { saving.value = false; }
}
async function remove(b) {
    const ok = await confirmStore.ask({
        title: 'Удалить баннер',
        message: `Удалить «${b.title || 'баннер'}»?`,
        confirmLabel: 'Удалить',
    });
    if (!ok) return;
    await api.delete(`/admin/banners/${b.id}`);
    toasts.success('Баннер удалён');
    await load();
}
onMounted(load);
</script>

<style scoped>
.modal-overlay { position: fixed; inset: 0; background: rgba(0,0,0,.5); z-index: 1050; display: flex; align-items: center; justify-content: center; padding: 1rem; }
.modal-dialog-custom { width: 100%; max-width: 560px; }
</style>
