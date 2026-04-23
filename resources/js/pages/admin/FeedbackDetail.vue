<template>
    <div v-if="item">
        <div class="d-flex align-items-center gap-2 mb-3">
            <router-link :to="{ name: 'admin.feedback' }" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> К списку
            </router-link>
            <h2 class="h4 mb-0">Сообщение #{{ item.id }}</h2>
            <span class="badge ms-2" :class="statusBadge(item.status)">{{ statusLabel(item.status) }}</span>
        </div>

        <div class="row g-3">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-3">
                    <div class="card-body">
                        <h5 class="mb-3">{{ item.subject }}</h5>
                        <p class="text-muted small mb-3">От <strong>{{ item.name }}</strong> &lt;{{ item.email }}&gt;<span v-if="item.phone"> · {{ item.phone }}</span> · {{ formatDate(item.created_at) }}</p>
                        <div class="p-3 rounded bg-light" style="white-space: pre-wrap;">{{ item.message }}</div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h5 class="mb-3">Ответ администратора</h5>
                        <div v-if="item.admin_reply && !editingReply" class="p-3 rounded bg-success-subtle mb-2" style="white-space: pre-wrap;">{{ item.admin_reply }}</div>
                        <div v-if="item.admin_reply && item.replied_at" class="small text-muted mb-3">
                            Ответил {{ item.admin?.name || 'администратор' }} · {{ formatDate(item.replied_at) }}
                        </div>
                        <button v-if="item.admin_reply && !editingReply" class="btn btn-outline-primary btn-sm" @click="startEdit">
                            <i class="bi bi-pencil me-1"></i>Изменить ответ
                        </button>
                        <div v-if="!item.admin_reply || editingReply">
                            <textarea v-model="replyDraft" class="form-control mb-2" rows="5" placeholder="Напишите ответ клиенту..."></textarea>
                            <div class="d-flex gap-2">
                                <button class="btn btn-primary" :disabled="saving || !replyDraft.trim()" @click="saveReply">
                                    <span v-if="saving" class="spinner-border spinner-border-sm me-2"></span>Сохранить ответ
                                </button>
                                <button v-if="editingReply" class="btn btn-outline-secondary" @click="cancelEdit">Отмена</button>
                            </div>
                            <div class="form-text">Ответ сохраняется в системе. Отправка e-mail клиенту не настроена в демо-режиме — напишите ему сами на {{ item.email }}.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-body">
                        <h6 class="mb-3">Статус</h6>
                        <select v-model="item.status" class="form-select" @change="updateStatus">
                            <option v-for="s in STATUSES" :key="s.value" :value="s.value">{{ s.label }}</option>
                        </select>
                        <hr />
                        <h6 class="mb-2">Клиент</h6>
                        <div class="small text-muted">
                            <div>Имя: <strong class="text-dark">{{ item.name }}</strong></div>
                            <div>E-mail: <a :href="`mailto:${item.email}`">{{ item.email }}</a></div>
                            <div v-if="item.phone">Телефон: <a :href="`tel:${item.phone}`">{{ item.phone }}</a></div>
                            <div v-if="item.user_id">
                                Аккаунт:
                                <router-link :to="{ name: 'admin.users' }">#{{ item.user_id }}</router-link>
                            </div>
                            <div v-else>Гость</div>
                        </div>
                        <hr />
                        <button class="btn btn-outline-danger w-100" @click="deleteOpen = true">
                            <i class="bi bi-trash me-1"></i>Удалить сообщение
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <AppModal v-model="deleteOpen" title="Удалить сообщение?" size="sm">
            <p class="mb-0">Сообщение будет удалено без возможности восстановления.</p>
            <template #footer>
                <button class="btn btn-light" @click="deleteOpen = false">Отмена</button>
                <button class="btn btn-danger" :disabled="deletingBusy" @click="doDelete">
                    <span v-if="deletingBusy" class="spinner-border spinner-border-sm me-2"></span>Удалить
                </button>
            </template>
        </AppModal>
    </div>
</template>

<script setup>
import { onMounted, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api from '../../api';
import AppModal from '../../components/AppModal.vue';

const STATUSES = [
    { value: 'new', label: 'Новое' },
    { value: 'read', label: 'Прочитано' },
    { value: 'answered', label: 'Отвечено' },
    { value: 'archived', label: 'В архиве' },
];

const route = useRoute();
const router = useRouter();
const item = ref(null);
const replyDraft = ref('');
const editingReply = ref(false);
const saving = ref(false);
const deleteOpen = ref(false);
const deletingBusy = ref(false);

function statusLabel(s) {
    return STATUSES.find((x) => x.value === s)?.label || s;
}
function statusBadge(s) {
    return { new: 'bg-danger', read: 'bg-secondary', answered: 'bg-success', archived: 'bg-dark' }[s] || 'bg-secondary';
}
function formatDate(iso) {
    if (!iso) return '';
    try {
        return new Date(iso).toLocaleString('ru-RU', { dateStyle: 'short', timeStyle: 'short' });
    } catch (_) {
        return iso;
    }
}

async function load() {
    const { data } = await api.get(`/admin/feedback/${route.params.id}`);
    item.value = data.data;
    replyDraft.value = item.value.admin_reply || '';
}

async function updateStatus() {
    const { data } = await api.put(`/admin/feedback/${item.value.id}`, { status: item.value.status });
    item.value = data.data;
}

function startEdit() {
    editingReply.value = true;
    replyDraft.value = item.value.admin_reply || '';
}
function cancelEdit() {
    editingReply.value = false;
    replyDraft.value = item.value.admin_reply || '';
}
async function saveReply() {
    saving.value = true;
    try {
        const { data } = await api.put(`/admin/feedback/${item.value.id}`, { admin_reply: replyDraft.value });
        item.value = data.data;
        editingReply.value = false;
    } finally {
        saving.value = false;
    }
}
async function doDelete() {
    deletingBusy.value = true;
    try {
        await api.delete(`/admin/feedback/${item.value.id}`);
        router.push({ name: 'admin.feedback' });
    } finally {
        deletingBusy.value = false;
    }
}

onMounted(load);
</script>
