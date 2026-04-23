<template>
    <div class="support-chat d-flex flex-column">
        <div class="support-chat-header d-flex justify-content-between align-items-start gap-2 px-3 py-2 border-bottom">
            <div class="min-w-0">
                <div class="fw-semibold text-truncate">{{ ticket?.subject || 'Обращение' }}</div>
                <div class="small text-muted d-flex flex-wrap gap-2 align-items-center">
                    <span class="badge" :class="statusClass">{{ statusLabel }}</span>
                    <span v-if="isAdminMode && ticket?.user_name">
                        <i class="bi bi-person me-1"></i>{{ ticket.user_name }}
                        <span v-if="ticket.user_email" class="text-muted">&lt;{{ ticket.user_email }}&gt;</span>
                    </span>
                    <span>#{{ ticket?.id }}</span>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button v-if="!isAdminMode && ticket?.status !== 'closed'"
                        class="btn btn-sm btn-outline-secondary"
                        @click="close">
                    <i class="bi bi-x-circle me-1"></i>Закрыть
                </button>
                <button v-if="isAdminMode"
                        class="btn btn-sm btn-outline-secondary"
                        :disabled="savingStatus"
                        @click="toggleStatus">
                    {{ ticket?.status === 'closed' ? 'Открыть' : 'Закрыть' }}
                </button>
            </div>
        </div>

        <div ref="scrollEl" class="support-chat-body flex-grow-1 p-3">
            <div v-if="loading" class="text-center text-muted py-4">
                <span class="spinner-border spinner-border-sm me-2"></span>Загрузка…
            </div>
            <template v-else-if="messages.length">
                <div v-for="m in messages" :key="m.id"
                     class="support-msg d-flex mb-2"
                     :class="bubbleAlignment(m)">
                    <div class="support-msg-bubble" :class="bubbleClass(m)">
                        <div class="support-msg-meta small text-muted d-flex gap-2 mb-1">
                            <strong>{{ messageAuthorName(m) }}</strong>
                            <span>{{ formatDateTime(m.created_at) }}</span>
                        </div>
                        <div class="support-msg-body">{{ m.body }}</div>
                    </div>
                </div>
            </template>
            <div v-else class="text-center text-muted py-4">Сообщений пока нет.</div>
        </div>

        <form v-if="canReply" class="support-chat-composer px-3 py-2 border-top" @submit.prevent="send">
            <div class="d-flex gap-2 align-items-end">
                <textarea v-model="draft"
                          class="form-control"
                          rows="2"
                          :disabled="sending"
                          maxlength="5000"
                          placeholder="Введите сообщение..."
                          @keydown.ctrl.enter.prevent="send"></textarea>
                <button type="submit" class="btn btn-primary" :disabled="!draft.trim() || sending">
                    <span v-if="sending" class="spinner-border spinner-border-sm me-1"></span>
                    <i v-else class="bi bi-send me-1"></i>
                    Отправить
                </button>
            </div>
            <div class="small text-muted mt-1">Ctrl+Enter — отправить</div>
        </form>
        <div v-else class="px-3 py-2 small text-muted border-top">
            Тикет закрыт. Откройте новый, чтобы продолжить переписку.
        </div>
    </div>
</template>

<script setup>
import { computed, nextTick, onBeforeUnmount, ref, watch } from 'vue';
import api from '../api';
import { useToastStore } from '../stores/toast';
import { formatDateTime } from '../utils/format';

const props = defineProps({
    ticketId: { type: [Number, String], required: true },
    mode: { type: String, default: 'user' }, // 'user' | 'admin'
});
const emit = defineEmits(['updated', 'closed']);

const toasts = useToastStore();
const ticket = ref(null);
const messages = ref([]);
const draft = ref('');
const loading = ref(true);
const sending = ref(false);
const savingStatus = ref(false);
const scrollEl = ref(null);
let pollTimer = null;

const isAdminMode = computed(() => props.mode === 'admin');
const baseUrl = computed(() => isAdminMode.value
    ? `/admin/support/tickets/${props.ticketId}`
    : `/support/tickets/${props.ticketId}`);
const canReply = computed(() => ticket.value?.status !== 'closed');

