<script setup>
import { reactive, ref } from 'vue';
import { useRouter } from 'vue-router';
import { toast } from 'vue3-toastify';
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();
const router = useRouter();
const form = reactive({ email: '', password: '' });
const errors = ref({});
const loading = ref(false);

async function submit() {
    loading.value = true;
    errors.value = {};
    try {
        await auth.login(form.email, form.password);
        toast.success('Добро пожаловать!');
        router.push({ name: 'dashboard' });
    } catch (e) {
        errors.value = e.response?.data?.errors || {};
        toast.error(e.response?.data?.message || 'Ошибка входа');
    } finally {
        loading.value = false;
    }
}
</script>

<template>
    <div class="login-page">
        <form class="login-card" @submit.prevent="submit">
            <h1>🛍️ Billaro Admin</h1>
            <p class="muted">Войдите в админ-панель</p>
            <div class="form-group">
                <label>Email</label>
                <input v-model="form.email" type="email" required autocomplete="username" />
                <div v-if="errors.email" class="error-text">{{ errors.email[0] }}</div>
            </div>
            <div class="form-group">
                <label>Пароль</label>
                <input v-model="form.password" type="password" required autocomplete="current-password" />
            </div>
            <button class="btn btn-primary" style="width:100%; justify-content:center; padding:10px;" :disabled="loading">
                {{ loading ? 'Входим…' : 'Войти' }}
            </button>
        </form>
    </div>
</template>
