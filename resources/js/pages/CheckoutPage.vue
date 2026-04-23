<template>
    <div class="container py-4">
        <h1 class="h3 fw-bold mb-4">Оформление заказа</h1>
        <div v-if="cart.items.length === 0" class="text-center py-5 text-muted">
            Корзина пуста. <router-link :to="{ name: 'catalog' }">Перейти в каталог</router-link>
        </div>
        <form v-else class="row g-4" @submit.prevent="submit">
            <div class="col-lg-7">
                <div class="card p-4">
                    <h5 class="mb-3">Контактные данные</h5>
                    <div class="mb-3">
                        <label class="form-label">Имя <span class="text-danger">*</span></label>
                        <input v-model="form.customer_name" required type="text" class="form-control" />
                    </div>
                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Телефон <span class="text-danger">*</span></label>
                            <input v-model="form.customer_phone" required type="tel" class="form-control" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Email <span class="text-danger">*</span></label>
                            <input v-model="form.customer_email" required type="email" class="form-control" />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Адрес доставки <span class="text-danger">*</span></label>
                        <input v-model="form.shipping_address" required type="text" class="form-control" />
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Комментарий</label>
                        <textarea v-model="form.comment" rows="3" class="form-control"></textarea>
                    </div>
                    <div v-if="error" class="alert alert-danger">{{ error }}</div>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="card p-4">
                    <h5 class="mb-3">Ваш заказ</h5>
                    <ul class="list-unstyled mb-3">
                        <li v-for="item in cart.items" :key="item.id" class="d-flex justify-content-between mb-2">
                            <span>{{ item.product?.name }} × {{ item.quantity }}</span>
                            <span>{{ formatPrice(item.subtotal) }} ₽</span>
                        </li>
                    </ul>
                    <hr />
                    <div class="d-flex justify-content-between fs-5 fw-bold mb-3">
                        <span>Итого</span>
                        <span>{{ formatPrice(cart.totalAmount) }} ₽</span>
                    </div>
                    <button class="btn btn-primary w-100" :disabled="submitting">
                        <span v-if="submitting" class="spinner-border spinner-border-sm me-1"></span>
                        Подтвердить заказ
                    </button>
                </div>
            </div>
        </form>
    </div>
</template>

<script setup>
import { onMounted, reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import api from '../api';
import { useCartStore } from '../stores/cart';
import { useAuthStore } from '../stores/auth';
import { formatPrice } from '../utils/format';

const cart = useCartStore();
const auth = useAuthStore();
const router = useRouter();

const submitting = ref(false);
const error = ref('');
const form = reactive({
    customer_name: '',
    customer_phone: '',
    customer_email: '',
    shipping_address: '',
    comment: '',
});

onMounted(() => {
    if (auth.user) {
        form.customer_name = auth.user.name || '';
        form.customer_email = auth.user.email || '';
        form.customer_phone = auth.user.phone || '';
        form.shipping_address = auth.user.address || '';
    }
});

async function submit() {
    submitting.value = true;
    error.value = '';
    try {
        const { data } = await api.post('/orders', { ...form });
        await cart.fetchCart();
        router.push({ name: 'order', params: { id: data.data.id } });
    } catch (e) {
        error.value = e.response?.data?.message || 'Не удалось создать заказ';
    } finally {
        submitting.value = false;
    }
}
</script>
