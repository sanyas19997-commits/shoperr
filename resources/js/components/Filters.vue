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

        <button class="btn btn-sm btn-link text-decoration-none p-0" @click="reset">
            <i class="bi bi-x-circle me-1"></i>Сбросить
        </button>
    </div>
</template>

<script setup>
import { reactive, watch } from 'vue';

const props = defineProps({
    modelValue: { type: Object, default: () => ({}) },
    categories: { type: Array, default: () => [] },
});
const emit = defineEmits(['update:modelValue', 'change']);

const local = reactive({
    category: props.modelValue.category || '',
    price_min: props.modelValue.price_min ?? null,
    price_max: props.modelValue.price_max ?? null,
    in_stock: !!props.modelValue.in_stock,
});

watch(() => props.modelValue, (v) => {
    local.category = v.category || '';
    local.price_min = v.price_min ?? null;
    local.price_max = v.price_max ?? null;
    local.in_stock = !!v.in_stock;
}, { deep: true });

function emitChange() {
    emit('update:modelValue', { ...local });
    emit('change', { ...local });
}
function reset() {
    local.category = '';
    local.price_min = null;
    local.price_max = null;
    local.in_stock = false;
    emitChange();
}
</script>
