<template>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card p-4">
                    <h3 class="fw-bold text-center mb-4">Вход</h3>
                    <form @submit.prevent="submit">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input v-model="form.email" required type="email" class="form-control" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Пароль</label>
                            <input v-model="form.password" required type="password" class="form-control" />
                        </div>
                        <div class="form-check mb-3">
                            <input id="remember" v-model="form.remember" type="checkbox" class="form-check-input" />
                            <label for="remember" class="form-check-label">Запомнить меня</label>
                        </div>
                        <div v-if="error" class="alert alert-danger">{{ error }}</div>
                        <button class="btn btn-primary w-100" :disabled="loading">
                            <span v-if="loading" class="spinner-border spinner-border-sm me-1"></span>
                            Войти
                        </button>
                    </form>
                    <div class="text-center mt-3 small">
                        <router-link :to="{ name: 'forgot-password' }">Забыли пароль?</router-link>
                    </div>
                    <div class="text-center mt-2 small">
                        Нет аккаунта? <router-link :to="{ name: 'register' }">Зарегистрируйтесь</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref } from 'vue';
import { useRoute, useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import { useCartStore } from '../stores/cart';

const auth = useAuthStore();
const cart = useCartStore();
const router = useRouter();
const route = useRoute();

const form = reactive({ email: '', password: '', remember: false });
const loading = ref(false);
const error = ref('');

async function submit() {
    loading.value = true;
    error.value = '';
    try {
        await auth.login(form);
        await cart.fetchCart();
        const redirect = route.query.redirect || '/';
        router.push(redirect);
    } catch (e) {
        error.value = e.response?.data?.message || 'Не удалось войти';
    } finally {
        loading.value = false;
    }
}
</script>
