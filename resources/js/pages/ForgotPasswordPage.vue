<template>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card p-4">
                    <h4 class="fw-bold text-center mb-4">Восстановление пароля</h4>
                    <form v-if="!token && !emailSent" @submit.prevent="request">
                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input v-model="email" required type="email" class="form-control" />
                        </div>
                        <button class="btn btn-primary w-100">Получить токен</button>
                    </form>
                    <div v-else-if="!token" class="alert alert-info small">
                        Если такой email зарегистрирован, инструкции по сбросу пароля отправлены письмом. Проверьте почту.
                    </div>
                    <div v-else>
                        <div class="alert alert-info small">
                            Для демо: ваш токен — <code>{{ token }}</code>. В реальном проекте он приходит на email.
                        </div>
                        <form @submit.prevent="reset">
                            <div class="mb-3">
                                <label class="form-label">Новый пароль</label>
                                <input v-model="password" required type="password" class="form-control" />
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Повторите пароль</label>
                                <input v-model="password_confirmation" required type="password" class="form-control" />
                            </div>
                            <div v-if="error" class="alert alert-danger">{{ error }}</div>
                            <div v-if="success" class="alert alert-success">{{ success }}</div>
                            <button class="btn btn-primary w-100">Сбросить пароль</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import api from '../api';

const email = ref('');
const token = ref('');
const password = ref('');
const password_confirmation = ref('');
const error = ref('');
const success = ref('');
const emailSent = ref(false);

async function request() {
    error.value = '';
    try {
        const { data } = await api.post('/forgot-password', { email: email.value });
        token.value = data.reset_token || '';
        emailSent.value = true;
    } catch (e) {
        error.value = e.response?.data?.message || 'Ошибка';
    }
}

async function reset() {
    error.value = '';
    success.value = '';
    try {
        await api.post('/reset-password', {
            email: email.value,
            token: token.value,
            password: password.value,
            password_confirmation: password_confirmation.value,
        });
        success.value = 'Пароль обновлен. Теперь можно войти.';
    } catch (e) {
        error.value = e.response?.data?.message || 'Ошибка';
    }
}
</script>
