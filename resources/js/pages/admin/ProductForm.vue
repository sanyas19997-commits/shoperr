<template>
    <div>
        <router-link :to="{ name: 'admin.products' }" class="small"><i class="bi bi-arrow-left me-1"></i>К списку</router-link>
        <h1 class="h3 fw-bold mt-2 mb-4">{{ isEdit ? 'Редактирование товара' : 'Новый товар' }}</h1>
        <form @submit.prevent="save" class="card p-4">
            <div class="row g-3">
                <div class="col-md-8">
                    <label class="form-label">Название *</label>
                    <input v-model="form.name" required class="form-control" />
                </div>
                <div class="col-md-4">
                    <label class="form-label">SKU</label>
                    <input v-model="form.sku" class="form-control" />
                </div>
                <div class="col-md-4">
                    <label class="form-label">Категория *</label>
                    <select v-model.number="form.category_id" required class="form-select">
                        <option :value="null" disabled>—</option>
                        <option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Цена *</label>
                    <input v-model.number="form.price" required type="number" step="0.01" class="form-control" />
                </div>
                <div class="col-md-2">
                    <label class="form-label">Старая цена</label>
                    <input v-model.number="form.old_price" type="number" step="0.01" class="form-control" />
                </div>
                <div class="col-md-2">
                    <label class="form-label">Остаток *</label>
                    <input v-model.number="form.stock" required type="number" class="form-control" />
                </div>
                <div class="col-md-2">
                    <label class="form-label d-block">&nbsp;</label>
                    <div class="form-check form-switch">
                        <input id="active" v-model="form.is_active" type="checkbox" class="form-check-input" />
                        <label for="active" class="form-check-label">Активен</label>
                    </div>
                    <div class="form-check form-switch">
                        <input id="featured" v-model="form.is_featured" type="checkbox" class="form-check-input" />
                        <label for="featured" class="form-check-label">Хит</label>
                    </div>
                </div>
                <div class="col-12">
                    <label class="form-label">Краткое описание</label>
                    <input v-model="form.short_description" class="form-control" />
                </div>
                <div class="col-12">
                    <label class="form-label">Описание</label>
                    <textarea v-model="form.description" rows="4" class="form-control"></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Характеристики (JSON)</label>
                    <textarea v-model="attrsText" rows="3" class="form-control" placeholder='{"Материал": "Хлопок", "Цвет": "Синий"}'></textarea>
                </div>
                <div class="col-12">
                    <label class="form-label">Изображения (URL, по одному на строку)</label>
                    <textarea v-model="imageUrlsText" rows="3" class="form-control" placeholder="https://example.com/image.jpg"></textarea>
                    <small class="text-muted">Можно также загрузить файлы ниже.</small>
                </div>
                <div class="col-12">
                    <label class="form-label">Загрузить файлы</label>
                    <input type="file" multiple accept="image/*" class="form-control" @change="onFiles" />
                </div>
                <div class="col-12" v-if="existingImages.length">
                    <label class="form-label">Текущие изображения</label>
                    <div class="d-flex gap-2 flex-wrap">
                        <img v-for="img in existingImages" :key="img.id" :src="img.url" style="width: 96px; height: 96px; object-fit: cover" class="rounded border" />
                    </div>
                </div>
                <div v-if="error" class="col-12"><div class="alert alert-danger">{{ error }}</div></div>
                <div class="col-12">
                    <button class="btn btn-primary" :disabled="saving">
                        <span v-if="saving" class="spinner-border spinner-border-sm me-1"></span>
                        Сохранить
                    </button>
                    <router-link :to="{ name: 'admin.products' }" class="btn btn-outline-secondary ms-2">Отмена</router-link>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api from '../../api';

const route = useRoute();
const router = useRouter();
const isEdit = computed(() => !!route.params.id);
const saving = ref(false);
const error = ref('');
const categories = ref([]);
const existingImages = ref([]);
const files = ref([]);

const form = reactive({
    name: '', sku: '', category_id: null, price: 0, old_price: null,
    stock: 0, is_active: true, is_featured: false,
    short_description: '', description: '',
});
const attrsText = ref('');
const imageUrlsText = ref('');

function onFiles(e) { files.value = Array.from(e.target.files || []); }

async function loadCategories() {
    const { data } = await api.get('/admin/categories');
    categories.value = data.data;
}

async function loadProduct() {
    if (!isEdit.value) return;
    const { data } = await api.get(`/admin/products/${route.params.id}`);
    const p = data.data;
    Object.assign(form, {
        name: p.name, sku: p.sku, category_id: p.category_id,
        price: p.price, old_price: p.old_price, stock: p.stock,
        is_active: p.is_active, is_featured: p.is_featured,
        short_description: p.short_description, description: p.description,
    });
    attrsText.value = p.attributes ? JSON.stringify(p.attributes, null, 2) : '';
    existingImages.value = p.images || [];
}

async function save() {
    saving.value = true; error.value = '';
    try {
        const fd = new FormData();
        for (const [k, v] of Object.entries(form)) {
            if (v === null || v === undefined || v === '') continue;
            if (typeof v === 'boolean') {
                fd.append(k, v ? '1' : '0');
            } else {
                fd.append(k, v);
            }
        }
        if (attrsText.value) {
            try {
                const parsed = JSON.parse(attrsText.value);
                Object.entries(parsed).forEach(([k, v]) => {
                    fd.append(`attributes[${k}]`, String(v));
                });
            } catch (_) {
                error.value = 'Неверный JSON в характеристиках';
                saving.value = false; return;
            }
        }
        imageUrlsText.value.split('\n').map(s => s.trim()).filter(Boolean).forEach(url => fd.append('image_urls[]', url));
        files.value.forEach(f => fd.append('images[]', f));
        if (isEdit.value) fd.append('_method', 'PUT');

        const url = isEdit.value ? `/admin/products/${route.params.id}` : '/admin/products';
        await api.post(url, fd, { headers: { 'Content-Type': 'multipart/form-data' } });
        router.push({ name: 'admin.products' });
    } catch (e) {
        const errs = e.response?.data?.errors;
        error.value = errs ? Object.values(errs).flat().join(' ') : (e.response?.data?.message || 'Ошибка');
    } finally {
        saving.value = false;
    }
}

onMounted(async () => { await loadCategories(); await loadProduct(); });
</script>
