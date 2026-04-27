<script setup>
import { reactive, ref } from 'vue';
import { toast } from 'vue3-toastify';
import api from '../services/api';
import { useAuthStore } from '../stores/auth';

const auth = useAuthStore();
const form = reactive({ current_password: '', new_password: '', new_password_confirmation: '' });
const errors = ref({});
const loading = ref(false);

async function submit() {
    errors.value = {};
    loading.value = true;
    try {
        await api.post('/change-password', form);
        toast.success('Пароль обновлён.');
        Object.assign(form, { current_password: '', new_password: '', new_password_confirmation: '' });
    } catch (e) {
        errors.value = e.response?.data?.errors || {};
        toast.error(e.response?.data?.message || 'Ошибка');
    } finally {
        loading.value = false;
    }
}
</script>

<template>
    <div class="card" style="max-width: 520px;">
        <div class="card-head"><h3>Профиль</h3></div>
        <div class="card-pad">
            <div class="form-group"><label>Имя</label><input :value="auth.user?.name" disabled /></div>
            <div class="form-group"><label>Email</label><input :value="auth.user?.email" disabled /></div>
            <div class="form-group"><label>Роль</label><input :value="auth.user?.role_label" disabled /></div>

            <h4 style="margin-top:24px;">Сменить пароль</h4>
            <form @submit.prevent="submit">
                <div class="form-group"><label>Текущий пароль</label><input v-model="form.current_password" type="password" required />
                    <div v-if="errors.current_password" class="error-text">{{ errors.current_password[0] }}</div>
                </div>
                <div class="form-group"><label>Новый пароль</label><input v-model="form.new_password" type="password" required minlength="8" />
                    <div v-if="errors.new_password" class="error-text">{{ errors.new_password[0] }}</div>
                </div>
                <div class="form-group"><label>Подтверждение</label><input v-model="form.new_password_confirmation" type="password" required minlength="8" /></div>
                <button class="btn btn-primary" :disabled="loading">{{ loading ? 'Сохраняем…' : 'Обновить' }}</button>
            </form>
        </div>
    </div>
</template>
