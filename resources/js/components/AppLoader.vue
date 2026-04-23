<template>
    <div class="app-loader" :class="{ active }">
        <div class="app-loader-bar"></div>
    </div>
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
    z-index: 1080;
    overflow: hidden;
    opacity: 0;
    transition: opacity 0.2s ease;
}
.app-loader.active {
    opacity: 1;
}
.app-loader-bar {
    position: absolute;
    left: -40%;
    height: 100%;
    width: 40%;
    background: linear-gradient(90deg, transparent 0%, #0d6efd 20%, #66a9ff 50%, #0d6efd 80%, transparent 100%);
    animation: app-loader-slide 1.1s linear infinite;
    box-shadow: 0 0 12px rgba(13, 110, 253, 0.6);
}
@keyframes app-loader-slide {
    0% { left: -40%; }
    100% { left: 100%; }
}
</style>
