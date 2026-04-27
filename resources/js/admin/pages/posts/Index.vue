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
const errors = ref({});
const loading = ref(false);
const newImage = ref(null);
const previewUrl = ref('');

const blank = () => ({
    id: null,
    title: '',
    slug: '',
    category: '',
    excerpt: '',
    content: '',
    meta_title: '',
    meta_description: '',
    is_published: true,
    image_path: '',
});

const form = reactive(blank());

async function load(page = 1) {
    const { data } = await api.get('/posts', { params: { page, q: search.value || undefined } });
    items.value = data.data;
    meta.value = data;
}

function startNew() {
    Object.assign(form, blank());
    newImage.value = null;
    previewUrl.value = '';
    editing.value = 'new';
    errors.value = {};
}

function startEdit(p) {
    Object.assign(form, blank(), {
        id: p.id,
        title: p.title,
        slug: p.slug,
        category: p.category || '',
        excerpt: p.excerpt || '',
        content: p.content || '',
        meta_title: p.meta_title || '',
        meta_description: p.meta_description || '',
        is_published: !!p.is_published,
        image_path: p.image || '',
    });
    newImage.value = null;
    previewUrl.value = p.image_url || (p.image ? imagePreview(p.image) : '');
    editing.value = p.id;
    errors.value = {};
}

