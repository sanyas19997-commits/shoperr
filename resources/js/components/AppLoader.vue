<template>
    <Teleport to="body">
        <Transition name="app-loader-fade">
            <div v-if="active" class="app-loader" aria-hidden="true">
                <div class="app-loader-bar"></div>
            </div>
        </Transition>
    </Teleport>
</template>

<script setup>
import { computed } from 'vue';
import { useLoaderStore } from '../stores/loader';

const loader = useLoaderStore();
const active = computed(() => loader.active);
</script>

<style scoped>
.app-loader {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    height: 3px;
    pointer-events: none;
    z-index: 1200;
    overflow: hidden;
    background: rgba(108, 92, 231, 0.08);
}
.app-loader-bar {
    position: absolute;
    left: -40%;
    height: 100%;
    width: 40%;
    background: linear-gradient(
        90deg,
        transparent 0%,
        #6c5ce7 25%,
        #4e7fff 55%,
        #6c5ce7 75%,
        transparent 100%
    );
    box-shadow: 0 0 12px rgba(108, 92, 231, 0.7);
    animation: app-loader-slide 1.1s cubic-bezier(0.4, 0, 0.2, 1) infinite;
    will-change: left;
}
@keyframes app-loader-slide {
    0%   { left: -40%; }
    100% { left: 100%; }
}
.app-loader-fade-enter-active,
.app-loader-fade-leave-active {
    transition: opacity 0.2s ease;
}
.app-loader-fade-enter-from,
.app-loader-fade-leave-to {
    opacity: 0;
}
</style>