const statusLabel = computed(() => {
    switch (ticket.value?.status) {
        case 'open': return 'Ожидает ответа';
        case 'answered': return 'Отвечено';
        case 'pending': return 'На рассмотрении';
        case 'closed': return 'Закрыт';
        default: return ticket.value?.status || '';
    }
});
const statusClass = computed(() => {
    switch (ticket.value?.status) {
        case 'open': return 'bg-warning text-dark';
        case 'answered': return 'bg-success';
        case 'pending': return 'bg-info text-dark';
        case 'closed': return 'bg-secondary';
        default: return 'bg-secondary';
    }
});

async function load(silent = false) {
    if (!silent) loading.value = true;
    try {
        const { data } = await api.get(baseUrl.value, { silent: true });
        const payload = data.data || data;
        ticket.value = payload;
        messages.value = payload.messages || [];
        emit('updated', payload);
        await nextTick();
        scrollToBottom();
    } catch (e) {
        if (!silent) toasts.error('Не удалось загрузить переписку');
    } finally {
        loading.value = false;
    }
}

function scrollToBottom() {
    if (scrollEl.value) {
        scrollEl.value.scrollTop = scrollEl.value.scrollHeight;
    }
}

async function send() {
    const body = draft.value.trim();
    if (!body) return;
    sending.value = true;
    try {
        const { data } = await api.post(`${baseUrl.value}/reply`, { body });
        const payload = data.data || data;
        ticket.value = payload;
        messages.value = payload.messages || [];
        draft.value = '';
        emit('updated', payload);
        await nextTick();
        scrollToBottom();
    } finally {
        sending.value = false;
    }
}

async function close() {
    savingStatus.value = true;
    try {
        await api.post(`${baseUrl.value}/close`);
        toasts.info('Тикет закрыт');
        emit('closed');
        await load(true);
    } finally {
        savingStatus.value = false;
    }
}

async function toggleStatus() {
    savingStatus.value = true;
    try {
        const next = ticket.value?.status === 'closed' ? 'pending' : 'closed';
        const { data } = await api.put(`${baseUrl.value}/status`, { status: next });
        const payload = data.data || data;
        ticket.value = payload;
        emit('updated', payload);
    } finally {
        savingStatus.value = false;
    }
}

function bubbleAlignment(m) {
    const mine = isAdminMode.value ? m.is_admin : !m.is_admin;
    return mine ? 'justify-content-end' : 'justify-content-start';
}
function bubbleClass(m) {
    const mine = isAdminMode.value ? m.is_admin : !m.is_admin;
    if (mine) return 'support-msg-bubble--mine';
    return m.is_admin ? 'support-msg-bubble--support' : 'support-msg-bubble--user';
}
function messageAuthorName(m) {
    if (m.is_admin) return m.author_name || 'Поддержка';
    return m.author_name || 'Пользователь';
}

watch(() => props.ticketId, () => load(), { immediate: true });

// Poll every 10s for fresh messages while the thread is open.
pollTimer = window.setInterval(() => load(true), 10000);
onBeforeUnmount(() => {
    if (pollTimer) clearInterval(pollTimer);
});
</script>

<style scoped>
.support-chat {
    background: #fff;
    border-radius: 12px;
    min-height: 420px;
    max-height: 72vh;
}
.support-chat-body {
    overflow-y: auto;
    background: #f7f7fb;
    scroll-behavior: smooth;
}
.support-msg-bubble {
    max-width: 72%;
    padding: 10px 12px;
    border-radius: 14px;
    background: #fff;
    border: 1px solid rgba(0, 0, 0, 0.06);
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.03);
    word-break: break-word;
}
.support-msg-bubble--mine {
    background: linear-gradient(135deg, #6c5ce7 0%, #4e7fff 100%);
    color: #fff;
    border-color: transparent;
}
.support-msg-bubble--mine .support-msg-meta { color: rgba(255, 255, 255, 0.8) !important; }
.support-msg-bubble--mine .support-msg-meta strong { color: #fff; }
.support-msg-bubble--support {
    background: #eef1ff;
    border-color: #d6dcff;
}
.support-msg-body {
    white-space: pre-wrap;
}
</style>