function imagePreview(path) {
    if (!path) return '';
    if (/^https?:\/\//.test(path)) return path;
    if (path.startsWith('/')) return path;
    return '/storage/' + path;
}

function onImageChange(e) {
    const f = e.target.files?.[0];
    newImage.value = f || null;
    if (f) previewUrl.value = URL.createObjectURL(f);
}

async function save() {
    errors.value = {};
    loading.value = true;
    const fd = new FormData();
    fd.append('title', form.title);
    if (form.slug) fd.append('slug', form.slug);
    if (form.category) fd.append('category', form.category);
    if (form.excerpt) fd.append('excerpt', form.excerpt);
    fd.append('content', form.content);
    if (form.meta_title) fd.append('meta_title', form.meta_title);
    if (form.meta_description) fd.append('meta_description', form.meta_description);
    fd.append('is_published', form.is_published ? 1 : 0);
    if (newImage.value) fd.append('image', newImage.value);
    else if (form.image_path) fd.append('image_path', form.image_path);

    try {
        const url = form.id ? `/posts/${form.id}` : '/posts';
        await api.post(url, fd);
        toast.success('Сохранено');
        editing.value = null;
        await load(meta.value.current_page || 1);
    } catch (e) {
        errors.value = e.response?.data?.errors || {};
        toast.error(e.response?.data?.message || 'Ошибка валидации');
    } finally {
        loading.value = false;
    }
}

async function remove(p) {
    if (!confirm(`Удалить запись «${p.title}»?`)) return;
    try {
        await api.delete(`/posts/${p.id}`);
        toast.success('Удалено');
        load(meta.value.current_page || 1);
    } catch (e) {
        toast.error(e.response?.data?.message || 'Ошибка');
    }
}

onMounted(load);
</script>

<template>
    <div class="toolbar">
        <input v-model="search" class="search-input" placeholder="Поиск по блогу…" @input="load(1)" />
        <div class="grow"></div>
        <button class="btn btn-primary" @click="startNew">+ Новая запись</button>
    </div>

    <div :style="editing ? 'display:grid; grid-template-columns: 1fr 1fr; gap:20px;' : ''">
        <div class="card">
            <div class="table-wrap">
                <table class="data">
                    <thead>
                        <tr>
                            <th style="width:60px;">Фото</th>
                            <th>Заголовок</th>
                            <th>Категория</th>
                            <th>Опубликовано</th>
                            <th>Дата</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="p in items" :key="p.id">
                            <td>
                                <img v-if="p.image" :src="imagePreview(p.image)" alt="" style="width:48px;height:48px;object-fit:cover;border-radius:6px;" />
                            </td>
                            <td>
                                <strong>{{ p.title }}</strong>
                                <div class="help-text">/{{ p.slug }}</div>
                            </td>
                            <td>{{ p.category || '—' }}</td>
                            <td>
                                <span class="badge" :class="p.is_published ? 'badge-paid' : 'badge-canceled'">
                                    {{ p.is_published ? 'опубликован' : 'черновик' }}
                                </span>
                            </td>
                            <td>{{ p.published_at ? new Date(p.published_at).toLocaleDateString('ru-RU') : '—' }}</td>
                            <td class="row-actions">
                                <a class="btn btn-sm" :href="'/blog/' + p.slug" target="_blank" rel="noopener">Открыть</a>
                                <button class="btn btn-sm" @click="startEdit(p)">Изм.</button>
                                <button v-if="auth.isAdmin" class="btn btn-sm btn-danger" @click="remove(p)">×</button>
                            </td>
                        </tr>
                        <tr v-if="!items.length">
                            <td colspan="6" class="empty">Записей пока нет — создайте первую</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div v-if="editing" class="card">
            <div class="card-head">
                <h3>{{ form.id ? 'Редактирование записи' : 'Новая запись' }}</h3>
                <button class="btn btn-sm" @click="editing = null">×</button>
            </div>
            <div class="card-pad">
                <div class="form-group">
                    <label>Заголовок *</label>
                    <input v-model="form.title" required />
                    <div v-if="errors.title" class="error-text">{{ errors.title[0] }}</div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Slug (URL)</label>
                        <input v-model="form.slug" placeholder="авто-генерация" />
                    </div>
                    <div class="form-group">
                        <label>Категория</label>
                        <input v-model="form.category" placeholder="Например: Советы" />
                    </div>
                </div>
                <div class="form-group">
                    <label>Изображение записи</label>
                    <input type="file" accept="image/*" @change="onImageChange" />
                    <div v-if="previewUrl" style="margin-top:8px;">
                        <img :src="previewUrl" alt="" style="max-width:100%;max-height:160px;border-radius:8px;" />
                    </div>
                    <div v-if="errors.image" class="error-text">{{ errors.image[0] }}</div>
                </div>
                <div class="form-group">
                    <label>Краткое описание (анонс)</label>
                    <textarea v-model="form.excerpt" rows="3" maxlength="500"></textarea>
                    <div class="help-text">До 500 символов. Показывается в списке статей.</div>
                </div>
                <div class="form-group">
                    <label>Содержимое (HTML разрешён) *</label>
                    <textarea v-model="form.content" rows="14" style="font-family:monospace;font-size:13px;" required></textarea>
                    <div class="help-text">Поддерживаются &lt;p&gt;, &lt;h2&gt;-&lt;h4&gt;, &lt;strong&gt;, &lt;em&gt;, &lt;ul&gt;, &lt;ol&gt;, &lt;li&gt;, &lt;a href&gt;, &lt;img&gt;, &lt;blockquote&gt;.</div>
                    <div v-if="errors.content" class="error-text">{{ errors.content[0] }}</div>
                </div>
                <h4 style="margin-top:24px;">SEO</h4>
                <div class="form-group"><label>Meta title</label><input v-model="form.meta_title" /></div>
                <div class="form-group"><label>Meta description</label><textarea v-model="form.meta_description" rows="2"></textarea></div>

                <div class="checkbox-row form-group">
                    <input id="post-pub" v-model="form.is_published" type="checkbox" />
                    <label for="post-pub" style="margin:0;">Опубликовать</label>
                </div>

                <button class="btn btn-primary" :disabled="loading" @click="save">
                    {{ loading ? 'Сохраняем…' : 'Сохранить' }}
                </button>
                <button class="btn" style="margin-left:8px;" @click="editing = null">Отмена</button>
            </div>
        </div>
    </div>
</template>
