<template>
    <div class="container py-4">
        <h1 class="h3 fw-bold mb-4">Корзина</h1>
        <div v-if="cart.items.length === 0" class="text-center py-5">
            <i class="bi bi-cart-x fs-1 text-muted"></i>
            <p class="mt-3 mb-3">Корзина пуста</p>
            <router-link :to="{ name: 'catalog' }" class="btn btn-primary">В каталог</router-link>
        </div>
        <div v-else class="row g-4">
            <div class="col-lg-8">
                <div v-for="item in cart.items" :key="item.id" class="card mb-3 p-3">
                    <div class="row g-3 align-items-center">
                        <div class="col-3 col-md-2">
                            <img :src="item.product?.primary_image_url || item.product?.images?.[0]?.url || placeholder" class="w-100 rounded" style="aspect-ratio: 1/1; object-fit: cover" />
                        </div>
                        <div class="col-9 col-md-5">
                            <router-link :to="{ name: 'product', params: { slug: item.product?.slug } }" class="fw-medium text-dark">
                                {{ item.product?.name || 'Товар' }}
                            </router-link>
                            <div class="text-muted small">{{ formatPrice(item.price) }} ₽</div>
                        </div>
                        <div class="col-6 col-md-3">
                            <div class="input-group input-group-sm">
                                <button class="btn btn-outline-secondary" @click="decrement(item)">-</button>
                                <input type="number" :value="item.quantity" @change="setQty(item, $event.target.value)" class="form-control text-center" />
                                <button class="btn btn-outline-secondary" @click="increment(item)">+</button>
                            </div>
                        </div>
                        <div class="col-6 col-md-2 text-end">
                            <div class="fw-semibold">{{ formatPrice(item.subtotal) }} ₽</div>
                            <button class="btn btn-sm btn-link text-danger p-0" @click="remove(item)">
                                <i class="bi bi-trash"></i> Удалить
                            </button>
                        </div>
                    </div>
                </div>
                <button class="btn btn-outline-secondary btn-sm" @click="clear">
                    <i class="bi bi-trash me-1"></i>Очистить корзину
                </button>
            </div>
            <div class="col-lg-4">
                <div class="card p-3 sticky-top" style="top: 90px;">
                    <h5 class="fw-semibold">Итого</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Товары ({{ cart.itemCount }})</span>
                        <span>{{ formatPrice(cart.totalAmount) }} ₽</span>
                    </div>
                    <div class="d-flex justify-content-between mb-3">
                        <span>Доставка</span>
                        <span class="text-success">Бесплатно</span>
                    </div>
                    <hr />
                    <div class="d-flex justify-content-between fs-5 fw-bold mb-3">
                        <span>К оплате</span>
                        <span>{{ formatPrice(cart.totalAmount) }} ₽</span>
                    </div>
                    <router-link :to="checkoutTarget" class="btn btn-primary w-100">
                        <i class="bi bi-bag-check me-1"></i>Оформить заказ
                    </router-link>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue';
import { useCartStore } from '../stores/cart';
import { useAuthStore } from '../stores/auth';
import { formatPrice } from '../utils/format';

const cart = useCartStore();
const auth = useAuthStore();
const placeholder = 'data:image/svg+xml;utf8,<svg xmlns=%22http://www.w3.org/2000/svg%22 width=%22200%22 height=%22200%22><rect fill=%22%23eef0f5%22 width=%22200%22 height=%22200%22/></svg>';

const checkoutTarget = computed(() => auth.isAuthenticated
    ? { name: 'checkout' }
    : { name: 'login', query: { redirect: '/checkout' } });

function increment(item) { cart.updateItem(item.id, item.quantity + 1); }
function decrement(item) {
    if (item.quantity <= 1) cart.removeItem(item.id);
    else cart.updateItem(item.id, item.quantity - 1);
}
function setQty(item, val) {
    const q = Math.max(0, parseInt(val) || 0);
    if (q === 0) cart.removeItem(item.id);
    else cart.updateItem(item.id, q);
}
function remove(item) { cart.removeItem(item.id); }
function clear() {
    if (confirm('Очистить корзину?')) cart.clear();
}
</script>
