<template>
    <div>
        <div class="d-flex align-items-center justify-content-between mb-3">
            <router-link :to="{ name: 'admin.support' }" class="btn btn-sm btn-outline-secondary">
                <i class="bi bi-arrow-left me-1"></i>К списку
            </router-link>
            <button class="btn btn-sm btn-outline-danger" @click="remove">
                <i class="bi bi-trash me-1"></i>Удалить тикет
            </button>
        </div>
        <SupportChat :ticket-id="id" mode="admin" />
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import api from '../../api';
import { useConfirmStore } from '../../stores/confirm';
import { useToastStore } from '../../stores/toast';
import SupportChat from '../../components/SupportChat.vue';

const route = useRoute();
const router = useRouter();
const confirm = useConfirmStore();
const toasts = useToastStore();

const id = computed(() => route.params.id);

async function remove() {
    const ok = await confirm.ask({
        title: 'Удалить тикет?',
        message: 'Вся переписка будет удалена безвозвратно.',
        confirmLabel: 'Удалить',
        variant: 'danger',
    });
    if (!ok) return;
    await api.delete(`/admin/support/tickets/${id.value}`);
    toasts.success('Тикет удалён');
    router.push({ name: 'admin.support' });
}
</script>
