<template>
    <Teleport to="body">
        <div class="toast-stack" role="region" aria-label="Уведомления">
            <TransitionGroup name="toast">
                <div v-for="t in toasts.items" :key="t.id" :class="`toast-item toast-${t.type}`" role="alert">
                    <i class="toast-icon bi" :class="iconFor(t.type)"></i>
                    <div class="flex-grow-1">
                        <div v-if="t.title" class="toast-title">{{ t.title }}</div>
                        <div v-if="t.message" class="toast-body">{{ t.message }}</div>
                    </div>
                    <button class="toast-close" @click="toasts.remove(t.id)" aria-label="Закрыть">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </TransitionGroup>
        </div>
    </Teleport>
</template>

<script setup>
import { useToastStore } from '../stores/toast';
const toasts = useToastStore();

function iconFor(type) {
    return {
        success: 'bi-check-circle-fill',
        error: 'bi-exclamation-octagon-fill',
        warning: 'bi-exclamation-triangle-fill',
        info: 'bi-info-circle-fill',
    }[type] || 'bi-info-circle-fill';
}
</script>
