<template>
    <div>
        <div v-if="activeId === null">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h5 class="mb-0">Обращения в поддержку</h5>
                <button class="btn btn-primary btn-sm" @click="creating = true">
                    <i class="bi bi-plus-lg me-1"></i>Новое обращение
                </button>
            </div>

            <div v-if="creating" class="card border-0 shadow-sm mb-3">
                <div class="card-body">
                    <h6 class="mb-3">Новое обращение</h6>
                    <div class="mb-2">
                        <label class="form-label small">Тема</label>
                        <input v-model="form.subject" maxlength="255" class="form-control" placeholder="Например: Не пришёл заказ" />
                    </div>
                    <div class="mb-2">
                        <label class="form-label small">Сообщение</label>
                        <textarea v-model="form.body" maxlength="5000" rows="4" class="form-control" placeholder="Опишите проблему подробнее"></textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-primary" :disabled="!canSubmit || submitting" @click="submit">
                            <span v-if="submitting" class="spinner-border spinner-border-sm me-1"></span>
                            Отправить
                        </button>
                        <button class="btn btn-outline-secondary" :disabled="submitting" @click="cancel">Отмена</button>
                    </div>
                </div>
            </div>

            <div v-if="loading" class="text-center text-muted py-4">
                <span class="spinner-border spinner-border-sm me-2"></span>Загрузка…
            </div>
            <div v-else-if="!tickets.length" class="card border-0 shadow-sm">
                <div class="card-body text-center py-5 text-muted">
                    <i class="bi bi-headset fs-1 d-block mb-2"></i>
                    У вас пока нет обращений.
                </div>
            </div>
            <div v-else class="list-group shadow-sm">
                <button v-for="t in tickets" :key="t.id"
                        class="list-group-item list-group-item-action"
                        @click="activeId = t.id">
                    <div class="d-flex justify-content-between align-items-start gap-2">
                        <div class="min-w-0">
                            <div class="fw-semibold text-truncate">{{ t.subject }}</div>
                            <div v-if="t.last_message" class="small text-muted text-truncate" style="max-width: 520px">
                                <i v-if="t.last_message.is_admin" class="bi bi-reply-fill text-primary me-1"></i>
                                {{ t.last_message.body }}
                            </div>
                        </div>
                        <div class="text-end small">
                            <span class="badge" :class="statusClass(t.status)">{{ statusLabel(t.status) }}</span>
                            <span v-if="t.unread > 0" class="badge bg-danger ms-1">{{ t.unread }}</span>
                            <div class="text-muted mt-1">{{ formatDateTime(t.last_message_at) }}</div>
                        </div>
                    </div>
                </button>
            </div>
        </div>

        <div v-else>
            <button class="btn btn-sm btn-outline-secondary mb-2" @click="activeId = null; load(true)">
                <i class="bi bi-arrow-left me-1"></i>К списку обращений
            </button>
            <SupportChat :ticket-id="activeId" mode="user" @closed="onClosed" />
        </div>
    </div>
</template>

<script setup>
import { computed, onMounted, reactive, ref } from 'vue';
import api from '../api';
import { useToastStore } from '../stores/toast';
import { formatDateTime } from '../utils/format';
import SupportChat from './SupportChat.vue';

const toasts = useToastStore();
const tickets = ref([]);
const loading = ref(true);
const creating = ref(false);
const submitting = ref(false);
const activeId = ref(null);
const form = reactive({ subject: '', body: '' });

const canSubmit = computed(() => form.subject.trim().length > 0 && form.body.trim().length > 0);

async function load(silent = false) {
    if (!silent) loading.value = true;
    try {
        const { data } = await api.get('/support/tickets', { silent });
        tickets.value = data.data || [];
    } finally {
        loading.value = false;
    }
}

async function submit() {
    if (!canSubmit.value) return;
    submitting.value = true;
    try {
        const { data } = await api.post('/support/tickets', {
            subject: form.subject.trim(),
            body: form.body.trim(),
        });
        toasts.success('Обращение отправлено. Мы ответим как можно скорее.');
        form.subject = '';
        form.body = '';
        creating.value = false;
        const payload = data.data || data;
        await load(true);
        activeId.value = payload.id;
    } finally {
        submitting.value = false;
    }
}

function cancel() {
    creating.value = false;
    form.subject = '';
    form.body = '';
}

function onClosed() {
    load(true);
}

function statusLabel(s) {
    return { open: 'Открыт', answered: 'Отвечено', pending: 'Ждёт ответа', closed: 'Закрыт' }[s] || s;
}
function statusClass(s) {
    return {
        open: 'bg-warning text-dark',
        answered: 'bg-success',
        pending: 'bg-info text-dark',
        closed: 'bg-secondary',
    }[s] || 'bg-secondary';
}

onMounted(load);
</script>
