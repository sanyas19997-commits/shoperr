<script setup>
import { ref, watch } from 'vue';

const q = ref('');
const results = ref([]);
const open = ref(false);
let timer = null;

watch(q, (v) => {
    clearTimeout(timer);
    if (!v || v.length < 2) {
        results.value = [];
        return;
    }
    timer = setTimeout(async () => {
        const res = await fetch(`/api/search?q=${encodeURIComponent(v)}`);
        if (res.ok) {
            results.value = await res.json();
            open.value = true;
        }
    }, 250);
});

function go() {
    if (q.value) {
        window.location.href = `/catalog?q=${encodeURIComponent(q.value)}`;
    }
}
</script>

<template>
    <form class="form-search" @submit.prevent="go">
        <input v-model="q" type="text" placeholder="Поиск товаров..." @focus="open = results.length > 0" @blur="setTimeout(() => open = false, 200)">
        <button type="submit">🔍</button>
        <div v-if="open && results.length" class="search-results">
            <a v-for="r in results" :key="r.id" :href="'/product/' + r.slug" class="search-row">
                {{ r.name }} — <strong>{{ r.price }} ₽</strong>
            </a>
        </div>
    </form>
</template>

<style scoped>
.form-search { position: relative; display: flex; }
.search-results { position: absolute; top: 100%; left: 0; right: 0; background: #fff; border: 1px solid #eee; border-radius: 8px; max-height: 320px; overflow-y: auto; z-index: 1000; }
.search-row { display: block; padding: 8px 12px; color: #0E0E0E; text-decoration: none; border-bottom: 1px solid #f3f3f3; }
.search-row:hover { background: #f8f9fa; }
</style>
