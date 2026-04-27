<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AppHead from '../../Components/AppHead.vue';

const form = useForm({
    name: '',
    email: '',
    phone: '',
    password: '',
    password_confirmation: '',
});

function submit() {
    form.post('/register');
}
</script>

<template>
    <AppHead title="Регистрация" />

    <section class="section box-section-auth">
        <div class="page-head">
            <div class="container">
                <h2 class="font-3xl-bold color-brand-3 mb-15">Регистрация</h2>
                <ul class="breadcrumb">
                    <li><Link class="font-sm" href="/">Главная</Link></li>
                    <li><a class="font-sm" href="#">Регистрация</a></li>
                </ul>
            </div>
        </div>
        <div class="container mt-30 mb-50">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8">
                    <div style="background:#fff;border:1px solid #eee;border-radius:14px;padding:40px;">
                        <h3 class="font-xl-bold neutral-900 mb-20 text-center">Создать аккаунт</h3>
                        <form @submit.prevent="submit">
                            <div class="mb-15">
                                <label class="form-label">ФИО *</label>
                                <input type="text" v-model="form.name" class="form-control" required>
                                <small v-if="form.errors.name" class="text-danger">{{ form.errors.name }}</small>
                            </div>
                            <div class="mb-15">
                                <label class="form-label">Email *</label>
                                <input type="email" v-model="form.email" class="form-control" required>
                                <small v-if="form.errors.email" class="text-danger">{{ form.errors.email }}</small>
                            </div>
                            <div class="mb-15">
                                <label class="form-label">Телефон</label>
                                <input type="text" v-model="form.phone" class="form-control">
                                <small v-if="form.errors.phone" class="text-danger">{{ form.errors.phone }}</small>
                            </div>
                            <div class="mb-15">
                                <label class="form-label">Пароль *</label>
                                <input type="password" v-model="form.password" class="form-control" required>
                                <small v-if="form.errors.password" class="text-danger">{{ form.errors.password }}</small>
                            </div>
                            <div class="mb-20">
                                <label class="form-label">Подтверждение пароля *</label>
                                <input type="password" v-model="form.password_confirmation" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-brand-3 w-100 mb-15" :disabled="form.processing">
                                {{ form.processing ? 'Создаём...' : 'Зарегистрироваться' }}
                            </button>
                            <p class="text-center mb-0 font-sm neutral-700">
                                Уже есть аккаунт? <Link href="/login" style="color:#FF6E30;">Войти</Link>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
