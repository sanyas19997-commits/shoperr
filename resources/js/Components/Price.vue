<script setup>
import { computed } from 'vue';

const props = defineProps({
    value: { type: [Number, String], required: true },
});

const formatted = computed(() => {
    const n = Math.round(Number(props.value || 0));
    return new Intl.NumberFormat('ru-RU').format(n) + ' ₽';
});
</script>

<template>
    <span>{{ formatted }}</span>
</template>
