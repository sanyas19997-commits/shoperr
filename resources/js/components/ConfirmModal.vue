<template>
    <AppModal v-model="open" :title="title" size="sm">
        <p class="mb-0">{{ message }}</p>
        <template #footer>
            <button class="btn btn-outline-secondary" @click="cancel">{{ cancelLabel }}</button>
            <button class="btn" :class="variantClass" :disabled="loading" @click="confirm">
                <span v-if="loading"><span class="spinner-border spinner-border-sm me-1"></span></span>
                {{ confirmLabel }}
            </button>
        </template>
    </AppModal>
</template>

<script setup>
import { ref, computed } from 'vue';
import AppModal from './AppModal.vue';

const props = defineProps({
    title: { type: String, default: 'Подтвердите действие' },
    message: { type: String, default: 'Вы уверены?' },
    confirmLabel: { type: String, default: 'Удалить' },
    cancelLabel: { type: String, default: 'Отмена' },
    variant: { type: String, default: 'danger' }, // danger | primary
});

const emit = defineEmits(['confirmed', 'cancelled']);

const open = ref(false);
const loading = ref(false);
let resolver = null;

const variantClass = computed(() => ({
    danger: 'btn-danger',
    primary: 'btn-primary',
    warning: 'btn-warning',
}[props.variant] || 'btn-primary'));

function ask() {
    open.value = true;
    return new Promise((res) => { resolver = res; });
}

async function confirm() {
    loading.value = true;
    emit('confirmed');
    if (resolver) resolver(true);
    open.value = false;
    loading.value = false;
    resolver = null;
}

function cancel() {
    emit('cancelled');
    if (resolver) resolver(false);
    open.value = false;
    resolver = null;
}

defineExpose({ ask });
</script>
