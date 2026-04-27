<script setup>
import { Link, useForm } from '@inertiajs/vue3';
import AppHead from '../../Components/AppHead.vue';

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

function submit() {
    form.post('/login');
}
</script>

<template>
    <AppHead title="Вход" />

    <section class="section box-section-auth">
        <div class="page-head">
            <div class="container">
                <h2 class="font-3xl-bold color-brand-3 mb-15">Вход</h2>
                <ul class="breadcrumb">
                    <li><Link class="font-sm" href="/">Главная</Link></li>
                    <li><a class="font-sm" href="#">Вход</a></li>
                </ul>
            </div>
        </div>
        <div class="container mt-30 mb-50">
            <div class="row justify-content-center">
                <div class="col-lg-5 col-md-8">
                    <div style="background:#fff;border:1px solid #eee;border-radius:14px;padding:40px;">
                        <h3 class="font-xl-bold neutral-900 mb-20 text-center">Вход в личный кабинет</h3>
                        <form @submit.prevent="submit">
                            <div class="mb-15">
                                <label class="form-label">Email</label>
                                <input type="email" v-model="form.email" class="form-control" required autofocus>
                                <small v-if="form.errors.email" class="text-danger">{{ form.errors.email }}</small>
                            </div>
                            <div class="mb-15">
                                <label class="form-label">Пароль</label>
                                <input type="password" v-model="form.password" class="form-control" required>
                                <small v-if="form.errors.password" class="text-danger">{{ form.errors.password }}</small>
                            </div>
                            <div class="form-check mb-20">
                                <input type="checkbox" id="remember" v-model="form.remember" class="form-check-input">
                                <label for="remember" class="form-check-label">Запомнить меня</label>
                            </div>
                            <button type="submit" class="btn btn-brand-3 w-100 mb-15" :disabled="form.processing">
                                {{ form.processing ? 'Входим...' : 'Войти' }}
                            </button>
                            <p class="text-center mb-0 font-sm neutral-700">
                                Нет аккаунта? <Link href="/register" style="color:#FF6E30;">Зарегистрироваться</Link>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
