<template>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card p-4">
                    <h3 class="fw-bold text-center mb-4">Регистрация</h3>
                    <form @submit.prevent="submit">
                        <div class="mb-3">
                            <label class="form-label">Имя</label>
                            <input v-model="form.name" required type="text" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input v-model="form.email" required type="email" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Телефон</label>
                            <input v-model="form.phone" type="tel" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Пароль</label>
                            <input v-model="form.password" required type="password" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Повторите пароль</label>
                            <input v-model="form.password_confirmation" required type="password" class="form-control" />
                        </div>
                        <div v-if="error" class="alert alert-danger">{{ error }}</div>
                        <button class="btn btn-primary w-100" :disabled="loading">
                            <span v-if="loading" class="spinner-border spinner-border-sm me-1"></span>
                            Зарегистрироваться
                        </button>
                    </form>
                    <div class="text-center mt-3 small">
                        Уже есть аккаунт? <router-link :to="{ name: 'login' }">Войти</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import { useCartStore } from '../stores/cart';

const auth = useAuthStore();
const cart = useCartStore();
const router = useRouter();

const form = reactive({ name: '', email: '', phone: '', password: '', password_confirmation: '' });
const loading = ref(false);
const error = ref('');

async function submit() {
    loading.value = true;
    error.value = '';
    try {
        await auth.register(form);
        await cart.fetchCart();
        router.push({ name: 'home' });
    } catch (e) {
        const errs = e.response?.data?.errors;
        if (errs) error.value = Object.values(errs).flat().join(' ');
        else error.value = e.response?.data?.message || 'Не удалось зарегистрироваться';
    } finally {
        loading.value = false;
    }
}
</script>
