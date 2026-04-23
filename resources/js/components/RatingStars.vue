<template>
    <div class="d-inline-flex align-items-center gap-1 small">
        <span>
            <i v-for="i in 5" :key="i" class="bi" :class="[i <= rounded ? 'bi-star-fill rating-star' : 'bi-star rating-star empty']"></i>
        </span>
        <span v-if="reviews !== undefined" class="text-muted ms-1">({{ reviews }})</span>
    </div>
</template>

<script setup>
import { computed } from 'vue';
const props = defineProps({
    value: { type: [Number, String], default: 0 },
    reviews: { type: Number, default: undefined },
});
const rounded = computed(() => Math.round(Number(props.value) || 0));
</script>
