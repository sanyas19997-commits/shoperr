<template>
    <nav v-if="lastPage > 1" aria-label="Pagination">
        <ul class="pagination justify-content-center">
            <li class="page-item" :class="{ disabled: currentPage === 1 }">
                <a class="page-link" href="#" @click.prevent="goto(currentPage - 1)">
                    <i class="bi bi-chevron-left"></i>
                </a>
            </li>
            <li v-for="p in pages" :key="p" class="page-item" :class="{ active: p === currentPage }">
                <a class="page-link" href="#" @click.prevent="goto(p)">{{ p }}</a>
            </li>
            <li class="page-item" :class="{ disabled: currentPage === lastPage }">
                <a class="page-link" href="#" @click.prevent="goto(currentPage + 1)">
                    <i class="bi bi-chevron-right"></i>
                </a>
            </li>
        </ul>
    </nav>
</template>

<script setup>
import { computed } from 'vue';
const props = defineProps({
    currentPage: { type: Number, required: true },
    lastPage: { type: Number, required: true },
});
const emit = defineEmits(['change']);

const pages = computed(() => {
    const max = 7;
    const cur = props.currentPage;
    const last = props.lastPage;
    if (last <= max) {
        return Array.from({ length: last }, (_, i) => i + 1);
    }
    const half = Math.floor(max / 2);
    let start = Math.max(1, cur - half);
    let end = start + max - 1;
    if (end > last) {
        end = last;
        start = end - max + 1;
    }
    return Array.from({ length: end - start + 1 }, (_, i) => start + i);
});

function goto(p) {
    if (p < 1 || p > props.lastPage || p === props.currentPage) return;
    emit('change', p);
}
</script>
