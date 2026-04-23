<template>
    <Teleport to="body">
        <Transition name="app-modal">
            <div
                v-if="modelValue"
                class="app-modal-overlay"
                @click.self="closeOnBackdrop && $emit('update:modelValue', false)"
            >
                <div class="app-modal-dialog" :class="sizeClass" role="dialog" aria-modal="true">
                    <div v-if="title || $slots.header" class="app-modal-header">
                        <h5 class="app-modal-title mb-0">
                            <slot name="header">{{ title }}</slot>
                        </h5>
                        <button
                            v-if="showClose"
                            type="button"
                            class="btn-close"
                            aria-label="Закрыть"
                            @click="$emit('update:modelValue', false)"
                        ></button>
                    </div>
                    <div class="app-modal-body">
                        <slot />
                    </div>
                    <div v-if="$slots.footer" class="app-modal-footer">
                        <slot name="footer" />
                    </div>
                </div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
import { computed, onBeforeUnmount, watch } from 'vue';

const props = defineProps({
    modelValue: { type: Boolean, default: false },
    title: { type: String, default: '' },
    size: { type: String, default: 'md' }, // sm | md | lg | xl
    closeOnBackdrop: { type: Boolean, default: true },
    showClose: { type: Boolean, default: true },
    closeOnEsc: { type: Boolean, default: true },
});
const emit = defineEmits(['update:modelValue']);

const sizeClass = computed(() => `app-modal-${props.size}`);

function onKey(e) {
    if (e.key === 'Escape' && props.closeOnEsc && props.modelValue) {
        emit('update:modelValue', false);
    }
}

watch(
    () => props.modelValue,
    (v) => {
        if (v) {
            document.body.style.overflow = 'hidden';
            document.addEventListener('keydown', onKey);
        } else {
            document.body.style.overflow = '';
            document.removeEventListener('keydown', onKey);
        }
    },
    { immediate: true }
);

onBeforeUnmount(() => {
    document.body.style.overflow = '';
    document.removeEventListener('keydown', onKey);
});
</script>

<style scoped>
.app-modal-overlay {
    position: fixed;
    inset: 0;
    background: rgba(20, 24, 36, 0.55);
    backdrop-filter: blur(2px);
    -webkit-backdrop-filter: blur(2px);
    display: flex;
    align-items: flex-start;
    justify-content: center;
    z-index: 1070;
    overflow-y: auto;
    padding: 40px 16px;
}
.app-modal-dialog {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 20px 60px rgba(0, 0, 0, 0.25);
    width: 100%;
    max-width: 520px;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    max-height: calc(100vh - 80px);
}
.app-modal-sm { max-width: 380px; }
.app-modal-md { max-width: 520px; }
.app-modal-lg { max-width: 760px; }
.app-modal-xl { max-width: 960px; }

.app-modal-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 1rem 1.25rem;
    border-bottom: 1px solid #edf0f6;
}
.app-modal-title {
    font-weight: 700;
}
.app-modal-body {
    padding: 1.25rem;
    overflow-y: auto;
}
.app-modal-footer {
    padding: 0.9rem 1.25rem;
    border-top: 1px solid #edf0f6;
    display: flex;
    justify-content: flex-end;
    gap: 0.5rem;
    background: #fafbfd;
}

.app-modal-enter-active, .app-modal-leave-active {
    transition: opacity 0.2s ease;
}
.app-modal-enter-from, .app-modal-leave-to {
    opacity: 0;
}
.app-modal-enter-active .app-modal-dialog,
.app-modal-leave-active .app-modal-dialog {
    transition: transform 0.25s ease;
}
.app-modal-enter-from .app-modal-dialog {
    transform: translateY(-14px) scale(0.98);
}
.app-modal-leave-to .app-modal-dialog {
    transform: translateY(-14px) scale(0.98);
}
</style>
