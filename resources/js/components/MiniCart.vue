<script setup>
import { ref, onMounted, computed } from 'vue';

const items = ref([]);
const subtotal = ref(0);
const open = ref(false);

const count = computed(() => items.value.reduce((s, i) => s + i.quantity, 0));

async function load() {
    try {
        const res = await fetch('/cart/summary', { headers: { Accept: 'application/json' } });
        const data = await res.json();
        items.value = data.items || [];
        subtotal.value = data.subtotal || 0;
    } catch (e) {
        // ignore
    }
}

onMounted(load);

function format(n) { return new Intl.NumberFormat('ru-RU').format(Math.round(n)); }
</script>

<template>
    <div class="mini-cart" @mouseenter="open = true" @mouseleave="open = false">
        <a href="/cart" class="header-icon">
            🛒 <span v-if="count > 0" class="badge bg-warning">{{ count }}</span>
            <span class="ml-1">{{ format(subtotal) }} ₽</span>
        </a>
        <div v-if="open && items.length" class="mini-cart-dropdown">
            <div v-for="i in items" :key="i.id" class="mini-cart-row">
                <a :href="'/product/' + i.slug">{{ i.name }}</a>
                <span>{{ i.quantity }} × {{ format(i.price) }} ₽</span>
            </div>
            <div class="mini-cart-total">
                <strong>Итого: {{ format(subtotal) }} ₽</strong>
            </div>
            <a href="/cart" class="btn btn-buy w-100 mt-10">Перейти в корзину →</a>
        </div>
    </div>
</template>

<style scoped>
.mini-cart { position: relative; display: inline-block; }
.mini-cart-dropdown { position: absolute; top: 100%; right: 0; background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 12px; min-width: 280px; box-shadow: 0 8px 24px rgba(0,0,0,.1); z-index: 1000; }
.mini-cart-row { display: flex; justify-content: space-between; padding: 6px 0; border-bottom: 1px solid #f3f3f3; font-size: 14px; }
.mini-cart-total { padding: 8px 0; }
</style>
