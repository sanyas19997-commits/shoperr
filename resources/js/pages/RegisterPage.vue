<template>
    <div class="auth-page">
        <div class="container">
            <div class="row justify-content-center align-items-center g-4">
                <div class="col-md-6 col-lg-5">
                    <div class="card auth-card shadow-lg border-0 p-4 p-md-5">
                        <div class="text-center mb-4">
                            <div class="auth-icon"><i class="bi bi-person-plus"></i></div>
                            <h1 class="h3 fw-bold mb-1">Создать аккаунт</h1>
                            <p class="text-muted small mb-0">Заполните форму, чтобы начать покупки</p>
                        </div>
                        <form @submit.prevent="submit" novalidate>
                            <div class="mb-3">
                                <label class="form-label">Имя <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent"><i class="bi bi-person"></i></span>
                                    <input v-model="form.name" required autocomplete="name"
                                           class="form-control" :class="{ 'is-invalid': fieldErrors.name }"
                                           placeholder="Ваше имя" />
                                    <div class="invalid-feedback">{{ fieldErrors.name?.[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">E-mail <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent"><i class="bi bi-envelope"></i></span>
                                    <input v-model="form.email" required type="email" autocomplete="email"
                                           class="form-control" :class="{ 'is-invalid': fieldErrors.email }"
                                           placeholder="you@example.com" />
                                    <div class="invalid-feedback">{{ fieldErrors.email?.[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Телефон</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent"><i class="bi bi-telephone"></i></span>
                                    <input v-model="form.phone" type="tel" autocomplete="tel"
                                           class="form-control" :class="{ 'is-invalid': fieldErrors.phone }"
                                           placeholder="+7 (999) 000-00-00" />
                                    <div class="invalid-feedback">{{ fieldErrors.phone?.[0] }}</div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Пароль <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent"><i class="bi bi-lock"></i></span>
                                    <input v-model="form.password" required
                                           :type="showPassword ? 'text' : 'password'" autocomplete="new-password"
                                           class="form-control" :class="{ 'is-invalid': fieldErrors.password }"
                                           placeholder="Минимум 8 символов" />
                                    <button type="button" class="btn btn-outline-secondary" @click="showPassword = !showPassword">
                                        <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                                    </button>
                                    <div class="invalid-feedback">{{ fieldErrors.password?.[0] }}</div>
                                </div>
                                <div class="mt-2 password-strength" v-if="form.password">
                                    <div class="progress" style="height: 4px">
                                        <div class="progress-bar" :class="strength.class" :style="{ width: strength.pct + '%' }"></div>
                                    </div>
                                    <small :class="strength.textClass">{{ strength.label }}</small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Повторите пароль <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text bg-transparent"><i class="bi bi-shield-lock"></i></span>
                                    <input v-model="form.password_confirmation" required
                                           :type="showPassword ? 'text' : 'password'" autocomplete="new-password"
                                           class="form-control"
                                           :class="{ 'is-invalid': confirmInvalid }"
                                           placeholder="Повторите пароль" />
                                    <div class="invalid-feedback">Пароли не совпадают</div>
                                </div>
                            </div>
                            <Transition name="error-fade">
                                <div v-if="error" class="alert alert-danger d-flex align-items-center gap-2 py-2">
                                    <i class="bi bi-exclamation-circle"></i>{{ error }}
                                </div>
                            </Transition>
                            <button class="btn btn-primary w-100 btn-lg" :disabled="loading">
                                <span v-if="loading" class="spinner-border spinner-border-sm me-1"></span>
                                Зарегистрироваться
                            </button>
                        </form>
                        <div class="text-center mt-4 small text-muted">
                            Уже есть аккаунт?
                            <router-link :to="{ name: 'login' }" class="fw-semibold">Войти</router-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { reactive, ref, computed } from 'vue';
import { useRouter } from 'vue-router';
import { useAuthStore } from '../stores/auth';
import { useCartStore } from '../stores/cart';
import { useToastStore } from '../stores/toast';

const auth = useAuthStore();
const cart = useCartStore();
const router = useRouter();
const toasts = useToastStore();

const form = reactive({ name: '', email: '', phone: '', password: '', password_confirmation: '' });
const loading = ref(false);
const error = ref('');
const fieldErrors = ref({});
const showPassword = ref(false);

const confirmInvalid = computed(() => form.password_confirmation.length > 0 && form.password_confirmation !== form.password);

const strength = computed(() => {
    const p = form.password;
    let score = 0;
    if (p.length >= 8) score++;
    if (/[A-ZА-Я]/.test(p)) score++;
    if (/\d/.test(p)) score++;
    if (/[^A-Za-zА-Яа-я0-9]/.test(p)) score++;
    const map = {
        0: { pct: 10, label: 'Слишком слабый', class: 'bg-danger', textClass: 'text-danger' },
        1: { pct: 30, label: 'Слабый', class: 'bg-danger', textClass: 'text-danger' },
        2: { pct: 55, label: 'Средний', class: 'bg-warning', textClass: 'text-warning' },
        3: { pct: 80, label: 'Хороший', class: 'bg-info', textClass: 'text-info' },
        4: { pct: 100, label: 'Отличный', class: 'bg-success', textClass: 'text-success' },
    };
    return map[score];
});

async function submit() {
    loading.value = true;
    error.value = '';
    fieldErrors.value = {};
    try {
        await auth.register(form);
        await cart.fetchCart();
        toasts.success('Аккаунт создан! Добро пожаловать в ShopHub.', 'Успешно');
        router.push({ name: 'home' });
    } catch (e) {
        const errs = e.response?.data?.errors;
        if (errs) {
            fieldErrors.value = errs;
            error.value = Object.values(errs).flat()[0];
        } else {
            error.value = e.response?.data?.message || 'Не удалось зарегистрироваться';
        }
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
.auth-card { border-radius: 1.25rem; background: #fff; }
.auth-icon {
    width: 64px; height: 64px;
    margin: 0 auto 1rem;
    border-radius: 50%;
    background: var(--gradient-primary);
    color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-size: 1.75rem;
}
.password-strength small { font-size: 0.75rem; }
.error-fade-enter-active, .error-fade-leave-active { transition: opacity 0.2s ease, transform 0.2s ease; }
.error-fade-enter-from, .error-fade-leave-to { opacity: 0; transform: translateY(-4px); }
</style>
