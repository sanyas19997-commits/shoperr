<template>
    <div class="card sidebar-filter p-3">
        <h6 class="fw-semibold mb-3">Фильтры</h6>

        <div class="mb-3">
            <label class="form-label small fw-medium">Категория</label>
            <select v-model="local.category" class="form-select form-select-sm" @change="emitChange">
                <option value="">Все категории</option>
                <option v-for="c in categories" :key="c.id" :value="c.slug">{{ c.name }}</option>
            </select>
        </div>

        <div class="mb-3">
            <label class="form-label small fw-medium">Цена, ₽</label>
            <div class="d-flex gap-2">
                <input v-model.number="local.price_min" type="number" min="0" class="form-control form-control-sm" placeholder="от" />
                <input v-model.number="local.price_max" type="number" min="0" class="form-control form-control-sm" placeholder="до" />
            </div>
            <button class="btn btn-outline-primary btn-sm mt-2 w-100" @click="emitChange">Применить</button>
        </div>

        <div class="mb-3 form-check">
            <input id="in_stock" v-model="local.in_stock" type="checkbox" class="form-check-input" @change="emitChange" />
            <label for="in_stock" class="form-check-label">Только в наличии</label>
        </div>

        <!-- Dynamic attribute facets (color, size, brand, …). Only rendered
             when the API returns non-empty buckets for the current category. -->
        <div v-for="facet in facets" :key="facet.code" class="mb-3 facet-group">
            <label class="form-label small fw-medium d-flex justify-content-between align-items-center">
                <span>{{ facet.label }}</span>
                <button v-if="hasAttr(facet.code)"
                        type="button"
                        class="btn btn-link btn-sm p-0 small text-decoration-none"
                        @click="clearAttr(facet.code)">очистить</button>
            </label>
            <!-- Color facet renders as tappable swatches; others as a scrollable checkbox list. -->
            <div v-if="isColorCode(facet.code)" class="color-swatches">
                <button v-for="v in facet.values"
                        :key="v.value"
                        type="button"
                        class="swatch"
                        :class="{ active: isSelected(facet.code, v.value) }"
                        :style="{ background: colorToCss(v.value) }"
                        :title="`${v.value} (${v.count})`"
                        @click="toggleAttr(facet.code, v.value)">
                    <i v-if="isSelected(facet.code, v.value)" class="bi bi-check"></i>
                </button>
            </div>
            <div v-else class="facet-list">
                <div v-for="v in facet.values.slice(0, expanded[facet.code] ? facet.values.length : 8)"
                     :key="v.value"
                     class="form-check">
                    <input :id="`f-${facet.code}-${v.value}`"
                           type="checkbox"
                           class="form-check-input"
                           :checked="isSelected(facet.code, v.value)"
                           @change="toggleAttr(facet.code, v.value)" />
                    <label :for="`f-${facet.code}-${v.value}`" class="form-check-label small d-flex justify-content-between">
                        <span>{{ v.value }}</span>
                        <span class="text-muted">{{ v.count }}</span>
                    </label>
                </div>
                <button v-if="facet.values.length > 8"
                        type="button"
                        class="btn btn-link btn-sm p-0 small text-decoration-none"
                        @click="expanded[facet.code] = !expanded[facet.code]">
                    {{ expanded[facet.code] ? 'Свернуть' : `Показать все (${facet.values.length})` }}
                </button>
            </div>
        </div>

        <button class="btn btn-sm btn-link text-decoration-none p-0" @click="reset">
            <i class="bi bi-x-circle me-1"></i>Сбросить всё
        </button>
    </div>
</template>

<script setup>
import { reactive, watch } from 'vue';

const props = defineProps({
    modelValue: { type: Object, default: () => ({}) },
    categories: { type: Array, default: () => [] },
    facets: { type: Array, default: () => [] },
});
const emit = defineEmits(['update:modelValue', 'change']);

const local = reactive({
    category: props.modelValue.category || '',
    price_min: props.modelValue.price_min ?? null,
    price_max: props.modelValue.price_max ?? null,
    in_stock: !!props.modelValue.in_stock,
    // { color: ['red','blue'], size: ['m'] }
    attrs: cloneAttrs(props.modelValue.attrs),
});
const expanded = reactive({});

