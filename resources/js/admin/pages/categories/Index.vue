<script setup>
import { onMounted, reactive, ref } from 'vue';
import { toast } from 'vue3-toastify';
import api from '../../services/api';
import { useAuthStore } from '../../stores/auth';
import CategoryNode from './CategoryNode.vue';

const auth = useAuthStore();
const tree = ref([]);
const flatList = ref([]);
const editing = ref(null);
const form = reactive({ id: null, name: '', slug: '', description: '', parent_id: '', meta_title: '', meta_description: '', sort_order: 0, is_active: true });
const errors = ref({});

async function load() {
    const [{ data: t }, { data: flat }] = await Promise.all([
        api.get('/categories'),
        api.get('/categories', { params: { flat: 1 } }),
    ]);
    tree.value = t;
    flatList.value = flat;
}

function startNew(parent_id = '') {
    Object.assign(form, { id: null, name: '', slug: '', description: '', parent_id, meta_title: '', meta_description: '', sort_order: 0, is_active: true });
    editing.value = 'new';
    errors.value = {};
}
async function startEdit(id) {
    const { data } = await api.get(`/categories/${id}`);
    Object.assign(form, data.data);
    editing.value = id;
    errors.value = {};
}

async function save() {
    errors.value = {};
    try {
        const url = form.id ? `/categories/${form.id}` : '/categories';
        await api.post(url, form);
        toast.success('Сохранено');
        editing.value = null;
        load();
    } catch (e) {
        errors.value = e.response?.data?.errors || {};
        toast.error(e.response?.data?.message || 'Ошибка');
    }
}

async function remove(node) {
    if (!confirm(`Удалить категорию «${node.name}»?`)) return;
    try {
        await api.delete(`/categories/${node.id}`);
        toast.success('Удалено');
        load();
    } catch (e) { toast.error(e.response?.data?.message || 'Ошибка'); }
}

onMounted(load);
</script>

<template>
    <div style="display:grid; grid-template-columns: 1fr 1fr; gap: 20px;">
        <div class="card">
            <div class="card-head"><h3>Дерево категорий</h3>
                <button class="btn btn-primary btn-sm" @click="startNew('')">+ Корневая</button>
            </div>
            <div class="card-pad">
                <ul class="tree-list">
                    <CategoryNode v-for="n in tree" :key="n.id" :node="n" :is-admin="auth.isAdmin"
                        @edit="startEdit" @add-child="startNew" @remove="remove" />
                </ul>
                <div v-if="!tree.length" class="empty">Категорий пока нет</div>
            </div>
        </div>

        <div v-if="editing" class="card">
            <div class="card-head"><h3>{{ form.id ? 'Редактирование' : 'Новая категория' }}</h3>
                <button class="btn btn-sm" @click="editing = null">×</button>
            </div>
            <div class="card-pad">
                <div class="form-group"><label>Название *</label><input v-model="form.name" required />
                    <div v-if="errors.name" class="error-text">{{ errors.name[0] }}</div>
                </div>
                <div class="form-group"><label>Slug (URL)</label><input v-model="form.slug" placeholder="авто-генерация" /></div>
                <div class="form-group"><label>Родитель</label>
                    <select v-model="form.parent_id">
                        <option value="">— Корневая —</option>
                        <option v-for="c in flatList" :key="c.id" :value="c.id" :disabled="form.id === c.id">{{ c.name }}</option>
                    </select>
                </div>
                <div class="form-group"><label>Описание</label><textarea v-model="form.description"></textarea></div>
                <h4>SEO</h4>
                <div class="form-group"><label>Meta title</label><input v-model="form.meta_title" /></div>
                <div class="form-group"><label>Meta description</label><textarea v-model="form.meta_description" rows="2"></textarea></div>
                <div class="form-row">
                    <div class="form-group"><label>Сортировка</label><input v-model.number="form.sort_order" type="number" /></div>
                    <div class="form-group"><label>&nbsp;</label>
                        <div class="checkbox-row"><input id="cat-active" v-model="form.is_active" type="checkbox" /><label for="cat-active" style="margin:0;">Активна</label></div>
                    </div>
                </div>
                <button class="btn btn-primary" @click="save">Сохранить</button>
            </div>
        </div>
        <div v-else class="empty card" style="display:flex; align-items:center; justify-content:center;">
            Выберите категорию для редактирования или создайте новую.
        </div>
    </div>
</template>
