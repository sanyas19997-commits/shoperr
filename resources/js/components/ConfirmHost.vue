<template>
    <AppModal v-model="openModel" :title="store.title" size="sm" :close-on-backdrop="false">
        <p class="mb-0" style="white-space: pre-line">{{ store.message }}</p>
        <template #footer>
            <button class="btn btn-outline-secondary" @click="store.cancel()">{{ store.cancelLabel }}</button>
            <button class="btn" :class="variantClass" @click="store.confirm()">{{ store.confirmLabel }}</button>
        </template>
    </AppModal>
</template>

<script setup>
import { computed } from 'vue';
import AppModal from './AppModal.vue';
import { useConfirmStore } from '../stores/confirm';

const store = useConfirmStore();

const openModel = computed({
    get: () => store.open,
    set: (v) => { if (!v) store.cancel(); },
});

const variantClass = computed(() => ({
    danger: 'btn-danger',
    primary: 'btn-primary',
    warning: 'btn-warning',
    success: 'btn-success',
}[store.variant] || 'btn-primary'));
</script>