function cloneAttrs(raw) {
    const out = {};
    if (!raw || typeof raw !== 'object') return out;
    for (const k of Object.keys(raw)) {
        const v = raw[k];
        if (Array.isArray(v)) out[k] = [...v];
        else if (v != null && v !== '') out[k] = [String(v)];
    }
    return out;
}

watch(() => props.modelValue, (v) => {
    local.category = v.category || '';
    local.price_min = v.price_min ?? null;
    local.price_max = v.price_max ?? null;
    local.in_stock = !!v.in_stock;
    local.attrs = cloneAttrs(v.attrs);
}, { deep: true });

function emitChange() {
    const payload = {
        category: local.category,
        price_min: local.price_min,
        price_max: local.price_max,
        in_stock: local.in_stock,
        attrs: { ...local.attrs },
    };
    emit('update:modelValue', payload);
    emit('change', payload);
}
function reset() {
    local.category = '';
    local.price_min = null;
    local.price_max = null;
    local.in_stock = false;
    local.attrs = {};
    emitChange();
}

function isSelected(code, value) {
    return Array.isArray(local.attrs[code]) && local.attrs[code].includes(String(value));
}
function hasAttr(code) {
    return Array.isArray(local.attrs[code]) && local.attrs[code].length > 0;
}
function toggleAttr(code, value) {
    const v = String(value);
    const cur = Array.isArray(local.attrs[code]) ? [...local.attrs[code]] : [];
    const i = cur.indexOf(v);
    if (i === -1) cur.push(v);
    else cur.splice(i, 1);
    if (cur.length) local.attrs[code] = cur;
    else delete local.attrs[code];
    emitChange();
}
function clearAttr(code) {
    delete local.attrs[code];
    emitChange();
}

const COLOR_CODES = new Set(['color', 'colour', 'tsvet', 'цвет']);
function isColorCode(code) { return COLOR_CODES.has(String(code).toLowerCase()); }

// Map common Russian/English colour names to CSS — falls back to the raw
// value so exotic colours (e.g. 'nebula') still render if the admin used a
// valid CSS colour keyword.
const COLOR_MAP = {
    'red': '#d32f2f', 'красный': '#d32f2f',
    'blue': '#1976d2', 'синий': '#1976d2',
    'green': '#2e7d32', 'зелёный': '#2e7d32', 'зеленый': '#2e7d32',
    'yellow': '#fbc02d', 'жёлтый': '#fbc02d', 'желтый': '#fbc02d',
    'black': '#212121', 'чёрный': '#212121', 'черный': '#212121',
    'white': '#f5f5f5', 'белый': '#f5f5f5',
    'grey': '#757575', 'gray': '#757575', 'серый': '#757575',
    'pink': '#e91e63', 'розовый': '#e91e63',
    'purple': '#8e24aa', 'фиолетовый': '#8e24aa',
    'orange': '#f57c00', 'оранжевый': '#f57c00',
    'brown': '#6d4c41', 'коричневый': '#6d4c41',
    'beige': '#d7ccc8', 'бежевый': '#d7ccc8',
    'gold': '#c9a227', 'золотой': '#c9a227',
    'silver': '#bdbdbd', 'серебряный': '#bdbdbd',
};
function colorToCss(value) {
    const v = String(value).toLowerCase().trim();
    return COLOR_MAP[v] || v;
}
</script>

<style scoped>
.facet-group { border-top: 1px solid rgba(0,0,0,.05); padding-top: 0.75rem; }
.facet-list .form-check-label { width: 100%; cursor: pointer; }
.color-swatches { display: flex; flex-wrap: wrap; gap: 0.4rem; }
.swatch {
    width: 28px; height: 28px;
    border-radius: 50%;
    border: 2px solid rgba(0,0,0,.15);
    display: inline-flex; align-items: center; justify-content: center;
    padding: 0;
    color: #fff;
    transition: transform .15s, box-shadow .15s;
    cursor: pointer;
}
.swatch:hover { transform: scale(1.08); }
.swatch.active {
    box-shadow: 0 0 0 2px #fff, 0 0 0 4px var(--bs-warning, #fdb827);
}
.swatch i { font-size: 14px; text-shadow: 0 0 2px rgba(0,0,0,.7); }
</style>
