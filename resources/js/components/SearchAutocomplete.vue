<template>
    <div class="sa-wrap" @focusout="onBlur">
        <form class="search-megabar" @submit.prevent="submit">
            <div class="input-group">
                <select v-if="withCategory"
                        v-model="cat"
                        class="form-select"
                        aria-label="Категория">
                    <option value="">Все категории</option>
                    <option v-for="c in categories.slice(0, 20)" :key="c.id" :value="c.slug">{{ c.name }}</option>
                </select>
                <input v-model="q"
                       type="search"
                       class="form-control"
                       :placeholder="placeholder"
                       autocomplete="off"
                       @input="onInput"
                       @focus="showPanel = true"
                       @keydown.down.prevent="moveHighlight(1)"
                       @keydown.up.prevent="moveHighlight(-1)"
                       @keydown.esc="showPanel = false"
                       @keydown.enter.prevent="onEnter" />
                <button class="btn" type="submit"><i class="bi bi-search"></i></button>
            </div>
        </form>

        <div v-if="showPanel && (loading || results.length || q.length >= 2)" class="sa-panel shadow">
            <div v-if="loading" class="sa-loading small text-muted">
                <span class="spinner-border spinner-border-sm me-2"></span>Ищем товары…
            </div>
            <ul v-else-if="results.length" class="sa-list list-unstyled mb-0">
                <li v-for="(r, i) in results"
                    :key="r.id"
                    class="sa-item"
                    :class="{ active: i === highlight }"
                    @mouseenter="highlight = i"
                    @mousedown.prevent="pick(r)">
                    <img :src="r.image_url || '/img/placeholder.png'" class="sa-thumb" :alt="r.name" />
                    <div class="sa-info">
                        <div class="sa-name" v-html="highlightMatch(r.name)"></div>
                        <div v-if="r.category" class="sa-cat small text-muted">{{ r.category.name }}</div>
                    </div>
                    <div class="sa-price">
                        <div class="fw-semibold">{{ formatPrice(r.price) }} ₽</div>
                        <div v-if="r.old_price" class="text-muted small text-decoration-line-through">{{ formatPrice(r.old_price) }} ₽</div>
                    </div>
                </li>
                <li class="sa-all">
                    <a href="#" @mousedown.prevent="submit">
                        <i class="bi bi-search me-2"></i>Показать все результаты по «{{ q }}»
                    </a>
                </li>
            </ul>
            <div v-else-if="q.length >= 2" class="sa-empty small text-muted">
                Ничего не найдено по «{{ q }}».
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref, watch } from 'vue';
import { useRouter } from 'vue-router';
import api from '../api';
import { formatPrice } from '../utils/format';

const props = defineProps({
    categories: { type: Array, default: () => [] },
    withCategory: { type: Boolean, default: false },
    initialQuery: { type: String, default: '' },
    initialCategory: { type: String, default: '' },
    placeholder: { type: String, default: 'Искать товар...' },
});
const router = useRouter();

const q = ref(props.initialQuery);
const cat = ref(props.initialCategory);
const results = ref([]);
const loading = ref(false);
const showPanel = ref(false);
const highlight = ref(-1);
let timer = null;
let activeReq = 0;

// Keep the input in sync when the URL query changes externally (e.g. user
// navigates to /catalog?q=xxx) — prevents a stale input after route changes.
watch(() => props.initialQuery, (v) => { q.value = v || ''; });
watch(() => props.initialCategory, (v) => { cat.value = v || ''; });

function onInput() {
    highlight.value = -1;
    showPanel.value = true;
    const term = q.value.trim();
    if (timer) clearTimeout(timer);
    if (term.length < 2) {
        results.value = [];
        loading.value = false;
        return;
    }
    loading.value = true;
    timer = setTimeout(async () => {
        const myReq = ++activeReq;
        try {
            const { data } = await api.get('/products/search', {
                params: { q: term, limit: 8 },
                // This is a background typeahead — shouldn't trigger the global
                // loader bar or toast on every keystroke.
                silent: true,
            });
            // Only apply the result if this is still the most recent request —
            // otherwise an earlier slow response could clobber a newer one.
            if (myReq === activeReq) {
                results.value = data?.data || [];
            }
        } catch (_) {
            if (myReq === activeReq) results.value = [];
        } finally {
            if (myReq === activeReq) loading.value = false;
        }
    }, 250);
}

function moveHighlight(dir) {
    if (!results.value.length) return;
    const max = results.value.length - 1;
    let next = highlight.value + dir;
    if (next < 0) next = max;
    if (next > max) next = 0;
    highlight.value = next;
}

function onEnter() {
    if (highlight.value >= 0 && results.value[highlight.value]) {
        pick(results.value[highlight.value]);
    } else {
        submit();
    }
}

function pick(product) {
    showPanel.value = false;
    results.value = [];
    router.push({ name: 'product', params: { slug: product.slug } });
}

function submit() {
    showPanel.value = false;
    const query = {};
    if (q.value.trim()) query.q = q.value.trim();
    if (cat.value) query.category = cat.value;
    router.push({ name: 'catalog', query });
}

function onBlur(event) {
    // focusout fires when the user tabs out of the whole wrapper; delay so a
    // pending mousedown on a result still resolves before we hide the panel.
    setTimeout(() => {
        if (!event.currentTarget?.contains?.(document.activeElement)) {
            showPanel.value = false;
        }
    }, 120);
}

function highlightMatch(name) {
    const term = q.value.trim();
    if (!term) return escapeHtml(name);
    const safeName = escapeHtml(name);
    const safeTerm = term.replace(/[.*+?^${}()|[\]\\]/g, '\\$&');
    return safeName.replace(new RegExp(`(${safeTerm})`, 'ig'), '<mark>$1</mark>');
}

function escapeHtml(s) {
    return String(s)
        .replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;').replace(/'/g, '&#39;');
}
</script>

<style scoped>
.sa-wrap { position: relative; }
.sa-panel {
    position: absolute;
    top: calc(100% + 4px);
    left: 0;
    right: 0;
    z-index: 1050;
    background: #fff;
    border: 1px solid var(--mf-border, #e5e7eb);
    border-radius: 6px;
    max-height: 480px;
    overflow-y: auto;
}
.sa-loading, .sa-empty { padding: 0.85rem 1rem; }
.sa-list { max-height: 420px; overflow-y: auto; }
.sa-item {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.55rem 0.85rem;
    cursor: pointer;
    border-bottom: 1px solid rgba(0,0,0,.04);
    transition: background .12s;
}
.sa-item:last-child { border-bottom: none; }
.sa-item.active, .sa-item:hover { background: rgba(253, 184, 39, .08); }
.sa-thumb {
    width: 42px; height: 42px;
    object-fit: cover;
    border-radius: 4px;
    flex: 0 0 42px;
    background: #f3f4f6;
}
.sa-info { flex: 1; min-width: 0; }
.sa-name { font-size: 0.9rem; color: #222; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.sa-name :deep(mark) { background: #fff4c2; padding: 0; color: inherit; font-weight: 600; }
.sa-price { text-align: right; white-space: nowrap; }
.sa-all {
    padding: 0.55rem 0.85rem;
    border-top: 1px solid rgba(0,0,0,.06);
    text-align: center;
}
.sa-all a { color: var(--bs-warning-dark, #c98e00); font-weight: 600; text-decoration: none; font-size: 0.9rem; }
.sa-all a:hover { text-decoration: underline; }
</style>
