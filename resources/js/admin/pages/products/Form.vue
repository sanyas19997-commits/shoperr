<script setup>
import { onMounted, reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { toast } from 'vue3-toastify';
import api from '../../services/api';

const route = useRoute();
const router = useRouter();
const isNew = !route.params.id;
const product = reactive({
    name: '', slug: '', sku: '', category_id: '', brand_id: '',
    short_description: '', description: '',
    meta_title: '', meta_description: '',
    price: '', sale_price: '', stock: 0,
    is_active: true, is_featured: false, sort_order: 0,
});
const newImage = ref(null);
const newGallery = ref([]);
const existingImages = ref([]);
const categories = ref([]);
const brands = ref([]);
const errors = ref({});
const loading = ref(false);

onMounted(async () => {
    const [{ data: cats }, { data: bs }] = await Promise.all([
        api.get('/categories', { params: { flat: 1 } }),
        api.get('/brands/all'),
    ]);
    categories.value = cats;
    brands.value = bs;

    if (!isNew) {
        const { data } = await api.get(`/products/${route.params.id}`);
        Object.assign(product, data.data);
        existingImages.value = data.data.images || [];
    }
});

async function submit() {
    errors.value = {};
    loading.value = true;
    const fd = new FormData();
    Object.entries(product).forEach(([k, v]) => {
        if (v === null || v === undefined || v === '') return;
        if (typeof v === 'boolean') fd.append(k, v ? 1 : 0);
        else fd.append(k, v);
    });
    if (newImage.value) fd.append('image', newImage.value);
    newGallery.value.forEach((f) => fd.append('images[]', f));

    try {
        const url = isNew ? '/products' : `/products/${route.params.id}`;
        const { data } = await api.post(url, fd);
        toast.success('Сохранено');
        router.push({ name: 'product-edit', params: { id: data.data.id } });
        if (isNew) Object.assign(product, data.data);
    } catch (e) {
        errors.value = e.response?.data?.errors || {};
        toast.error(e.response?.data?.message || 'Ошибка валидации');
    } finally { loading.value = false; }
}

async function deleteImg(img) {
    if (!confirm('Удалить изображение?')) return;
    await api.delete(`/product-images/${img.id}`);
    existingImages.value = existingImages.value.filter(i => i.id !== img.id);
}

function onGallery(e) { newGallery.value = Array.from(e.target.files); }
</script>

<template>
    <form @submit.prevent="submit">
        <div style="display:grid; grid-template-columns: 2fr 1fr; gap: 20px;">
            <div class="card card-pad">
                <div class="form-group"><label>Название *</label><input v-model="product.name" required />
                    <div v-if="errors.name" class="error-text">{{ errors.name[0] }}</div>
                </div>
                <div class="form-row">
                    <div class="form-group"><label>Slug</label><input v-model="product.slug" placeholder="авто-генерация" /></div>
                    <div class="form-group"><label>Артикул (SKU)</label><input v-model="product.sku" /></div>
                </div>
                <div class="form-group"><label>Краткое описание</label><textarea v-model="product.short_description"></textarea></div>
                <div class="form-group"><label>Полное описание (HTML разрешён)</label><textarea v-model="product.description" rows="10" style="font-family:monospace; font-size:13px;"></textarea>
                    <div class="help-text">Поддерживаются HTML-теги: &lt;p&gt;, &lt;strong&gt;, &lt;ul&gt;, &lt;li&gt; и др.</div>
                </div>
                <h4 style="margin-top:24px;">SEO</h4>
                <div class="form-group"><label>Meta title</label><input v-model="product.meta_title" /></div>
                <div class="form-group"><label>Meta description</label><textarea v-model="product.meta_description" rows="2"></textarea></div>
            </div>
            <div>
                <div class="card card-pad" style="margin-bottom:16px;">
                    <h4 style="margin-top:0;">Цена и остатки</h4>
                    <div class="form-row">
                        <div class="form-group"><label>Цена ₽ *</label><input v-model.number="product.price" type="number" step="0.01" min="0" required /></div>
                        <div class="form-group"><label>Цена со скидкой</label><input v-model.number="product.sale_price" type="number" step="0.01" min="0" /></div>
                    </div>
                    <div class="form-group"><label>Остаток на складе</label><input v-model.number="product.stock" type="number" min="0" /></div>
                </div>
                <div class="card card-pad" style="margin-bottom:16px;">
                    <h4 style="margin-top:0;">Категория и бренд</h4>
                    <div class="form-group"><label>Категория</label>
                        <select v-model="product.category_id"><option value="">—</option><option v-for="c in categories" :key="c.id" :value="c.id">{{ c.name }}</option></select>
                    </div>
                    <div class="form-group"><label>Бренд</label>
                        <select v-model="product.brand_id"><option value="">—</option><option v-for="b in brands" :key="b.id" :value="b.id">{{ b.name }}</option></select>
                    </div>
                </div>
                <div class="card card-pad" style="margin-bottom:16px;">
                    <h4 style="margin-top:0;">Видимость</h4>
                    <div class="checkbox-row form-group"><input id="active" v-model="product.is_active" type="checkbox" /><label for="active" style="margin:0;">Активен (виден на витрине)</label></div>
                    <div class="checkbox-row form-group"><input id="featured" v-model="product.is_featured" type="checkbox" /><label for="featured" style="margin:0;">Рекомендуемый (хит)</label></div>
                    <div class="form-group"><label>Сортировка</label><input v-model.number="product.sort_order" type="number" /></div>
                </div>
                <div class="card card-pad">
                    <h4 style="margin-top:0;">Главное изображение</h4>
                    <img v-if="product.image" :src="`/storage/${product.image}`" style="width:100%; border-radius:8px; margin-bottom:8px;" />
                    <input type="file" accept="image/*" @change="newImage = $event.target.files[0]" />

                    <h4 style="margin-top:16px;">Галерея</h4>
                    <div v-if="existingImages.length" class="images-grid" style="margin-bottom:8px;">
                        <div v-for="img in existingImages" :key="img.id" class="img-card">
                            <img :src="`/storage/${img.path}`" />
                            <button type="button" class="remove-btn" @click="deleteImg(img)">×</button>
                        </div>
                    </div>
                    <input type="file" accept="image/*" multiple @change="onGallery" />
                </div>
            </div>
        </div>

        <div style="margin-top: 20px; display:flex; gap:10px;">
            <button class="btn btn-primary" :disabled="loading">{{ loading ? 'Сохраняем…' : 'Сохранить' }}</button>
            <router-link class="btn" :to="{ name: 'products' }">Отмена</router-link>
        </div>
    </form>
</template>
