<template>
    <div class="auth-page">
        <div class="container">
            <div class="row justify-content-center align-items-center g-4">
                <div class="col-md-6 col-lg-5">
                    <div class="card auth-card shadow-lg border-0 p-4 p-md-5">
                        <div class="text-center mb-4">
                            <div class="auth-icon"><i class="bi bi-bag-fill"></i></div>
                            <h1 class="h3 fw-bold mb-1">С возвращением</h1>
                            <p class="text-muted small mb-0">Войдите, чтобы продолжить покупки</p>
                        </div>
                        <form @submit.prevent="submit" novalidate>
                            <div class="mb-3">
                                <label class="form-label">E-mail</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent"><i class="bi bi-envelope"></i></span>
                                    <input v-model="form.email" required type="email" autocomplete="email"
                                           class="form-control" :class="{ 'is-invalid': fieldErrors.email }"
                                           placeholder="you@example.com" />
                                    <div class="invalid-feedback">{{ fieldErrors.email?.[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label d-flex justify-content-between">
                                    <span>Пароль</span>
                                    <router-link :to="{ name: 'forgot-password' }" class="small">Забыли?</router-link>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent"><i class="bi bi-lock"></i></span>
                                    <input v-model="form.password" required
                                           :type="showPassword ? 'text' : 'password'" autocomplete="current-password"
                                           class="form-control" :class="{ 'is-invalid': fieldErrors.password }"
                                           placeholder="Пароль" />
                                    <button type="button" class="btn btn-outline-secondary" @click="showPassword = !showPassword">
                                        <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                                    </button>
                                    <div class="invalid-feedback">{{ fieldErrors.password?.[0] }}</div>
                                </div>
                            </div>
                            <div class="form-check mb-3">
                                <input id="remember" v-model="form.remember" type="checkbox" class="form-check-input" />
                                <label for="remember" class="form-check-label small">Запомнить меня на этом устройстве</label>
                            </div>
                            <Transition name="error-fade">
                                <div v-if="error" class="alert alert-danger d-flex align-items-center gap-2 py-2">
                                    <i class="bi bi-exclamation-circle"></i>{{ error }}
                                </div>
                            </Transition>
                            <button class="btn btn-primary w-100 btn-lg" :disabled="loading">
                                <span v-if="loading" class="spinner-border spinner-border-sm me-1"></span>
                                Войти
                            </button>
                        </form>
                        <div class="text-center mt-4 small text-muted">
                            Нет аккаунта?
                            <router-link :to="{ name: 'register' }" class="fw-semibold">Создать</router-link>
                        </div>
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
import { useToastStore } from '../stores/toast';

const auth = useAuthStore();
const cart = useCartStore();
const router = useRouter();
const route = useRoute();
const toasts = useToastStore();

const form = reactive({ email: '', password: '', remember: false });
const loading = ref(false);
const error = ref('');
const fieldErrors = ref({});
const showPassword = ref(false);

async function submit() {
    loading.value = true;
    error.value = '';
    fieldErrors.value = {};
    try {
        await auth.login(form);
        await cart.fetchCart();
        toasts.success(`Добро пожаловать${auth.user?.name ? `, ${auth.user.name}` : ''}!`, 'Вход выполнен');
        const redirect = route.query.redirect || '/';
        router.push(redirect);
    } catch (e) {
        const errs = e.response?.data?.errors;
        if (errs) fieldErrors.value = errs;
        error.value = e.response?.data?.message || 'Не удалось войти. Проверьте данные.';
    } finally {
        loading.value = false;
    }
}
</script>

<style scoped>
.auth-page {
    min-height: calc(100vh - 120px);
    display: flex;
    align-items: center;
    padding: 2rem 0;
    background:
        radial-gradient(1200px 600px at 100% -10%, rgba(108, 92, 231, 0.08), transparent),
        radial-gradient(900px 500px at -10% 110%, rgba(78, 127, 255, 0.08), transparent);
}
.auth-card {
    border-radius: 1.25rem;
    background: #fff;
}
.auth-icon {
    width: 64px; height: 64px;
    margin: 0 auto 1rem;
    border-radius: 50%;
    background: var(--gradient-primary);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.75rem;
}
.error-fade-enter-active, .error-fade-leave-active { transition: opacity 0.2s ease, transform 0.2s ease; }
.error-fade-enter-from, .error-fade-leave-to { opacity: 0; transform: translateY(-4px); }
</style>
